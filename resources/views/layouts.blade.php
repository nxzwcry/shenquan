<!DOCTYPE html>
<html>
	
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/weui.min.css') }}"/>
		<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/jquery-weui.min.css') }}"/>
		<style type="text/css">
			html,body{
				height: 100%;
			}
		</style>
		<title>@yield('title')</title>
	</head>
	
	<body>
		
		<!--@section('header')
		@show-->
		
		<!--@section('footer')
		@show-->
		
		<!--@yield('content','主要内容区域')-->
		
		<div class="weui-tab">
			
		  <div class="weui-tab__bd">
		
		    <div id="tab1" class="weui-tab__bd-item weui-tab__bd-item--active">
		      @yield('userinfo','用户信息页面')
		    </div>
		    
		    <div id="tab2" class="weui-tab__bd-item">
		      @yield('lessons','课程信息区域')
		    </div>
		    
		    <div id="tab3" class="weui-tab__bd-item">
		      @yield('file','课件视频区域')
		    </div>
		    
		  </div>
		  
		  <div class="weui-tabbar">
		    <a class="weui-navbar__item weui-bar__item--on" href="#tab1">
		      学生信息
		    </a>
		    
		    <a class="weui-navbar__item" href="#tab2">
		      课程信息
		      
		    </a>
		    
		    <a class="weui-navbar__item" href="#tab3">
		      课件视频
		      
		    </a>
		  </div>
		
		</div>


		<script src="{{ URL::asset('js/jquery-2.1.4.js') }}"></script>		
		<script src="{{ URL::asset('js/jquery-weui.min.js') }}"></script>
	</body>
	
</html>
