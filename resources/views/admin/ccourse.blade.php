@extends('layouts.app')

@section('head')

@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            	<ol class="breadcrumb">
				  <li><a href="{{ route('home') }}">首页</a></li>
				  <li><a href="{{ url('lessonsinfo') . '/' . $students -> id }}">学生课程信息</a></li>
				  <li class="active">增加课程</li>
				</ol>
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
			                        <label for="tname" class="col-md-4 control-label" >外教教师</label>
			
			                        <div class="col-md-6">
			                            <input id="tname" type="text" class="form-control" name="tname" value="{{ old('tname') }}" >
				                        @if ($errors->has('tname'))
			                                <span class="help-block">
			                                    <strong>{{ $errors->first('tname') }}</strong>
			                                </span>
			                            @endif
			                        </div>
		                        </div>
		                        		                           
		                        <div class="form-group{{ $errors->has('cteacher_id') ? ' has-error' : '' }}">
			                        <label for="cteacher_id" class="col-md-4 control-label" >中教教师</label>
			
			                        <div class="col-md-6">
										<select class="form-control" name="cteacher_id">
											  	<option value="">无</option>
											@foreach ( $cteachers as $cteacher )
											  	<option value="{{$cteacher -> id}}" {{ old('cteacher_id')==$cteacher -> id ? ' selected' : '' }}>{{$cteacher -> tname}}</option>
											@endforeach
										</select>	
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
						                <input class="form-control time_form" size="16" type="text" value="{{ old('stime') }}" name="stime" readonly required>
									</div>
		                        </div>
		                                     
		                        <div class="form-group{{ $errors->has('etime') ? ' has-error' : '' }}">
			                        <label for="etime" class="col-md-4 control-label" >结束时间*</label>
				                    <div class="col-md-6">
						                    <input class="form-control time_form" size="16" type="text" value="{{ old('etime') }}" name="etime" readonly required>
									</div>
		                        </div>
		                        
		                        <div class="form-group{{ $errors->has('sdate') ? ' has-error' : '' }}">
			                        <label for="sdate" class="col-md-4 control-label" >课程开始日期*</label>
				                    <div class="col-md-6">
						                    <input class="form-control date_form" size="16" type="text" value="{{ old('edate') }}" name="sdate" readonly required>
									</div>
		                        </div>
		                        
		                        <div class="form-group{{ $errors->has('edate') ? ' has-error' : '' }}">
			                        <label for="edate" class="col-md-4 control-label" >课程结束日期</label>
				                    <div class="col-md-6">
						                    <input class="form-control date_form" size="16" type="text" value="{{ old('edate') }}" name="edate" readonly>
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
			                        <label for="cost" class="col-md-4 control-label" >消耗课时数(外教1对1)*</label>
			
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
		                        <div class="form-group{{ $errors->has('cost1') ? ' has-error' : '' }}">
			                        <label for="cost1" class="col-md-4 control-label" >消耗课时数(中教课时)*</label>
			
			                        <div class="col-md-6">
										<select id="cost1" class="form-control" name="cost1" required>
											  <option value="0" {{ old('cost1')==0 ? ' selected' : '' }}>0课时</option>
											  <option value="1" {{ old('cost1')==1 ? ' selected' : '' }}>1课时</option>
											  <option value="2" {{ old('cost1')==2 ? ' selected' : '' }}>2课时</option>
											  <option value="3" {{ old('cost1')==3 ? ' selected' : '' }}>3课时</option>
											  <option value="4" {{ old('cost1')==4 ? ' selected' : '' }}>4课时</option>
											  <option value="5" {{ old('cost1')==5 ? ' selected' : '' }}>5课时</option>
										</select>	
									</div>
		                        </div>                                                                          
		                        <div class="form-group{{ $errors->has('cost2') ? ' has-error' : '' }}">
			                        <label for="cost2" class="col-md-4 control-label" >消耗课时数(精品课时)*</label>
			
			                        <div class="col-md-6">
										<select id="cost2" class="form-control" name="cost2" required>
											  <option value="0" {{ old('cost2')==0 ? ' selected' : '' }}>0课时</option>
											  <option value="1" {{ old('cost2')==1 ? ' selected' : '' }}>1课时</option>
											  <option value="2" {{ old('cost2')==2 ? ' selected' : '' }}>2课时</option>
											  <option value="3" {{ old('cost2')==3 ? ' selected' : '' }}>3课时</option>
											  <option value="4" {{ old('cost2')==4 ? ' selected' : '' }}>4课时</option>
											  <option value="5" {{ old('cost2')==5 ? ' selected' : '' }}>5课时</option>
										</select>	
									</div>
		                        </div>                
		
		                                   
		                        <div class="form-group{{ $errors->has('cwid') ? ' has-error' : '' }}">
			                        <label for="cwid" class="col-md-4 control-label" >课程课件</label>
			
			                        <div class="col-md-6">
										<select id="cwid-class" class="form-control" name="cwid">
											  	<option value="">无</option>
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
			                        <label for="tname" class="col-md-4 control-label" >外教教师</label>
			
			                        <div class="col-md-6">
			                            <input id="tname" type="text" class="form-control" name="tname" value="{{ old('tname') }}" >
				                        @if ($errors->has('tname'))
			                                <span class="help-block">
			                                    <strong>{{ $errors->first('tname') }}</strong>
			                                </span>
			                            @endif
			                        </div>
		                        </div>
		                        		                           
		                        <div class="form-group{{ $errors->has('cteacher_id') ? ' has-error' : '' }}">
			                        <label for="cteacher_id" class="col-md-4 control-label" >中教教师</label>
			
			                        <div class="col-md-6">
										<select class="form-control" name="cteacher_id">
											  	<option value="">无</option>
											@foreach ( $cteachers as $cteacher )
											  	<option value="{{$cteacher -> id}}" {{ old('cteacher_id')==$cteacher -> id ? ' selected' : '' }}>{{$cteacher -> tname}}</option>
											@endforeach
										</select>	
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
						                    <input class="form-control date_form" size="16" type="text" value="{{ old('date') }}" name="date" readonly required>
									</div>
		                        </div>
		                                                
		                        <div class="form-group{{ $errors->has('stime') ? ' has-error' : '' }}">
			                        <label for="stime" class="col-md-4 control-label" >开始时间*</label>
			
			                        <div class="col-md-6">
						                    <input class="form-control time_form" size="16" type="text" value="{{ old('stime') }}" name="stime" readonly required>
									</div>
		                        </div>
		                                     
		                        <div class="form-group{{ $errors->has('etime') ? ' has-error' : '' }}">
			                        <label for="etime" class="col-md-4 control-label" >结束时间*</label>
			
			                        <div class="col-md-6">
						                    <input class="form-control time_form" size="16" type="text" value="{{ old('etime') }}" name="etime" readonly required>
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
			                        <label for="cost" class="col-md-4 control-label" >消耗课时数(外教1对1)*</label>
			
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
		                        <div class="form-group{{ $errors->has('cost1') ? ' has-error' : '' }}">
			                        <label for="cost1" class="col-md-4 control-label" >消耗课时数(中教课时)*</label>
			
			                        <div class="col-md-6">
										<select id="cost1" class="form-control" name="cost1" required>
											  <option value="0" {{ old('cost1')==0 ? ' selected' : '' }}>0课时</option>
											  <option value="1" {{ old('cost1')==1 ? ' selected' : '' }}>1课时</option>
											  <option value="2" {{ old('cost1')==2 ? ' selected' : '' }}>2课时</option>
											  <option value="3" {{ old('cost1')==3 ? ' selected' : '' }}>3课时</option>
											  <option value="4" {{ old('cost1')==4 ? ' selected' : '' }}>4课时</option>
											  <option value="5" {{ old('cost1')==5 ? ' selected' : '' }}>5课时</option>
										</select>	
									</div>
		                        </div>                                                                          
		                        <div class="form-group{{ $errors->has('cost2') ? ' has-error' : '' }}">
			                        <label for="cost2" class="col-md-4 control-label" >消耗课时数(精品课时)*</label>
			
			                        <div class="col-md-6">
										<select id="cost2" class="form-control" name="cost2" required>
											  <option value="0" {{ old('cost2')==0 ? ' selected' : '' }}>0课时</option>
											  <option value="1" {{ old('cost2')==1 ? ' selected' : '' }}>1课时</option>
											  <option value="2" {{ old('cost2')==2 ? ' selected' : '' }}>2课时</option>
											  <option value="3" {{ old('cost2')==3 ? ' selected' : '' }}>3课时</option>
											  <option value="4" {{ old('cost2')==4 ? ' selected' : '' }}>4课时</option>
											  <option value="5" {{ old('cost2')==5 ? ' selected' : '' }}>5课时</option>
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
                
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('tail')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript">	
	$(".date_form").flatpickr();
	$(".time_form").flatpickr({
	    enableTime: true,
	    noCalendar: true,
	
	    enableSeconds: false, // disabled by default
	
	    time_24hr: true, // AM/PM time picker is used by default
	
	    // default format
	    dateFormat: "H:i", 
	
	    // initial values for time. don't use these to preload a date
//	    defaultHour: 12,
//	    defaultMinute: 0
	
	    // Preload time with defaultDate instead:
	    // defaultDate: "3:30"
	});
	
</script>

@endsection