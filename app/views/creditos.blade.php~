<!-- app/views/nerds/inico.blade.php -->
@if(Session::get('autorizacion') != 'si') 
{{	header("Location: /");
	exit();
	}}
@else
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
            <li><a href="usuarios"><i class="glyphicon glyphicon-user"></i> Administracion de Usuarios</a></li>
            <li><a href="administracionRoles"><i class="glyphicon glyphicon-registration-mark"></i> Administracion de Roles</a></li>
            <li><a href="/procesos"><i class="glyphicon glyphicon-random"></i>  Administracion de Procesos</a></li>
            <li style="top:30px"><a href="/bandeja"><i class="glyphicon glyphicon-th-list"></i>  Bandeja de Tareas</a></li>   
                        <li class="active" style="top:320px"><a href="/creditos" align="center" style="color:#FFFFFF"><strong>Creditos</strong></a></li>  
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
      
          <div style="margin-left:30px">
              <br>
<h1 align="center"><strong>ITESM WorkFlow Engine</strong></h1>
<br>
<div style="padding:50px">
<h4><strong>ITESM Workflow Engine</strong> consiste en un motor que agilize las diferentes tareas, así como la administración de los procesos para el cual sea configurado. La decision de desarrollar esta aplicación viene de la necesidad de optimizar el tiempo, dinero, una mejor organización de los diferentes procesos que se llevan a cabo.</h4>
<br>

<h2><strong>Autores:</h2></strong>
        <br>
   <h4><strong>Representantes ITESM</strong></h4>
   <div style="padding:30px">
	<h4>Ing. Martha Sordia Salinas -<span style="color:#1A26CF;"> msordia@itesm.mx</span></h4>
	<h4>Dr. Juan Arturo Nolazco Flores -<span style="color:#1A26CF;"> jnolazco@itesm.mx</span></h4>
	<h4>Ing. Maria Isabel Cabrera Cancinos -<span style="color:#1A26CF;"> marisa.cabrera@tecvirtual.mx</span></h4>
   </div>
        <br>
   <h4><strong>Estudiantes ITESM</strong></h4>
   <div style="padding:30px">
	<h4>Angel Torquemada Vazquez -<span style="color:#1A26CF;"> torquemadage@gmail.com</span></h4>
	<h4>Salvador Juarez Gutierrez -<span style="color:#1A26CF;"> kimster021@gmail.com</span></h4>
	<h4>Jaime Eduardo Neri Campos -<span style="color:#1A26CF;"> ghx1337@gmail.com</span></h4>
   </div>   
</div>
<h4><strong>Copyright (C) 2014 - ITESM</strong></h4>
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
@endif
