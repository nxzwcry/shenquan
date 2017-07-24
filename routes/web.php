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
    return view('welcome');
});

Route::any('wechat','WechatController@serve');
Route::any('wechat/menu','WechatController@menu');

Route::any('wechat/connectto','WeuserinfController@connect');
Route::group(['middleware' => ['wechat.oauth']], function () {
    Route::any('wechat/connect', function () {
    return view('student.connect');
    });
});
Route::group(['middleware' => ['wechat.oauth' , 'wechat.checkcon']], function () {
    Route::any('wechat/userinfo', 'WeuserinfController@userinfo');
});
Route::any('wechat/enter','EnterController@index');
Route::get('create','WeuserinfController@createuser');
Route::get('createlesson','WeuserinfController@createlesson');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
