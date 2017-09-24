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



	protected $tempid = 'M7rVONQSBYxSA1Sfn5UsPIPkXRW4EXGiKHmFayoFlM8';
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
			$wechats = Wechat::where( 'sid' , $lesson -> sid ) -> get();
			foreach( $wechats as $wechat )
			{
				$this -> startmassage( [ 'touser' => $wechat -> openid ,
					'sname' => $student -> name . ' ' . $student -> ename , 
					'time' => $lesson -> date . ' ' . substr( $lesson -> stime , 0 , 5 ) . '~' . substr( $lesson -> etime , 0 , 5 ) ,
					'place' => '家中' . '',
					'teacher' => $lesson -> tname . '',
					'mid' => $lesson -> mid . ''] );
			}
		}
		Log::info('微信上课提醒发送完成');
    }
    
    public function startmassage( $data )
    {
    	$wechat = app('wechat');
		$notice = $wechat->notice;
		$messageId = $notice->send([
	        'touser' => $data['touser'],
	        'template_id' => $this -> tempid,
	        'url' => $this -> url,
	        'data' => [
	            'first' => '深泉教育上课提醒',
	            'sname' => $data['sname'],
	            'time' => $data['time'],
	            'place' => $data['place'],
	            'teacher' => $data['teacher'],
	            'mid' => $data['mid'],
	            'remark' => "请按时上课，如有疑问请拨打电话15378928311",
	        ],
	    ]);
    }
}
