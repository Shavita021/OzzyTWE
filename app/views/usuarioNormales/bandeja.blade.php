<!-- app/views/nerds/inico.blade.php -->
@if(Session::get('autorizacion') != 'si') 
{{	header("Location: /");
	exit();
	}}
@else
@if(Session::get('tipoSession') == 'usuarioNormal') 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ozzy WorkFlow Engine</title>

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
          <a class="navbar-brand" href="/usuarioNormal"><strong>ITESM WorkFlow Engine</strong></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li><a href="/usuarioNormal"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
            <li class="active" style="top:30px"><a href="/bandeja"><i class="glyphicon glyphicon-th-list"></i>  Bandeja de Tareas</a></li>
                        <li style="top:470px"><a href="/creditos" align="center" style="color:#FFFFFF"><strong>Creditos</strong></a></li>                               
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">

            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> {{ Session::get('sesionUsuario') }} <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="/logout"><i class="glyphicon glyphicon-off"></i> Salir</a></li>
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
                         <h2>Bandeja de Tareas</h2>
                    </td>
                    <td align="center">
                          @if (Session::has('message'))
                         <div class="alert alert-info"  style="width:300px;">{{ Session::get('message') }}</div>
                         @endif
                    </td>
                    </tr>  
                 </tbody>
              </table> 
              
              <br>
              <br>
<!----------------------------------------Tareas Normales ------------------------------------>
               <h4>Tareas Normales</h4>
               <br>
               <table class="table table-hover">
	            <thead>
		        <tr align="center">
	      	   <td><b>Nombre Proceso</b></td>
			   <td><b>Fecha Limite</b></td>
<?php $cont=0; ?>
		       </tr>
	            </thead>
	           <tbody>
@foreach($datos[0] as $dato)
	           <tr class="{{ $datos[2][$cont] }}" align="center">
			   <td align="left">{{ $dato->nombre }}</td>
			   <td>{{ $dato->fechaTermino }}</td>
			   <td>
			   <a class="btn btn-default btn-lg" href="{{ URL::to('bandeja/responder/'.$dato->id) }}"><span> Responder</span></a>
			   </td>	
		       </tr>
<?php $cont++; ?>		       
@endforeach
	          </tbody>
             </table>
              <br>
              <br>             
<!----------------------------------------Tareas Paralelas ------------------------------------>
               <h4>Tareas Paralelas</h4>
               <br>
               <table class="table table-hover">
	            <thead>
		        <tr align="center">
	      	   <td><b>Nombre Proceso</b></td>
			   <td><b>Fecha Limite</b></td>
<?php $cont=0; ?>
		       </tr>
	            </thead>
	           <tbody>
@foreach($datos[1] as $dato)
	           <tr class="{{ $datos[3][$cont] }} " align="center">
			   <td align="left">{{ $dato->nombre }}</td>
			   <td>{{ $dato->fechaTermino }}</td>
			   <td>
			   <a class="btn btn-default btn-lg" href="{{ URL::to('bandeja/responder/'.$dato->id) }}"><span> Responder</span></a>
			   </td>	
		       </tr>
<?php $cont++; ?>		       
@endforeach
	          </tbody>
             </table>
             <br>             
             <button style="width:30px;height:30px" class="btn btn-danger" disabled="disabled"></button> Tarea atrasada.   
             <br><br>  
             <button style="width:30px;height:30px" class="btn btn-warning" disabled="disabled"></button> Tarea proxima a vencerse.                              
             <br><br>               
             <button style="width:30px;height:30px" class="btn btn-success" disabled="disabled"></button> Tarea a tiempo.                        
          </div>
          
    </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <script src="/js/jquery-1.10.2.js"></script>
    <script src="/js/bootstrap.js"></script>

    <!-- Page Specific Plugins -->
    <script src="/js/morris/chart-data-morris.js"></script>
    <script src="/js/tablesorter/jquery.tablesorter.js"></script>
    <script src="/js/tablesorter/tables.js"></script>

  </body>
</html>
@else
{{	header("Location: /");
	exit();
	}}
@endif
@endif
