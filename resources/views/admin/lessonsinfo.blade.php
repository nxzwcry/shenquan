@extends('layouts.app')

@section('head')
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <ul class="nav nav-tabs" role="tablist">      
					<li role="presentation" class="active">
					  	<a href="#baseinfo" role="tab" data-toggle="tab">学生课程信息</a>
					</li>    
					<!--<li role="presentation">
					  	<a href="#classes" role="tab" data-toggle="tab">课程详细信息</a>
					</li>   		-->
					<li role="presentation">
					  	<a href="#lessons" role="tab" data-toggle="tab">已上课程列表</a>
					</li>   		
					<li role="presentation">
					  	<a href="#recharges" role="tab" data-toggle="tab">购课记录</a>
					</li>   					  
				</ul> 
				<div class="tab-content"> 

	 				<div role="tabpanel" class="tab-pane fade in active" id="baseinfo">
	
		                <div class="panel-body">
		                	<div class="row">
			                	<div class="col-md-10">
			                    	<h2>{{ $students -> name . ' ' . $students -> ename }}</h2>
			                   	</div>
			                   	<div class="col-md-2">
			                   		已上课时：{{ $lessons -> sum('cost') }} <br/>
			                   		剩余课时：{{ $recharges -> sum('lessons') - $lessons -> sum('cost') }}
			                   	</div>
			                </div>
		                	<div class="row">
			                	<div class="col-md-10">
			                   		<strong>下节课程</strong>
			                   </div>
			                   <div class="col-md-2">
			                   		<a href="{{ url('createclass') . '/' . $students -> id }}" class="btn btn-primary btn-primary btn-sm active" role="button">增加课程</a>			                   
			                   </div>
			                </div>
			                   	@foreach ( $newlessons as $newlesson )			                   		
	                   			<div class="bg-info">
		                			<div class="row">
			                			<div class="col-md-4">
			                   				{{ $newlesson -> date . ' ' . substr( $newlesson -> stime , 0 , 5 ) . '~' . substr( $newlesson -> etime , 0 , 5 ) }}
			                   			</div>
			                   			<div class="col-md-4">
			                   				{{ numtoweek(Carbon\Carbon::parse($newlesson -> date) -> dayOfWeek) }}
			                   			</div>
			                   			
			                			<div class="col-md-2">
			                   				{{ $newlesson -> classid == null ? '单节课程' : '固定课程' }}
			                   			</div>
			                			<div class="col-md-2">
			                   				{{ $newlesson -> cid == 1 ? 'KK' : '辅导君' }}
			                   			</div>
			                   		</div>
			                   		<div class="row">
			                			<div class="col-md-12">
			                   				授课内容：{{ $newlesson -> name }}
			                   			</div>
			                   		</div>
			                   		<div class="row">
			                			<div class="col-md-4">
			                   				授课教师：{{ $newlesson -> tname }}
			                   			</div>
			                			<div class="col-md-4">
			                   				会议ID：{{ $newlesson -> mid }}
			                   			</div>
			                   			<div class="col-md-2">
			                   				消费课时：{{ $newlesson -> cost }}
			                   			</div>
			                   			<div class="col-md-2">
			                   				<a href="#" class="btn btn-primary btn-primary btn-sm active" role="button">修改课程信息</a>
			                   			</div>
			                   		</div>
			                   	</div>
			                   	<br/>
			                   	@endforeach
			                   		
			                <div class="row">
			                	<div class="col-md-10">
			                   		<strong>固定课程</strong>
			                   </div>
			                   <div class="col-md-2">
			                   		<a href="{{ url('createclass') . '/' . $students -> id }}" class="btn btn-primary btn-primary btn-sm active" role="button">增加课程</a>			                   
			                   </div>
			                </div>
			                   	@foreach ( $classes as $class )			                   		
	                   			<div class="bg-info">
		                			<div class="row">
			                			<div class="col-md-4">
			                   				每周{{ numtoweek($class -> dow) }}
			                   			</div>
			                   			<div class="col-md-6">
			                   				{{ substr( $class -> stime , 0 , 5 ) . '~' . substr( $class -> etime , 0 , 5 ) }}
			                   			</div>			                   			
			                			<div class="col-md-2">
			                   				{{ $class -> cid == 1 ? 'KK' : '辅导君' }}
			                   			</div>
			                   		</div>
			                   		<div class="row">
			                			<div class="col-md-12">
			                   				课程名称：{{ $class -> name }}
			                   			</div>
			                   		</div>
			                   		<div class="row">
			                			<div class="col-md-4">
			                   				授课教师：{{ $class -> tname }}
			                   			</div>
			                			<div class="col-md-6">
			                   				会议ID：{{ $class -> mid }}
			                   			</div>
			                   			<div class="col-md-2">
			                   				<a href="#" class="btn btn-primary btn-primary btn-sm active" role="button">修改课程信息</a>
			                   			</div>
			                   		</div>
			                   	</div>
			                   	<br/>
			                   	@endforeach
			                   		
		                </div>	               
                
                	</div>
                	
                	
                	
	 				<div role="tabpanel" class="tab-pane fade" id="lessons">
	
		                <div class="panel-body">
		                	已上课程列表
		                </div>
		            </div>
		            
	 				<div role="tabpanel" class="tab-pane fade" id="recharges">
	
		                <div class="panel-body">
		                	购课记录
		                </div>
		            </div>
                	
                	
               </div>
                
            </div>
        </div>
    </div>
</div>
@endsection