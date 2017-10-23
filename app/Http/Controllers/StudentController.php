<?php
namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Lesson;
use App\Course;
use App\Recharge;

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
			'grade' => $request -> grade,
			'email' => $request -> email,
		]
		);
		
        return redirect('/admin');
	}
	
	// 修改学生信息显示页面
	public function changeindex(Request $request)
	{
		$student = Student::find($request -> id);
		if ($student)
		{
			return view( 'admin.schange' , [ 'student' => $student ]);
		}
	}
		
	// 修改学生信息操作
	public function change(Request $request)
	{
		$sex = ['boy' , 'girl'];
		$this -> validate($request,[
            'id' => 'required|numeric|exists:students,id',
            'name' => 'required',
            'ename' => 'nullable|alpha',
            'sex' => 'required|in_array:sex',
            'birthday' => 'required|date',
        ],[
            'required' => '输入不能为空',
            'ename.alpha' => '请输入正确的英文名',
            'birthday.date' => '请按照正确格式输入日期',
        ]);
		$student = Student::find($request -> id);
		$info = $request -> all();
		$info['birthday'] = Carbon::parse($request -> birthday);
		if ( $student )
		{
			if ( $student -> update($info) )
			{
				return redirect('/admin');
			}
		}
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
		
		if ( $sid == null ) return view( 'student.connect' );

		// 获取学生信息
		$students = Student::where( 'id' , $sid ) -> first();
				
		if ( $students == null ) return view( 'student.connect' );
			
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
    	
		return view( 'student.info' , [ 'students' => $students , 'lessons' => $lessons , 'recharges' => $recharges , 'newlessons' => $newlessons , 'courses' => $courses ]);

	}
	
}
?>