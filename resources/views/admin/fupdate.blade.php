@extends('layouts.app')

@section('head')
	<link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript">
        function sendcws(){
            var fileObj = $("#cws").get(0).files // 获取文件对象
            var FileController = "{{url('tscwstore')}}";                    // 接收上传文件的后台地址
            // FormData 对象

            var form = new FormData();
            var cwurl;
            if ( $('#cwurl').val() == '' )
            {
                cwurl = "lesson{{ $lesson -> id }}/";
            }
            else{
                cwurl = $('#cwurl').val();
            }
            form.append("url", cwurl);                        // 可以增加表单数据
            form.append("_token", $('input[name=_token]').val());

            for(var i=0; i< fileObj.length; i++){
                form.append("cws["+i+"]" , fileObj[i] );
            }



            // XMLHttpRequest 对象

            var xhr = new XMLHttpRequest();

            xhr.open("post", FileController, true);

            xhr.onload = function () {

                $('#cwpercent').text("上传成功");
                $('#cwurl').val(cwurl);
                $('#cwurl').attr("readonly", "readonly");
                setlist();
            };

            xhr.upload.addEventListener("progress", progressFunction, false);

            xhr.send(form);


        }

        function sendfs(){
            var fileObj = $("#fs").get(0).files // 获取文件对象
            var FileController = "{{url('fstore')}}";                    // 接收上传文件的后台地址
            // FormData 对象

            var form = new FormData();
            var furl;
            if ( $('#furl').val() == '' )
            {
                furl = "lesson{{ $lesson -> id }}/";
            }
            else{
                furl = $('#furl').val();
            }
            form.append("url", furl);                        // 可以增加表单数据
            form.append("_token", $('input[name=_token]').val());

            for(var i=0; i< fileObj.length; i++){
                form.append("fs["+i+"]" , fileObj[i] );
            }



            // XMLHttpRequest 对象

            var xhr = new XMLHttpRequest();

            xhr.open("post", FileController, true);

            xhr.onload = function () {

                $('#fpercent').text("上传成功");
                $('#furl').val(furl);
                $('#furl').attr("readonly", "readonly");
                setflist();
            };

            xhr.upload.addEventListener("progress", fprogressFunction, false);

            xhr.send(form);


        }

        function progressFunction(evt) {

            $('#cwpercent').text("上传进度："+Math.round(evt.loaded / evt.total * 100) + "%");

        }

        function fprogressFunction(evt) {

            $('#fpercent').text("上传进度："+Math.round(evt.loaded / evt.total * 100) + "%");

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
        function setlist()
        {
            var cwurl;
            if ( $('#cwurl').val() == '' )
            {
                cwurl = "lesson{{ $lesson -> id }}/";
            }
            else{
                cwurl = $('#cwurl').val();
            }
            $.ajax({
                timeout: 3000,
                async: true,
                url: '/urlgetcwlist',
                type: "post",
                data: {'url':cwurl, '_token': $('input[name=_token]').val()},
                success: function(data){
                    $('#cwlist').html(""); //清空
                    for (var i=0;i<data.length;i++){
                        $('#cwlist').append( '<tr><td class="col-md-11">'+data[i]+'</td><td class="col-md-1"><a href="javascript:void(0);"  onclick="cwdel(\''+data[i]+'\')" ><span class="glyphicon glyphicon-remove" ></span></a></td></tr>' );
                    }
                }
            });
        }
        function cwdel(fname){
            var cwurl;
            if ( $('#cwurl').val() == '' )
            {
                cwurl = "lesson{{ $lesson -> id }}/";
            }
            else{
                cwurl = $('#cwurl').val();
            }
            $.ajax({
                timeout: 3000,
                async: true,
                url: '/deletecw',
                type: "post",
                data: {'url':cwurl+fname, '_token': $('input[name=_token]').val()},
                success: function(data){
                    setlist();
                }
            });
        }

        function setflist()
        {
            var furl;
            if ( $('#furl').val() == '' )
            {
                furl = "lesson{{ $lesson -> id }}/";
            }
            else{
                furl = $('#furl').val();
            }
            $.ajax({
                timeout: 3000,
                async: true,
                url: '/urlgetflist',
                type: "post",
                data: {'url':furl, '_token': $('input[name=_token]').val()},
                success: function(data){
                    $('#flist').html(""); //清空
                    for (var i=0;i<data.length;i++){
                        $('#flist').append( '<tr><td class="col-md-11">'+data[i]+'</td><td class="col-md-1"><a href="javascript:void(0);"  onclick="fdel(\''+data[i]+'\')" ><span class="glyphicon glyphicon-remove" ></span></a></td></tr>' );
                    }
                }
            });
        }
        function fdel(fname){
            var furl;
            if ( $('#furl').val() == '' )
            {
                furl = "lesson{{ $lesson -> id }}/";
            }
            else{
                furl = $('#furl').val();
            }
            $.ajax({
                timeout: 3000,
                async: true,
                url: '/deletef',
                type: "post",
                data: {'url':furl+fname, '_token': $('input[name=_token]').val()},
                success: function(data){
                    setflist();
                }
            });
        }

	</script>
@endsection

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<ol class="breadcrumb">
						<li><a href="{{ route('home') }}">首页</a></li>
						<li><a href="{{ url('lessonsinfo') . '/' . $student -> id }}">学生课程信息</a></li>
						<li class="active">上传附件</li>
					</ol>
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active">
							<a href="#video" role="tab" data-toggle="tab">上传视频</a>
						</li>
						<li role="presentation">
							<a href="#file" role="tab" data-toggle="tab">上传课件/文件</a>
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
									<div id="container" class="form-group">
										<label for="video" class="col-md-4 control-label" >上传文件</label>
										<div class="col-md-6">
											{{--<input type="file" id="video" />--}}
                                            <div id="ossfile">你的浏览器不支持flash,Silverlight或者HTML5！</div>
										</div>
										<div class="col-md-2">
											{{--<p class="form-control-static" id="percent"></p>--}}
                                            <a id="selectfiles" href="javascript:void(0);" >选择文件</a>
										</div>
									</div>
									{{--<div id="container" class="form-group">--}}
										{{--<div class="col-md-4 control-label" >--}}
											{{--<a id="selectfiles" href="javascript:void(0);" >上传文件</a>--}}
										{{--</div>--}}
										{{--<div class="col-md-6">--}}
											{{--<div id="ossfile">你的浏览器不支持flash,Silverlight或者HTML5！</div>--}}
										{{--</div>--}}
										{{--<div class="col-md-2">--}}
											{{--<a id="postfiles" href="javascript:void(0);">开始上传</a>--}}
										{{--</div>--}}
									{{--</div>--}}
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
												<input type="file" id="cws" class="projectfile" multiple="multiple" onchange="sendcws()"/>
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
										<div class="form-group">
											<div class="col-md-4">
											</div>
											<div class="col-md-6">
												<p class="help-block">URL的最后需包含"/"</p>
											</div>
										</div>
										<div class="form-group">
											<label class="col-md-4 control-label" >课件列表</label>
											<div class="col-md-6">
												<div data-spy="scroll" data-target="#navbar-example" data-offset="0" style="height:100px;overflow:auto; position: relative;">
													<table class="table table-hover" id="cwlist">

													</table>

												</div>
											</div>
										</div>
									</div>
									<hr/>
									<div class="form-group">
										<label class="col-md-4 control-label" >文件（反馈/作业）</label>
										<div class="col-md-4">
											<input type="file" id="fs" class="projectfile" multiple="multiple" onchange="sendfs()"/>
										</div>
										<div class="col-md-4">
											<p class="form-control-static" id="fpercent"></p>
										</div>
									</div>

									<div class="form-group{{ $errors->has('furl') ? ' has-error' : '' }}">
										<label for="furl" class="col-md-4 control-label" >附件URL</label>

										<div class="col-md-6">
											<input id="furl" type="text" class="form-control" name="furl" value="{{ old('furl') <> null ? old('furl') : $lesson -> furl }}" />
											@if ($errors->has('furl'))
												<span class="help-block">
				                                    <strong>{{ $errors->first('furl') }}</strong>
				                                </span>
											@endif
										</div>
									</div>
									<div class="form-group">
										<div class="col-md-4">
										</div>
										<div class="col-md-6">
											<p class="help-block">URL的最后需包含"/"</p>
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-4 control-label" >附件列表</label>
										<div class="col-md-6">
											<div data-spy="scroll" data-target="#navbar-example" data-offset="0" style="height:100px;overflow:auto; position: relative;">
												<table class="table table-hover" id="flist">

												</table>

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
	{{--<script src="{{ asset('js/aliyun-sdk.min.js') }}"></script>--}}
	{{--<script src="{{ asset('js/vod-sdk-upload-1.0.6.min.js') }}"></script>--}}
	<script src="{{ asset('js/plupload.full.min.js') }}"></script>
	<script>
        var accessid;
        var g_object_name;
        var host;
        var policyBase64;
        var signature;
        var callbackbody;
        var key;
        var uploader;

        function get_signature()
        {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                timeout: 3000,
                async: false,
                url: '/getvideoupdateauth',
                type: "post",
                data: { 'lessonid': $('#id').val() },
                success: function(data){
                    var jsonObj = JSON.parse( data );
                    host = jsonObj.host;
                    policyBase64 = jsonObj.policy;
                    accessid = jsonObj.accessid;
                    signature = jsonObj.signature;
                    expire = parseInt(jsonObj.expire);
                    callbackbody = jsonObj.callback;
                    key = jsonObj.dir;
                }
            });
        };

        function set_upload_param(up, filename)
        {
            get_signature();
            g_object_name = key + filename;
            new_multipart_params = {
                'key' : g_object_name,
                'policy': policyBase64,
                'OSSAccessKeyId': accessid,
                'success_action_status' : '200', //让服务端返回200,不然，默认会返回204
                'callback' : callbackbody,
                'signature': signature,
            };

            up.setOption({
                'url': host,
                'multipart_params': new_multipart_params
            });
            up.start();

        };

        window.onload = new function() {

            uploader = new plupload.Uploader({
                runtimes : 'html5,flash,silverlight,html4',
                browse_button : 'selectfiles',
                multi_selection: false,
//                container: document.getElementById('container'),
                flash_swf_url : "{{ asset('js/Moxie.swf') }}",
                silverlight_xap_url : "{{ asset('js/Moxie.xap') }}",
                url : 'http://oss.aliyuncs.com',

                filters: {
                    mime_types : [ //只允许上传图片和zip,rar文件
                        { title : "Video files", extensions : "mp4" }
                        // { title : "Zip files", extensions : "zip,rar" }
                    ],
                    max_file_size : '200mb', //最大只能上传10mb的文件
                    prevent_duplicates : true //不允许选取重复文件
                },

                init: {
                    PostInit: function() {
                        document.getElementById('ossfile').innerHTML = '';
                        // document.getElementById('postfiles').onclick = function() {
                        // set_upload_param(uploader, '', false);
                        // return false;
                        // };
                    },

                    FilesAdded: function(up, files) {
                        plupload.each(files, function(file) {
                            document.getElementById('ossfile').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ')<b></b>'
                                +'</div>';
                        });
                        up.start();
                    },

                    BeforeUpload: function(up, file) {
                        set_upload_param(up, file.name);
                    },

                    UploadProgress: function(up, file) {
                        var d = document.getElementById(file.id);
                        d.getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
//                        var prog = d.getElementsByTagName('div')[0];
//                        var progBar = prog.getElementsByTagName('div')[0]
//                        progBar.style.width= 2*file.percent+'px';
//                        progBar.setAttribute('aria-valuenow', file.percent);
                    },

                    FileUploaded: function(up, file, info) {
                        if (info.status == 200)
                        {
                            document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '上传成功';
                            $('#vid').val(g_object_name);
                        }
                        else
                        {
                            document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = info.response;
                        }
                    },

                    Error: function(up, err) {
                        if (err.code == -600) {
                            document.getElementById('ossfile').appendChild(document.createTextNode("\n选择的文件太大了"));
                        }
                        else if (err.code == -601) {
                            document.getElementById('ossfile').appendChild(document.createTextNode("\n选择的文件后缀不对"));
                        }
                        else if (err.code == -602) {
                            document.getElementById('ossfile').appendChild(document.createTextNode("\n这个文件已经上传过一遍了"));
                        }
                        else
                        {
                            document.getElementById('ossfile').appendChild(document.createTextNode("\nError xml:" + err.response));
                        }
                    }
                }
            });

            uploader.init();

		}

	</script>
@endsection