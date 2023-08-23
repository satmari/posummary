@extends('app')

@section('content')
<div class="container-table">
	<div class="row vertical-center-row">
		<div class="text-center col-md-4 col-md-offset-4">
			<div class="panel panel-default">
				<div class="panel-heading">Edit PRO : <big><b>{{ $pro->pro }}</b></big></div>
				<br>
					{!! Form::model($pro , ['method' => 'POST', 'url' => 'edit_save_pro/'.$pro->id /*, 'class' => 'form-inline'*/]) !!}

					<!-- <div class="panel-body">
						<span>Id:</span>
						{{--  {!! Form::input('number', 'id', null, ['class' => 'form-control']) !!} --}}
					</div> -->
					
					<div class="panel-body">
						<span>PDM file: <span style="color:red;">*</span></span>
						{!! Form::input('string', 'pdm', $pro->pdm, ['class' => 'form-control']) !!}
					</div>
					<div class="panel-body">
						<span>Type: <span style="color:red;">*</span></span>
						{!! Form::input('string', 'flash_type', $pro->flash_type, ['class' => 'form-control']) !!}
					</div>

					<div class="panel-body">
						<span>Del date (format: m/d/y):</span>
						<input type="date" name="delivery_date" id="date" class="form-control" style="width: 100%; display: inline;" value="{{ date('Y-m-d', strtotime($pro->delivery_date))  }}">
					</div>

					<hr>

					<div class="panel-body">
						<span>Expected cost: </span>
						{{-- {!! Form::input('string', 'ec_cost', null, ['class' => 'form-control']) !!} --}}
						{!! Form::select('ec_cost', array(''=>'','YES'=>'YES','NO'=>'NO'), $pro->ec_cost, array('class' => 'form-control')); !!} 
					</div>

					<div class="panel-body">
						<span>Pref Origin: <span style="color:red;">*</span></span>
						{!! Form::input('string', 'pref_origin', $pro->pref_origin, ['class' => 'form-control']) !!}
						{{-- {!! Form::select('pref_origin', array(''=>'','PREF'=>'PREF','NOT PREF'=>'NOT PREF'), $pro->pref_origin, array('class' => 'form-control')); !!} --}}
					</div>

					<div class="panel-body">
						<span>Released: <span style="color:red;">*</span></span>
						{{-- {!! Form::input('string', 'release', null, ['class' => 'form-control']) !!} --}}
						{!! Form::select('release', array(''=>'','YES'=>'YES','NO'=>'NO'), $pro->release, array('class' => 'form-control')); !!} 
					</div>

					<div class="panel-body">
						<span>Sent to Inteos: <span style="color:red;">*</span></span>
						{{-- {!! Form::input('string', 'sent_to_inteos', null, ['class' => 'form-control']) !!} --}}
						{!! Form::select('sent_to_inteos', array(''=>'','YES'=>'YES','NO'=>'NO'), $pro->sent_to_inteos, array('class' => 'form-control')); !!} 
					</div>

					<div class="panel-body">
						<span>TTP shippment: <span style="color:red;">*</span></span>
						{!! Form::select('tpp_shipments', array(''=>'','OPEN'=>'OPEN','COMPLETE'=>'COMPLETE'), $pro->tpp_shipments, array('class' => 'form-control')); !!} 
					</div>

					<div class="panel-body">
						<span>TPP wastage: <span style="color:red;">*</span></span>
						{!! Form::select('tpp_wastage', array(''=>'','OPEN'=>'OPEN','COMPLETE'=>'COMPLETE'), $pro->tpp_wastage, array('class' => 'form-control')); !!} 
					</div>

					<div class="panel-body">
						<span>Skeda: <span style="color:red;">*</span></span>
						{!! Form::input('string', 'skeda', $pro->skeda , ['class' => 'form-control']) !!}
					</div>

					<div class="panel-body">
						<span>Deleted: <span style="color:red;">*</span></span>
						{!! Form::select('delete', array(''=>'','DELETED'=>'DELETED'), $pro->deleted, array('class' => 'form-control')); !!} 
					</div>

					<div class="panel-body">
						{!! Form::submit('Save', ['class' => 'btn btn-success center-block']) !!}
					</div>
					@include('errors.list')
					{!! Form::close() !!}

					
				<hr>
				<div class="panel-body">
					<div class="">
						<a href="{{url('/pro')}}" class="btn btn-default">Back</a>
					</div>
				</div>
					
			</div>
		</div>
	</div>
</div>

@endsection