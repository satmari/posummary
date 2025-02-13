@extends('app')

@section('content')

<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<br>
				
			<div class="panel panel-default">
				
				<div class="panel-heading">Update future orders
					<p><i>Upload Excel file with columns: id, main_mat, smv_fr, qty</i></p></div>

				
				{!! Form::open(['files'=>True, 'method'=>'POST', 'action'=>['importController@portUpdatefuture_orders']]) !!}
					
					
					<div class="panel-body">
						{!! Form::file('file11', ['class' => 'center-block']) !!}
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