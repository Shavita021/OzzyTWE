<!-- app/views/nerds/show.blade.php -->

<!DOCTYPE html>
<html>
<head>
	<title>Secundario</title>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

<nav class="navbar navbar-inverse">
	<div class="navbar-header">
		<a class="navbar-brand" href="{{ URL::to('adminSecundario') }}">Nerd Alert</a>
	</div>
	<ul class="nav navbar-nav">
		<li><a href="{{ URL::to('adminSecundario') }}">View All Nerds</a></li>
		<li><a href="{{ URL::to('adminSecundario/create') }}">Create a Nerd</a>
	</ul>
</nav>

<h1>Showing {{ $adminSecundario->name }}</h1>

	<div class="jumbotron text-center">
		<h2>{{ $adminSecundario->name }}</h2>
		<p>
			<strong>Email:</strong> {{ $adminSecundario->email }}<br>
			<strong>Telefono:</strong> {{ $adminSecundario->phone_number }}
		</p>
	</div>

</div>
</body>
</html>
