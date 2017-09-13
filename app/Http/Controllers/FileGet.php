<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
	
trait FileGet
{
	
	// 通过文件目录获取其中所有的文件名以及文件url
	public function getfiles( $furl )
	{          
        
	}
	
	// 根据文件目录得到该目录下的文件列表
	public function getfilelist( $url )
	{
		$files = Storage::disk('uploads') -> files($url);
		
        return $files;
	}
	
}
?>