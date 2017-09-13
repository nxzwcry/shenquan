<?php
namespace App\Http\Controllers;

use App\Student;
use App\Lesson;
use App\Wechat;
use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use Log;

class WeuserinfController extends Controller
{
	
	//关联微信和学生
	public function connect(Request $request)
	{
		Log::info('before captcha.');
		$this->validate($request, [
		    'captcha' => 'required|captcha'
		]);
		Log::info('after captcha.');
		$user = session('wechat.oauth_user'); // 拿到授权用户资料
		$sid = $request -> sid;
		$students = Student::where('id' , $sid) -> first();
//		dd($user);
		if( $students != null )
		{
			if( $request -> sname == $students -> name )
			{
				$wechat = Wechat::create(
					[ 'sid' => $sid,
					  'openid' => $user -> id,
					  'name' => $user -> name,
					  'nickname' => $user -> nickname
					]
				);
				$request->session()->put('sid', $sid);
			}
			else
			{
				return view( 'student.connect' );
			}
		}
		else
		{
			return view( 'student.connect' );
		}
		return redirect('wechat/userinfo');
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
	
	public function createlesson()
	{
		$lesson = Lesson::create(
			[ 'sid' => '1',
			  'tname' => 'Brooky',
			  'date' => '20170701',
			  'vurl' => 'baidu.com',
			  'furl' => 'baidu.com'
			]
		);
		dd($lesson);
	}

}
?>