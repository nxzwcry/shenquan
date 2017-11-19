<?php
namespace App\Http\Controllers;
use App\Classes;
use App\Cteacher;
use App\Courseware;
use App\Lesson;
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

    public function createcourse(Request $request)
    {
        $this -> validate($request,[
            'class_id' => 'required|numeric|exists:classes,id',
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
        $class = Classes::find($request->class_id);
        if ( $class )
        {
            $courseinfo = $request -> all();
            foreach ( $class -> students as $student )
            {
                $course = $student->createcourse($courseinfo);//创建固定课程
                if ($course)
                {
                    //根据固定课程创建单节课程
                    $course -> CreateLessons();
                }
            }
        }

        return view('admin.classinfo' ,
            ['class' => $class ]);
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
        $class = Classes::find( $request->cid );
        $class -> addstudent($request->sid);
        return redirect('class/' . $request->cid );
    }

    public function deletestudent( $cid , $sid )
    {
        $class = Classes::find($cid);
        if ( $class )
        {
            if ( $class -> deletestudent($sid) )
            {
                return redirect('class/' . $cid );
            }
        }
    }

	//处理添加班级请求
	public function createclass(Request $request)
	{
		$this -> validate($request,[
            'name' => 'required',
        ],[
            'required' => '输入不能为空',
        ]);

        $classinfo = $request -> all();
        $ans = Classes::create( $classinfo );
        return redirect('class/' . $ans -> id );
	}

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
	// 显示文件上传页面
	public function fileupdateindex($lid)
	{
		$lesson = Lesson::find($lid);
		$student = Student::find( $lesson -> sid );
		$cws = Courseware::all();
		if ( $lesson -> cwurl == null )
		{
			$cwid = 0;
		}
		else
		{
			$cw = Courseware::where( 'url' , $lesson -> cwurl );
			if ( $cw -> first() )
			{
				$cwid = $cw -> first() -> id;
			}
			else{
				$cwid = -1;
			}
		}
//  	dd($students);
        return view('admin.fupdate' , ['lesson' => $lesson , 'student' => $student , 'cws' => $cws , 'cwid' => $cwid , 'url' => '/class']);
	}

	// 存储视频上传信息
	public function videoupdate(Request $request)
	{
		$this -> validate($request,[
            'name' => 'required',
            'id' => 'required',
            'vid' => 'required',
        ],[
            'required' => '输入不能为空',
        ]);

        $temp = Lesson::find( $request -> id );
        if ( $temp )
        {
            $class = $temp -> classes;
            if ( $class )
            {
                $lessons = $temp -> sameclasslesson();
                foreach ($lessons as $lesson)
                {
                    $lesson -> name =  $request -> name;
                    $lesson -> tname =  $request -> tname;
                    $lesson -> vid =  $request -> vid;
                    $lesson -> save();
                }
                return view('admin.classinfo' ,
                    ['class' => $class ]);
            }
        }

	}

	// 存储文件上传信息
	public function fileupdate(Request $request)
	{
        $temp = Lesson::find( $request -> id );
        if ( $temp )
        {
            $class = $temp -> classes;
            if ( $class )
            {
                $lessons = $temp -> sameclasslesson();
                foreach ($lessons as $lesson)
                {
                    if ( $request -> type == 'gd' )
                    {
                        if ( $request -> cwid == 0 )
                        {
                            $lesson -> cwurl =  null;
                        }
                        else
                        {
                            $lesson -> cwurl = Courseware::find( $request -> cwid ) -> url;
                        }
                    }
                    else
                    {
                        $lesson -> cwurl = $request -> cwurl;
                    }
                    $lesson -> furl = $request -> furl;
                    $lesson -> save();
                }
                return view('admin.classinfo' ,
                    ['class' => $class ]);
            }
        }
	}

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