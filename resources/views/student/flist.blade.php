<!DOCTYPE HTML>
<html>
<head>
<title>{{ $title }}</title>
</head>
<body>
    <h1>{{ $title }}</h1>
	<table class="table">
		@foreach ( $files as $file )
		<tr>
			<a href="{{ $file -> get('url') }}">{{ $file -> get('name') }}</a><br/>		
		</tr>						
		@endforeach  
	</table>    
</body>