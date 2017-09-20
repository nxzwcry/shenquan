<?php
namespace App\Http\Controllers;

use App\Lesson;
use App\Http\Controllers\Controller;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use vod\Request\V20170321\GetPlayInfoRequest;
use vod\Request\V20170321\CreateUploadVideoRequest;
use Aliyun\Core\Config;

class VideoController extends Controller
{
	// 处理视频播放请求
	public function videoplay( $videoid )
	{
		Config::load();		
//		$videoid = '3a0241ea20254bf4a0fd824b091b8195';
		$regionId = 'cn-shanghai';
		$access_key_id = 'LTAIM1kjoOKiPGrq';
		$access_key_secret = 'rIZhoCetGywhK1rFPPVL9yA4lgSsAa';
		$profile = DefaultProfile::getProfile($regionId, $access_key_id, $access_key_secret);
		$client = new DefaultAcsClient($profile);
		$request = new GetPlayInfoRequest();
//		$request->setAcceptFormat('JSON');
//		$request->setRegionId($regionId);
		$request->setVideoId($videoid);            //视频ID
		$request->setFormats('mp4');
		$request->setAuthTimeout('1800');
//		$request->setChannel('HTTP');
		$response = $client->getAcsResponse($request);
		$playurl = $response -> PlayInfoList -> PlayInfo[0] -> PlayURL;
		$title = $response -> VideoBase -> Title;
		
		return view( 'student.video' , [ 'playurl' => $playurl , 'title' => $title ]);
	}
	
	// 处理获取上传地址和凭证的请求(Ajax)
	public function getupdateauth()
	{
		$title = $_POST['title'];
		$fname = $_POST['fname'];
		$fsize = $_POST['fsize'];
		
		Config::load();		
		$regionId = 'cn-shanghai';
		$access_key_id = 'LTAIpaZDiR8Btjan';
		$access_key_secret = 'klSWoIFWwEXpZMRelW3LhSroqprPO9';
		$profile = DefaultProfile::getProfile($regionId, $access_key_id, $access_key_secret);
		$client = new DefaultAcsClient($profile);
		
		$request = $request = new CreateUploadVideoRequest();
		$request->setAcceptFormat('JSON');
		$request->setRegionId($regionId);
		$request->setTitle($title);           //视频标题
		//视频源文件名称(必须包含扩展名)
   		$request->setFileName($fname);
		//视频源文件字节数
   		$request->setFileSize($fsize);
		$response = $client->getAcsResponse($request);
		
//		dd($response);
		$array = array('uploadaddress' => $response -> UploadAddress , 'videoid' => $response -> VideoId , 'uploadauth' => $response -> UploadAuth);
		return json_encode($array);
	}
}
?>