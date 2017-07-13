<?php
	
namespace App\Http\Controllers;

use Log;

class WechatController extends Controller
{
	//处理微信的请求消息
	public function serve()
	{
		Log::info('request arrived.'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function($message){
            return "欢迎关注深泉教育！";
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
                "url"  => "http://101.200.52.162/wechat/enter"
            ],
            [
                "type" => "view",
                "name" => "用户信息",
                "url"  => "http://101.200.52.162/wechat/userinfo"
            ],
		];
		$menu->add($buttons);
		return $menu->all();

	}
}
?>