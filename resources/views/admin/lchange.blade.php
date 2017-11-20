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
				  <li><a href="{{ url('lessonsinfo') . '/' . $lesson -> sid }}">{{$lesson -> student -> name}}</a></li>
				  <li class="active">修改课程信息</li>
				</ol>

	 					<div class="panel-body">
		                    <form class="form-horizontal" method="POST" action="{{ url('/lesson/change') }}">
								@include('shared.LessonChangeForm')
		                    </form>
	                	</div>
            </div>
        </div>
    </div>
</div>
	 				
@endsection

