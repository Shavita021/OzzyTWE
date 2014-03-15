<!-- app/views/nerds/edit.blade.php -->
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
	<script src="/js/bootstrap.js"></script>
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

<h1>Editar {{ $usuario->name }}</h1>

  @if (Session::has('errorRegistro'))
	<div class="alert alert-danger">{{ Session::get('errorRegistro') }}</div>
  @endif

<!-- if there are creation errors, they will show here -->
{{ HTML::ul($errors->all()) }}

{{ Form::model($usuario, array('route' => array('adminMaestro.update', $usuario->email), 'method' => 'PUT')) }}

	<div class="form-group">
		{{ Form::label('name', 'Nombre') }}
		{{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
		{{ Form::label('middleName', 'Segundo Nombre') }}
		{{ Form::text('middleName', Input::old('middleName'), array('class' => 'form-control')) }}
	</div>
	
	<div class="form-group">
		{{ Form::label('plast_name', 'Apellido Paterno') }}
		{{ Form::text('plast_name', Input::old('plast_name'), array('class' => 'form-control')) }}
	</div>
	
	<div class="form-group">
		{{ Form::label('mlast_name', 'Apellido Materno') }}
		{{ Form::text('mlast_name', Input::old('mlast_name'), array('class' => 'form-control')) }}
	</div>
	
	<div class="form-group">
		{{ Form::label('email', 'Email') }}
		{{ Form::email('email', Input::old('email'), array('class' => 'form-control')) }}
	</div>

	<div class="form-group">
	  {{ Form::label('password', 'Contraseña') }}
	  {{ Form::password('password1', array('class' => 'form-control', 'placeholder' => 'Password')) }}
	</div>
	
	<div class="form-group">
	  {{ Form::label('password', 'Confirmar Contraseña') }}
	  {{ Form::password('password2', array('class' => 'form-control', 'placeholder' => 'Password')) }}
	</div>
	
	<div class="form-group">
		{{ Form::label('phone_number', 'Telefono') }}
		{{ Form::text('phone_number', Input::old('phone_number'), array('class' => 'form-control')) }}
	</div>
	
	<div class="form-group">
		{{ Form::label('location', 'Ubicacion') }}
		{{ Form::text('location', Input::old('location'), array('class' => 'form-control')) }}
	</div>
	
	<div class="form-group">
	  {{ Form::label('tipo', 'Tipo de Usuario') }}
	  {{ Form::select('tipo', array('adminSecundario' => 'Administrador Secundario', 'usuarioNormal' => 'Usuario Normal')) }}
	</div>

<button type="submit" class= "btn btn-primary" onclick="if(!confirm('Desea guardar los cambios?')){return false;};" title="Delete this Item">Editar</a>

{{ Form::close() }}

</div>
</body>
</html>
@endif
