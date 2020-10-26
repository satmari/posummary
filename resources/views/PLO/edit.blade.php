@extends('app')

@section('content')
<div class="container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Edit PLO : <big><b>{{ $plo->plo }}</b></big></div>
				<br>
					{!! Form::model($plo , ['method' => 'POST', 'url' => 'edit_save_plo/'.$plo->id /*, 'class' => 'form-inline'*/]) !!}

					<!-- <div class="panel-body">
						<span>Id:</span>
						{{--  {!! Form::input('number', 'id', null, ['class' => 'form-control']) !!} --}}
					</div> -->
					
					
					<div class="panel-body">
						<span>Bom: </span>
						{{-- {!! Form::input('string', 'bom', null, ['class' => 'form-control']) !!} --}}
						{!! Form::select('bom', array(''=>'','YES'=>'YES','NO'=>'NO'), null, array('class' => 'form-control')); !!} 
					</div>

					<div class="panel-body">
						<span>Routing: <span style="color:red;">*</span></span>
						{{-- {!! Form::input('string', 'routing', null, ['class' => 'form-control']) !!} --}}
						{!! Form::select('routing', array(''=>'','YES'=>'YES','NO'=>'NO'), null, array('class' => 'form-control')); !!} 
					</div>

					<div class="panel-body">
						<span>Prod Version: <span style="color:red;">*</span></span>
						{{-- {!! Form::input('string', 'prod_version', null, ['class' => 'form-control']) !!} --}}
						{!! Form::select('prod_version', array(''=>'','YES'=>'YES','NO'=>'NO'), null, array('class' => 'form-control')); !!} 
					</div>

					
					<div class="panel-body">
						{!! Form::submit('Save', ['class' => 'btn btn-success center-block']) !!}
					</div>
					@include('errors.list')
					{!! Form::close() !!}

					
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/plo')}}" class="btn btn-default">Back</a>
					</div>
				</div>
					
			</div>
		</div>
	</div>
</div>

@endsection