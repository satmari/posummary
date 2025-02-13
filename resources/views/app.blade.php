<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PO Summary</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/css.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
	<link href="{{ asset('/css/choosen.css') }}" rel="stylesheet">

	<!-- <link href="{{ asset('/css/bootstrap.min.css') }}" rel='stylesheet' type='text/css'> -->
	<link href="{{ asset('/css/jquery-ui.min.css') }}" rel='stylesheet' type='text/css'>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="{{ url('/') }}">PO Summary</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/pro') }}">PRO table</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/plo') }}">PLO table</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/table') }}">Checking table</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/import') }}">Import</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/import_sap') }}">Import SAP</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/daily_plan') }}">Daily plan</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/future_orders') }}">Future orders</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/margin_analysis') }}">Board</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/plm_costing') }}">PLM costing</a></li>
				</ul>
				<!-- <ul class="nav navbar-nav">
					<li><a href="{{ url('/bom_cons') }}">BOM cons</a></li>
				</ul>
				<ul class="nav navbar-nav">
					<li><a href="{{ url('/bom_cons_ratio') }}">BOM cons ratio</a></li>
				</ul> -->
				

				<ul class="nav navbar-nav navbar-right">
					@if (Auth::guest())
						<li><a href="{{ url('/auth/login') }}">Login</a></li>
						{{--<li><a href="{{ url('/auth/register') }}">Register</a></li>--}}
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="{{ url('/auth/logout') }}">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->
	<script src="{{ asset('/js/jquery.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript" ></script>

    <script src="{{ asset('/js/bootstrap-table.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('/js/jquery-ui.min.js') }}" type="text/javascript" ></script>

    <script src="{{ asset('/js/tableExport.js') }}" type="text/javascript" ></script>

	<script src="{{ asset('/js/FileSaver.min.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('/js/bootstrap-table-export.js') }}" type="text/javascript" ></script>
	<script src="{{ asset('/js/choosen.js') }}" type="text/javascript" ></script>

<script type="text/javascript">
	$(function() {
    	
	$('#po').autocomplete({
		minLength: 3,
		autoFocus: true,
		source: '{{ URL('getpodata')}}'
	});
	$('#filter').keyup(function () {

        var rex = new RegExp($(this).val(), 'i');
        $('.searchable tr').hide();
        $('.searchable tr').filter(function () {
            return rex.test($(this).text());
        }).show();
	});

	$(".chosen").chosen();

	$('#sort').bootstrapTable({
    
	});

	$('.table tr').each(function(){
  		
  		//$("td:contains('pending')").addClass('pending');
  		//$("td:contains('confirmed')").addClass('confirmed');
  		//$("td:contains('back')").addClass('back');
  		//$("td:contains('error')").addClass('error');
  		//$("td:contains('TEZENIS')").addClass('tezenis');

  		// $("td:contains('TEZENIS')").function() {
  		// 	$(this).index().addClass('tezenis');
  		// }
	});

	$("#checkAll").click(function () {
    	$(".check").prop('checked', $(this).prop('checked'));
	});
	});
</script>

<script type="text/javascript">
   $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
</script>

</body>
</html>
