<?php
namespace App\Http\Controllers;

use App\Student;
use App\Lesson;
use Illuminate\Http\Request; 

class WeuserinfController extends Controller
{
	
	//处理微信的请求消息
	public function login()
	{

		return view( 'student.login' );
	}
	
	//显示用户信息
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
		$uid = $request -> uid;
		$students = Student::find($uid);
		$lessons = Lesson::where( 'uid' , $uid )
			-> orderBy( 'time' )
			-> get();
//		dd($lessons);
		return view( 'student.info' , [ 'students' => $students , 'lessons' => $lessons ]);
	}
	
	public function createuser()
	{
//		$student = new Student();
//		$student->name = 'Daisy';
//		$student->sex = 'girl';
//		$bool = $student->save();
		
		//使用模型的Create方法新增数据
		$student = Student::create(
			['name'=>'Daisy','ename' => 'daisy']
		);
	}
	
	public function createlesson()
	{
		$lasson = Lesson::create(
			[ 'uid' => '1',
			  'tname' => 'Brooky',
			  'time' => '20170701',
			  'vurl' => 'baidu.com',
			  'furl' => 'baidu.com'
			]
		);
		dd($lasson);
	}
}
?>