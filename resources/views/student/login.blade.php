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
			};
			page {
				display: block;
				min-height: 100%;
				background-color:red ;
			}
		</style>
				<title>@yield('title')</title>
	</head>
		
	<body>
	<div class="page">
		{!! Form::open(['action' => 'WeuserinfController@userinfo']) !!}
	   <div class="weui-cell">
	   		<div class="weui-cell__hd">
	       {!! Form::label('uid','学生号:',['class' => 'weui-label']) !!}
	       	</div>
	       	<div class="weui-cell__hd">
	       {!! Form::number('uid','请输入学生号',['class' => 'weui-input']) !!}
	       </div>
	   </div>
	   <div class="weui-cell__hd">
	       {!! Form::submit('确定',['class' => 'weui-btn weui-btn_primary']) !!}
	   </div>
		{!! Form::close() !!}
		</form>
			
		<script src="{{ URL::asset('js/jquery-2.1.4.js') }}"></script>		
		<script src="{{ URL::asset('js/jquery-weui.min.js') }}"></script>
	</div>
	</body>
	
</html>