<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Lesson;

trait LessonCreate
{
	
	//处理添加单节课程请求
	public function createlesson( $lessoninfo )
	{          
        $etime = Carbon::parse($lessoninfo['date'] . ' ' . $lessoninfo['etime'] );
                
        if ( Carbon::now() -> gte( $etime ) )
        {
        	$lessoninfo['conduct'] = 1;
        }
        else 
        {
        	$lessoninfo['conduct'] = 0;
        }
        
        
//		$student = new Student();
//		$student->name = 'Daisy';
//		$student->sex = 'girl';
//		$bool = $student->save();
		
//		使用模型的Create方法新增数据
		$lesson = Lesson::create($lessoninfo);
		
        return $lesson;
	}
	
	//处理删除单节课程请求
	public function deletelesson( $lessonid )
	{                  
		return Lesson::find($lessonid) -> delete();
	}
	
	// 发送上课提醒
	public function send()
	{
		$wechat = app('wechat');
		$notice = $wechat->notice;
		$messageId = $notice->send([
	        'touser' => 'oxxhXwMDaLaCBaLu5tOgdpM8jGRQ',
	        'template_id' => 'tUHvlvnWntF6COoDXjQKLtctmRkhozX9fdieWtcNGK0',
	        'url' => 'deepspring.cn/wechat/userinfo',
	        'data' => [
//	            'first' => '明天有朱瀚东的外教英语课！',
//	            'keyword1' => '认识字母A',
//	            'keyword2' => '2017-07-28 20:00 ~ 20:30',
//	            'keyword3' => "会议ID:1111111111",
//	            'keyword4' => "上课教师：Brooky",
	            'remark' => "1 \n 2",
	        ],
	    ]);
	    return 1;
	}
}
?>