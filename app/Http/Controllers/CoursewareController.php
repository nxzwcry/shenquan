<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Courseware;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;

class CoursewareController extends Controller
{
	//处理显示请求，将已有课件列表传给视图
	public function index()
	{
		$cws = Courseware::all();
		return view( 'admin.cwupdate' , [ 'cws' => $cws ] );
	}
	
	//处理添加新课件请求
	public function newcw(Request $request)
	{
		
		$this -> validate($request,[
            'name' => 'required|unique:coursewares,name',
            'files' => 'required',
        ],[
            'required' => '输入不能为空',
            'unique' => '指定课件名称已存在',
        ]);
           		
//		使用模型的Create方法新增数据
		$courseware = Courseware::create(
		[
			'name'=> $request -> name,
		]
		);    		
    	
    	$courseware -> url = $courseware -> id . '/';
    	$courseware -> save();          
		
		$files = $request -> file('files');
		$this -> store( $files , 'courseware/' . $courseware -> url );
		
        return redirect('/admin');
	}
	
	//处理上传课件请求
	public function update(Request $request)
	{
		
		$this -> validate($request,[
            'id' => 'required|numeric|exists:coursewares,id',
            'files' => 'required',
        ],[
            'required' => '输入不能为空',
            'exists' => '指定课件系列不存在',
        ]);
           		
		$courseware = Courseware::find($request -> id); 
		   	      
		$files = $request -> file('files');
		$this -> store( $files , 'courseware/' . $courseware -> url );
		
        return redirect('/admin');
	}
	
	// 处理存储课件请求
	public function store( $files , $path )
	{
        foreach( $files as $file )
        {
    		$filename =  $file->getClientOriginalName(); // 文件原名
//  		$realPath = $file->getRealPath();   //临时文件的绝对路径    		 
    		
    		$file->storeAs(
			    $path , $filename , 'uploads'
			);
				
    		// 使用我们新建的uploads本地存储空间（目录）
//          $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
        }
        return 1;
	}
		
	// 处理存储特殊课件请求（响应视图ajax）
	public function tscwstore(Request $request)
	{		   
		$files = $request -> file('cws');
//		dd($files);
		$url = $request -> url;
//		$files = $_POST['cws'];
//		$url = $_POST['url'];
		$this -> store( $files , 'courseware/' . $url );
        return 1;
	}
	
	// 根据课件id得到课件文件列表(响应视图ajax)
	public function getlist()
	{
		$id = $_POST['id'];
		
		$cw = Courseware::find( $id );
		
		if ( $cw -> url <> null )
//			dd($this -> getfilelist( $cw -> url ));
			return $this -> getfilelist( 'courseware/' . $cw -> url );
			
		return 0;
	}
	
	use FileGet;
}
?>