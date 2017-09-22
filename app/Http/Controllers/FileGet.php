<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
	
trait FileGet
{
	
	// 通过文件目录获取其中所有的文件名以及文件url
	public function getfiles( $furl )
	{          
        $files = Storage::disk('uploads') -> files($furl);
        $data = array();
        $i = 0;
        foreach ( $files as $file )
        {
        	$data[$i] = collect( [ 'fname' => substr( $file , strrpos( $file , '/' )+1 ) , 'url' => Storage::disk('uploads') -> url($file) ] );
        	$i++;
        }
        return $data;
	}
	
	// 根据文件目录得到该目录下的文件列表
	public function getfilelist( $url )
	{
		$files = Storage::disk('uploads') -> files($url);
		for ( $i=0 ; $i<count($files) ; $i++)
		{
			$files[$i] = substr( $files[$i] , strrpos( $files[$i] , '/' )+1 );
		}
		
        return $files;
	}
	
	// 根据文件url删除文件
	public function deletefile( $url )
	{
		return Storage::disk('uploads') -> delete($url);
	}
	
}
?>