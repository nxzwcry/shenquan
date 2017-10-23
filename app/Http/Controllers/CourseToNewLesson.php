<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Lesson;
use App\Course;
use App\Courseware;
use Log;

trait CourseToNewLesson
{
	
	use LessonCreate;
	//根据courseid添加下一节课程
	public function nextlesson( $cid )
	{          		
    	$course = Course::find($cid);
    	if ( $course )
    	{
	        $lesson = $course -> lessons() -> where('conduct' , 0) -> first();
	        Log::info($lesson);
			if ( !$lesson )
			{			
				Log::info('开始创建下一节课程');		        
		        $next = Carbon::now();    
		       	if ( $next -> dayOfWeek < $course -> dow )
		       	{
		       		// 追加一个自定义的 name=date
					$next -> addDays( $course -> dow - $next -> dayOfWeek );
		       	}
		       	else
		       	{
					$next -> addDays( $course -> dow - $next -> dayOfWeek + 7 );
		       	}     
				
				$lessoninfo = $course -> toArray();
				if ( $lessoninfo['cwid'] )
				{
					$courseware = Courseware::find($lessoninfo['cwid']);
					if ( $courseware )
					{
						$lessoninfo['cwurl'] = $courseware -> url;
					}
				}
				$lessoninfo['date'] = $next -> toDateString();
				$lessoninfo['courseid'] = $lessoninfo['id'];
				unset($lessoninfo['id']);
				unset($lessoninfo['dow']);
				unset($lessoninfo['sdate']);
				unset($lessoninfo['edate']);
				unset($lessoninfo['cwid']);
				
		//		使用模型的Create方法新增数据
				$lesson = $this -> createlesson($lessoninfo);
	        	return $lesson;
			}
		} 
		return 0;
		
	}
	
}
?>