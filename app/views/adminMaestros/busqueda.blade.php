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

    <title>ITESM WorkFlow Engine</title>

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
          <a class="navbar-brand" href="/adminMaestro"><strong>ITESM WorkFlow Engine</strong></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li><a href="/adminMaestro"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
            <li class="active"><a href="usuarios"><i class="glyphicon glyphicon-user"></i> Administracion de Usuarios</a></li>
            <li><a href="administracionRoles"><i class="glyphicon glyphicon-registration-mark"></i> Administracion de Roles</a></li>
            <li><a href="/procesos"><i class="glyphicon glyphicon-random"></i>  Administracion de Procesos</a></li>          
            <li style="top:30px"><a href="/bandeja"><i class="glyphicon glyphicon-th-list"></i>  Bandeja de Tareas</a></li>  
                        <li style="top:320px"><a href="/creditos" align="center" style="color:#FFFFFF"><strong>Creditos</strong></a></li>                                  
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
@if(Session::get('tipoSession') == 'adminMaestro')          
                <li><a href="/edit"><i class="glyphicon glyphicon-pencil"></i> Editar</a></li>
@endif                
                <li><a href="logout"><i class="glyphicon glyphicon-off"></i> Salir</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </nav>
      
      
      
               <div id="page-wrapper">
                    <h3>Busqueda</h3>
                    <br><br>
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
@if(Session::get('id'))	           
	           <tr align="center">
			   <td align="left">{{ Session::get('nombre') }}</td>
			   <td>{{ Session::get('email') }}</td>
			   <td>{{ Session::get('telefono') }}</td>
			   <td>
                         {{ Form::open(array('url' => 'adminMaestro/' .  Session::get('email'))) }}
				<a class="btn btn-default btn-lg" href="{{ URL::to('adminMaestro/' . Session::get('email')) }}"><span class="glyphicon glyphicon-eye-open"></span></a>
				    {{ Form::close() }}
			   </td>
			   <td>

				<a class="btn btn-default btn-lg" href="{{ URL::to('adminMaestro/' . Session::get('email'). '/edit') }}"><span class="glyphicon glyphicon-pencil"></span></a>
			   </td>	
			   <td>		
					{{ Form::hidden('_method', 'DELETE') }}
				<a type="button" class="btn btn-default btn-lg" onclick="if(!confirm('Confirma la eliminacion del usuario')){return false;};"><span class="glyphicon glyphicon-trash"></span></a>
				{{ Form::close() }}
			    </td>
		         </tr>
@endif		         
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
