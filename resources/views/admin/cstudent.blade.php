@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">添加学生</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('/createstudent') }}">
                        {{ csrf_field() }}

						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">姓名*</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('ename') ? ' has-error' : '' }}">
                            <label for="ename" class="col-md-4 control-label">英文名</label>

                            <div class="col-md-6">
                                <input id="ename" type="text" class="form-control" name="ename" >
                            
	                            @if ($errors->has('ename'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('ename') }}</strong>
	                                </span>
	                            @endif
                            </div>
                            
                        </div>
                        
                        <div class="form-group{{ $errors->has('sex') ? ' has-error' : '' }}">                     
                            <label class="col-md-4 control-label">性别*</label>
                            <div class="col-md-6">
		                        <label class="radio-inline">
								  	<input type="radio" name="sex" id="boy" value="boy"  required> 男
								</label>
								<label class="radio-inline">
								  	<input type="radio" name="sex" id="girl" value="girl" required> 女
								</label>
							</div>
                       </div>     
                        
                        <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
	                        <label for="birthday" class="col-md-4 control-label" >生日*</label>
	
	                        <div class="col-md-6">
	                            <input id="birthday" type="text" class="form-control" name="birthday" placeholder="输入例：{{Carbon\Carbon::now()->toDateString()}}" required>
		                        @if ($errors->has('birthday'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('birthday') }}</strong>
	                                </span>
	                            @endif
	                        </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('grade') ? ' has-error' : '' }}">
	                        <label for="grade" class="col-md-4 control-label">年级*</label>
	                        <div class="col-md-6">
								<select class="form-control" name="grade"  required>
									  <option value="4">幼儿园大班</option>
									  <option value="5">学前班</option>
									  <option value="6">一年级</option>
									  <option value="7">二年级</option>
									  <option value="8">三年级</option>
									  <option value="9">四年级</option>
									  <option value="10">五年级</option>
									  <option value="11">六年级</option>
									  <option value="12">初一</option>
									  <option value="13">初二</option>
									  <option value="14">初三</option>
									  <option value="15">高一</option>
									  <option value="16">高二</option>
									  <option value="17">高三</option>
								</select>	
							</div>                
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" >

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
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
