<!-- app/views/nerds/create.blade.php -->

<!DOCTYPE html>
<html>
<head>
	<title>Crear Usuario</title>
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

<h1>Crear Usuario</h1>

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::open(array('action' => 'adminMaestroController@store')) }}

	<div class="form-group">
		{{ Form::label('name', 'Nombre') }}
		{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('email', 'Email') }}
		{{ Form::email('email', Input::old('email'), array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('phone_number', 'Telefono') }}
		{{ Form::text('phone_number', Input::old('phone_number'), array('class' => 'form-control')) }}
	</div>
	
	<div class="form-group">
	  {{ Form::label('tipo', 'Tipo de Usuario') }}
	  {{ Form::select('tipo', array('adminSecundario' => 'Administrador Secundario', 'usuarioNormal' => 'Usuario Normal')) }}
	</div>

	{{ Form::submit('Crear', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

</div>
</body>
</html>
