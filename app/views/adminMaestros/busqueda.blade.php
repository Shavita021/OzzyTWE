<!-- app/views/nerds/index.blade.php -->
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
		<a class="navbar-brand" href="{{ URL::to('inicio')  }}">INICIO</a>
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

<h1>Usuario</h1>

<!-- will be used to show any messages -->

<table class="table table-striped table-hover">
	<thead>
		<tr align="center">
			<td><b>Nombre</b></td>
			<td><b>Email</b></td>
			<td><b>Numero</b></td>
			<td><b>Acciones</b></td>
		</tr>
	</thead>
	<tbody>

		<tr align="center">
			<td align="left">{{ Session::get('nombre') }}</td>
			<td>{{ Session::get('email') }}</td>
			<td>{{ Session::get('telefono') }}</td>

			<!-- we will also add show, edit, and delete buttons -->
			<td>
				{{ Form::open(array('url' => 'adminMaestro/' . Session::get('email'))) }}
				<!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
				<!-- we will add this later since its a little more complicated than the other two buttons -->
				<!-- show the nerd (uses the show method found at GET /nerds/{id} -->
				<a class="btn btn-small btn-success" href="{{ URL::to('adminMaestro/' . Session::get('email') ) }}">Datos de Usuario</a>

				<!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
				<a class="btn btn-small btn-info" href="{{ URL::to('adminMaestro/' . Session::get('email'). '/edit') }}">Editar Usuario</a>
				
				     {{ Form::hidden('_method', 'DELETE') }}
				<button type="submit" class= "btn btn-warning" onclick="if(!confirm('Confirma la eliminacion del usuario')){return false;};" title="Delete this Item">Borrar</a>
				{{ Form::close() }}

			</td>
		</tr>
	</tbody>
</table>

</div>
</body>
</html>
@endif
