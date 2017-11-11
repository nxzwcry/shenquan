@extends('layouts.app')

@section('head')
<style>
	.color-warning {background-color:#f0ad4e;color:#FFFFFF;}
	.color-danger {background-color:#d9534f;color:#FFFFFF;}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
				<ol class="breadcrumb">
					<li class="active">首页</li>
				</ol>
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active">
						<a href="#ostudents" role="tab" data-toggle="tab">1对1学生</a>
					</li>
					<li role="presentation">
						<a href="#classes" role="tab" data-toggle="tab">班级</a>
					</li>
					<li role="presentation">
						<a href="#cstudents" role="tab" data-toggle="tab">班课学生</a>
					</li>
					<li role="presentation">
						<a href="#sstudents" role="tab" data-toggle="tab">停课学生</a>
					</li>
				</ul>

				<div class="tab-content">

					<div role="tabpanel" class="tab-pane fade in active" id="ostudents">

						<div class="panel-body">
							<table class="table table-hover">
								<tr><th>英文名</th><th>姓名</th><th>性别</th><th>年龄</th><!--<th>年级</th>--><th>积分</th><th>操作</th></tr>
							@foreach ( $one2ones as $student )
								@if ( $student -> getbalance() <= 2 )
									<tr class="danger">
								@elseif ( $student -> getbalance() <= 3 )
									<tr class="warning">
								@else
									<tr>
								@endif
									<td>{{ $student -> ename }}</td>
									<td>{{ $student -> name }} &emsp;<span class="{{ $student -> getfuxi() > 5 ? 'color-danger' : ( $student -> getfuxi() == 5 ? 'color-warning' : 'hidden' ) }}">复</span>&emsp;<span class="{{ $student -> getjingpin() > 5 ? 'color-danger' : ( $student -> getjingpin() == 5 ? 'color-warning' : 'hidden' ) }}">精</span></td>
									<td>{{ $student -> sex }}</td>
									<td>{{ Carbon\Carbon::now() -> diffInYears($student -> birthday , 'true') }}岁</td>
									<td>{{ $student -> lessons -> sum('score') }}</td>
									<!--<td>{{ $student -> grade }}</td>-->
									<td><div class="btn-group">
										<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											操作 <span class="caret"></span>
										</button>
										<ul class="dropdown-menu" role="menu">
											<li><a href="{{ url('lessonsinfo') . '/' . $student -> id }}">查看课程信息</a></li>
											<li><a href="{{ url('createcourse') . '/' . $student -> id }}">添加课程</a></li>
											<li><a href="{{ url('recharge') . '/' . $student -> id }}">课时充值</a></li>
											<li class="divider"></li>
											<li><a href="{{ url('/student/change') . '/' . $student -> id }}">修改学生信息</a></li>
											<li hidden><a href="#">删除学生</a></li>
										</ul>
									</div></td>
									<!--<td><a href="">修改信息</a>
										<a href="/createcourse/{{ $student -> id }}">增加固定课程</a>
										<a href="/createlesson/{{ $student -> id }}">增加单节课程</a>
										<a href="">删除用户</a></td>-->
								</tr>
							@endforeach
							</table>
						</div>
					</div>


					<div role="tabpanel" class="tab-pane fade" id="classes">

						<div class="panel-body">
							<table class="table table-hover">
								<tr><th>班级ID</th><th>班级名称</th><th>上课地点</th><th>上课内容</th><th>班级人数</th><th>操作</th></tr>
									@foreach ( $classes as $class )
										<tr>
											<td>{{ $class -> id }}</td>
											<td>{{ $class -> name }}</td>
											<td>{{ $class -> getcourse() ? $class -> getcourse() -> place -> name : '' }}</td>
											<td>{{ $class -> getcourse() ? $class -> getcourse() -> name : '' }}</td>
											<td>{{ $class -> students() -> count() }}人</td>
											<td>
												<div class="btn-group">
													<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
														操作 <span class="caret"></span>
													</button>
													<ul class="dropdown-menu" role="menu">
														<li><a href="#">查看班级信息</a></li>
														<li><a href="#">修改班级信息</a></li>
													</ul>
												</div>
											</td>
										</tr>
									@endforeach
							</table>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane fade" id="cstudents">

						<div class="panel-body">
							<table class="table table-hover">
								<tr><th>英文名</th>姓名</th><th>性别</th><th>年龄</th><!--<th>年级</th>--><th>积分</th><th>操作</th></tr>
								@foreach ( $classs as $student )
									@if ( $student -> getbalance() <= 2 )
										<tr class="danger">
									@elseif ( $student -> getbalance() <= 3 )
										<tr class="warning">
									@else
										<tr>
										@endif
											<td>{{ $student -> ename }}</td>
											<td>{{ $student -> name }} &emsp;<span class="{{ $student -> getfuxi() > 5 ? 'color-danger' : ( $student -> getfuxi() == 5 ? 'color-warning' : 'hidden' ) }}">复</span>&emsp;<span class="{{ $student -> getjingpin() > 5 ? 'color-danger' : ( $student -> getjingpin() == 5 ? 'color-warning' : 'hidden' ) }}">精</span></td>
											<td>{{ $student -> sex }}</td>
											<td>{{ Carbon\Carbon::now() -> diffInYears($student -> birthday , 'true') }}岁</td>
											<td>{{ $student -> lessons -> sum('score') }}</td>
										<!--<td>{{ $student -> grade }}</td>-->
											<td><div class="btn-group">
													<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
														操作 <span class="caret"></span>
													</button>
													<ul class="dropdown-menu" role="menu">
														<li><a href="{{ url('lessonsinfo') . '/' . $student -> id }}">查看课程信息</a></li>
														<li><a href="{{ url('createcourse') . '/' . $student -> id }}">添加课程</a></li>
														<li><a href="{{ url('recharge') . '/' . $student -> id }}">课时充值</a></li>
														<li class="divider"></li>
														<li><a href="{{ url('/student/change') . '/' . $student -> id }}">修改学生信息</a></li>
														<li hidden><a href="#">删除学生</a></li>
													</ul>
												</div></td>
										<!--<td><a href="">修改信息</a>
										<a href="/createcourse/{{ $student -> id }}">增加固定课程</a>
										<a href="/createlesson/{{ $student -> id }}">增加单节课程</a>
										<a href="">删除用户</a></td>-->
										</tr>
										@endforeach
							</table>
						</div>
					</div>


					<div role="tabpanel" class="tab-pane fade" id="sstudents">

						<div class="panel-body">
							<table class="table table-hover">
								<tr><th>英文名</th><th>姓名</th><th>性别</th><th>年龄</th><!--<th>年级</th>--><th>积分</th><th>操作</th></tr>
								@foreach ( $stops as $student )
									@if ( $student -> getbalance() <= 2 )
										<tr class="danger">
									@elseif ( $student -> getbalance() <= 3 )
										<tr class="warning">
									@else
										<tr>
										@endif
											<td>{{ $student -> ename }}</td>
											<td>{{ $student -> name }} &emsp;<span class="{{ $student -> getfuxi() > 5 ? 'color-danger' : ( $student -> getfuxi() == 5 ? 'color-warning' : 'hidden' ) }}">复</span>&emsp;<span class="{{ $student -> getjingpin() > 5 ? 'color-danger' : ( $student -> getjingpin() == 5 ? 'color-warning' : 'hidden' ) }}">精</span></td>
											<td>{{ $student -> sex }}</td>
											<td>{{ Carbon\Carbon::now() -> diffInYears($student -> birthday , 'true') }}岁</td>
											<td>{{ $student -> lessons -> sum('score') }}</td>
										<!--<td>{{ $student -> grade }}</td>-->
											<td><div class="btn-group">
													<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
														操作 <span class="caret"></span>
													</button>
													<ul class="dropdown-menu" role="menu">
														<li><a href="{{ url('lessonsinfo') . '/' . $student -> id }}">查看课程信息</a></li>
														<li><a href="{{ url('createcourse') . '/' . $student -> id }}">添加课程</a></li>
														<li><a href="{{ url('recharge') . '/' . $student -> id }}">课时充值</a></li>
														<li class="divider"></li>
														<li><a href="{{ url('/student/change') . '/' . $student -> id }}">修改学生信息</a></li>
														<li hidden><a href="#">删除学生</a></li>
													</ul>
												</div></td>
										<!--<td><a href="">修改信息</a>
										<a href="/createcourse/{{ $student -> id }}">增加固定课程</a>
										<a href="/createlesson/{{ $student -> id }}">增加单节课程</a>
										<a href="">删除用户</a></td>-->
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
