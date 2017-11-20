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
				  <li><a href="{{ url('lessonsinfo') . '/' . $students -> id }}">{{ $students -> name }}</a></li>
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
							<form class="form-horizontal" method="POST" action="{{url('/createcourse')}}">
								<input type="text" name="sid" value="{{ $students -> id }}"  hidden>
								@include('shared.CourseForm')
							</form>
		                </div>
	                
	                </div>
                                
	 				<div role="tabpanel" class="tab-pane fade{{ $errors->has('lerror') ? ' active' : '' }}" id="lessons">
	 					<div class="panel-body">
							<form class="form-horizontal" method="POST" action="{{ url('/createlesson') }}">
								<input type="text" name="sid" value="{{ $students -> id }}"  hidden>
								@include('shared.LessonForm')
							</form>
	                	</div>
	 				</div>
                
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
