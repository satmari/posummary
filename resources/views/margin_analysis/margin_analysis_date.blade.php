@extends('app')

@section('content')
<div class="container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Import margin analysis</div>
				<br>
					{!! Form::open(['url' => 'margin_analysis_post']) !!}

					
					<div class="panel-body">
						<span>Please choose Date <br> (format is like mm/dd/yyyy):</span>
						<br>
						<br>
						<input type="date" name="date" id="date" class="form-control" style="width: 100%; display: inline;" value="{{ date('Y-m-d')  }}">
						{{-- {!! Form::text('date', null, ['class' => 'form-control']) !!} --}}

					</div>
					
					<div class="panel-body">
						{!! Form::submit('Next', ['class' => 'btn btn-success center-block']) !!}
					</div>
					@include('errors.list')
					{!! Form::close() !!}

					
								
			</div>

			<br>
			<div class="panel panel-default">
				<div class="panel-heading">Import PRO open/closed</div>
				<br>
					{!! Form::open(['url' => 'pro_open_closed_post']) !!}

					
					<div class="panel-body">
						<span>Please choose Date <br> (format is like mm/dd/yyyy):</span>
						<br>
						<br>
						<input type="date" name="date1" id="date1" class="form-control" style="width: 100%; display: inline;" value="{{ date('Y-m-d')  }}">
						{{-- {!! Form::text('date', null, ['class' => 'form-control']) !!} --}}

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