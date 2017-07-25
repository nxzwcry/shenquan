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

                                <!--@if ($errors->has('ename'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ename') }}</strong>
                                    </span>
                                @endif-->
                            </div>
                        </div>
                        
                         <div class="form-group{{ $errors->has('ename') ? ' has-error' : '' }}">
                            <label for="sex" class="col-md-4 control-label">性别*</label>

                            <div class="col-md-6">
                                <input id="sex" type="text" class="form-control" name="sex" required>

                                @if ($errors->has('ename'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sex') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('ename') ? ' has-error' : '' }}">
	                        <label for="birthday" class="col-md-4 control-label">生日*</label>
	
	                        <div class="col-md-6">
	                            <input id="birthday" type="text" class="form-control" name="birthday" required>
	                        </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('ename') ? ' has-error' : '' }}">
	                        <label for="grade" class="col-md-4 control-label">年级*</label>
	
	                        <div class="col-md-6">
	                            <input id="grade" type="text" class="form-control" name="grade" required>
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
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Login
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
