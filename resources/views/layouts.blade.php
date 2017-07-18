<!DOCTYPE html>
<html>
	
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../../../public/css/weui.mini.css"/>
		<title>@yield('title')</title>
	</head>
	
	<body>
		
		@section('header')
		@show
		
		@yield('content','主要内容区域')
		
		@section('footer')
		@show
		
	</body>
	
</html>
