<!-- app/views/nerds/inico.blade.php -->
@if(Session::get('autorizacion') != 'si') 
{{	header("Location: /");
	exit();
	}}
@else
@if(Session::get('tipoSession') == 'adminMaestro' OR Session::get('tipoSession') == 'adminSecundario') 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ozzy WorkFlow Engine</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <link href="/css/sb-admin.css" rel="stylesheet">
  </head>

  <body>

    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">

            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="inicio"><strong>WorkFlow Engine</strong></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li><a href="inicio"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
            <li class="active"><a href="Usuarios"><i class="glyphicon glyphicon-user"></i> Administracion Usuarios</a></li>
            <li><a href="administracionRoles"><i class="glyphicon glyphicon-registration-mark"></i> Administracion Roles</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown messages-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-flag"></i> Notificaciones <span class="badge">7</span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class="dropdown-header">7 Mensajes Nuevos</li>
                <li class="message-preview">
                  <a href="#">
                    <span class="avatar"><img src="http://placehold.it/50x50"></span>
                    <span class="name">John Smith:</span>
                    <span class="message">Hey there, I wanted to ask you something...</span>
                    <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                  </a>
                </li>
                <li class="divider"></li>
                <li><a href="#">View Inbox <span class="badge">7</span></a></li>
              </ul>
            </li>
            <li class="dropdown alerts-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-bell"></i> Alertas <span class="badge">3</span> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#">View All</a></li>
              </ul>
            </li>
            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> {{ Session::get('sesionUsuario') }} <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="logout"><i class="glyphicon glyphicon-off"></i> Salir</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
      
          <div style="margin-left:30px">
          <br>
              <table width="100%">
                 <tbody>
                    <tr>
                    <td>
                         <h3>Usuarios Registrados</h3>
                    </td>
                    <td name="ddiv" align="center">
                         @if (Session::has('message'))
                         <div class="alert alert-info" style="width:300px;">{{ Session::get('message') }}</div>
                         @endif
                    </td>
                    </tr>  
                 </tbody>
              </table> 
                  <br>
                  <div class="container"">
                     <table style="width:80%">
	                 <tbody>
	                    <tr>
	                    <td><a class="btn btn-default btn-lg" href="adminMaestro/create"><span class="glyphicon glyphicon-user"> Crear</span></a>
	                    </td>
	                    <td align="right" style="width:500px" class="form-inline">
	                    {{ Form::open(array('action' => 'systemController@busqueda', 'method' => 'get')) }}
	                    <i style="color:#7080CD">{{ Session::get('errorMail') }}</i>
	              	{{ Form::email('email', Input::old('email'), array('class' => 'form-control', 'style'=>'width:250px', 'placeholder' => 'e-mail')) }}
	               {{ Form::submit('Buscar', array('class' => 'btn btn-default btn-lg')) }}
	            				{{ Form::close() }}
	            		</td>
	                      </tr>
	                </tbody>
	            </table>      
                 </div>
     
              <br>
              <br>
               <table class="table table-striped table-hover">
	            <thead>
		        <tr align="center">
	      	   <td><b>Nombre</b></td>
			   <td><b>Email</b></td>
			   <td><b>Numero</b></td>
			   <td><b>Datos</b></td>
			   <td><b>Editar</b></td>			
			   <td><b>Eliminar</b></td>			   
		       </tr>
	            </thead>
	           <tbody>
@foreach($usuarios as $key => $value)
	           <tr align="center">
			   <td align="left">{{ $value->name }}</td>
			   <td>{{ $value->email }}</td>
			   <td>{{ $value->phone_number }}</td>
			   <td>
				<a class="btn btn-default btn-lg" href="{{ URL::to('adminMaestro/' . $value->email) }}"><span class="glyphicon glyphicon-eye-open"></span></a>
			   </td>
			   <td>

				<a class="btn btn-default btn-lg" href="{{ URL::to('adminMaestro/' . $value->email . '/edit') }}"><span class="glyphicon glyphicon-pencil"></span></a>
			   </td>	
			   <td>		
			          {{ Form::open(array('url' => 'adminMaestro/' . $value->email)) }}
					{{ Form::hidden('_method', 'DELETE') }}
				<button type="submit" class="btn btn-default btn-lg" onclick="if(!confirm('Confirma la eliminacion del usuario')){return false;};"><span class="glyphicon glyphicon-trash"></span></button>
				{{ Form::close() }}
			    </td>
		       </tr>
@endforeach
	          </tbody>
             </table>
            </div>
          </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <script src="/js/jquery-1.10.2.js"></script>
    <script src="/js/bootstrap.js"></script>

    <!-- Page Specific Plugins -->
    <script src="/js/morris/chart-data-morris.js"></script>
    <script src="/js/tablesorter/jquery.tablesorter.js"></script>
    <script src="/js/tablesorter/tables.js"></script>
    <script src="/js/javaScript.js"></script>

  </body>
</html>
@else
{{	header("Location: /");
	exit();
	}}
@endif
@endif
