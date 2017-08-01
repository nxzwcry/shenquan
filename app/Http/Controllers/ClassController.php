<?php
namespace App\Http\Controllers;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Student;
use App\Classes;
use App\Lesson;

class ClassController extends Controller
{
	// 显示增加页面
	public function index($sid)
	{
		$students = Student::where('id' , $sid)
    		-> get(['id' , 'name' , 'ename'])
			-> first();
//  	dd($students);
        return view('admin.cclass' , ['students' => $students]);
	}
	
	//处理添加固定课程请求
	public function create(Request $request)
	{
		$this -> validate($request,[
            'sid' => 'required|numeric|exists:students,id',
            'stime' => 'required',
            'etime' => 'required',
            'sdate' => 'required|date',
            'edate' => 'nullable|date',
            'mid' => 'nullable|numeric', 
            'cost' => 'required|numeric|max:5',           
        ],[
            'required' => '输入不能为空',
            'date.date' => '请按照正确格式输入日期',
        ]);
       	
//		使用模型的Create方法新增固定课程数据
//		$class = Classes::create(
//		[
//			'sid'=> $request -> sid,
//			'tname' => $request -> tname,
//			'dow' => $request -> dow,
//			'sdate' => Carbon::parse($request -> sdate . ' 0:00:00') ,
//			'edate' => Carbon::parse($request -> edate . ' 23:59:59') ,
//			'stime' => $request -> stime,
//			'etime' => $request -> etime,
//			'mid' => $request -> mid,
//			'cost' => $request -> cost,
//			'cid' => $request -> cid
//		]
//		);
		
		
		$class = new Classes();
		$class->sid = $request -> sid;
		$class->tname = $request -> tname;
		$class->dow = $request -> dow;
		$class->sdate = Carbon::parse($request -> sdate . ' 0:00:00');
		if ( $request -> edate == null )
		{
			$class->edate = null;
		}
		else
		{
			$class->edate = Carbon::parse($request -> edate . ' 23:59:59') ;
		}
		$class->stime = $request -> stime;
		$class->etime = $request -> etime;
		$class->mid = $request -> mid;
		$class->cost = $request -> cost;
		$class->cid = $request -> cid;		
		
		$bool = $class->save();


		if ( $bool ){
		    $this-> clesson($class);
		    return redirect('/admin');
		    }
		else
			return 0;
	}
	
	//根据固定课程添加单节课程请求
	public function clesson(Classes $class)
	{		
       	$now = Carbon::now();
       	
       	if ( $class -> sdate -> dayOfWeek <= $class -> dow )
       	{
       		// 追加一个自定义的 name=date
//			$request -> offsetSet('date', $now -> addDays( $class -> dow - $today ) -> toDateString() );
			$next = $class -> sdate -> addDays( $class -> dow - $class -> sdate -> dayOfWeek );
       	}
       	else
       	{
       		$next = $class -> sdate -> addDays( $class -> dow - $class -> sdate -> dayOfWeek + 7 );
       	}
       	
       	if ( $class -> edate == null )
       	{
       		$edate = Carbon::now();	
       		$edate -> addDays( 20 );	
       	}
       	else 
       	{
       		$edate = $class -> edate;
       	}
       	       	
       	while ( $next -> lte( $edate ) && $next -> lte( $now ) )
       	{
       		$this -> createlesson( $class , $next , 1 );
       		$next = $next -> addDays(7);
       	}
       	
       	if ( $next -> lte( $edate ) && $next -> gt( $now ) )
       	{
       		$this -> createlesson( $class , $next , 0 );       		
       	}
       	return 1;
	}
	
	//添加单节课程操作
	public function createlesson( Classes $class , Carbon $date , $conduct )
	{			
//		使用模型的Create方法新增单节数据
		$lesson = Lesson::create(
		[
			'classid' => $class -> id,
			'sid'=> $class -> sid,
			'tname' => $class -> tname,
			'name' => $class -> name,
			'date' => $date -> toDateString(),
			'stime' => $class -> stime,
			'etime' => $class -> etime,
			'mid' => $class -> mid,
			'cost' => $class -> cost,
			'cid' => $class -> cid,
			'conduct' => $conduct,
		]
		);
		return $lesson;
	}
	
}
?>