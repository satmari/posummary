@extends('app')

@section('content')
<div class="container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Import daily plan - choose date</div>
				<br>
					{!! Form::open(['url' => 'date_daily_plan']) !!}

					
					<div class="panel-body">
						<span>Plan date (format: m/d/y):</span>
						<input type="date" name="import_date" id="date" class="form-control" style="width: 100%; display: inline;" value="{{ date('Y-m-d')  }}">
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