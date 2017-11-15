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

Route::get('test/{url}','CoursewareController@getfile')->where('url', '.*$');
    
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
    
	Route::get('flist/{url}', 'CoursewareController@showflist');
	
	Route::get('cwlist/{url}', 'CoursewareController@showcwlist');

});



// 后台操作中间件（确认后台已登录）
Route::group(['middleware' => ['auth']], function () {
    
	Route::get('/admin', 'AdminhomeController@index')->name('home');
	
	Route::any('wechat/menu','WechatController@menu');
	Route::get('wechat/list/{type}/{offset}', 'WechatController@getlist');
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
	
	Route::post('urlgetcwlist','CoursewareController@urlgetcwlist');
	
	Route::post('deletecw','CoursewareController@deletecw');
	
	Route::post('urlgetflist','CoursewareController@urlgetflist');
	
	Route::post('deletef','CoursewareController@deletef');
	
    Route::any('video/{lessonid}', 'VideoController@videoplay');
    
    Route::any('getvideoupdateauth', 'VideoController@getupdateauth');
       
    Route::get('fileupdate/{lessonid}', 'LessonController@fileupdateindex');
    
    Route::post('fileupdate', 'LessonController@fileupdate');
    
	Route::post('videoupdate','LessonController@videoupdate');
	
	Route::post('tscwstore','CoursewareController@tscwstore');
	
	Route::post('fstore','CoursewareController@fstore');
	
	Route::get('showflist/{url}', 'CoursewareController@showflist');
	
	Route::get('showcwlist/{url}', 'CoursewareController@showcwlist');
	
	Route::get('deletelesson/{sid}/{id}', 'LessonController@delete');
	
	Route::post('deletecourse', 'CourseController@delete');
	
	Route::get('course/stop/{sid}/{id}', 'CourseController@stop');	
	
	Route::get('course/restart/{sid}/{id}', 'CourseController@restart');
	
	Route::post('student/change', 'StudentController@change');	
	
	Route::get('student/change/{id}', 'StudentController@changeindex');	
	
	Route::post('lesson/change', 'LessonController@change');	
	
	Route::get('lesson/change/{id}', 'LessonController@changeindex');
		
	Route::get('recharge/delete/{sid}/{id}', 'RechargeController@delete');

    Route::get('class/{cid}', 'ClassController@info');

    Route::post('/class/addstudent', 'ClassController@add');

    Route::get('/class/deletestudent/{cid}/{sid}', 'ClassController@deletestudent');

    Route::post('/class/createcourse','ClassController@createcourse');

    Route::get('/class/createcourse/{id}', 'ClassController@createcourseindex');
	
});

Auth::routes();
