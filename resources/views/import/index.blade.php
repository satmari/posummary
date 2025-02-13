@extends('app')

@section('content')

<div class="container container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<br>
			<div class="panel panel-default">
				
				<div class="panel-heading">Import in PRO table</div>
				
				{!! Form::open(['files'=>True, 'method'=>'POST', 'action'=>['importController@postImportPro']]) !!}
					<div class="panel-body">
						{!! Form::file('file1', ['class' => 'center-block']) !!}
					</div>
					<div class="panel-body">
						{!! Form::submit('Import', ['class' => 'btn btn-warning center-block']) !!}
					</div>
					@include('errors.list')
				{!! Form::close() !!}

				<!-- <hr> -->
			</div>
			<!--
			<br>
			<div class="panel panel-default">
				
				<div class="panel-heading">Import in PLO table</div>
				
				{!! Form::open(['files'=>True, 'method'=>'POST', 'action'=>['importController@postImportPlo']]) !!}
					<div class="panel-body">
						{!! Form::file('file2', ['class' => 'center-block']) !!}
					</div>
					<div class="panel-body">
						{!! Form::submit('Import', ['class' => 'btn btn-warning center-block']) !!}
					</div>
					@include('errors.list')
				{!! Form::close() !!}

				 <hr> 
			</div>
			-->
			
			<br>
			<div class="panel panel-default">
				
				<div class="panel-heading">Import SkedaStatus from Skeda</div>
				
				{!! Form::open(['files'=>True, 'method'=>'POST', 'action'=>['importController@portImportSkedaStatus']]) !!}
					<div class="panel-body">
						{!! Form::file('file3', ['class' => 'center-block']) !!}
					</div>
					<div class="panel-body">
						{!! Form::submit('Import', ['class' => 'btn btn-warning center-block']) !!}
					</div>
					@include('errors.list')
				{!! Form::close() !!}

				<!-- <hr> -->
			</div>

			<br>
			<div class="panel panel-default">
				
				<div class="panel-heading">Import Number of lines (by PRO or by Skeda)</div>
				
				{!! Form::open(['files'=>True, 'method'=>'POST', 'action'=>['importController@portImportNumberOfLines']]) !!}
					<div class="panel-body">
						{!! Form::file('file4', ['class' => 'center-block']) !!}
					</div>
					<div class="panel-body">
						{!! Form::submit('Import', ['class' => 'btn btn-warning center-block']) !!}
					</div>
					@include('errors.list')
				{!! Form::close() !!}

				<!-- <hr> -->
			</div>

			<!-- <br>
			<div class="panel panel-default">
				
				<div class="panel-heading">Import daily plan</div>
				
				{!! Form::open(['files'=>True, 'method'=>'POST', 'action'=>['importController@portImportdaily_plan']]) !!}
					<div class="panel-body">
						<span>Plan date (format: m/d/y):</span>
						<input type="date" name="post_date" id="date" class="form-control" style="width: 100%; display: inline;" value="{{ date('Y-m-d')  }}">
					</div>
					<div class="panel-body">
						{!! Form::file('file5', ['class' => 'center-block']) !!}
					</div>
					<div class="panel-body">
						{!! Form::submit('Import', ['class' => 'btn btn-warning center-block']) !!}
					</div>
					@include('errors.list')
				{!! Form::close() !!}

				
			</div> -->
 

		
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="">
						<a href="{{url('/')}}" class="btn btn-default btn-lg center-block">Back to main menu</a>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>

@endsection