<?php
namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;

class StudentController extends Controller
{
	//处理添加学生请求
	public function create(Request $request)
	{
		$sex = ['boy' , 'girl'];
		$this -> validate($request,[
            'name' => 'required',
            'ename' => 'nullable|alpha',
            'sex' => 'required|in_array:sex',
            'birthday' => 'required|date',
        ],[
            'required' => '输入不能为空',
            'ename.alpha' => '请输入正确的英文名',
            'birthday.date' => '请按照正确格式输入日期',
        ]);
        
//		$student = new Student();
//		$student->name = 'Daisy';
//		$student->sex = 'girl';
//		$bool = $student->save();
		
//		使用模型的Create方法新增数据
		$student = Student::create(
		[
			'name'=> $request -> name,
			'ename' => $request -> ename,
			'sex' => $request -> sex,
			'birthday' => Carbon::parse($request -> birthday) ,
			'gread' => $request -> gread,
			'email' => $request -> email,
		]
		);
		
        return redirect('/admin');
	}
}
?>