<?php
namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Lesson;

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
	
	//处理添加学生请求
	public function create(Request $request)
	{
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
        
        $etime = Carbon::parse($request -> date . ' ' . $request -> etime);
                
        if ( Carbon::now() -> gte( $etime ) )
        {
        	$conduct = 1;
        }
        else 
        {
        	$conduct = 0;
        }
        
//      dd($conduct);
        
//		$student = new Student();
//		$student->name = 'Daisy';
//		$student->sex = 'girl';
//		$bool = $student->save();
		
//		使用模型的Create方法新增数据
		$lesson = Lesson::create(
		[
			'sid'=> $request -> sid,
			'tname' => $request -> tname,
			'name' => $request -> name,
			'date' => $request -> date,
			'stime' => $request -> stime,
			'etime' => $request -> etime,
			'mid' => $request -> mid,
			'cost' => $request -> cost,
			'cid' => $request -> cid,
			'conduct' => $conduct,
		]
		);
		
        return 1;
	}
}
?>