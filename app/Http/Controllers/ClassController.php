<?php
namespace App\Http\Controllers;
use App\Classes;
use App\Cteacher;
use App\Courseware;
use App\Student;
use App\Place;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClassController extends Controller
{
	// 显示增加页面
	public function createcourseindex($class_id)
	{
		$class = Classes::find($class_id);
        $cteachers = Cteacher::all();
        $cws = Courseware::all();
        $places = Place::all();
      return view('admin.classccourse' , ['class' => $class , 'cws' => $cws , 'cteachers' => $cteachers , 'places' => $places ]);
	}
	
	// 显示学生课程信息(管理界面)
	public function info($cid)
	{
        $class = Classes::find( $cid );
//        dd($class->getnextlessons());
        return view('admin.classinfo' ,
        ['class' => $class ]);
	}
	
	use LessonCreate;

	public function add(Request $request)
    {
//        dd($request);
		$this -> validate($request,[
            'sid' => 'required|numeric|exists:students,id',
            'cid' => 'required|numeric|exists:classes,id',
        ],[
        ]);
        $this -> addstudent($request->cid,$request->sid);
        return redirect('class/' . $request->cid );
    }

    public function deletestudent( $cid , $sid )
    {
        $class = Classes::find($cid);
        $student = Student::find($sid);
        if ( $class && $student )
        {
            $courses = $class -> getscourses($sid);
            foreach ($courses as $course)
            {
                $course -> stop();
            }
            $lessons = $class -> getlessons($sid);
            foreach ($lessons as $lesson)
            {
                $lesson -> delete();
            }
            $student -> class_id = 0;
            $student -> save(); //将学生从班级删去
        }
        return redirect('class/' . $cid );
    }

    // 添加学生的实现
    public function addstudent( $cid , $sid )
    {
        $class = Classes::find( $cid );
        $student = Student::find( $sid );
        $student -> class_id = $cid;
        $student -> save(); //将学生加入班级

        //给加入学生添加目前班级的新课（正式）
        $courses = $class -> getcourses();
        foreach( $courses as $course )
        {
            $course -> copytostudent($sid);
        }
        $lessons = $class -> getnextlessons();
        foreach( $lessons as $lesson )
        {
            $lesson -> copytostudent($sid);
        }
        //将学生正在上的课程归入班课（正式删去）
//        $student -> lessons() -> update(['class_id' => $cid]); //正式删去
//        $student -> courses() -> update(['class_id' => $cid]); //正式删去

        return true;
    }

//	//处理添加单节课程请求
//	public function create(Request $request)
//	{
//
////      $this -> validate -> errors() -> add('lerror' , '1');
//		$this -> validate($request,[
//            'sid' => 'required|numeric|exists:students,id',
//            'stime' => 'required',
//            'etime' => 'required',
//            'date' => 'required|date',
//            'cost' => 'required|numeric|max:5',
//            'cost1' => 'required|numeric|max:5',
//            'cost2' => 'required|numeric|max:5',
//        ],[
//            'required' => '输入不能为空',
//            'date.date' => '请按照正确格式输入日期',
//        ]);
//
//        $lessoninfo = $request -> all();
//        $ans = $this -> createlesson( $lessoninfo );
//
//        return redirect('lessonsinfo/' . $request -> sid );
//	}
//
//	//处理删除单节课程请求
//	public function delete(Request $request)
//	{
//
////      $this -> validate -> errors() -> add('lerror' , '1');
////		$this -> validate($request,[
////          'sid' => 'required|numeric|exists:students,id',
////          'id' => 'required|numeric|exists:lessons,id',
////      ]);
//
//        $lesson = Lesson::find($request -> id);
////      dd($lesson);
////      $lesson -> delete();
//		if ( $lesson -> sid == $request -> sid )
//		{
//        	if( $this -> deletelesson( $request -> id ) )
//        	{
//        		return redirect('lessonsinfo/' . $request -> sid );
//        	}
//		}
//
//        return 0;
//	}
//
//	// 显示文件上传页面
//	public function fileupdateindex($lid)
//	{
//		$lesson = Lesson::find($lid);
//		$student = Student::find( $lesson -> sid );
//		$cws = Courseware::all();
//		if ( $lesson -> cwurl == null )
//		{
//			$cwid = 0;
//		}
//		else
//		{
//			$cw = Courseware::where( 'url' , $lesson -> cwurl );
//			if ( $cw -> first() )
//			{
//				$cwid = $cw -> first() -> id;
//			}
//			else{
//				$cwid = -1;
//			}
//		}
////  	dd($students);
//        return view('admin.fupdate' , ['lesson' => $lesson , 'student' => $student , 'cws' => $cws , 'cwid' => $cwid ]);
//	}
//
//	// 存储视频上传信息
//	public function videoupdate(Request $request)
//	{
//		$this -> validate($request,[
//            'name' => 'required',
//            'id' => 'required',
//            'vid' => 'required',
//        ],[
//            'required' => '输入不能为空',
//        ]);
//
////      dd($request);
//		$lesson = Lesson::find( $request -> id );
//		$lesson -> name =  $request -> name;
//		$lesson -> tname =  $request -> tname;
//		$lesson -> vid =  $request -> vid;
//		$lesson -> save();
//		return $this -> info( $request -> sid );
//	}
//
//	// 存储文件上传信息
//	public function fileupdate(Request $request)
//	{
//		$lesson = Lesson::find( $request -> id );
//		if ( $request -> type == 'gd' )
//		{
//			if ( $request -> cwid == 0 )
//			{
//				$lesson -> cwurl =  null;
//			}
//			else
//			{
//				$lesson -> cwurl = Courseware::find( $request -> cwid ) -> url;
//			}
//		}
//		else
//		{
//			$lesson -> cwurl = $request -> cwurl;
//		}
//		$lesson -> furl = $request -> furl;
//		$lesson -> save();
//		return $this -> info( $request -> sid );
//	}
//
//
//	// 修改课程信息显示页面
//	public function changeindex(Request $request)
//	{
//		$lesson = Lesson::find($request -> id);
//		if ($lesson)
//		{
//			$cteachers = Cteacher::all();
//			$places = Place::all();
//			return view( 'admin.lchange' , [ 'lesson' => $lesson , 'cteachers' => $cteachers , 'places' => $places]);
//		}
//	}
//
//	// 修改课程信息操作
//	public function change(Request $request)
//	{
//		$this -> validate($request,[
//            'id' => 'required|numeric|exists:lessons,id',
//            'stime' => 'required',
//            'etime' => 'required',
//            'date' => 'required|date',
//            'cost' => 'required|numeric|max:5',
//            'cost1' => 'required|numeric|max:5',
//            'cost2' => 'required|numeric|max:5',
//        ],[
//            'required' => '输入不能为空',
//            'date.date' => '请按照正确格式输入日期',
//        ]);
//		$lesson = Lesson::find($request -> id);
//		$info = $request -> all();
//		$etime = Carbon::parse( $request -> date . $request -> etime );
//
//        if ( Carbon::now() -> gte( $etime ) )
//        {
//        	$info['conduct'] = 1;
//        }
//        else
//        {
//        	$info['conduct'] = 0;
//        }
//		if ( $lesson )
//		{
//			if ( $lesson -> update($info) )
//			{
//				return redirect('lessonsinfo/' . $lesson -> sid );
//			}
//		}
//	}
	
}
?>