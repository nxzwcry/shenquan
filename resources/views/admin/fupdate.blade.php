@extends('layouts.app')

@section('head')
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript">	
	function sendcws(){
		var fileObj = $("#cws").get(0).files // 获取文件对象
		var FileController = "{{url('tscwstore')}}";                    // 接收上传文件的后台地址
		 // FormData 对象

        var form = new FormData();

        form.append("url", "lesson{{ $lesson -> id }}/");                        // 可以增加表单数据
        form.append("_token", $('input[name=_token]').val());

        for(var i=0; i< fileObj.length; i++){
        	form.append("cws["+i+"]" , fileObj[i] );
    	}



        // XMLHttpRequest 对象

        var xhr = new XMLHttpRequest();

        xhr.open("post", FileController, true);

        xhr.onload = function () {

            $('#cwpercent').text("上传成功");

        };

        xhr.send(form);


//	    $.ajax({
//	      async: true,
//	      url: 'getcwlist',
//	      type: "post",
//	      data: {'id':strvalue, '_token': $('input[name=_token]').val()},
//	      success: function(data){
//	        $('#list').html("已有课件<br/>"); //清空
//	        for (var i=0;i<data.length;i++){		
//				$('#list').append( data[i] + "<br/>");
//			}
//	      }
//	    });      
	  }
	
	function changetogdcw()
	{
		$("#tscw").attr("class", "hidden");
		$("#gdcw").removeAttr("class");
	}
	function changetotscw()
	{
		$("#gdcw").attr("class", "hidden");
		$("#tscw").removeAttr("class");
		
	}

</script>
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
								<input type="hidden" id="id" name="id" value="{{ $lesson -> id }}"/>
								<input type="hidden" id="sid" name="sid" value="{{ $student -> id }}"/>
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
			                    	<label for="video" class="col-md-4 control-label" >上传文件</label>			                    	
			                    	<div class="col-md-4">
			                    		<input type="file" id="video" />
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
							
							<!--<p id="msg">上传信息：</p>-->
	                	</div>	                
	                </div>
                                
	 				<div role="tabpanel" class="tab-pane fade{{ $errors->has('lerror') ? ' active' : '' }}" id="file">
	 					<div class="panel-body">
		                    <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="/fileupdate">                    			
                    			{{ csrf_field() }}
								<input type="hidden" name="id" value="{{ $lesson -> id }}"/>
								<input type="hidden" name="sid" value="{{ $student -> id }}"/>
								
			                    <div class="form-group">
				            		<label class="col-md-4 control-label" >课件</label>				                        
		                            <div class="col-md-6">
				                        <label class="radio-inline">
										  	<input type="radio" name="type" id="gd" value="gd" {{ $cwid >= 0 ? ' checked' : '' }} onclick="changetogdcw()" required /> 固定课件
										</label>
										<label class="radio-inline">
										  	<input type="radio" name="type" id="ts" value="ts" {{ $cwid < 0 ? ' checked' : '' }} onclick="changetotscw()" required /> 特殊课件
										</label>
									</div>
			                    </div>
			                    <div id="gdcw">
				            		<div class="form-group{{ $errors->has('cwid') ? ' has-error' : '' }}">
				                        <label class="col-md-4 control-label" >课件名称</label>
				
				                        <div class="col-md-6">
											<select onchange="" id="cwid" class="form-control" name="cwid" >
												<option value="0" {{ old('cwid') <> null ? ( old('cwid') == 0 ? ' selected' : '' ) : ( $cwid == 0 ? ' selected' : '' )  }}>请选择课件</option>
												@foreach ( $cws as $cw )												
												  <option value="{{ $cw -> id }}" {{ old('cwid') <> null ? ( old('cwid')== $cw -> id ? ' selected' : '' ) : ( $cwid == $cw -> id ? ' selected' : '' ) }}>{{ $cw -> name }}</option>
												@endforeach
											</select>	
										</div>		
			                        </div>
			                    </div>			                    
			                    <div id="tscw" class="hidden">
			                        <div class="form-group">
			                        	<label class="col-md-4 control-label" ></label>
								        <div class="col-md-4">
								            <input type="file" name="cws[]" id="cws" class="projectfile" multiple="multiple" onchange="sendcws()"/>					            
								        </div>
								        <div class="col-md-4">
				                    		<p class="form-control-static" id="cwpercent"></p>
				                    	</div>
								    </div> 
				                    <div class="form-group{{ $errors->has('cwurl') ? ' has-error' : '' }}">
				                        <label for="cwurl" class="col-md-4 control-label" >课件URL</label>
				
				                        <div class="col-md-6">
				                            <input id="cwurl" type="text" class="form-control" name="cwurl" value="{{ old('cwurl') <> null ? old('cwurl') : ( $cwid < 0 ? $lesson -> cwurl : '' ) }}" />
					                        @if ($errors->has('cwurl'))
				                                <span class="help-block">
				                                    <strong>{{ $errors->first('cwurl') }}</strong>
				                                </span>
				                            @endif
				                        </div>
			                        </div>
			                        <div class="form-group{{ $errors->has('cwurl') ? ' has-error' : '' }}">
			                        	<label class="col-md-4 control-label" >课件列表</label>
			                        	<div class="col-md-6">
					                        <div data-spy="scroll" data-target="#navbar-example" data-offset="0" style="height:100px;overflow:auto; position: relative;">
												<h4 id="ios">iOS</h4>
												<p>iOS 是一个由苹果公司开发和发布的手机操作系统。最初是于 2007 年首次发布 iPhone、iPod Touch 和 Apple 
													TV。iOS 派生自 OS X，它们共享 Darwin 基础。OS X 操作系统是用在苹果电脑上，iOS 是苹果的移动版本。
												</p>
												
											</div>
										</div>
									</div>
								</div>
								<div class="form-group text-center ">
							        <div class="col-md-10 col-md-offset-1">
							            <button type="submit" class="btn btn-primary btn-lg" >保存</button>
							        </div>
							    </div>				
							</form>
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
//		      $('#msg').append("onUploadStarted:" + uploadInfo.file.name + ", endpoint:" + uploadInfo.endpoint + ", bucket:" + uploadInfo.bucket + ", object:" + uploadInfo.object);
		      title = '{{ $student -> ename }}'+'_'+'{{ $lesson -> date }}'+'_'+$('#name').val();
		      fname = uploadInfo.file.name;
		      getauth();
		      uploader.setUploadAuthAndAddress(uploadInfo, uploadauth, uploadaddress);
		    },
		    // 文件上传成功
		    'onUploadSucceed': function (uploadInfo) {
//		      log("onUploadSucceed: " + uploadInfo.file.name + ", endpoint:" + uploadInfo.endpoint + ", bucket:" + uploadInfo.bucket + ", object:" + uploadInfo.object);
//			  $('#msg').append("<br/> 上传成功");
			  $('#percent').text("上传成功");
			  $('#vid').val(videoid);
		    },
		    // 文件上传失败
		    'onUploadFailed': function (uploadInfo, code, message) {
//		      log("onUploadFailed: file:" + uploadInfo.file.name + ",code:" + code + ", message:" + message);
			  $('#percent').text("<br/> 上传失败");
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
//		        $('#msg').append("<br/> 上传超时");
		    }
		});
		uploader.init();
//		$('#msg').append("<br/> 初始化成功");
	};
	     	
	function start() {
//  	log("start upload.");
		var name = $("#name").val();
        if(!$.trim(name)){
            $('#percent').text("课程内容不能为空");
            return false;
        }

//		$('#msg').append("<br/> 开始上传");
    	uploader.startUpload();
	};
			
	document.getElementById("video")
	     .addEventListener('change', function (event) {            
			userData = '{"Vod":{"UserData":"{"IsShowWaterMark":"false","Priority":"7"}"}}';
            uploader.addFile(event.target.files[0], null, null, null, userData);
            fsize = event.target.files[0].size;
//		    $('#msg').append("<br/> 加入文件");   
		    start();
	     });	

</script>
@endsection