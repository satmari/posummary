@extends('app')

@section('content')

<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<br>
				
			<div class="panel panel-default">
				
				<div class="panel-heading">Import PLM costings &nbsp;&nbsp;<b><big></big></b></div>
				
				{!! Form::open(['files'=>True, 'method'=>'POST', 'action'=>['importController@post_plm_costing']]) !!}
					<div class="panel-body">
						{!! Form::file('file7', ['class' => 'center-block']) !!}
					</div>
					<div class="panel-body">
						{!! Form::submit('Import', ['class' => 'btn btn-warning center-block']) !!}
					</div>
					
					@include('errors.list')
				{!! Form::close() !!}

			</div>
		</div>
	</div>
</div>

@endsection