<!-- app/views/nerds/inico.blade.php -->

<!DOCTYPE html>
<html>
<head>
	<title>Bienvenida</title>
	<link rel="stylesheet" href="css/bootstrap.css">
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

  @if (Session::has('message'))
	<div class="alert alert-danger">{{ Session::get('message') }}</div>
@endif

<h1>Bienvenido</h1>

</div>
</body>
</html>
