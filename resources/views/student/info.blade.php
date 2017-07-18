@extends('layouts')

@section('header')
	hello world!
@stop

@section('content')
	<p>姓名：{{ $students -> name }}</p>
	<p>英文名：{{ $students -> ename }}</p>
	<p>性别：{{ $students -> sex }}</p>
	<p>年龄：{{ $students -> age }}</p>
	
	<table>
		<tr><th>上课时间</th><th>上课教师</th><th>课程名称</th><th>课程附件</th></tr>
	@foreach ( $lessons as $lesson )
		<tr>
			<td>{{ $lesson -> time }}</td>
			<td>{{ $lesson -> tname }}</td>
			<td>{{ $lesson -> name }}</td>
			<td><a href="{{ $lesson -> vurl }}">视频</a> <a href="{{ $lesson -> furl }}">课件</a></td>
		</tr>
	@endforeach
	</table>
@stop
