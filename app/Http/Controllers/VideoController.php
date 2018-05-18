<?php
namespace App\Http\Controllers;

use App\Lesson;
use App\Http\Controllers\Controller;
use Aliyun\Core\Profile\DefaultProfile;
use Aliyun\Core\DefaultAcsClient;
use vod\Request\V20170321\GetPlayInfoRequest;
use vod\Request\V20170321\CreateUploadVideoRequest;
use Aliyun\Core\Config;
use OSS\OssClient;
use OSS\Core\OssException;

class VideoController extends Controller
{
    protected $accessKeyId = "LTAIM1kjoOKiPGrq";
    protected $accessKeySecret = "rIZhoCetGywhK1rFPPVL9yA4lgSsAa";
    protected $endpoint = "oss-cn-beijing.aliyuncs.com";
    // 处理视频播放请求
    public function videoplay( $lessonid )
    {
        $lesson = Lesson::find( $lessonid );
        if( !$lesson ) return 0; //如果课程id有误
        $videoid = $lesson -> vid;
        if ( substr( $videoid , 0 , 23 ) == "http://img.kktalkee.com" ){
            $title =  $lesson -> student -> ename . '_' . $lesson -> date . '_' . $lesson -> name;
            $signedUrl = $videoid;
        }
        elseif ( substr( $videoid , 0 , 6 ) == "lesson" )
        {
            $title =  $lesson -> student -> ename . '_' . $lesson -> date . '_' . $lesson -> name;
            $bucket= "ds-classvideo";
            $object = $videoid;
            $timeout = 1800; // URL的有效期是1800秒
            try {
                $ossClient = new OssClient($this -> accessKeyId, $this -> accessKeySecret, $this -> endpoint);
            } catch (OssException $e) {
                print $e->getMessage(); // 代码完善师补全log
            }
            if ( $ossClient )
            {
                try{
                    $signedUrl = $ossClient->signUrl($bucket, $object, $timeout);
                } catch(OssException $e) {
                    printf(__FUNCTION__ . ": FAILED\n"); // 代码完善师补全log
                    printf($e->getMessage() . "\n");
                    return;
                }
            }
        }
        else
        {
            Config::load();
//		$videoid = '3a0241ea20254bf4a0fd824b091b8195';
            $regionId = 'cn-shanghai';
            $access_key_id = $this -> accessKeyId;
            $access_key_secret = $this -> accessKeySecret;
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
            $signedUrl = $response -> PlayInfoList -> PlayInfo[0] -> PlayURL;
            $title = $response -> VideoBase -> Title;
        }

        return view( 'student.video' , [ 'playurl' => $signedUrl , 'title' => $title ]);
    }

	// 处理视频播放请求
//	public function videoplay( $videoid )
//	{
//		Config::load();
////		$videoid = '3a0241ea20254bf4a0fd824b091b8195';
//		$regionId = 'cn-shanghai';
//		$access_key_id = 'LTAIM1kjoOKiPGrq';
//		$access_key_secret = 'rIZhoCetGywhK1rFPPVL9yA4lgSsAa';
//		$profile = DefaultProfile::getProfile($regionId, $access_key_id, $access_key_secret);
//		$client = new DefaultAcsClient($profile);
//		$request = new GetPlayInfoRequest();
////		$request->setAcceptFormat('JSON');
////		$request->setRegionId($regionId);
//		$request->setVideoId($videoid);            //视频ID
//		$request->setFormats('mp4');
//		$request->setAuthTimeout('1800');
////		$request->setChannel('HTTP');
//		$response = $client->getAcsResponse($request);
//		$playurl = $response -> PlayInfoList -> PlayInfo[0] -> PlayURL;
//		$title = $response -> VideoBase -> Title;
//
//		return view( 'student.video' , [ 'playurl' => $playurl , 'title' => $title ]);
//	}
	
	// 处理获取上传地址和凭证的请求(Ajax)
//	public function getupdateauth()
//	{
//		$title = $_POST['title'];
//		$fname = $_POST['fname'];
//		$fsize = $_POST['fsize'];
//
//		Config::load();
//		$regionId = 'cn-shanghai';
//		$access_key_id = 'LTAIpaZDiR8Btjan';
//		$access_key_secret = 'klSWoIFWwEXpZMRelW3LhSroqprPO9';
//		$profile = DefaultProfile::getProfile($regionId, $access_key_id, $access_key_secret);
//		$client = new DefaultAcsClient($profile);
//
//		$request = $request = new CreateUploadVideoRequest();
//		$request->setAcceptFormat('JSON');
//		$request->setRegionId($regionId);
//		$request->setTitle($title);           //视频标题
//		//视频源文件名称(必须包含扩展名)
//   		$request->setFileName($fname);
//		//视频源文件字节数
//   		$request->setFileSize($fsize);
//		$response = $client->getAcsResponse($request);
//
////		dd($response);
//		$array = array('uploadaddress' => $response -> UploadAddress , 'videoid' => $response -> VideoId , 'uploadauth' => $response -> UploadAuth);
//		return json_encode($array);
//	}


    protected $upId = "LTAIpaZDiR8Btjan";
    protected $upSecret = "klSWoIFWwEXpZMRelW3LhSroqprPO9";
    protected $host = "http://ds-classvideo.oss-cn-beijing.aliyuncs.com";
    // 处理获取上传签名请求(Ajax)
    public function getupdateauth()
    {
        $lessonid = $_POST['lessonid'];

        $now = time();
        $expire = 30; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
        $end = $now + $expire;
        $expiration = $this -> gmt_iso8601($end);

        $dir = 'lesson' . $lessonid . '/';

        //最大文件大小.用户可以自己设置
        $condition = array(0=>'content-length-range', 1=>0, 2=>1048576000);
        $conditions[] = $condition;

        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start = array(0=>'starts-with', 1=>'$key', 2=>$dir);
        $conditions[] = $start;


        $arr = array('expiration'=>$expiration,'conditions'=>$conditions);
        //echo json_encode($arr);
        //return;
        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $this -> upSecret, true));

        $response = array();
        $response['accessid'] = $this -> upId;
        $response['host'] = $this -> host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;
        return json_encode($response);
    }

    public function gmt_iso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }
}
?>