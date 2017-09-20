@extends('layouts.layouts')

<!--@section('header')
	hello world!
@stop-->

@section('userinfo')
	<div class="weui-flex">
	  <div class="weui-flex__item">姓名：{{ $students -> name }}</div>
	</div>
	<div class="weui-flex">
	  <div class="weui-flex__item">英文名：{{ $students -> ename }}</div>
	</div>
	<div class="weui-flex">
	  <div class="weui-flex__item">性别：{{ $students -> sex }}</div>
	</div>
	<div class="weui-flex">
	  <div class="weui-flex__item">生日：{{ $students -> birthday }}</div>
	</div>
	<div class="weui-flex">
	  <div class="weui-flex__item">邮箱：{{ $students -> email }}</div>
	</div>
@stop

@section('file')
	<table>
		<tr><th>上课时间</th><th>上课教师</th><th>课程名称</th><th>课程附件</th></tr>
	@foreach ( $lessons as $lesson )
		<tr>
			<td>{{ $lesson -> date }}</td>
			<td>{{ $lesson -> tname }}</td>
			<td>{{ $lesson -> name }}</td>
			<td>
				@if ( $lesson -> vid <> null )
					<a href="{{ url('wechat/video') . '/' . $lesson -> vid }}">视频</a>
				@endif
				@if ( $lesson -> furl <> null )
					<a href="{{ $lesson -> furl }}">附件</a>
				@endif
				@if ( $lesson -> cwurl <> null )
					<a href="{{ $lesson -> cwurl }}">课件</a>
				@endif
			</td>
		</tr>
	@endforeach
	</table>
@stop
