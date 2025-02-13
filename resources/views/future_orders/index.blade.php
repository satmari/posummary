@extends('app')

@section('content')
<div class="container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Future orders <br><br>
					 <a href="{{ url('/future_order_status') }}" class="btn btn-warning btn-xs center-blo ck">Change status of the Order Group</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					 <a href="{{ url('/future_order_update') }}" class="btn btn-info btn-xs center-blo ck">Update MAIN FABRIC</a>
				</div>
				<br>
					{!! Form::open(['url' => 'future_order_1']) !!}

					@if(isset($msgs))

					<div class="alert alert-success" role="alert">
					  {{ $msgs }}
					</div>

					@endif
					<div class="panel-body">
						<p>Order Macro Group : <span style="color:red;">*</span></p>
						{!! Form::select('order_group_macro', [''=>'','BASIC' => 'BASIC','FASHION' => 'FASHION','FLASH' => 'FLASH'], null,['class' => 'form-control']) !!}
					</div>
					<div class="panel-body">
						<p>Order Group : <span style="color:red;">*</span></p>
    					{!! Form::text('order_group', null, ['class' => 'form-control']) !!}
   					</div>

					<div class="panel-body">
						{!! Form::submit('Next', ['class' => 'btn btn-success center-block']) !!}
					</div>
					@include('errors.list')
					{!! Form::close() !!}
				
								
			</div>
		</div>
	</div>
</div>

@endsection