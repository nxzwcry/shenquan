@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            	          	
            	<ol class="breadcrumb">
				  <li><a href="{{ route('home') }}">首页</a></li>
				  <li><a href="{{ url('lessonsinfo') . '/' . $students -> id }}">学生课程信息</a></li>
				  <li class="active">课时充值</li>
				</ol>
                <div class="panel-heading">课时充值</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('/recharge') }}">
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
                        
                        <div class="form-group">
                            <label for="used" class="col-md-4 control-label">已用课时</label>

                            <div class="col-md-6">
                                <p class="form-control-static">{{ $used }}</p>                           
                            </div>                            
                        </div>
                        
                        <div class="form-group">
                            <label for="surplus" class="col-md-4 control-label">剩余课时</label>

                            <div class="col-md-6">
                                <p class="form-control-static">{{ $surplus }}</p>                           
                            </div>                            
                        </div>
                        
                        <!--<div class="form-group{{ $errors->has('cid') ? ' has-error' : '' }}">                     
		                            <label class="col-md-4 control-label">课程类别*</label>
		                            <div class="col-md-6">
				                        <label class="radio-inline">
										  	<input type="radio" name="cid" id="kk" value="1" checked="checked" required> KK Talkee
										</label>
										<label class="radio-inline">
										  	<input type="radio" name="cid" id="fu" value="2"  {{ old('cid')==2 ? ' checked' : '' }} required> 辅导君
										</label>
									</div>
		                       </div> -->
		                         
                        <input type="text" name="sid" value="{{ $students -> id }}"  hidden>
                        
                        <div class="form-group{{ $errors->has('lessons') ? ' has-error' : '' }}">
	                        <label for="lessons" class="col-md-4 control-label" >外教1对1课时数*</label>
	
	                        <div class="col-md-6">
	                            <input id="lessons" type="text" class="form-control" name="lessons" value="{{ old('lessons') }}" required>
		                        @if ($errors->has('lessons'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('lessons') }}</strong>
	                                </span>
	                            @endif
	                        </div>
                        </div>
                        <div class="form-group{{ $errors->has('lessons1') ? ' has-error' : '' }}">
	                        <label for="lessons1" class="col-md-4 control-label" >中教课程课时数*</label>
	
	                        <div class="col-md-6">
	                            <input id="lessons1" type="text" class="form-control" name="lessons1" value="{{ old('lessons1') }}" required>
		                        @if ($errors->has('lessons1'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('lessons1') }}</strong>
	                                </span>
	                            @endif
	                        </div>
                        </div>
                        <div class="form-group{{ $errors->has('lessons2') ? ' has-error' : '' }}">
	                        <label for="lessons2" class="col-md-4 control-label" >外教精品课课时数*</label>
	
	                        <div class="col-md-6">
	                            <input id="lessons2" type="text" class="form-control" name="lessons2" value="{{ old('lessons2') }}" required>
		                        @if ($errors->has('lessons2'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('lessons2') }}</strong>
	                                </span>
	                            @endif
	                        </div>
                        </div>
                                                
                        <div class="form-group{{ $errors->has('money') ? ' has-error' : '' }}">
	                        <label for="money" class="col-md-4 control-label" >金额</label>
	
	                        <div class="col-md-6">
	                            <input id="money" type="text" class="form-control" name="money" value="{{ old('money') }}">
		                        @if ($errors->has('money'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('money') }}</strong>
	                                </span>
	                            @endif
	                        </div>
                        </div>
                                                
                        <div class="form-group">
	                        <label for="note" class="col-md-4 control-label" >备注</label>
	
	                        <div class="col-md-6">
	                        	<textarea class="form-control" rows="3" id="note" name="note" value="{{ old('date') }}"></textarea>	                            
	                        </div>
                        </div>                           

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    	确定
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
