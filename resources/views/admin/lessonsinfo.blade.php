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
					@if($students -> classes)
				  	<li><a href="{{ url('class') . '/' . $students -> classes -> id }}">{{ $students -> classes -> name }}</a></li>
					@endif
				  	<li class="active">{{ $students -> name }}</li>
				</ol>
                <ul class="nav nav-tabs" role="tablist">      
					<li role="presentation" class="active">
					  	<a href="#baseinfo" role="tab" data-toggle="tab">学生课程信息</a>
					</li>    
					<!--<li role="presentation">
					  	<a href="#courses" role="tab" data-toggle="tab">课程详细信息</a>
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
				            <div class="row center-vertical-row">
			                	<div class="col-md-5 center-vertical-col">
			                    	<h4>{{ $students -> id }}</h4>
			                    	<h2>{{ $students -> name . ' ' . $students -> ename }}</h2>
			                    	<h4>{{ $lessons -> sum('score') }}分</h4>
			                   	</div>
			                   	<div class="col-md-5 center-vertical-col">
			                   		
				                	<div class="row">
					                   		已上：外{{ $lessons -> sum('cost') }}/中{{ $lessons -> sum('cost1') }}/精{{ $lessons -> sum('cost2') }} <br/>
					                </div>
				                	<div class="row">
					                   		剩余：外{{ $recharges -> sum('lessons') - $lessons -> sum('cost') }}/中{{ $recharges -> sum('lessons1') - $lessons -> sum('cost1') }}/精{{ $recharges -> sum('lessons2') - $lessons -> sum('cost2') }} <br/>
					                  		
					                </div>
				                	<div class="row">
						                <div class="col-md-8">
					                   		@for ( $i = 9 ; $i >= 0 ; $i-- )
					                   			@if ( $tenlessons[$i] == 'w' )
					                   				<span class="color-waijiao">_</span>&emsp;
					                   			@elseif ( $tenlessons[$i] == 'f' )
					                   				<span class="color-fuxi">_</span>&emsp;
					                   			@elseif ( $tenlessons[$i] == 'j' )
					                   				<span class="color-jingpin">_</span>&emsp;
					                   			@elseif ( $tenlessons[$i] == 'b' )
					                   				<span class="color-ban">_</span>&emsp;
					                   			@elseif ( $tenlessons[$i] == 'n' )
					                   				<span class="color-null">_</span>&emsp;
					                   			@endif
					                   			@if ( $i == 5 ) 
					                   				<span class="color-null">_</span>
					                   			@endif
					                   		@endfor
					                   	</div>
				                   		<div class="col-md-4">
				                   			<span class="color-waijiao">外</span>
				                   			<span class="color-fuxi">复</span>
				                   			<span class="color-jingpin">精</span>
				                   			<span class="color-ban">班</span>
				                   		</div>	
					                </div>
			                   	</div>
			                   	<div class="col-md-2 center-vertical-col">
			                   		<a href="{{ url('createcourse') . '/' . $students -> id }}">增加课程</a> <br/>
			                   		<a href="{{ url('recharge') . '/' . $students -> id }}">课时充值</a><br/>
									<a href="{{ url('/student/change') . '/' . $students -> id }}">修改学生信息</a>
			                   </div>
			               </div>
		                	<div class="row">
			                	<div class="col-md-12">
			                   		<strong>下节课程</strong>
			                  	</div>
			                </div>
			                   	@foreach ( $newlessons as $newlesson )			                   		
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
			                   				<a href="{{ url('/lesson/change/' . $newlesson -> id) }}" >修改</a>
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
			                   	@foreach ( $courses as $course )			                   		
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
			                   				<a href="{{ url('course/stop/' . $course -> sid . '/' . $course -> id) }}" >停课</a>
			                   				<a href="#" onclick="pop('{{$course -> id}}' , '{{$course -> sid}}')" >删除</a>
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
			                   	@foreach ( $oldcourses as $course )			                   		
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
			                   				<a href="{{ url('course/restart/' . $course -> sid . '/' . $course -> id) }}" >复课</a>
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
							@foreach ( $lessons as $lesson )
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
												<li><a href="{{ url('/lesson/change/' . $lesson -> id) }}" >修改课程信息</a></li>			                   				
												<li><a href="{{ url('/lesson/fileupdate') . '/' . $lesson -> id }}">上传/修改附件</a></li>
												<li class="divider"></li>
												<li><a href="{{ url('deletelesson/' .$lesson -> sid . '/' . $lesson -> id) }}">删除课程</a></li>
											</ul>
										</div>
									</td>
								</tr>
							@endforeach
							</table>
		                </div>
		            </div>
		            
	 				<div role="tabpanel" class="tab-pane fade" id="recharges">
	
		                <div class="panel-body">
		                	<table class="table table-hover">
								<tr><th>充值课时数</th><th>缴费金额</th><th>创建时间</th><th>备注</th><th>操作</th></tr>
							@foreach ( $recharges as $recharge )
								<tr>
									<td>外{{ $recharge -> lessons }}/中{{ $recharge -> lessons1 }}/精{{ $recharge -> lessons2 }}</td>
									<td>{{ $recharge -> money }}</td>
									<td>{{ $recharge -> created_at -> toDateString() }}</td>									
									<td>{{ $recharge -> note }}</td>								
									<td>
										修改
										<a href="{{ url( 'recharge/delete/' . $recharge -> sid . '/' . $recharge -> id ) }}" onclick="">删除</a>
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