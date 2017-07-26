@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">学生管理</div>

                <div class="panel-body">
                    <table class="table table-hover">
						<tr><!--<th>学生号</th>--><th>姓名</th><th>性别</th><th>英文名</th><th>年龄</th><th>年级</th><th>邮箱</th><th>操作</th></tr>
					@foreach ( $students as $student )
						<tr>
							<!--<td>{{ $student -> id }}</td>-->
							<td>{{ $student -> name }}</td>
							<td>{{ $student -> sex }}</td>
							<td>{{ $student -> ename }}</td>
							<td>{{ Carbon\Carbon::now() -> diffInYears($student -> birthday , 'true') }}岁</td>
							<td>{{ $student -> grade }}</td>
							<td>{{ $student -> email }}</td>
							<td><a href="">修改信息</a> 
								<a href="">增加固定课程</a>
								<a href="">增加单节课程</a>
								<a href="">删除用户</a></td>
						</tr>
					@endforeach
					</table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
