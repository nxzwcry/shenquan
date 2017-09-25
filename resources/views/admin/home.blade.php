@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            	<ol class="breadcrumb">
				  <li class="active">首页</li>
				</ol>
                <div class="panel-heading">学生管理</div>

                <div class="panel-body">
                    <table class="table table-hover">
						<tr><th>学生号</th><th>姓名</th><th>性别</th><th>英文名</th><th>年龄</th><th>年级</th><th>邮箱</th><!--<th>创建时间</th>--><th>操作</th></tr>
					@foreach ( $students as $student )
						<tr>
							<td>{{ $student -> id }}</td>
							<td>{{ $student -> name }}</td>
							<td>{{ $student -> sex }}</td>
							<td>{{ $student -> ename }}</td>
							<td>{{ Carbon\Carbon::now() -> diffInYears($student -> birthday , 'true') }}岁</td>
							<td>{{ $student -> grade }}</td>
							<td>{{ $student -> email }}</td>
							<!--<td>{{ $student -> created_at }}</td>-->
							<td><div class="btn-group">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
									操作 <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a href="{{ url('lessonsinfo') . '/' . $student -> id }}">查看课程信息</a></li>
									<li><a href="{{ url('createcourse') . '/' . $student -> id }}">添加课程</a></li>
									<li><a href="{{ url('recharge') . '/' . $student -> id }}">课时充值</a></li>
									<li class="divider"></li>
									<li><a href="#">修改学生信息</a></li>
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
@endsection
