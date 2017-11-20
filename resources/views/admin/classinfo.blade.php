@extends('layouts.app')

@section('head')
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.color-waijiao {background-color:#428bca;color:#FFFFFF;}
		.color-jingpin {background-color:#5cb85c;color:#FFFFFF;}
		.color-fuxi {background-color:#f0ad4e;color:#FFFFFF;}
		.color-ban {background-color:#5bc0de;color:#FFFFFF;}
		.color-null {background-color:#FFFFFF;color:#FFFFFF;}
		.center-vertical-col {

			display: inline-block;

			float: none;

			vertical-align: middle;

			font-size: 14px;

		}

		.center-vertical-row {

			font-size: 0;

		}
	</style>
    <script type="text/javascript">	
	function pop( id , sid ){
	    $("#courseid").val(id);
	    $("#studentid").val(sid);
	    $("#modal").modal();
	 }
	</script>
@endsection

@section('content')
<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modal">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
    	<div class="modal-header">
      		<h4 class="modal-title" >删除方式</h4>
      	</div>
      	<form class="form-horizontal" method="POST" action="/deletecourse">
      		<div class="modal-body">
      			{{ csrf_field() }}
      			<input type="hidden" id="courseid" name="id" value=""/>
      			<input type="hidden" id="studentid" name="sid" value=""/>
			  	<input type="radio" name="option" value="no" checked required> 不删除关联课程</input><br />
			  	<input type="radio" name="option" value="after" required> 删除未上关联课程</input><br />
			  	<input type="radio" name="option" value="all" required> 删除所有关联课程</input>
		  	</div>	 
		  	<div class="modal-footer">
		  		<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
		  		<button type="submit" class="btn btn-primary">删除</button>
		  	</div> 		
      	</form>
    </div>
  </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            	<ol class="breadcrumb">
				  <li><a href="{{ route('home') }}">首页</a></li>
				  <li class="active">{{$class->name}}</li>
				</ol>
                <ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active">
					  	<a href="#baseinfo" role="tab" data-toggle="tab">学生课程信息</a>
					</li>
					<li role="presentation">
					  	<a href="#lessons" role="tab" data-toggle="tab">已上课程列表</a>
					</li>
				</ul> 
				<div class="tab-content"> 

	 				<div role="tabpanel" class="tab-pane fade in active" id="baseinfo">
	
		                <div class="panel-body">
							<div class="row">
								<form class="form-horizontal" method="POST" action="{{ url('class/addstudent') }}">
									{{ csrf_field() }}
									<input type="hidden" id="classid" name="cid" value="{{$class->id}}"/>
									<div class="col-md-6">
										<input id="sid" type="text" class="form-control" name="sid" placeholder="请输入学生id"/>
									</div>
									<div class="col-md-2">
										<button type="submit" class="btn btn-primary">
											添加学生
										</button>
									</div>
									<div class="col-md-4">

									</div>
								</form>
							</div>
							@foreach( $class -> students as $student )
				            <div class="row center-vertical-row">
			                	<div class="col-md-4 center-vertical-col ">
			                    	<h2><a href="{{ url('lessonsinfo') . '/' . $student -> id }}">{{ $student -> name . ' ' . $student -> ename }}</a></h2>
			                   	</div>
								<div class="col-md-4 center-vertical-col ">
									<h4 class="vertical-center">{{ $student -> id }}&emsp;{{ $student -> lessons() -> sum('score') }}分</h4>
								</div>
			                   	<div class="col-md-2 center-vertical-col ">
				                	<div class="row">
					                   		已上：外{{ $student -> getoldlessons() -> sum('cost') }}/中{{ $student -> getoldlessons() -> sum('cost1') }} <br/>
					                </div>
				                	<div class="row">
					                   		剩余：外{{ $student -> recharges() -> sum('lessons') - $student -> getoldlessons() -> sum('cost') }}/中{{ $student -> recharges() -> sum('lessons1') - $student -> getoldlessons() -> sum('cost1') }} <br/>
					                </div>
			                   	</div>
								<div class="col-md-2 center-vertical-col ">
									<a href="{{ url('/class/deletestudent/' . $class -> id . '/' . $student -> id) }}">删除学生</a>
								</div>
			               	</div>
							@endforeach
		                	<div class="row">
			                	<div class="col-md-10">
			                   		<strong>下节课程</strong>
			                  	</div>
								<div class="col-md-2">
									@if($class->students()->first())
									<a href="{{ url('/class/createcourse/' . $class -> id ) }}">增加课程</a> <br/>
									@endif
								</div>
			                </div>
			                   	@foreach ( $class -> getnextlessons() as $newlesson )
	                   			<div class="{{ ($newlesson -> type == 'w') || ($newlesson -> type == 'b') ? 'bg-info' : ($newlesson -> type == 'f' ? 'bg-warning' : ($newlesson -> type == 'j' ? 'bg-success' : '' ))}}">
		                			<div class="row">
			                			<div class="col-md-4">
			                   				{{ $newlesson -> date . ' ' . substr( $newlesson -> stime , 0 , 5 ) . '~' . substr( $newlesson -> etime , 0 , 5 ) }}
			                   			</div>
			                   			<div class="col-md-4">
			                   				{{ numtoweek(Carbon\Carbon::parse($newlesson -> date) -> dayOfWeek) }}
			                   			</div>
			                   			<div class="col-md-4">
			                   				消费课时：外{{ $newlesson -> cost }}/中{{ $newlesson -> cost1 }}/精{{ $newlesson -> cost2 }}
			                   			</div>
			                   		</div>
			                   		<div class="row">
			                			<div class="col-md-12">
			                   				授课内容：{{ $newlesson -> name }}
			                   			</div>
			                   		</div>
			                   		<div class="row">
			                			<div class="col-md-12">
			                   				授课地点：{{ $newlesson -> place -> name }}
			                   			</div>
			                   		</div>
			                   		<div class="row">
			                			<div class="col-md-4">
			                   				授课教师：{{ $newlesson -> tname }}{{ ( $newlesson -> cteacher ) && ( $newlesson -> tname <> '' ) ? ' & ' : '' }}{{ $newlesson -> cteacher ? $newlesson -> cteacher -> tname : '' }}
			                   			</div>
			                			<div class="col-md-4">
			                   				会议ID：{{ $newlesson -> mid }}
			                   			</div>
			                			<div class="col-md-2">
			                   				@if ( $newlesson -> type == 'w' )
					                   			外教1对1
				                   			@elseif ( $newlesson -> type == 'f' )
				                   				复习课
				                   			@elseif ( $newlesson -> type == 'j' )
				                   				精品课
				                   			@elseif ( $newlesson -> type == 'b' )
				                   				班课
				                   			@endif
			                   			</div>
			                   			<div class="col-md-2">
			                   				<a href="{{ url('/class/lesson/change/' . $newlesson -> id) }}" >修改</a>
			                   				<a href="{{ url('/deletelesson/' . $newlesson -> sid . '/' . $newlesson -> id) }}" {{ $newlesson -> courseid == null ? '' : 'class=hidden' }}>删除</a>
			                   			</div>
			                   		</div>
			                   	</div>
			                   	<br/>
			                   	@endforeach

			                <div class="row">
			                	<div class="col-md-12">
			                   		<strong>固定课程</strong>
			                  	</div>
			                </div>
			                   	@foreach ( $class -> getcourses() as $course )
	                   			<div class="bg-info">
		                			<div class="row">
			                			<div class="col-md-4">
			                   				每周{{ numtoweek($course -> dow) }}
			                   			</div>
			                   			<div class="col-md-4">
			                   				{{ substr( $course -> stime , 0 , 5 ) . '~' . substr( $course -> etime , 0 , 5 ) }}
			                   			</div>
			                   			<div class="col-md-4">
			                   				消费课时：外{{ $course -> cost }}/中{{ $course -> cost1 }}/精{{ $course -> cost2 }}
			                   			</div>
			                   		</div>
			                   		<div class="row">
			                			<div class="col-md-12">
			                   				课程名称：{{ $course -> name }}
			                   			</div>
			                   		</div>
			                   		<div class="row">
			                			<div class="col-md-12">
			                   				授课地点：{{ $course -> place -> name }}
			                   			</div>
			                   		</div>
			                   		<div class="row">
			                			<div class="col-md-4">
			                   				授课教师：{{ $course -> tname }}{{ ( $course -> cteacher ) && ( $course -> tname <> '' ) ? ' & ' : '' }}{{ $course -> cteacher ? $course -> cteacher -> tname : '' }}
			                   			</div>
			                			<div class="col-md-6">
			                   				会议ID：{{ $course -> mid }}
			                   			</div>
			                   			<div class="col-md-2">
			                   				停课 &emsp;
			                   				删除
			                   			</div>
			                   		</div>
			                   	</div>
			                   	<br/>
			                   	@endforeach


			                <div class="row">
			                	<div class="col-md-12">
			                   		<strong>已完成固定课程</strong>
			                  	</div>
			                </div>
			                   	@foreach ( $class -> getoldcourses() as $course )
	                   			<div class="bg-info">
		                			<div class="row">
			                			<div class="col-md-4">
			                   				{{ $course -> sdate -> toDateString() }} ~ {{ $course -> edate -> toDateString() }}
			                   			</div>
			                			<div class="col-md-4">
			                   				每周{{ numtoweek($course -> dow) }}
			                   			</div>
			                   			<div class="col-md-4">
			                   				{{ substr( $course -> stime , 0 , 5 ) . '~' . substr( $course -> etime , 0 , 5 ) }}
			                   			</div>
			                   		</div>
			                   		<div class="row">
			                			<div class="col-md-12">
			                   				课程名称：{{ $course -> name }}
			                   			</div>
			                   		</div>
			                   		<div class="row">
			                			<div class="col-md-4">
			                   				授课教师：{{ $course -> tname }}{{ ( $course -> cteacher ) && ( $course -> tname <> '' ) ? ' & ' : '' }}{{ $course -> cteacher ? $course -> cteacher -> tname : '' }}
			                   			</div>
			                   			<div class="col-md-6">
			                   				消费课时：外{{ $course -> cost }}/中{{ $course -> cost1 }}/精{{ $course -> cost2 }}
			                   			</div>
			                   			<div class="col-md-2">
			                   				复课
			                   			</div>
			                   		</div>
			                   	</div>
			                   	<br/>
			                   	@endforeach

		                </div>

                	</div>



	 				<div role="tabpanel" class="tab-pane fade" id="lessons">

		                <div class="panel-body">
		                	<table class="table table-hover">
								<tr><th>老师姓名</th><th>课程内容</th><th>上课日期</th><th>附件</th><th>消耗课时</th><th>课程类型</th><th>得分</th><th>操作</th></tr>
							@foreach ( $class -> getoldlessons() as $lesson )
								@if ( $lesson -> type == 'w' )
	                   				<tr class="info">
	                   			@elseif ( $lesson -> type == 'f' )
	                   				<tr class="warning">
	                   			@elseif ( $lesson -> type == 'j' )
	                   				<tr class="success">
	                   			@else
	                   				<tr class="info">
	                   			@endif
									<td>{{ $lesson -> tname }}{{ ( $lesson -> cteacher ) && ( $lesson -> tname <> '' ) ? ' & ' : '' }}{{ $lesson -> cteacher ? $lesson -> cteacher -> tname : '' }}</td>
									<td>{{ $lesson -> name }}</td>
									<td>{{ $lesson -> date }}</td>
									<td>
										<a href="{{ '/video/' . $lesson -> id }}" {{ $lesson -> vid == null ? 'hidden' : '' }}>视频</a>
										<a href="{{ '/showflist/' .$lesson -> furl }}" {{ $lesson -> furl == null ? 'hidden' : '' }}>文件</a>
										<a href="{{ '/showcwlist/' .$lesson -> cwurl }}" {{ $lesson -> cwurl == null ? 'hidden' : '' }}>课件</a>
									</td>
									<td>外{{ $lesson -> cost }}/中{{ $lesson -> cost1 }}/精{{ $lesson -> cost2 }}</td>
									<td>{{ $lesson -> type == 'w' ? '外教1对1' : ( $lesson -> type == 'f' ? '复习课' : ( $lesson -> type == 'j' ? '精品课' :   ( $lesson -> type == 'b' ? '班课' : '' ) ) ) }}</td>
									<td>{{ $lesson -> score }}</td>
									<td>
										<div class="btn-group">
											<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
												操作 <span class="caret"></span>
											</button>
											<ul class="dropdown-menu" role="menu">
												{{--<li><a href="{{ url('/class/lesson/change/' . $lesson -> id) }}" >修改课程信息</a></li>--}}
												<li><a href="{{ url('/class/fileupdate') . '/' . $lesson -> id }}">上传/修改附件</a></li>
												{{--<li class="divider"></li>--}}
												{{--<li><a href="{{ url('deletelesson/' .$lesson -> sid . '/' . $lesson -> id) }}">删除课程</a></li>--}}
											</ul>
										</div>
									</td>
								</tr>
							@endforeach
							</table>
		                </div>
		            </div>


               </div>
                
            </div>
        </div>
    </div>
</div>
@endsection