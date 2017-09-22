<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
	
trait FileGet
{
	// 通过文件url获取文件
	public function getfile( $furl )
	{          
        return response() -> file( $furl );
	}
	
	// 通过文件目录获取其中所有的文件名以及文件url
	public function getfiles( $furl )
	{          
        $files = Storage::disk('public') -> files($furl);
        $data = array();
        $i = 0;
        foreach ( $files as $file )
        {
        	$data[$i] = collect( [ 'name' => substr( $file , strrpos( $file , '/' )+1 ) , 'url' => '/storage/' . $file ] );
        	$i++;
        }
        return $data;
	}
	
	// 根据文件目录得到该目录下的文件列表
	public function getfilelist( $url )
	{
		$files = Storage::disk('public') -> files($url);
		for ( $i=0 ; $i<count($files) ; $i++)
		{
			$files[$i] = substr( $files[$i] , strrpos( $files[$i] , '/' )+1 );
		}
		
        return $files;
	}
	
	// 根据文件url删除文件
	public function deletefile( $url )
	{
		return Storage::disk('public') -> delete($url);
	}
	
		
	// 处理存储课件请求
	public function store( $files , $path )
	{
        foreach( $files as $file )
        {
    		$filename =  $file->getClientOriginalName(); // 文件原名
//  		$realPath = $file->getRealPath();   //临时文件的绝对路径    		 
    		
    		$file->storeAs(
			    $path , $filename , 'public'
			);
				
    		// 使用我们新建的public本地存储空间（目录）
//          $bool = Storage::disk('public')->put($filename, file_get_contents($realPath));
        }
        return 1;
	}
}
?>