@extends('layouts.layouts')

@section('header')
<style type="text/css">
	  h1 {
	  	color: #666;
	  	margin: 10% 0;
	  }
</style>
@stop

@section('userinfo')
	<div class="weui-flex">
		<h1>{{ $students -> name }} {{ $students -> ename }}</h1>
	</div>
	<div class="weui-flex">
	  <div class="weui-flex__item">性别：{{ $students -> sex }}</div>
	</div>
	<div class="weui-flex">
	  <div class="weui-flex__item">生日：{{ $students -> birthday }}</div>
	</div>
	<div class="weui-flex">
	  <div class="weui-flex__item">积分：</div>
	</div>
	<br/>
	<div class="weui-flex">
	  <div class="weui-flex__item">已用课时：<br/>
	  	外教1对1&emsp;&emsp;&emsp;{{ $lessons -> sum('cost') }}节<br/>
	  	中教课程&emsp;&emsp;&emsp;{{ $lessons -> sum('cost1') }}节<br/>
	  	外教精品课&emsp;&emsp;{{ $lessons -> sum('cost2') }}节
	  </div>
	</div>
	<br/>
	<div class="weui-flex">
	  <div class="weui-flex__item">剩余课时：<br/>
	  	外教1对1&emsp;&emsp;&emsp;{{ $recharges -> sum('lessons') - $lessons -> sum('cost') }}节<br/>
	  	中教课程&emsp;&emsp;&emsp;{{ $recharges -> sum('lessons1') - $lessons -> sum('cost1') }}节<br/>
	  	外教精品课&emsp;&emsp;{{ $recharges -> sum('lessons2') - $lessons -> sum('cost2') }}节<br/>
	  </div>
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
					<a href="{{ '/flist/' .$lesson -> furl }}">附件</a>
				@endif
				@if ( $lesson -> cwurl <> null )
					<a href="{{ '/cwlist/' .$lesson -> cwurl }}">课件</a>
				@endif
			</td>
		</tr>
	@endforeach
	</table>
@stop
