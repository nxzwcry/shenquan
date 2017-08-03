<?php
namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Lesson;
use App\Classes;
use App\Recharge;

class LessonController extends Controller
{
	// 显示增加页面
	public function index($sid)
	{
		$students = Student::where('id' , $sid)
			-> where('valid' , 1 )
    		-> get(['id' , 'name' , 'ename'])
			-> first();
//  	dd($students);
        return view('admin.clesson' , ['students' => $students]);
	}
	
	// 显示学生课程信息
	public function info($sid)
	{
		$students = Student::where('id' , $sid)
			-> where('valid' , 1 )
    		-> get(['id' , 'name' , 'ename'])
			-> first();
			
		$classes = Classes::where('sid' , $sid)
			-> where('valid' , 1 )
			-> orderby('dow')
    		-> get();
			
		$recharges = Recharge::where('sid' , $sid)
			-> where('valid' , 1 )
    		-> get();
    	
    	$lessons = Lesson::where('sid' , $sid)
			-> where('valid' , 1 )
			-> orderby('date' , 'desc' )
			-> orderby('etime' , 'desc' )
    		-> get();
    		
    	$newlessons = Lesson::where('sid' , $sid)
			-> where('valid' , 1 )
			-> where('conduct' , 0 )
			-> orderby('date' )
			-> orderby('stime' )
    		-> get();
    	
//  	dd($students);
        return view('admin.lessonsinfo' , 
        ['students' => $students , 
        'classes' => $classes , 
        'recharges' => $recharges , 
        'lessons' => $lessons,
        'newlessons' => $newlessons]);
	}
	
	//处理添加单节课程请求
	public function create(Request $request)
	{

        $this -> validate -> errors() -> add('lerror' , '1');
		
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
	
	// 发送上课提醒
	public function send()
	{
		$wechat = app('wechat');
		$notice = $wechat->notice;
		$messageId = $notice->send([
	        'touser' => 'o1XxxxB81qwbsP75Ecoquf5mdCyg',
	        'template_id' => '0vuoBhcp-78VRZTe4Kw50ID6GVRY8v9nWbX8ORHJ2qU',
	        'url' => 'deepspring.cn/wechat/userinfo',
	        'data' => [
	            'first' => '明天有朱瀚东的外教英语课！',
	            'keyword1' => '认识字母A',
	            'keyword2' => '2017-07-28 20:00 ~ 20:30',
	            'remark' => "会议ID:1111111111",
	        ],
	    ]);
	    return 1;
	}
}
?>