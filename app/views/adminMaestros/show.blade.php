<!-- app/views/nerds/show.blade.php -->
@if((Session::get('autorizacion')) != 'si') 
{{	header("Location: /");
	exit();
	}}
@else
<!DOCTYPE html>
<html>
<head>
	<title>Maestro</title>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<a class="navbar-brand" href="{{ URL::to('inicio') }}">INICIO</a>
	</div>
		<ul class="nav navbar-nav">
		<li><a href="{{ URL::to('buscar') }}">Administrar usuarios</a></li>
	</ul>
	<div align="right">
	  <a class="btn btn-default btn-lg" href="{{ URL::action('systemController@logout') }}" >
	  <span class="glyphicon glyphicon-log-out"></span>
	  </a>
	</div>
</nav>


	
	
<h1>Showing {{ $adminMaestro->name }}</h1>

	<div class="jumbotron text-center">
		<h2>{{ $adminMaestro->name }}</h2>
		<p>
			<strong>Email:</strong> {{ $adminMaestro->email }}<br>
			<strong>Telefono:</strong> {{ $adminMaestro->phone_number }}
		</p>
	</div>

</div>
</body>
</html>
@endif
