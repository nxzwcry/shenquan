<?php
namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Lesson;
use App\Recharge;

class RechargeController extends Controller
{
	// 显示充值页面
	public function index($sid)
	{
		$students = Student::where('id' , $sid)
    		-> get(['id' , 'name' , 'ename'])
			-> first();
//  	dd($students);
		$recharges = Recharge::where('sid' , $sid)
    		-> get();
    	$all = $recharges -> sum('lessons');
    	$lessons = Lesson::where('sid' , $sid)
			-> where('conduct' , 1 )
			-> where('cost' , '>' , 0)
    		-> get();
    	$used = $lessons -> sum('cost');
    	$surplus = $all - $used;
//  	dd($lessons);
        return view('admin.recharge' , ['students' => $students , 'used' => $used , 'surplus' => $surplus]);
	}
	
	//处理添加充值记录请求
	public function create(Request $request)
	{
		$this -> validate($request,[
            'sid' => 'required|numeric|exists:students,id',
            'lessons' => 'required|numeric|max:200',
            'lessons1' => 'required|numeric|max:200',
            'lessons2' => 'required|numeric|max:200',
            'money' => 'nullable|numeric',          
        ],[
            'required' => '输入不能为空',
            'lessons.max:200' => '请输入200以下的数字',
            'lessons1.max:200' => '请输入200以下的数字',
            'lessons2.max:200' => '请输入200以下的数字',
        ]);
       	
       	$rechargeinfo = $request -> all();
       	
//		使用模型的Create方法新增充值记录
		$recharge = Recharge::create($rechargeinfo);
				
		return redirect('lessonsinfo/' . $request -> sid );
	}	
	
}
?>