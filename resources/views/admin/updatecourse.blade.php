@extends('layouts.app')

@section('head')
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" media="screen">

@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            	<ol class="breadcrumb">
				  <li><a href="{{ route('home') }}">首页</a></li>
				  <li><a href="{{ url('lessonsinfo') . '/' . $students -> id }}">学生课程信息</a></li>
				  <li class="active">修改固定课程</li>
				</ol>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('/updatecourse') }}">
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
	                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') <> null ? old('name') : $lesson -> name }}" >
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
	                            <input id="tname" type="text" class="form-control" name="tname" value="{{ old('tname') <> null ? old('tname') : $lesson -> tname }}" >
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
									  <option value="1" {{ old('dow') <> null ? (old('dow')==1 ? ' selected' : '') : ($lesson -> tname==1 ? ' selected' : '') }}>星期一</option>
									  <option value="2" {{ old('dow') <> null ? (old('dow')==2 ? ' selected' : '') : ($lesson -> tname==2 ? ' selected' : '') }}>星期二</option>
									  <option value="3" {{ old('dow') <> null ? (old('dow')==3 ? ' selected' : '') : ($lesson -> tname==3 ? ' selected' : '') }}>星期三</option>
									  <option value="4" {{ old('dow') <> null ? (old('dow')==4 ? ' selected' : '') : ($lesson -> tname==4 ? ' selected' : '') }}>星期四</option>
									  <option value="5" {{ old('dow') <> null ? (old('dow')==5 ? ' selected' : '') : ($lesson -> tname==5 ? ' selected' : '') }}>星期五</option>
									  <option value="6" {{ old('dow') <> null ? (old('dow')==6 ? ' selected' : '') : ($lesson -> tname==6 ? ' selected' : '') }}>星期六</option>
									  <option value="0" {{ old('dow') <> null ? (old('dow')==0 ? ' selected' : '') : ($lesson -> tname==0 ? ' selected' : '') }}>星期日</option>
								</select>	
							</div>							
                        </div>
                                                
                        <div class="form-group{{ $errors->has('stime') ? ' has-error' : '' }}">
	                        <label for="stime" class="col-md-4 control-label" >开始时间*</label>	
	                        <div class="col-md-6">
								<div class="input-group date form_time col-md-6" data-date="" data-date-format="hh:ii" data-link-field="stime" data-link-format="hh:ii">
				                    <input class="form-control" size="16" type="text" value="{{ old('stime') <> null ? old('stime') : substr( $lesson -> stime , 0 , 5 ) }}" name="stime" readonly required>
									<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
				                </div>
							</div>
                        </div>
                                     
                        <div class="form-group{{ $errors->has('etime') ? ' has-error' : '' }}">
	                        <label for="etime" class="col-md-4 control-label" >结束时间*</label>
		                    <div class="col-md-6">
								<div class="input-group date form_time col-md-6" data-date="" data-date-format="hh:ii" data-link-field="etime" data-link-format="hh:ii">
				                    <input class="form-control" size="16" type="text" value="{{ old('etime') <> null ? old('etime') : substr( $lesson -> etime , 0 , 5 ) }}" name="etime" readonly required>
									<span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
				                </div>
							</div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('sdate') ? ' has-error' : '' }}">
	                        <label for="sdate" class="col-md-4 control-label" >课程开始日期*</label>
		                    <div class="col-md-6">
								<div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="sdate" data-link-format="yyyy-mm-dd">
				                    <input class="form-control" size="16" type="text" value="{{ old('sdate') <> null ? old('sdate') : $lesson -> sdate -> toDateString() }}" name="sdate" readonly required>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				                </div>
							</div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('edate') ? ' has-error' : '' }}">
	                        <label for="edate" class="col-md-4 control-label" >课程结束日期</label>
		                    <div class="col-md-6">
								<div class="input-group date form_date col-md-5" data-date="" data-date-format="yyyy-mm-dd" data-link-field="edate" data-link-format="yyyy-mm-dd">
				                    <input class="form-control" size="16" type="text" value="{{ old('edate') <> null ? old('edate') : $lesson -> edate -> toDateString() }}" name="edate" readonly>
									<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
				                </div>
							</div>
                        </div>
                                                                   
                        <div class="form-group{{ $errors->has('mid') ? ' has-error' : '' }}">
	                        <label for="mid" class="col-md-4 control-label" >会议ID</label>
	
	                        <div class="col-md-6">
	                            <input id="mid" type="text" class="form-control" name="mid" value="{{ old('mid') <> null ? old('mid') : $lesson -> mid }}" >
		                        @if ($errors->has('mid'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('mid') }}</strong>
	                                </span>
	                            @endif
	                        </div>
                        </div>
                                                                                           
                        <div class="form-group{{ $errors->has('cost') ? ' has-error' : '' }}">
	                        <label for="cost" class="col-md-4 control-label" >消耗课时数(外教1对1)*</label>
	
	                        <div class="col-md-6">
								<select id="cost" class="form-control" name="cost" required>
									  <option value="0" {{ old('cost') <> null ? (old('cost')==0 ? ' selected' : '') : ($lesson -> cost==0 ? ' selected' : '') }}>0课时</option>
									  <option value="1" {{ old('cost') <> null ? (old('cost')==1 ? ' selected' : '') : ($lesson -> cost==1 ? ' selected' : '')>1课时</option>
									  <option value="2" {{ old('cost') <> null ? (old('cost')==2 ? ' selected' : '') : ($lesson -> cost==2 ? ' selected' : '')>2课时</option>
									  <option value="3" {{ old('cost') <> null ? (old('cost')==3 ? ' selected' : '') : ($lesson -> cost==3 ? ' selected' : '')>3课时</option>
									  <option value="4" {{ old('cost') <> null ? (old('cost')==4 ? ' selected' : '') : ($lesson -> cost==4 ? ' selected' : '')>4课时</option>
									  <option value="5" {{ old('cost') <> null ? (old('cost')==5 ? ' selected' : '') : ($lesson -> cost==5 ? ' selected' : '')>5课时</option>
								</select>	
							</div>
                        </div>                                                                     
                        <div class="form-group{{ $errors->has('cost1') ? ' has-error' : '' }}">
	                        <label for="cost1" class="col-md-4 control-label" >消耗课时数(中教课时)*</label>
	
	                        <div class="col-md-6">
								<select id="cost1" class="form-control" name="cost1" required>
									  <option value="0" {{ old('cost1') <> null ? (old('cost1')==0 ? ' selected' : '') : ($lesson -> cost1==0 ? ' selected' : '') }}>0课时</option>
									  <option value="1" {{ old('cost1') <> null ? (old('cost1')==1 ? ' selected' : '') : ($lesson -> cost1==1 ? ' selected' : '')>1课时</option>
									  <option value="2" {{ old('cost1') <> null ? (old('cost1')==2 ? ' selected' : '') : ($lesson -> cost1==2 ? ' selected' : '')>2课时</option>
									  <option value="3" {{ old('cost1') <> null ? (old('cost1')==3 ? ' selected' : '') : ($lesson -> cost1==3 ? ' selected' : '')>3课时</option>
									  <option value="4" {{ old('cost1') <> null ? (old('cost1')==4 ? ' selected' : '') : ($lesson -> cost1==4 ? ' selected' : '')>4课时</option>
									  <option value="5" {{ old('cost1') <> null ? (old('cost1')==5 ? ' selected' : '') : ($lesson -> cost1==5 ? ' selected' : '')>5课时</option>
								</select>	
							</div>
                        </div>                                                                          
                        <div class="form-group{{ $errors->has('cost2') ? ' has-error' : '' }}">
	                        <label for="cost2" class="col-md-4 control-label" >消耗课时数(精品课时)*</label>
	
	                        <div class="col-md-6">
								<select id="cost2" class="form-control" name="cost2" required>
									  <option value="0" {{ old('cost2') <> null ? (old('cost2')==0 ? ' selected' : '') : ($lesson -> cost2==0 ? ' selected' : '') }}>0课时</option>
									  <option value="1" {{ old('cost2') <> null ? (old('cost2')==1 ? ' selected' : '') : ($lesson -> cost2==1 ? ' selected' : '')>1课时</option>
									  <option value="2" {{ old('cost2') <> null ? (old('cost2')==2 ? ' selected' : '') : ($lesson -> cost2==2 ? ' selected' : '')>2课时</option>
									  <option value="3" {{ old('cost2') <> null ? (old('cost2')==3 ? ' selected' : '') : ($lesson -> cost2==3 ? ' selected' : '')>3课时</option>
									  <option value="4" {{ old('cost2') <> null ? (old('cost2')==4 ? ' selected' : '') : ($lesson -> cost2==4 ? ' selected' : '')>4课时</option>
									  <option value="5" {{ old('cost2') <> null ? (old('cost2')==5 ? ' selected' : '') : ($lesson -> cost2==5 ? ' selected' : '')>5课时</option>
								</select>	
							</div>
                        </div>                

                                   
                        <div class="form-group{{ $errors->has('cwid') ? ' has-error' : '' }}">
	                        <label for="cwid" class="col-md-4 control-label" >课程课件</label>
	
	                        <div class="col-md-6">
								<select onchange="getlist1()" id="cwid-class" class="form-control" name="cwid" required>
									@foreach ( $cws as $cw )
									  	<option value="{{$cw -> id}}" {{ old('cwid') <> null ? (old('cwid')==$cw -> id ? ' selected' : '') : ($lesson -> cwid==$cw -> id ? ' selected' : '') }}>{{$cw -> name}}</option>
									@endforeach
								</select>	
							</div>
                        </div>         
                                       
                        <div class="form-group{{ $errors->has('option') ? ' has-error' : '' }}">                     
                            <label class="col-md-4 control-label">关联选项*</label>
                            <div class="col-md-6">
		                        <label class="radio-inline">
								  	<input type="radio" name="option" id="no" value="0" {{ old('option')=='0' ? ' checked' : '' }} required> 不修改已创建课程信息
								</label>
								<label class="radio-inline">
								  	<input type="radio" name="option" id="after" value="1" {{ old('option')=='1' ? ' checked' : '' }} required> 修改未上课程信息
								</label>
								<label class="radio-inline">
								  	<input type="radio" name="option" id="all" value="2" {{ old('option')=='2' ? ' checked' : '' }} required> 修改本固定课程关联的所有课程信息
								</label>
							</div>
                       	</div>     
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    	修改
                                </button>

                            </div>
                        </div>
                    </form>
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