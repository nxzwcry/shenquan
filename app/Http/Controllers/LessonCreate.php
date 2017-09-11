<?php
namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Lesson;
use App\Classes;
use App\Recharge;

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
	
	// 发送上课提醒
	public function send()
	{
		$wechat = app('wechat');
		$notice = $wechat->notice;
		$messageId = $notice->send([
	        'touser' => 'o1XxxxB81qwbsP75Ecoquf5mdCyg',
	        'template_id' => '0vuoBhcp-78VRZTe4Kw50ID6GVRY8v9nWbX8ORHJ2qU',
	        'url' => 'deepspring.cn/wechat/userinfo',
	        'data' => [
	            'first' => '明天有朱瀚东的外教英语课！',
	            'keyword1' => '认识字母A',
	            'keyword2' => '2017-07-28 20:00 ~ 20:30',
	            'remark' => "会议ID:1111111111",
	        ],
	    ]);
	    return 1;
	}
}
?>