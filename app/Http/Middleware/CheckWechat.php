<?php
namespace App\Http\Middleware;

use Closure;
use App\Wechat;
use App\Student;

class CheckWechat{
	
	// 检查微信和学生有没有关联起来
	
	public function handle($request, Closure $next)
    {
    	$user = session('wechat.oauth_user'); // 拿到授权用户资料
    	
    	$con = Wechat::where( 'openid' , $user->id )
    		-> where( 'valid' , '1' ) -> first();
    	
//  	dd($con);
    	
        if ( $con == null ) {
            return redirect('wechat/connect');
        }
        
        $student = Student::where( 'id' , $con -> sid )
    		-> where( 'valid' , '1' ) -> first();
    		
		if ( $student == null ) {
			Wechat::where( 'openid' , $user->id )
    		-> where( 'valid' , '1' ) 
    		-> update(['valid'=> 0]);
        	return redirect('wechat/connect');
        }
        
        $request->session()->put('sid', $con -> sid);

        return $next($request);
    }
	
}

?>