@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            	
            	<ol class="breadcrumb">
				  <li><a href="{{ route('home') }}">首页</a></li>
				  <li class="active">修改学生信息</li>
				</ol>
                <div class="panel-heading">修改学生信息</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('/student/change') }}">
                        {{ csrf_field() }}
						<input type="hidden" name="id" value="{{ $student -> id }}">
						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">姓名*</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name"  value="{{ old('name') <> null ? old('name') : $student -> name }}" required autofocus>

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
                                <input id="ename" type="text" class="form-control" name="ename"  value="{{ old('ename') <> null ? old('ename') : $student -> ename }}">
                            
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
								  	<input type="radio" name="sex" id="boy" value="boy" {{ old('sex') <> null ? ( old('sex')=='boy' ? ' checked' : '' ) : ( $student -> sex =='boy' ? ' checked' : '' ) }} required> 男
								</label>
								<label class="radio-inline">
								  	<input type="radio" name="sex" id="girl" value="girl" {{ old('sex') <> null ? ( old('sex')=='girl' ? ' checked' : '' ) : ( $student -> sex =='girl' ? ' checked' : '' ) }} required> 女
								</label>
							</div>
                       </div>     
                        
                        <div class="form-group{{ $errors->has('birthday') ? ' has-error' : '' }}">
	                        <label for="birthday" class="col-md-4 control-label" >生日*</label>
	
	                        <div class="col-md-6">
	                            <input id="birthday" type="text" class="form-control" name="birthday" placeholder="输入例：{{Carbon\Carbon::now()->toDateString()}}"  value="{{ old('birthday') <> null ? old('birthday') : $student -> birthday-> toDateString() }}" required>
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
								<select id="grade" class="form-control" name="grade" required>
									  <option value="4" {{ old('grade') <> null ? ( old('grade')== 4 ? ' selected' : '' ) : ( $student -> grade == 4 ? ' selected' : '' ) }}>幼儿园大班</option>
									  <option value="5" {{ old('grade') <> null ? ( old('grade')== 5 ? ' selected' : '' ) : ( $student -> grade == 5 ? ' selected' : '' ) }}>学前班</option>
									  <option value="6" {{ old('grade') <> null ? ( old('grade')== 6 ? ' selected' : '' ) : ( $student -> grade == 6 ? ' selected' : '' ) }}>一年级</option>
									  <option value="7" {{ old('grade') <> null ? ( old('grade')== 7 ? ' selected' : '' ) : ( $student -> grade == 7 ? ' selected' : '' ) }}>二年级</option>
									  <option value="8" {{ old('grade') <> null ? ( old('grade')== 8 ? ' selected' : '' ) : ( $student -> grade == 8 ? ' selected' : '' ) }}>三年级</option>
									  <option value="9" {{ old('grade') <> null ? ( old('grade')== 9 ? ' selected' : '' ) : ( $student -> grade == 9 ? ' selected' : '' ) }}>四年级</option>
									  <option value="10" {{ old('grade') <> null ? ( old('grade')== 10 ? ' selected' : '' ) : ( $student -> grade == 10 ? ' selected' : '' ) }}>五年级</option>
									  <option value="11" {{ old('grade') <> null ? ( old('grade')== 11 ? ' selected' : '' ) : ( $student -> grade == 11 ? ' selected' : '' ) }}>六年级</option>
									  <option value="12" {{ old('grade') <> null ? ( old('grade')== 12 ? ' selected' : '' ) : ( $student -> grade == 12 ? ' selected' : '' ) }}>初一</option>
									  <option value="13" {{ old('grade') <> null ? ( old('grade')== 13 ? ' selected' : '' ) : ( $student -> grade == 13 ? ' selected' : '' ) }}>初二</option>
									  <option value="14" {{ old('grade') <> null ? ( old('grade')== 14 ? ' selected' : '' ) : ( $student -> grade == 14 ? ' selected' : '' ) }}>初三</option>
									  <option value="15" {{ old('grade') <> null ? ( old('grade')== 15 ? ' selected' : '' ) : ( $student -> grade == 15 ? ' selected' : '' ) }}>高一</option>
									  <option value="16" {{ old('grade') <> null ? ( old('grade')== 16 ? ' selected' : '' ) : ( $student -> grade == 16 ? ' selected' : '' ) }}>高二</option>
									  <option value="17" {{ old('grade') <> null ? ( old('grade')== 17 ? ' selected' : '' ) : ( $student -> grade == 17 ? ' selected' : '' ) }}>高三</option>
								</select>	
							</div>                
                        </div>

                        <!--<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" >

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>-->

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
