@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">增加单节课程</div>

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
                                <p class="form-control-static">{{ $students -> eame }}</p>                           
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
	                            <input id="date" type="text" class="form-control" name="date" placeholder="输入例：{{Carbon\Carbon::now()->toDateString()}}" value="{{ old('date') }}" required>
		                        @if ($errors->has('date'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('date') }}</strong>
	                                </span>
	                            @endif
	                        </div>
                        </div>
                                                
                        <div class="form-group{{ $errors->has('stime') ? ' has-error' : '' }}">
	                        <label for="stime" class="col-md-4 control-label" >开始时间*</label>
	
	                        <div class="col-md-6">
	                            <input id="stime" type="text" class="form-control" name="stime" placeholder="输入例：{{Carbon\Carbon::now()->format('h:i')}} 24小时制" value="{{ old('stime') }}" required>
		                        @if ($errors->has('stime'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('stime') }}</strong>
	                                </span>
	                            @endif
	                        </div>
                        </div>
                                     
                        <div class="form-group{{ $errors->has('etime') ? ' has-error' : '' }}">
	                        <label for="etime" class="col-md-4 control-label" >结束时间*</label>
	
	                        <div class="col-md-6">
	                            <input id="etime" type="text" class="form-control" name="etime" placeholder="输入例：{{Carbon\Carbon::now()->addMinutes(30)->format('h:i')}}  24小时制" value="{{ old('etime') }}" required>
		                        @if ($errors->has('etime'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('etime') }}</strong>
	                                </span>
	                            @endif
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
@endsection
