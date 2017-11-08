<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Wechat;
use App\Student;
use App\Lesson;
use Carbon\Carbon;

class SendStartMassage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendStartMassage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '微信发送上课提醒';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }



//	protected $tempid = 'M7rVONQSBYxSA1Sfn5UsPIPkXRW4EXGiKHmFayoFlM8'; //测试ID
	protected $tempid = 'CNTO2nogT9MngwGN-TCIfWv5c21Wq9UBlnpk-5w69z0'; //正式ID
	protected $url = 'deepspring.cn/wechat/userinfo';
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
		Log::info('微信发送上课提醒');
		$lessons1 = Lesson::where( 'date' , Carbon::now() -> toDateString() ) 
						-> where( 'stime' , '>=' , '12:00:00.000000' )
						-> get();
		$lessons2 = Lesson::where( 'date' , Carbon::now() -> addDay() -> toDateString() ) 
						-> where( 'stime' , '<' , '12:00:00.000000' )
						-> get();
		$lessons = $lessons1 -> merge( $lessons2 );
		foreach( $lessons as $lesson )
		{
			$student = Student::find( $lesson -> sid );		
			if ( $student )
			{				
				if ( ( $lesson -> tname <> '' ) && ( $lesson -> cteacher ) )
				{
					$teacher = $lesson -> tname . ' & ' . $lesson -> cteacher -> tname;
				}
				else
				{
					$teacher = $lesson -> tname;
					if ( $lesson -> cteacher )
					{
						$teacher = $teacher . $lesson -> cteacher -> tname;
					}
				}		
				if ( $lesson -> date > Carbon::now() -> toDateString() )
				{
					$first = '深泉教育提醒 明天 有您的课程';
				}
				else
				{
					$first = '深泉教育提醒 今天 有您的课程';
				}
				$message = ['first' => $first , 
							'sname' => $student -> name . ' ' . $student -> ename , 
							'time' => $lesson -> date . ' ' . substr( $lesson -> stime , 0 , 5 ) . '~' . substr( $lesson -> etime , 0 , 5 ) ,
							'place' => $lesson -> place -> name . '',
							'teacher' => $teacher,
							'mid' => $lesson -> mid . ''];
				$wechats = $student -> wechats;	
				foreach( $wechats as $wechat )
				{
					$message['touser'] = $wechat -> openid;
					$this -> startmassage( $message );
				}
			}		
		}
		Log::info('微信上课提醒发送完成');
    }
    
    public function startmassage( $data )
    {
    	$wechat = app('wechat');
		$notice = $wechat->notice;
		try {  
			$messageId = $notice->send([
		        'touser' => $data['touser'],
		        'template_id' => $this -> tempid,
		        'url' => $this -> url,
		        'data' => [
		            'first' => $data['first'],
		            'keyword1' => $data['sname'],
		            'keyword2' => $data['time'],
		            'keyword3' => $data['teacher'],
		            'keyword4' => $data['place'],
		            'remark' => "\n会议ID:" . $data['mid'] . "\n请按时上课，如有疑问请拨打电话15378928311",
		        ],
		    ]); 
			Log::info( $data['sname'] . '消息已发送');
		} catch (Exception $e) {   
			Log::error( $e->getMessage() ); 
		}		
    }
}
