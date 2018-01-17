<?php
	
namespace App\Http\Controllers;

use App\Student;
use Log;
use Illuminate\Http\Request; 
use App\Wechat;
use EasyWeChat\Message\Material;
use EasyWeChat\Message\Image;
use EasyWeChat\Message\News;

class WechatController extends Controller
{
	
	protected $image_enter_id = 'vtbLSsSNTmRkKNBgjySygAPhUoVetGjbH_D_HZxFFqY';
	protected $news_adv_id = 'vtbLSsSNTmRkKNBgjySygFahZ7t5Y0X1puemnwGXrJ8';
	protected $news_adv =[	  
			  "title" => "深泉教育招聘—英语老师&教学顾问" ,
              "description" => "趁年轻，让我们一起做一点不得了的事情" ,
              "url" => "http://mp.weixin.qq.com/s?__biz=MzI5NTc3MTg2MQ==&mid=100000079&idx=2&sn=104bf2d05afd3dac3f441b834c53c224&chksm=6c4fcaf55b3843e38d15d534cdd70cc1ea23d2a2ff1ebdb0ccc388bb43dc4c9b4e613f18e24f#rd " ,
              "image" => "http://mmbiz.qpic.cn/mmbiz_jpg/a0PJJ0nV5OTZ8Y55PJn2ar76DyNvp3d0Z4JFKfdmicsXJiaVNdTN7ib3TGy9vgrIOp7eVoGZZ1MQbMcf14T5icnyjw/0?wx_fmt=jpeg" ,
            ];
	
	//处理微信的请求消息
	public function serve()
	{
		Log::info('处理微信请求消息开始'); # 注意：Log 为 Laravel 组件，所以它记的日志去 Laravel 日志看，而不是 EasyWeChat 日志

        $wechat = app('wechat');
        $wechat->server->setMessageHandler(function($message) {
	        if ($message->MsgType=='event') {
	            $user_openid = $message->FromUserName;
                Log::info('用户'.$user_openid);
	            if ($message->Event=='subscribe') {
	            	//下面是你点击关注时，进行的操作
					return $this -> entermessage();
	            }
	            else if ($message->Event=='unsubscribe') {
	            	//取消关注时执行的操作，（注意下面返回的信息用户不会收到，因为你已经取消关注，但别的操作还是会执行的<如：取消关注的时候，要把记录该用户从记录微信用户信息的表中删掉>）
					$users = Wechat::where( 'openid' , $user_openid ) -> get();
	                if (  $users -> first() ) {
	                	foreach( $users as $user )
	                	{
	                		if ( $user -> delete() )
	                		{
	                			Log::info('用户 ' . $user -> nickname . ' 已删除');
	                			return '解除关注';
	                		}
	                	}
	                }
	            }
	            else if ($message->Event=='CLICK') {
	            	//自定义菜单
					//深泉招聘菜单
					if ( $message -> EventKey == 'BUTTEN_ADV' )
					{
						return $this -> advertisemessage();
					}
					//报名试课菜单
					else if ( $message -> EventKey == 'BUTTEN_ENTER' )
					{
						return $this -> entermessage();
					}
	            }
	        }
	        else	//自动回复
	        {
				return $this -> entermessage();
	        }

	    });
    
//      $wechat->server->setMessageHandler(function($message){
//          return "欢迎关注 overtrue！";
//      });

        Log::info('处理微信请求消息结束');

        return $wechat->server->serve();
	}
	
	public function menu()
	{
		$wechat = app('wechat');
		$menu = $wechat->menu;
		$menu->destroy(); // 删除全部
		$buttons = [
		    [
		    	"name"       => "联系我们",
		        "sub_button" => [
		            [
		                "type" => "click",
		                "name" => "报名试听",
		                "key"  => "BUTTEN_ENTER"
		            ],
		            [
		                "type" => "click",
		                "name" => "深泉招聘",
		                "key"  => "BUTTEN_ADV"
		            ],
		        ],
		    ],
		    [
                "type" => "view",
                "name" => "绘本跟读",
                "url"  => "http://mp.weixin.qq.com/mp/homepage?__biz=MzI5NTc3MTg2MQ==&hid=1&sn=e3deacf1eb5c5579f36766bbf18eb4b1#wechat_redirect"
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
	
	public function getlist(Request $request)
	{
		$type = $request -> type;
		$offset = $request -> offset;
		$wechat = app('wechat');
		$material = $wechat -> material;
		$lists = $material -> lists( $type , $offset , 10 );
		dd($lists);
	}
	
	//关联微信和学生
	public function connect(Request $request)
	{
		Log::info('关联微信');
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
                Log::info('用户'.$user -> name);
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
	
	public function entermessage()
	{
		$material = new Image(['media_id' => $this -> image_enter_id]);
//		$material = new Material('image', $this -> image_enter_id);
		return $material;
	}
	
	public function advertisemessage()
	{
//		$material = new Material('mpnews', $this -> news_adv_id);
		$material = new News( $this -> news_adv );
		return $material;
	}
}
?>