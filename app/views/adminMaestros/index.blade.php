<!-- app/views/nerds/index.blade.php -->

<!DOCTYPE html>
<html>
<head>
	<title>Maestro</title>
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

<h1>Maestros</h1>

<!-- will be used to show any messages -->

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<td>Nombre</td>
			<td>Email</td>
			<td>Numero</td>
			<td>Acciones</td>
		</tr>
	</thead>
	<tbody>

		<tr>
			<td>{{ Session::get('nombre') }}</td>
			<td>{{ Session::get('email') }}</td>
			<td>{{ Session::get('telefono') }}</td>

			<!-- we will also add show, edit, and delete buttons -->
			<td>

				<!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
				<!-- we will add this later since its a little more complicated than the other two buttons -->
				{{ Form::open(array('url' => 'adminMaestro/' . Session::get('id'), 'class' => 'pull-right')) }}
					{{ Form::hidden('_method', 'DELETE') }}
					{{ Form::submit('Borrar', array('class' => 'btn btn-warning')) }}
				{{ Form::close() }}
				<!-- show the nerd (uses the show method found at GET /nerds/{id} -->
				<a class="btn btn-small btn-success" href="{{ URL::to('adminMaestro/' . Session::get('id') ) }}">Datos de Usuario</a>

				<!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
				<a class="btn btn-small btn-info" href="{{ URL::to('adminMaestro/' . Session::get('id'). '/edit') }}">Editar Usuario</a>

			</td>
		</tr>
	</tbody>
</table>

</div>
</body>
</html>
