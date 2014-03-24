<!-- app/views/nerds/show.blade.php -->
@if((Session::get('autorizacion')) != 'si') 
{{	header("Location: /");
	exit();
	}}
@else
<!DOCTYPE html>
<html>
<head>
  <title>Tec WorkFlow Engine</title>
	<link rel="stylesheet" href="/css/bootstrap.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<a class="navbar-brand" href="{{ URL::to('inicio') }}">INICIO</a>
	</div>
		<ul class="nav navbar-nav">
		<li><a href="{{ URL::to('mostrarUsuarios') }}">Administrar usuarios</a></li>
	</ul>
	<div align="right">
	  <a class="btn btn-default btn-lg" href="{{ URL::action('systemController@logout') }}" >
	  <span class="glyphicon glyphicon-log-out"></span>
	  </a>
	</div>
</nav>


	
	
<h1>Showing {{ $usuario->name }}</h1>

	<div class="jumbotron text-center">
		<h2>{{ $usuario->name." ", $usuario->plast_name." ", $usuario->mlast_name }}</h2>
		<p>
			<strong>Tipo de Usuario:</strong> {{ Session::get('tipo')}}<br>
			<strong>Email:</strong> {{ $usuario->email }}<br>
			<strong>Telefono:</strong> {{ $usuario->phone_number }}<br>
		  <strong>Ubicacion:</strong> {{ $usuario->location }}
		</p>
	</div>

</div>
</body>
</html>
@endif
