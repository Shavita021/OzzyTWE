<!-- app/views/nerds/create.blade.php -->

<!DOCTYPE html>
<html>
<head>
	<title>Crear Usuario Normal</title>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<a class="navbar-brand" href="{{ URL::to('usuarioNormal') }}">Nerd Alert</a>
	</div>
	<ul class="nav navbar-nav">
		<li><a href="{{ URL::to('usuarioNormal') }}">View All Nerds</a></li>
		<li><a href="{{ URL::to('usuarioNormal/create') }}">Create a Nerd</a>
	</ul>
</nav>

<h1>Crear Usuario Normal</h1>

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::open(array('action' => 'usuarioNormalController@store')) }}

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

	{{ Form::submit('Crear', array('class' => 'btn btn-primary')) }}

{{ Form::close() }}

</div>
</body>
</html>
