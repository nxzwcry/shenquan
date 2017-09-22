@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $title }}</div>
                
                <div class="panel-body">
	                <table class="table">
						@foreach ( $files as $file )
						<tr>
							<a href="{{ $file -> get('url') }}">{{ $file -> get('name') }}</a><br/>		
						</tr>						
						@endforeach  
					</table>              
           		</div>           
            </div>
        </div>
    </div>
</div>
@endsection
