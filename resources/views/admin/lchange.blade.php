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
				  <li class="active">修改课程信息</li>
				</ol>

	 					<div class="panel-body">
		                    <form class="form-horizontal" method="POST" action="{{ url('/lesson/change') }}">
		                    	<input type="hidden" name="id" value="{{ $lesson -> id }}"/>
		                        {{ csrf_field() }}
		                                           
		                        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
			                        <label for="type" class="col-md-4 control-label" >课程种类*</label>
			
			                        <div class="col-md-6">
										<select id="type" class="form-control" name="type" required>
											  <option value="w" {{ old('type') <> null ? ( old('type')=='w' ? ' selected' : '' ) : ( $lesson -> type =='w' ? ' selected' : '' ) }}>外教1对1</option>
											  <option value="j" {{ old('type') <> null ? ( old('type')=='j' ? ' selected' : '' ) : ( $lesson -> type =='j' ? ' selected' : '' ) }}>精品课</option>
											  <option value="f" {{ old('type') <> null ? ( old('type')=='f' ? ' selected' : '' ) : ( $lesson -> type =='f' ? ' selected' : '' ) }}>复习课</option>
											  <option value="b" {{ old('type') <> null ? ( old('type')=='b' ? ' selected' : '' ) : ( $lesson -> type =='b' ? ' selected' : '' ) }}>小班课</option>
										</select>	
									</div>
		                        </div>      
		                        
		                        <div class="form-group{{ $errors->has('tname') ? ' has-error' : '' }}">
			                        <label for="tname" class="col-md-4 control-label" >外教教师</label>
			
			                        <div class="col-md-6">
			                            <input id="tname" type="text" class="form-control" name="tname" value="{{ old('tname') <> null ? old('tname') : $lesson -> tname }}" >
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
											  	<option value="{{$cteacher -> id}}" {{ old('cteacher_id') <> null ? ( old('cteacher_id')== $cteacher -> id ? ' selected' : '' ) : ( $lesson -> cteacher ? ( $lesson -> cteacher -> id == $cteacher -> id ? ' selected' : '' ) : '' )}}>{{$cteacher -> tname}}</option>
											@endforeach
										</select>	
									</div>
		                        </div>       
		                                     		                                                
		                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
			                        <label for="name" class="col-md-4 control-label" >课程内容</label>
			
			                        <div class="col-md-6">
			                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') <> null ? old('name') : $lesson -> name }}">
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
						                <input class="form-control date_form" size="16" type="text" value="{{ old('date') <> null ? old('date') : $lesson -> date }}" name="date" required>
									</div>
		                        </div>
		                                                
		                        <div class="form-group{{ $errors->has('stime') ? ' has-error' : '' }}">
			                        <label for="stime" class="col-md-4 control-label" >开始时间*</label>
			
			                        <div class="col-md-6">
						                <input class="form-control time_form" size="16" type="text" value="{{ old('stime') <> null ? old('stime') : substr( $lesson -> stime , 0 , 5 ) }}" name="stime" readonly required>
									</div>
		                        </div>
		                                     
		                        <div class="form-group{{ $errors->has('etime') ? ' has-error' : '' }}">
			                        <label for="etime" class="col-md-4 control-label" >结束时间*</label>
			
			                        <div class="col-md-6">
						                <input class="form-control time_form" size="16" type="text" value="{{ old('etime') <> null ? old('etime') : substr( $lesson -> etime , 0 , 5 ) }}" name="etime" readonly required>
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
											  <option value="0" {{ old('cost') <> null ? ( old('cost') == 0 ? ' selected' : '' ) : ( $lesson -> cost == 0 ? ' selected' : '' ) }}>0课时</option>
											  <option value="1" {{ old('cost') <> null ? ( old('cost') == 1 ? ' selected' : '' ) : ( $lesson -> cost == 1 ? ' selected' : '' ) }}>1课时</option>
											  <option value="2" {{ old('cost') <> null ? ( old('cost') == 2 ? ' selected' : '' ) : ( $lesson -> cost == 2 ? ' selected' : '' ) }}>2课时</option>
											  <option value="3" {{ old('cost') <> null ? ( old('cost') == 3 ? ' selected' : '' ) : ( $lesson -> cost == 3 ? ' selected' : '' ) }}>3课时</option>
											  <option value="4" {{ old('cost') <> null ? ( old('cost') == 4 ? ' selected' : '' ) : ( $lesson -> cost == 4 ? ' selected' : '' ) }}>4课时</option>
											  <option value="5" {{ old('cost') <> null ? ( old('cost') == 5 ? ' selected' : '' ) : ( $lesson -> cost == 5 ? ' selected' : '' ) }}>5课时</option>
										</select>	
									</div>
		                        </div>                                                                     
		                        <div class="form-group{{ $errors->has('cost1') ? ' has-error' : '' }}">
			                        <label for="cost1" class="col-md-4 control-label" >消耗课时数(中教课时)*</label>
			
			                        <div class="col-md-6">
										<select id="cost1" class="form-control" name="cost1" required>
											  <option value="0" {{ old('cost1') <> null ? ( old('cost1') == 0 ? ' selected' : '' ) : ( $lesson -> cost1 == 0 ? ' selected' : '' ) }}>0课时</option>
											  <option value="1" {{ old('cost1') <> null ? ( old('cost1') == 1 ? ' selected' : '' ) : ( $lesson -> cost1 == 1 ? ' selected' : '' ) }}>1课时</option>
											  <option value="2" {{ old('cost1') <> null ? ( old('cost1') == 2 ? ' selected' : '' ) : ( $lesson -> cost1 == 2 ? ' selected' : '' ) }}>2课时</option>
											  <option value="3" {{ old('cost1') <> null ? ( old('cost1') == 3 ? ' selected' : '' ) : ( $lesson -> cost1 == 3 ? ' selected' : '' ) }}>3课时</option>
											  <option value="4" {{ old('cost1') <> null ? ( old('cost1') == 4 ? ' selected' : '' ) : ( $lesson -> cost1 == 4 ? ' selected' : '' ) }}>4课时</option>
											  <option value="5" {{ old('cost1') <> null ? ( old('cost1') == 5 ? ' selected' : '' ) : ( $lesson -> cost1 == 5 ? ' selected' : '' ) }}>5课时</option>
										</select>	
									</div>
		                        </div>                                                                          
		                        <div class="form-group{{ $errors->has('cost2') ? ' has-error' : '' }}">
			                        <label for="cost2" class="col-md-4 control-label" >消耗课时数(精品课时)*</label>
			
			                        <div class="col-md-6">
										<select id="cost2" class="form-control" name="cost2" required>
											  <option value="0" {{ old('cost2') <> null ? ( old('cost2') == 0 ? ' selected' : '' ) : ( $lesson -> cost2 == 0 ? ' selected' : '' ) }}>0课时</option>
											  <option value="1" {{ old('cost2') <> null ? ( old('cost2') == 1 ? ' selected' : '' ) : ( $lesson -> cost2 == 1 ? ' selected' : '' ) }}>1课时</option>
											  <option value="2" {{ old('cost2') <> null ? ( old('cost2') == 2 ? ' selected' : '' ) : ( $lesson -> cost2 == 2 ? ' selected' : '' ) }}>2课时</option>
											  <option value="3" {{ old('cost2') <> null ? ( old('cost2') == 3 ? ' selected' : '' ) : ( $lesson -> cost2 == 3 ? ' selected' : '' ) }}>3课时</option>
											  <option value="4" {{ old('cost2') <> null ? ( old('cost2') == 4 ? ' selected' : '' ) : ( $lesson -> cost2 == 4 ? ' selected' : '' ) }}>4课时</option>
											  <option value="5" {{ old('cost2') <> null ? ( old('cost2') == 5 ? ' selected' : '' ) : ( $lesson -> cost2 == 5 ? ' selected' : '' ) }}>5课时</option>
										</select>	
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