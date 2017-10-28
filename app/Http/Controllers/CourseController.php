<?php
namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Course;
use App\Lesson;
use App\Courseware;
use App\Cteacher;
use Log;

class CourseController extends Controller
{
	// 显示增加页面
	public function index($sid)
	{
		$students = Student::where('id' , $sid)
    		-> get(['id' , 'name' , 'ename'])
			-> first();
		$cteachers = Cteacher::all();
		$cws = Courseware::all();
//  	dd($students);
        return view('admin.ccourse' , ['students' => $students , 'cws' => $cws , 'cteachers' => $cteachers]);
	}
	
	//处理添加固定课程请求
	public function create(Request $request)
	{
		$this -> validate($request,[
            'sid' => 'required|numeric|exists:students,id',
            'stime' => 'required',
            'etime' => 'required',
            'sdate' => 'required|date',
            'edate' => 'nullable|date',
            'cost' => 'required|numeric|max:5',
            'cost1' => 'required|numeric|max:5',
            'cost2' => 'required|numeric|max:5',           
        ],[
            'required' => '输入不能为空',
            'date.date' => '请按照正确格式输入日期',
        ]);
       	
//		使用模型的Create方法新增固定课程数据
//		$class = Course::create(
//		[
//			'sid'=> $request -> sid,
//			'tname' => $request -> tname,
//			'dow' => $request -> dow,
//			'sdate' => Carbon::parse($request -> sdate . ' 0:00:00') ,
//			'edate' => Carbon::parse($request -> edate . ' 23:59:59') ,
//			'stime' => $request -> stime,
//			'etime' => $request -> etime,
//			'mid' => $request -> mid,
//			'cost' => $request -> cost,
//			'cid' => $request -> cid
//		]
//		);

		
		
		
		$classinfo = $request -> all();
		
		$classinfo['sdate'] = Carbon::parse($classinfo['sdate'] . ' 0:00:00');
		if ( $classinfo['edate'] <> null )
		{
			$classinfo['edate'] = Carbon::parse($classinfo['edate'] . ' 23:59:59');
		}
		
//		dd($classinfo);
		
//		else
//		{
//			$class->edate = Carbon::parse($request -> edate . ' 23:59:59') ;
//		}
//		
//		$class = new Course();
//		$class->sid = $request -> sid;
//		$class->tname = $request -> tname;
//		$class->dow = $request -> dow;
//		$class->sdate = Carbon::parse($request -> sdate . ' 0:00:00');
//		if ( $request -> edate == null )
//		{
//			$class->edate = null;
//		}
//		else
//		{
//			$class->edate = Carbon::parse($request -> edate . ' 23:59:59') ;
//		}
//		$class->stime = $request -> stime;
//		$class->etime = $request -> etime;
//		$class->mid = $request -> mid;
//		$class->cost = $request -> cost;
//		$class->cid = $request -> cid;	
		$class = Course::create($classinfo);			
		
//		dd($class-> toArray());
//		$bool = $class->save();


//		if ( $bool ){
		    $this-> clesson($class);
		    return redirect('lessonsinfo/' . $request -> sid );
//		    }
//		else
//			return 0;
	}
			
	//处理删除单节课程请求
	public function delete(Request $request)
	{
		
//      $this -> validate -> errors() -> add('lerror' , '1');
		$this -> validate($request,[
            'sid' => 'required|numeric|exists:students,id',
            'id' => 'required|numeric|exists:lessons,id',
        ]);
        
        $course = Course::find($request -> id);
//      dd($lesson);
//      $lesson -> delete();
		$sum = 0;
		if ( $course -> sid == $request -> sid )
		{			
        	if( $request -> option == 'after' )
        	{        		
        		$sum = $sum + Lesson::where( 'conduct' , 0 )
					-> where( 'courseid' , $course -> id )
					-> delete();
        	}
        	elseif( $request -> option == 'all' )
        	{        		
        		$sum = $sum + Lesson::where( 'courseid' , $course -> id )
					-> delete();
        	}
        	$sum = $sum + $course -> delete();
		}
		
        return redirect('lessonsinfo/' . $request -> sid );
	}
	
	//处理修改固定课程请求
	public function update(Request $request)
	{
		$this -> validate($request,[
            'id' => 'required|numeric|exists:course,id',
            'sid' => 'required|numeric|exists:students,id',
            'stime' => 'required',
            'etime' => 'required',
            'sdate' => 'required|date',
            'edate' => 'nullable|date',
            'cost' => 'required|numeric|max:5',
            'cost1' => 'required|numeric|max:5',
            'cost2' => 'required|numeric|max:5',           
        ],[
            'required' => '输入不能为空',
            'date.date' => '请按照正确格式输入日期',
        ]);
       	
		
		$classinfo = $request -> all();
		
		$classinfo['sdate'] = Carbon::parse($classinfo['sdate'] . ' 0:00:00');
		if ( $classinfo['edate'] <> null )
		{
			$classinfo['edate'] = Carbon::parse($classinfo['edate'] . ' 23:59:59');
		}
			
		unset($classinfo['id']);
		unset($classinfo['option']);
		$class = Carbon::find($request -> id);
		$class -> fill($classinfo);			
	
		$option = $request -> option;
		$this-> clesson($class);
		return redirect('lessonsinfo/' . $request -> sid );
	}
	
	//根据固定课程添加单节课程请求
	public function clesson(Course $class)
	{		  	
		$next = clone $class -> sdate;
		Log::info( 'next' . $next -> dayOfWeek . 'dow' . $class -> dow );
       	if ( $next -> dayOfWeek <= $class -> dow )
       	{
       		// 追加一个自定义的 name=date
//			$request -> offsetSet('date', $now -> addDays( $class -> dow - $today ) -> toDateString() );
			$next -> addDays( $class -> dow - $next -> dayOfWeek );
       	}
       	else
       	{
			$next -> addDays( $class -> dow - $next -> dayOfWeek + 7 );
       	}
       	
       	if ( $class -> edate == null )
       	{
       		if ( $next -> lte( Carbon::now() ) )
       		{       			
	       		$edate = Carbon::now();	
	       		$edate -> addDays( 7 );
       		}
       		else
       		{
       			$edate = clone $next;	
	       		$edate -> addDays( 1 );
       		}	
       	}
       	else 
       	{
       		$edate = $class -> edate;
       	}
       	           	
       	if ( $next  -> lte( $edate ) )
       	{
	       	$lesson = $this -> precreate( $class -> toArray() , $next -> toDateString() ); 
	       	$next -> addDays(7); 	
	       	$i = 1;
	       	while ( $lesson -> conduct == 1 &&  $next  -> lte( $edate ) )
	       	{
	       		$lesson = $this -> precreate( $class -> toArray() , $next -> toDateString() );
	       		$next -> addDays(7);
	       		$i++;
	       	}
       	}
       	
       	return 1;
	}
		
//	use LessonCreate;
	
	//添加单节课程操作
	public function precreate( $lessoninfo , $date )
	{			
//		使用模型的Create方法新增单节数据
		if ( $lessoninfo['cwid'] )
		{
			$courseware = Courseware::find($lessoninfo['cwid']);
			if ( $courseware )
			{
				$lessoninfo['cwurl'] = $courseware -> url;
			}
		}
		$lessoninfo['courseid'] = $lessoninfo['id'];
		$lessoninfo['date'] = $date;
//		$lessoninfo['conduct'] = $conduct;
		unset($lessoninfo['id']);
		unset($lessoninfo['dow']);
		unset($lessoninfo['sdate']);
		unset($lessoninfo['edate']);
		unset($lessoninfo['cwid']);
//		dd($lessoninfo);
		$lesson = $this -> createlesson($lessoninfo);
//		$lesson = Lesson::create(
//		[
//			'courseid' => $course -> id,
//			'sid'=> $class -> sid,
//			'name' =>
//			'tname' => $class -> tname,
//			'name' => $class -> name,
//			'date' => $date -> toDateString(),
//			'stime' => $class -> stime,
//			'etime' => $class -> etime,
//			'mid' => $class -> mid,
//			'cost' => $class -> cost,
//			'cid' => $class -> cid,
//			'conduct' => $conduct,
//		]
//		);
		return $lesson;
	}
		
	// 固定课程停课
	public function stop(Request $request)
	{
		$course = Course::find( $request -> id );
		if ( $course )
		{
			if ( $course -> sid == $request -> sid )
			{
				$course -> edate = Carbon::now() -> subSecond();
				$course -> save();				
				Lesson::where( 'conduct' , 0 )
							->where( 'courseid' , $course -> id )
							->delete();
			}
		}
		return redirect('lessonsinfo/' . $request -> sid );
	}
	
	use CourseToNewLesson;
	// 固定课程复课
	public function restart(Request $request)
	{
		$course = Course::find( $request -> id );
		if ( $course )
		{
			if ( $course -> sid == $request -> sid )
			{
				$course -> edate = NULL;
				$course -> save();
				$this -> nextlesson( $course -> id );
			}
		}
		return redirect('lessonsinfo/' . $request -> sid );
	}
	
}
?>