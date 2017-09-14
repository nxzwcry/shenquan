<?php
namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Lesson;

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
	
	// 在微信客户端显示用户信息
	public function userinfo(Request $request)
	{
		//主键查找
//      $students = Student::find(1);
        
        //打印时间
//      echo $students->created_at;
		//自定义格式打印时间
//		echo date('Y年m月d日 H:i:s');
//		$students = Student::where('id','>','1')
//			->orderBy('created_at','desc')
//			->first();
//		dd($students);
//		$this->validate($request, [
//		        'uid' => 'required|unique:posts|max:7',
//		    ]);
		
		$sid = $request->session()->get('sid', null);
		
//			dd($sid);
		if ( $sid == null ) return view( 'student.connect' );

		$students = Student::where( 'id' , $sid ) -> first();
		
		if ( $students == null ) return view( 'student.connect' );
			
		$lessons = Lesson::where( 'sid' , $sid )
			-> orderBy( 'date'  , 'desc' )
			->orderBy('stime','desc')
			-> get();
		return view( 'student.info' , [ 'students' => $students , 'lessons' => $lessons ]);

	}
	
}
?>