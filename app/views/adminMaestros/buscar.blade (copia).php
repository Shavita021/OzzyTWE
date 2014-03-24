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
</div>

    <div class="container"">
    <table style="width:100%">
	     <tbody>
	          <tr>
	               <td><a class="btn btn-small btn-info" style="margin-left:50px" href="{{ URL::to('crearUsuario') }}">Nuevo Usuario</a>
	               </td>
	               <td align="right" style="width:500px" class="form-inline">{{ Form::open(array('action' => 'systemController@busqueda', 'method' => 'get')) }}
	         	{{ Form::email('email', Input::old('email'), array('class' => 'form-control', 'style'=>'width:250px', 'placeholder' => 'Email')) }}
	          {{ Form::submit('Buscar', array('class' => 'btn btn-primary', 'style'=>'width:100px')) }}
	       				{{ Form::close() }}
	       		</td>
	          </tr>
	     </tbody>
	</table>      
            
     </div>


<div class="container">

<h1>Usuarios Registrados</h1>

<!-- will be used to show any messages -->
@if (Session::has('message'))
	<div class="alert alert-info">{{ Session::get('message') }}</div>
@endif

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
	@foreach($usuarios as $key => $value)
		<tr align="center">
			<td align="left">{{ $value->name }}</td>
			<td>{{ $value->email }}</td>
			<td>{{ $value->phone_number }}</td>

			<!-- we will also add show, edit, and delete buttons -->
			<td>
                         {{ Form::open(array('url' => 'adminMaestro/' . $value->email)) }}
				<!-- delete the nerd (uses the destroy method DESTROY /nerds/{id} -->
				<!-- we will add this later since its a little more complicated than the other two buttons -->
				<!-- show the nerd (uses the show method found at GET /nerds/{id} -->
				<a class="btn btn-small btn-success" href="{{ URL::to('adminMaestro/' . $value->email) }}">Datos de Usuario</a>
				<!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
				<a class="btn btn-small btn-info" href="{{ URL::to('adminMaestro/' . $value->email . '/edit') }}">Editar Usuario</a>
								
					{{ Form::hidden('_method', 'DELETE') }}
				<button type="submit" class= "btn btn-warning" onclick="if(!confirm('Confirma la eliminacion del usuario')){return false;};" title="Delete this Item">Borrar</a>
				{{ Form::close() }}
				

			</td>
		</tr>
	@endforeach
	</tbody>
</table>

</div>

</body>
</html>
@endif
