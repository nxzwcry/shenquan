@extends('layouts.app')

@section('head')
<script type="text/javascript">	
function change(){
    var strvalue=$("#id option:selected").val();
    console.log(strvalue);
//  var strvalue=$("#name").val();
    $.ajax({
      timeout: 3000,
      async: false,
      url: 'getcwlist',
      type: "post",
      data: {'id':strvalue, '_token': $('input[name=_token]').val()},
      success: function(data){
        $('#list').html("已有课件<br/>"); //清空
        for (var i=0;i<data.length;i++){		
			$('#list').append( data[i] + "<br/>");
		}
      }
    });      
  }

</script>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            	<ul class="nav nav-tabs" role="tablist">      
					<li role="presentation" class="active">
					  	<a href="#newcw" role="tab" data-toggle="tab">添加新课件系列</a>
					</li>    
					<li role="presentation">
					  	<a href="#update" role="tab" data-toggle="tab">上传课件到已有系列</a>
					</li>    					  
				</ul> 
				
				<div class="tab-content"> 

	 				<div role="tabpanel" class="tab-pane fade in active" id="newcw">

                <div class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ url('/newcw') }}">
                    	<input type="hidden" name="_token" value="{csrf_token()}"/>
                       	{{ csrf_field() }}
						                        
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
	                        <label for="name" class="col-md-4 control-label" >课件名称*</label>
	
	                        <div class="col-md-6">
	                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required>
		                        @if ($errors->has('name'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('name') }}</strong>
	                                </span>
	                            @endif
	                        </div>
                        </div>
                                                
                        <div class="form-group{{ $errors->has('files') ? ' has-error' : '' }}">
                        	<label for="name" class="col-md-4 control-label" ></label>
					        <div class="col-md-6">
					            <input type="file" name="files[]" class="projectfile" value="${deal.image}" multiple="multiple" />					            
					        	@if ($errors->has('files'))
	                                <span class="help-block">
	                                    <strong>{{ $errors->first('files') }}</strong>
	                                </span>
	                            @endif
					        </div>
					    </div>  
					    <div class="form-group text-center ">
					        <div class="col-md-10 col-md-offset-1">
					            <button type="submit" class="btn btn-primary btn-lg">保存</button>
					        </div>
					    </div>
					    
                    </form>
                </div>
                
                </div>                

	 				<div role="tabpanel" class="tab-pane fade" id="update">
	 					<div class="panel-body">
		                    <form class="form-horizontal" enctype="multipart/form-data" method="POST" action="{{ url('/updatecw') }}">
		                    	<input type="hidden" name="_token" value="{csrf_token()}"/>
		                        {{ csrf_field() }}
								                        
		                        <div class="form-group{{ $errors->has('id') ? ' has-error' : '' }}">
			                        <label class="col-md-4 control-label" >课件名称*</label>
			
			                        <div class="col-md-6">
										<select onchange="change()" id="id" class="form-control" name="id"  required>
											@foreach ( $cws as $cw )												
											  <option value="{{ $cw -> id }}" {{ old('id')== $cw -> id ? ' selected' : '' }}>{{ $cw -> name }}</option>
											@endforeach
										</select>	
									</div>		
		                        </div>
		                                                
		                        <div class="form-group">
		                        	<label for="name" class="col-md-4 control-label" ></label>
							        <div class="col-md-6">
							            <input type="file" name="files[]" class="projectfile" value="${deal.image}" multiple="multiple" />					            
							        </div>
							    </div>  
							    <div class="form-group text-center ">
							        <div class="col-md-10 col-md-offset-1">
							            <button type="submit" class="btn btn-primary btn-lg">保存</button>
							        </div>
							    </div>
							    
		                    </form>
		                    <p id="list">
		                    	
		                    </p>
		                </div>
	 				</div>
	 			
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('tail')


@endsection