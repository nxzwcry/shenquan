<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="x-ua-compatible" content="IE=edge" >
<meta name="viewport"   content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no"/>
<title>Prismpplayer在线配置</title>
<link rel="stylesheet" href="//g.alicdn.com/de/prismplayer/1.9.9/skins/default/index.css" />
<script type="text/javascript" src="//g.alicdn.com/de/prismplayer/1.9.9/prism-min.js"></script>
</head>
<body>
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
         source:"http://video.deepspring.cn/3a0241ea20254bf4a0fd824b091b8195/3cd7bcd5068944a98ec6ed870677eb16-S00000001-200000.mp4",
         cover:""                  
});
  </script>
</body>