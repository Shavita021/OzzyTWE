<!-- app/views/nerds/inico.blade.php -->

<!DOCTYPE html>
<html>
<head>
	<title>Busqueda de Usuario</title>
	<link rel="stylesheet" href="css/bootstrap.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<a class="navbar-brand" href="{{ URL::to('inicio')  }}">INICIO</a>
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


        <h2 class="form-signin-heading">Crear un nuevo usuario</h2>
<a class="btn btn-small btn-info" href="{{ URL::to('crearUsuario') }}">Crear Usuario</a>

    {{ Form::open(array('action' => 'systemController@busqueda', 'method' => 'get')) }}
        <h2 class="form-signin-heading">Busqueda</h2>
	    	{{ Form::email('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'Email')) }}
	    	
	  {{ Form::submit('Buscar', array('class' => 'btn btn-primary')) }}
	  
  @if (Session::has('message'))
	<div class="alert alert-danger">{{ Session::get('message') }}</div>
@endif

{{ HTML::ul($errors->all()) }}
</div>
</body>
</html>
