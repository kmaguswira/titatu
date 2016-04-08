<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>TITATU @yield('title')</title>

	<meta name="description" content="Tic Tac Toe Online Game !!">
	<meta name="author" content="kmaguswira">

	<link href="{!! asset('assets/css/bootstrap.min.css'); !!}" rel="stylesheet">
	<link href="{!! asset('assets/css/style.css'); !!}" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Aldrich' rel='stylesheet' type='text/css'>
	<link href='https://fonts.googleapis.com/css?family=Dosis:300' rel='stylesheet' type='text/css'>
	@yield('scriptHead')

</head>
<body class="background">
	<nav class="navbar navbar-default navbar-fixed-bottom navbar-inverse" role="navigation" style="font-family: 'Helvetica', sans-serif; font-size:14px;">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
			</button> <a class="navbar-brand" href="{!! url('/'); !!}"><img alt="Brand" src="{!! asset('assets/img/logo.png'); !!}" height="25" width="25"></a>
		</div>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			@yield('navigation')
			<ul class="nav navbar-nav navbar-right">
				<li>
					
				</li>
			</ul>
		</div>

	</nav>
	<div class="container-fluid">
		<div class="col-md-2">
		</div>
		<div class="col-md-8">
			@yield('content')
			<div style="margin-bottom:70px;">
			</div>
		</div>
		<div class="col-md-2">
		</div>
	</div>

	<script src="{!! asset('assets/js/jquery.min.js'); !!}"></script>
	<script src="{!! asset('assets/js/bootstrap.min.js'); !!}"></script>
	<script src="{!! asset('assets/js/scripts.js'); !!}"></script>
	@yield('script')
</body>
</html>