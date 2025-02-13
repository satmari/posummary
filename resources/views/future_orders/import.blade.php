@extends('app')

@section('content')

<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<br>
				
			<div class="panel panel-default">
				
				<div class="panel-heading">Import future orders</div>
				
				{!! Form::open(['files'=>True, 'method'=>'POST', 'action'=>['importController@portImportfuture_orders']]) !!}
					
					{!! Form::hidden('order_group', $order_group) !!}
					{!! Form::hidden('order_group_macro', $order_group_macro) !!}
					
					
					<div class="panel-body">
						{!! Form::file('file8', ['class' => 'center-block']) !!}
					</div>
					<div class="panel-body">
						{!! Form::submit('Import', ['class' => 'btn btn-warning center-block']) !!}
					</div>
					@include('errors.list')
				{!! Form::close() !!}

				<!-- <hr> -->
			</div>
 		</div>
	</div>
</div>

@endsection