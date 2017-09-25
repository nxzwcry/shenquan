<?php
namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Lesson;
use App\Course;
use App\Recharge;
use App\Courseware;

class LessonController extends Controller
{
	// 显示增加页面
	public function index($sid)
	{
		$students = Student::where('id' , $sid)
    		-> get(['id' , 'name' , 'ename'])
			-> first();
//  	dd($students);
        return view('admin.clesson' , ['students' => $students]);
	}
	
	// 显示学生课程信息
	public function info($sid)
	{
		// 学生信息
		$students = Student::where('id' , $sid)
    		-> get(['id' , 'name' , 'ename'])
			-> first();
			
		// 固定课程信息
		$courses = Course::where('sid' , $sid)
			-> where(function($query){
				$query -> where( 'edate' , null )
				-> orwhere( 'edate' , '>=' , Carbon::now() -> timestamp );
			})
			-> orderby('dow')
    		-> get();
			
		// 购课记录
		$recharges = Recharge::where('sid' , $sid)
			-> orderby('created_at' , 'desc' )
    		-> get();
    	
    	// 已上课程列表
    	$lessons = Lesson::where('sid' , $sid)
			-> where('conduct' , 1 )
			-> orderby('date' , 'desc' )
			-> orderby('etime' , 'desc' )
    		-> get();
    		
    	// 下节课程	
    	$newlessons = Lesson::where('sid' , $sid)
			-> where('conduct' , 0 )
			-> orderby('date' )
			-> orderby('stime' )
    		-> get();
    	
//  	dd($students);
        return view('admin.lessonsinfo' , 
        ['students' => $students , 
        'courses' => $courses , 
        'recharges' => $recharges , 
        'lessons' => $lessons,
        'newlessons' => $newlessons]);
	}
	
	use LessonCreate;
	
	//处理添加单节课程请求
	public function create(Request $request)
	{

//      $this -> validate -> errors() -> add('lerror' , '1');
		$this -> validate($request,[
            'sid' => 'required|numeric|exists:students,id',
            'stime' => 'required',
            'etime' => 'required',
            'date' => 'required|date',
            'mid' => 'nullable|numeric', 
            'cost' => 'required|numeric|max:5',  
            'cost1' => 'required|numeric|max:5',
            'cost2' => 'required|numeric|max:5',         
        ],[
            'required' => '输入不能为空',
            'date.date' => '请按照正确格式输入日期',
        ]);
        
        $ans = $this -> createlesson( $request -> all() );        
		
        return redirect('lessonsinfo/' . $request -> sid );
	}
	
	//处理删除单节课程请求
	public function delete(Request $request)
	{
		
//      $this -> validate -> errors() -> add('lerror' , '1');
//		$this -> validate($request,[
//          'sid' => 'required|numeric|exists:students,id',
//          'id' => 'required|numeric|exists:lessons,id',
//      ]);
        
        $lesson = Lesson::find($request -> id);
//      dd($lesson);
//      $lesson -> delete();
		if ( $lesson -> sid == $request -> sid )
		{			
        	if( $this -> deletelesson( $request -> id ) )
        	{        		
        		return redirect('lessonsinfo/' . $request -> sid );
        	} 
		}
		
        return 0;
	}
	
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
        return view('admin.fupdate' , ['lesson' => $lesson , 'student' => $student , 'cws' => $cws , 'cwid' => $cwid ]);
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

//      dd($request);
		$lesson = Lesson::find( $request -> id );
		$lesson -> name =  $request -> name;
		$lesson -> tname =  $request -> tname;
		$lesson -> vid =  $request -> vid;
		$lesson -> save();
		return $this -> info( $request -> sid );
	}
			
	// 存储文件上传信息
	public function fileupdate(Request $request)
	{
		$lesson = Lesson::find( $request -> id );
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
		return $this -> info( $request -> sid );
	}
}
?>