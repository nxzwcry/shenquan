<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="x-ua-compatible" content="IE=edge" >
<meta name="viewport"   content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>
<title>{{ $title }}</title>
<link rel="stylesheet" href="//g.alicdn.com/de/prismplayer/1.9.9/skins/default/index.css" />
<script type="text/javascript" src="//g.alicdn.com/de/prismplayer/1.9.9/prism-min.js"></script>
</head>
<body>
	<h1>{{ $title }}</h1>
  	<!--<a href="{{ $playurl }}">下载视频</a>-->
 	<div  class="prism-player" id="J_prismPlayer" style="position: absolute;left:0%;"></div>
 	<script>
	    var player = new prismplayer({
	    id: "J_prismPlayer",
	         autoplay: false,
	         isLive:false,
	         playsinline:false,
	         width:"100%",
	         height:"40%",
	         controlBarVisibility:"always",
	         useH5Prism:false,
	         useFlashPrism:false,
	         source:"{{ $playurl }}",
	         cover:""                  
	});
	 </script>
</body>