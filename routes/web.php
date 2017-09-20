<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

//  Route::any('/wechat/video', function () {
//	    	return view('student.video');
//	    });
//	    
//  Route::any('/wechat/video/{videoid}', 'WeuserinfController@videoplay');

// 测试区域
Route::get('wechat/send', 'LessonController@send' );

Route::any('wechat','WechatController@serve');

Route::any('test/{id}','VideoController@update');
    
	Route::post('videoupdate','LessonController@videoupdate');

// 绑定微信号（确认微信已登录）
Route::group(['middleware' => ['wechat.oauth']], function () {
    Route::any('wechat/connect', function () {
    	return view('student.connect');
    });
    Route::any('wechat/connectto','WechatController@connect');    
});


// 用户微信操作中间件（拿到用户信息）
Route::group(['middleware' => ['wechat.oauth' , 'wechat.checkcon']], function () {
    Route::any('wechat/userinfo', 'StudentController@userinfo');
       
    Route::any('/wechat/video/{videoid}', 'VideoController@videoplay');

});



// 后台操作中间件（确认后台已登录）
Route::group(['middleware' => ['auth']], function () {
    
	Route::get('/admin', 'AdminhomeController@index')->name('home');
	
	Route::any('wechat/menu','WechatController@menu');
	Route::any('wechat/enter','EnterController@index');
		
	Route::get('createstudent',function () {
	    	return view('admin.cstudent');
	    });
	    
    Route::post('createstudent','StudentController@create');
    
	Route::get('createlesson/{id}', 'LessonController@index');
	    
    Route::post('createlesson','LessonController@create');
    
	Route::get('createcourse/{id}', 'CourseController@index');
	    
    Route::post('createcourse','CourseController@create');
    
	Route::get('recharge/{id}', 'RechargeController@index');
	    
    Route::post('recharge','RechargeController@create');
    
	Route::get('lessonsinfo/{id}', 'LessonController@info');
	
	Route::get('cwupdate', 'CoursewareController@index');
	    
	Route::post('newcw','CoursewareController@newcw');
	
	Route::post('getcwlist','CoursewareController@getlist');
	
	Route::post('updatecw','CoursewareController@update');
	
    Route::any('video/{videoid}', 'VideoController@videoplay');
    
    Route::any('getvideoupdateauth', 'VideoController@getupdateauth');
       
    Route::get('fileupdate/{lessonid}', 'LessonController@fileupdateindex');
    
    Route::post('fileupdate', 'LessonController@fileupdate');
	
});

Auth::routes();
