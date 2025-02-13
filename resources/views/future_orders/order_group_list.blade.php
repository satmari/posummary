@extends('app')

@section('content')
<div class="container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Future orders - change status of the Order Group
					 
				</div>
				<br>
					
					{!! Form::open(['url' => 'future_order_2']) !!}

					<div class="panel-body">
						<p>Order group: </p>
						<select name="order_group_selected" class="select form-control select-form chosen" >
	                        <option value="" selected></option>
	                        @foreach ($data as $m)
	                        <option value="{{ $m->order_group }}">
	                            {{ $m->order_group }}
	                        </option>
	                        @endforeach
	                    </select>
					</div>

					<div class="panel-body">
						<p>Status: </p>
						<select name="status_selected" class="select form-control select-form chosen" >
	                        <option value="" selected></option>
	                        
	                        <option value="NEW">NEW</option>
	                        <option value="IN_PRODUCTION">IN_PRODUCTION</option>
	                        <option value="COMPLETED">COMPLETED</option>
	                        
	                    </select>
					</div>

					<div class="panel-body">
						{!! Form::submit('Save', ['class' => 'btn btn-danger center-block']) !!}
					</div>
					@include('errors.list')
					{!! Form::close() !!}
			
			</div>
		</div>
	</div>
</div>

@endsection