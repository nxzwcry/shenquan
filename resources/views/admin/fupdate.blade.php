@extends('layouts.app')

@section('head')
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">

@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <ul class="nav nav-tabs" role="tablist">      
					<li role="presentation" class="active">
					  	<a href="#video" role="tab" data-toggle="tab">上传视频</a>
					</li>    
					<li role="presentation">
					  	<a href="#file" role="tab" data-toggle="tab">上传课件/附件</a>
					</li>    					  
				</ul> 
				<div class="tab-content"> 
	 				<div role="tabpanel" class="tab-pane fade in active" id="video">
			            <div class="panel-body">
			            	<form class="form-horizontal" enctype="multipart/form-data" method="POST" action="/videoupdate">                    			
                    			{{ csrf_field() }}
								<input type="hidden" name="id" value="{{ $lesson -> id }}"/>
								<input type="hidden" name="sid" value="{{ $student -> id }}"/>
			            		<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			                        <label for="name" class="col-md-4 control-label" >课件名称*</label>
			
			                        <div class="col-md-6">
			                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') <> null ? old('name') : $lesson -> name }}" required>
				                        @if ($errors->has('name'))
			                                <span class="help-block">
			                                    <strong>{{ $errors->first('name') }}</strong>
			                                </span>
			                            @endif
			                        </div>
		                        </div>
		                        <div class="form-group{{ $errors->has('tname') ? ' has-error' : '' }}">
			                        <label for="tname" class="col-md-4 control-label" >授课教师</label>
			
			                        <div class="col-md-6">
			                            <input id="tname" type="text" class="form-control" name="tname" value="{{ old('tname') <> null ? old('tname') : $lesson -> tname }}">
				                        @if ($errors->has('tname'))
			                                <span class="help-block">
			                                    <strong>{{ $errors->first('tname') }}</strong>
			                                </span>
			                            @endif
			                        </div>
		                        </div>
		                        <div class="form-group">
			                        <label class="col-md-4 control-label" >上课时间</label>
									<div class="col-md-6">
			                            <p class="form-control-static">{{ $lesson -> date }}</p>
			                       </div>
			                    </div>    
			                    <div class="form-group">
			                    	<div class="col-md-4">
			                    	</div>
			                    	<div class="col-md-6">
			                    		<p class="help-block">请先补全/修改课件名称后再选择文件</p>
			                    	</div>
			                    </div>
			                    <div class="form-group">
			                    	<div class="col-md-4 control-label">
			                    	</div>
			                    	<div class="col-md-6">
			                    		<input type="file" id="video" />
			                    	</div>
			                    </div>
			                    <div class="form-group">
			                    	<div class="col-md-4">
			                    	</div>
			                    	<div class="col-md-2">
			                    		<button class="btn btn-default" id="startb" type="button" onclick="start()" disabled="disabled">开始上传</button>
			                    	</div>
			                    	<div class="col-md-4">
			                    		<p class="form-control-static" id="percent"></p>
			                    	</div>
			                    </div>
			                    <div class="form-group{{ $errors->has('vid') ? ' has-error' : '' }}">
			                        <label for="vid" class="col-md-4 control-label" >视频ID</label>
			
			                        <div class="col-md-6">
			                            <input id="vid" type="text" class="form-control" name="vid" value="{{ old('vid') <> null ? old('vid') : $lesson -> vid }}" required>
				                        @if ($errors->has('vid'))
			                                <span class="help-block">
			                                    <strong>{{ $errors->first('vid') }}</strong>
			                                </span>
			                            @endif
			                        </div>
		                        </div>
								<div class="form-group text-center ">
							        <div class="col-md-10 col-md-offset-1">
							            <button type="submit" class="btn btn-primary btn-lg">保存</button>
							        </div>
							    </div>				
							</form>
							
							<p id="msg">上传信息：</p>
	                	</div>	                
	                </div>
                                
	 				<div role="tabpanel" class="tab-pane fade{{ $errors->has('lerror') ? ' active' : '' }}" id="file">
	 					<div class="panel-body">
		                    
	                	</div>
	 				</div>
                
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('tail')
<script src="{{ asset('js/aliyun-sdk.min.js') }}"></script>
<script src="{{ asset('js/vod-sdk-upload-1.0.6.min.js') }}"></script>
<script>			
    var uploader;
    var fhave = 0;
    var uploadauth;
    var uploadaddress;
    var videoid;
    var fname;
    var title;
    var fsize;
    
	function getauth(){
	    $.ajax({
	      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	  },
	      timeout: 3000,
	      async: false,
	      url: '/getvideoupdateauth',
	      type: "post",
	      data: { 'title': title , 'fname': fname , 'fsize': fsize },
	      success: function(data){
	      	var jsonObj = JSON.parse( data );
	      	uploadaddress = jsonObj.uploadaddress;
	        videoid = jsonObj.videoid;
	        uploadauth = jsonObj.uploadauth;
	      }
	    });      
	}
	  
	window.onload = new function() {
		uploader = new VODUpload({
		    // 开始上传
		    'onUploadstarted': function (uploadInfo) {
		      $('#msg').append("onUploadStarted:" + uploadInfo.file.name + ", endpoint:" + uploadInfo.endpoint + ", bucket:" + uploadInfo.bucket + ", object:" + uploadInfo.object);
		      title = '{{ $student -> ename }}'+'_'+'{{ $lesson -> date }}'+'_'+$('#name').val();
		      fname = uploadInfo.file.name;
		      getauth();
		      uploader.setUploadAuthAndAddress(uploadInfo, uploadauth, uploadaddress);
			  $('#msg').append("<br/> 开始上传");
		    },
		    // 文件上传成功
		    'onUploadSucceed': function (uploadInfo) {
//		      log("onUploadSucceed: " + uploadInfo.file.name + ", endpoint:" + uploadInfo.endpoint + ", bucket:" + uploadInfo.bucket + ", object:" + uploadInfo.object);
			  $('#msg').append("<br/> 上传成功");
			  $('#percent').text("上传成功");
			  $('#vid').val(videoid);
		    },
		    // 文件上传失败
		    'onUploadFailed': function (uploadInfo, code, message) {
//		      log("onUploadFailed: file:" + uploadInfo.file.name + ",code:" + code + ", message:" + message);
			  $('#msg').append("<br/> 上传失败");
		    },
		    // 文件上传进度，单位：字节
		    'onUploadProgress': function (uploadInfo, totalSize, uploadedSize) {
//		        log("onUploadProgress:file:" + uploadInfo.file.name + ", fileSize:" + totalSize + ", percent:" + Math.ceil(uploadedSize * 100 / totalSize) + "%");
				$('#percent').text("上传进度："+Math.ceil(uploadedSize * 100 / totalSize) + "%");
		    },
		    // 上传凭证超时
		    'onUploadTokenExpired': function () {
		        console.log("onUploadTokenExpired");
		        // uploader.resumeUploadWithAuth(uploadAuth);
		        $('#msg').append("<br/> 上传超时");
		    }
		});
		uploader.init();
		$('#msg').append("<br/> 初始化成功");
	};
		
	document.getElementById("video")
	     .addEventListener('change', function (event) {            
			userData = '{"Vod":{"UserData":"{"IsShowWaterMark":"false","Priority":"7"}"}}';
            uploader.addFile(event.target.files[0], null, null, null, userData);
            fsize = event.target.files[0].size;
            $('#startb').removeAttr("disabled");
		    $('#msg').append("<br/> 加入文件");   
	     });	
	     	
	function start() {
//  	log("start upload.");
		$('#msg').append("<br/> 开始上传按钮");
		var name = $("#name").val();
        if(!$.trim(name)){
            $('#msg').append("<br/> 课程内容不能为空");
            return false;
        }

    	uploader.startUpload();
	};
		
</script>
@endsection