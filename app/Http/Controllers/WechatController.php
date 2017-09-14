<?php
	
namespace App\Http\Controllers;

use App\Student;
use Log;
use Illuminate\Http\Request; 
use App\Wechat;

class WechatController extends Controller
{
	//处理微信的请求消息
	public function serve()
	{
		Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');
//      $wechat->server->setMessageHandler(function($message use ($app){
//	        if ($message->MsgType=='event') {
//	             $user_openid = $message->FromUserName;
//	            if ($message->Event=='subscribe') {
//	　　　　　　　　//下面是你点击关注时，进行的操作
//	                $user_info['unionid'] = $message->ToUserName;
//	                $user_info['openid'] = $user_openid;
//	                $userService = $app->user;
//	                $user = $userService->get($user_info['openid']);
//	                $user_info['subscribe_time'] = $user['subscribe_time'];
//	                $user_info['nickname'] = $user['nickname'];
//	                $user_info['avatar'] = $user['headimgurl'];
//	                $user_info['sex'] = $user['sex'];
//	                $user_info['province'] = $user['province'];
//	                $user_info['city'] = $user['city'];
//	                $user_info['country'] = $user['country'];
//	                $user_info['is_subscribe'] = 1;
//	                if (WxStudent::weixin_attention($user_info)) {
//	                    return '欢迎关注';
//	                }else{
//	                    return '您的信息由于某种原因没有保存，请重新关注';
//	                }
//	            }else if ($message->Event=='unsubscribe') {
//	　　　　　　　　//取消关注时执行的操作，（注意下面返回的信息用户不会收到，因为你已经取消关注，但别的操作还是会执行的<如：取消关注的时候，要把记录该用户从记录微信用户信息的表中删掉>）
//	                if (WxStudent::weixin_cancel_attention($user_openid)) {
//	                    return '已取消关注';
//	                }
//	            }
//	        }
//	        
//	    });
    
        $wechat->server->setMessageHandler(function($message){
            return "欢迎关注 overtrue！";
        });

        Log::info('return response.');

        return $wechat->server->serve();
	}
	
	public function menu()
	{
		$wechat = app('wechat');
		$menu = $wechat->menu;
//		$menu->destroy(); // 删除全部
		$buttons = [
		    [
		        "type" => "click",
		        "name" => "近期活动",
		        "key"  => "EVENT"
		    ],
		    [
		        "type" => "view",
		        "name" => "报名试课",
                "url"  => "http://deepspring.cn/wechat/enter"
            ],
            [
                "type" => "view",
                "name" => "用户信息",
                "url"  => "http://deepspring.cn/wechat/userinfo"
            ],
		];
		$menu->add($buttons);
		return $menu->all();

	}
	
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
	
	public function test()
	{
		$test = Wechat::where( 'id' , '>=' , 1 ) -> delete();
//		$test = Wechat::withTrashed()->get();
		dd($test);
		return 1;
	}
}
?>