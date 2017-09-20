@extends('layouts.app')

@section('head')
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen">

<script type="text/javascript">	
function getlist1(){
    var strvalue=$("#cwid-class option:selected").val();
    console.log(strvalue);
//  var strvalue=$("#name").val();
    $.ajax({
      timeout: 3000,
      async: false,
      url: 'getcwlist',
      type: "post",
      data: {'id':strvalue, '_token': $('input[name=_token]').val()},
      success: function(data){
        $('#list').html("已有课件<br/>"); //清空
        for (var i=0;i<data.length;i++){		
			$('#list').append( data[i] + "<br/>");
		}
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
                <ul class="nav nav-tabs" role="tablist">      
					<li role="presentation" class="active">
					  	<a href="#courses" role="tab" data-toggle="tab">增加固定课程</a>
					</li>    
					<li role="presentation">
					  	<a href="#lessons" role="tab" data-toggle="tab">增加单节课程</a>
					</li>    					  
				</ul> 
				<div class="tab-content"> 

	 				<div role="tabpanel" class="tab-pane fade in active" id="courses">
	
		                <div class="panel-body">
		                    <form class="form-horizontal" method="POST" action="{{ url('/createcourse') }}">
		                    	<input type="hidden" name="_token" value="{csrf_token()}"/>
		                        {{ csrf_field() }}
		
								<div class="form-group">
		                            <label class="col-md-4 control-label">姓名</label>
		
		                            <div class="col-md-6">
		                                <p class="form-control-static">{{ $students -> name }}</p>
		                            </div>
		                        </div>
		                        
		                        <div class="form-group">
		                            <label for="ename" class="col-md-4 control-label">英文名</label>
		
		                            <div class="col-md-6">
		                                <p class="form-control-static">{{ $students -> ename }}</p>                           
		                            </div>                            
		                        </div>
		                        
		                        <input type="text" name="sid" value="{{ $students -> id }}"  hidden>
		                        	
		                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			                        <label for="name" class="col-md-4 control-label" >课程名称</label>
			
			                        <div class="col-md-6">
			                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" >
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
			                            <input id="tname" type="text" class="form-control" name="tname" value="{{ old('tname') }}" >
				                        @if ($errors->has('tname'))
			                                <span class="help-block">
			                                    <strong>{{ $errors->first('tname') }}</strong>
			                                </span>
			                            @endif
			                        </div>
		                        </div>
		                                                
		                        <div class="form-group{{ $errors->has('dow') ? ' has-error' : '' }}">
			                        <label for="dow" class="col-md-4 control-label" >授课时间*</label>
			                        <div class="col-md-6">
										<select id="cost" class="form-control" name="dow" required>
											  <option value="1" {{ old('dow')==1 ? ' selected' : '' }}>星期一</option>
											  <option value="2" {{ old('dow')==2 ? ' selected' : '' }}>星期二</option>
											  <option value="3" {{ old('dow')==3 ? ' selected' : '' }}>星期三</option>
											  <option value="4" {{ old('dow')==4 ? ' selected' : '' }}>星期四</option>
											  <option value="5" {{ old('dow')==5 ? ' selected' : '' }}>星期五</option>
											  <option value="6" {{ old('dow')==6 ? ' selected' : '' }}>星期六</option>
											  <option value="0" {{ old('dow')==0 ? ' selected' : '' }}>星期日</option>
										</select>	
									</div>							
		                        </div>
		                                                
		                        <div class="form-group{{ $errors->has('stime') ? ' has-error' : '' }}">
			                        <label for="stime" class="col-md-4 control-label" >开始时间*</label>	
			                        <div class="col-md-6">
										<div class="input-group date form_time col-md-6" data-date="" data-date-format="hh:ii" data-link-field="stime" data-link-format="hh:ii">
						                    <input class="form-control" size="16" type="text" value="{{ old('stime') }}" name="stime" readonly required>
											<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
						                </div>
									</div>
		                        </div>
		                                     
		                        <div class="form-group{{ $errors->has('etime') ? ' has-error' : '' }}">
			                        <label for="etime" class="col-md-4 control-label" >结束时间*</label>
				                    <div class="col-md-6">
										<div class="input-group date form_time col-md-6" data-date="" data-date-format="hh:ii" data-link-field="etime" data-link-format="hh:ii">
						                    <input class="form-control" size="16" type="text" value="{{ old('etime') }}" name="etime" readonly required>
											<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
						                </div>
									</div>
		                        </div>
		                        
		                        <div class="form-group{{ $errors->has('sdate') ? ' has-error' : '' }}">
			                        <label for="sdate" class="col-md-4 control-label" >课程开始日期*</label>
				                    <div class="col-md-6">
										<div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="sdate" data-link-format="yyyy-mm-dd">
						                    <input class="form-control" size="16" type="text" value="{{ old('edate') }}" name="sdate" readonly required>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						                </div>
									</div>
		                        </div>
		                        
		                        <div class="form-group{{ $errors->has('edate') ? ' has-error' : '' }}">
			                        <label for="edate" class="col-md-4 control-label" >课程结束日期</label>
				                    <div class="col-md-6">
										<div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="edate" data-link-format="yyyy-mm-dd">
						                    <input class="form-control" size="16" type="text" value="{{ old('edate') }}" name="edate" readonly>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						                </div>
									</div>
		                        </div>
		                                                                   
		                        <div class="form-group{{ $errors->has('mid') ? ' has-error' : '' }}">
			                        <label for="mid" class="col-md-4 control-label" >会议ID</label>
			
			                        <div class="col-md-6">
			                            <input id="mid" type="text" class="form-control" name="mid" value="{{ old('mid') }}" >
				                        @if ($errors->has('mid'))
			                                <span class="help-block">
			                                    <strong>{{ $errors->first('mid') }}</strong>
			                                </span>
			                            @endif
			                        </div>
		                        </div>
		                                                                                           
		                        <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
			                        <label for="cost" class="col-md-4 control-label" >消耗课时数*</label>
			
			                        <div class="col-md-6">
										<select id="cost" class="form-control" name="cost" required>
											  <option value="0" {{ old('cost')==0 ? ' selected' : '' }}>0课时</option>
											  <option value="1" {{ old('cost')==1 ? ' selected' : '' }}>1课时</option>
											  <option value="2" {{ old('cost')==2 ? ' selected' : '' }}>2课时</option>
											  <option value="3" {{ old('cost')==3 ? ' selected' : '' }}>3课时</option>
											  <option value="4" {{ old('cost')==4 ? ' selected' : '' }}>4课时</option>
											  <option value="5" {{ old('cost')==5 ? ' selected' : '' }}>5课时</option>
										</select>	
									</div>
		                        </div>                       
		
		                        <div class="form-group{{ $errors->has('cid') ? ' has-error' : '' }}">                     
		                            <label class="col-md-4 control-label">课程类别*</label>
		                            <div class="col-md-6">
				                        <label class="radio-inline">
										  	<input type="radio" name="cid" id="kk" value="1" checked="checked" required> KK Talkee
										</label>
										<label class="radio-inline">
										  	<input type="radio" name="cid" id="fu" value="2"  {{ old('cid')==2 ? ' checked' : '' }} required> 辅导君
										</label>
									</div>
		                       </div>   
		                                   
		                        <div class="form-group{{ $errors->has('cwid') ? ' has-error' : '' }}">
			                        <label for="cwid" class="col-md-4 control-label" >课程课件</label>
			
			                        <div class="col-md-6">
										<select onchange="getlist1()" id="cwid-class" class="form-control" name="cwid" required>
											@foreach ( $cws as $cw )
											  	<option value="{{$cw -> id}}" {{ old('cwid')==$cw -> id ? ' selected' : '' }}>{{$cw -> name}}</option>
											@endforeach
										</select>	
									</div>
		                        </div>         
		                                       
		                        <div class="form-group">
		                            <div class="col-md-8 col-md-offset-4">
		                                <button type="submit" class="btn btn-primary">
		                                    	添加
		                                </button>
		
		                            </div>
		                        </div>
		                    </form>
		                </div>
	                
	                </div>
                                
	 				<div role="tabpanel" class="tab-pane fade{{ $errors->has('lerror') ? ' active' : '' }}" id="lessons">
	 					<div class="panel-body">
		                    <form class="form-horizontal" method="POST" action="{{ url('/createlesson') }}">
		                    	<input type="hidden" name="_token" value="{csrf_token()}"/>
		                        {{ csrf_field() }}
		
								<div class="form-group">
		                            <label for="name" class="col-md-4 control-label">姓名</label>
		
		                            <div class="col-md-6">
		                                <p class="form-control-static">{{ $students -> name }}</p>
		                            </div>
		                        </div>
		                        
		                        <div class="form-group">
		                            <label for="ename" class="col-md-4 control-label">英文名</label>
		
		                            <div class="col-md-6">
		                                <p class="form-control-static">{{ $students -> ename }}</p>                           
		                            </div>                            
		                        </div>
		                        
		                        <input type="text" name="sid" value="{{ $students -> id }}"  hidden>
		                        
		                        <div class="form-group{{ $errors->has('tname') ? ' has-error' : '' }}">
			                        <label for="tname" class="col-md-4 control-label" >授课教师</label>
			
			                        <div class="col-md-6">
			                            <input id="tname" type="text" class="form-control" name="tname" value="{{ old('tname') }}" >
				                        @if ($errors->has('tname'))
			                                <span class="help-block">
			                                    <strong>{{ $errors->first('tname') }}</strong>
			                                </span>
			                            @endif
			                        </div>
		                        </div>
		                                                
		                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			                        <label for="name" class="col-md-4 control-label" >课程内容</label>
			
			                        <div class="col-md-6">
			                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}">
				                        @if ($errors->has('name'))
			                                <span class="help-block">
			                                    <strong>{{ $errors->first('name') }}</strong>
			                                </span>
			                            @endif
			                        </div>
		                        </div>
		                                                
		                        <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
			                        <label for="date" class="col-md-4 control-label" >授课日期*</label>
			
			                        <div class="col-md-6">
										<div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="date" data-link-format="yyyy-mm-dd">
						                    <input class="form-control" size="16" type="text" value="{{ old('date') }}" name="date" readonly required>
											<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						                </div>
									</div>
		                        </div>
		                                                
		                        <div class="form-group{{ $errors->has('stime') ? ' has-error' : '' }}">
			                        <label for="stime" class="col-md-4 control-label" >开始时间*</label>
			
			                        <div class="col-md-6">
										<div class="input-group date form_time col-md-6" data-date="" data-date-format="hh:ii" data-link-field="stime" data-link-format="hh:ii">
						                    <input class="form-control" size="16" type="text" value="{{ old('stime') }}" name="stime" readonly required>
											<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
						                </div>
									</div>
		                        </div>
		                                     
		                        <div class="form-group{{ $errors->has('etime') ? ' has-error' : '' }}">
			                        <label for="etime" class="col-md-4 control-label" >结束时间*</label>
			
			                        <div class="col-md-6">
										<div class="input-group date form_time col-md-6" data-date="" data-date-format="hh:ii" data-link-field="etime" data-link-format="hh:ii">
						                    <input class="form-control" size="16" type="text" value="{{ old('etime') }}" name="etime" readonly required>
											<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
						                </div>
									</div>
		                        </div>
		                                                                   
		                        <div class="form-group{{ $errors->has('mid') ? ' has-error' : '' }}">
			                        <label for="mid" class="col-md-4 control-label" >会议ID</label>
			
			                        <div class="col-md-6">
			                            <input id="mid" type="text" class="form-control" name="mid" value="{{ old('mid') }}" >
				                        @if ($errors->has('mid'))
			                                <span class="help-block">
			                                    <strong>{{ $errors->first('mid') }}</strong>
			                                </span>
			                            @endif
			                        </div>
		                        </div>
		                                                                                           
		                        <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
			                        <label for="cost" class="col-md-4 control-label" >消耗课时数*</label>
			
			                        <div class="col-md-6">
										<select id="cost" class="form-control" name="cost" required>
											  <option value="0" {{ old('cost')==0 ? ' selected' : '' }}>0课时</option>
											  <option value="1" {{ old('cost')==1 ? ' selected' : '' }}>1课时</option>
											  <option value="2" {{ old('cost')==2 ? ' selected' : '' }}>2课时</option>
											  <option value="3" {{ old('cost')==3 ? ' selected' : '' }}>3课时</option>
											  <option value="4" {{ old('cost')==4 ? ' selected' : '' }}>4课时</option>
											  <option value="5" {{ old('cost')==5 ? ' selected' : '' }}>5课时</option>
										</select>	
									</div>
		                        </div>                       
		
		                        <div class="form-group{{ $errors->has('cid') ? ' has-error' : '' }}">                     
		                            <label class="col-md-4 control-label">课程类别*</label>
		                            <div class="col-md-6">
				                        <label class="radio-inline">
										  	<input type="radio" name="cid" id="kk" value="1" checked="checked" required> KK Talkee
										</label>
										<label class="radio-inline">
										  	<input type="radio" name="cid" id="fu" value="2"  {{ old('cid')==2 ? ' checked' : '' }} required> 辅导君
										</label>
									</div>
		                       </div>     
		
		                        <div class="form-group">
		                            <div class="col-md-8 col-md-offset-4">
		                                <button type="submit" class="btn btn-primary">
		                                    	添加
		                                </button>
		
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
<!--<script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->
<script type="text/javascript" src="{{ asset('js/bootstrap-datetimepicker.js') }}" charset="UTF-8"></script>
<script type="text/javascript" src="{{ asset('js/locales/bootstrap-datetimepicker.zh-CN.js') }}" charset="UTF-8"></script>
<script type="text/javascript">	
	$('.form_date').datetimepicker({
        language:  'zh-CN',
        weekStart: 1,
        todayBtn:  1,
		autoclose: 1,
		todayHighlight: 1,
		startView: 2,
		minView: 2,
		forceParse: 0
    });
	$('.form_time').datetimepicker({
        language:  'zh-CN',
        weekStart: 0,
        todayBtn:  0,
		autoclose: 1,
		todayHighlight: 0,
		startView: 1,
		minView: 0,
		maxView: 1,
		forceParse: 0
   });
</script>

@endsection