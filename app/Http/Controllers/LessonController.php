<?php
namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Lesson;
use App\Course;
use App\Recharge;

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
		$students = Student::where('id' , $sid)
    		-> get(['id' , 'name' , 'ename'])
			-> first();
			
		$courses = Course::where('sid' , $sid)
			-> orderby('dow')
    		-> get();
			
		$recharges = Recharge::where('sid' , $sid)
			-> orderby('created_at' , 'desc' )
    		-> get();
    	
    	$lessons = Lesson::where('sid' , $sid)
			-> orderby('date' , 'desc' )
			-> orderby('etime' , 'desc' )
    		-> get();
    		
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
        ],[
            'required' => '输入不能为空',
            'date.date' => '请按照正确格式输入日期',
        ]);
        
        $ans = $this -> createlesson( $request -> all() );        
		
        return $ans;
	}
	
}
?>