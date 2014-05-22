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

    <title>ITESM WorkFlow Engine</title>

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
          <a class="navbar-brand" href="/usuarioNormal"><strong>ITESM WorkFlow Engine</strong></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li><a href="/usuarioNormal"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>    
            <li class="active" style="top:50px"><a href="/bandejaProcesos"><i class="glyphicon glyphicon-list-alt"></i>  Bandeja de Procesos</a></li>               
            <li style="top:50px"><a href="/bandeja"><i class="glyphicon glyphicon-th-list"></i>  Bandeja de Tareas</a></li>   
                        <li style="top:270px"><a href="/creditos" align="center" style="color:#FFFFFF"><strong>Créditos</strong></a></li>                     
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">

            <li class="dropdown user-dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i> {{ Session::get('sesionUsuario') }} <b class="caret"></b></a>
              <ul class="dropdown-menu">
@if(Session::get('tipoSession') == 'adminMaestro')          
                <li><a href="/edit"><i class="glyphicon glyphicon-pencil"></i> Editar</a></li>
@endif                
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
                         <h3>Proceso <strong>{{ $datos[1]->nombre }}</strong></h3>
                    </td>
                    <td name="ddiv" align="center">
                         @if (Session::has('message'))
                         <div class="alert alert-info" style="width:300px;">{{ Session::get('message') }}</div>
                         @endif
                    </td>
                    </tr>  
                 </tbody>
              </table> 
               <h3 align="center">Tareas</h3>
              <br>
               <table class="table table-hover">
	            <thead>
		        <tr align="center">
			   <td><b>Tarea</b></td>		        
			   <td><b>Respuestas</b></td>		   			   
		       </tr>
	            </thead>
	           <tbody>
<?php $cont=0; ?>
@foreach($datos[0] as $tarea)
	           <tr class="{{ $datos[2][$cont] }}" align="center">
			   <td>{{ $tarea->descripcion }}<br>
                    <strong>Archivo adjunto:</strong>
                    <a href="{{ $tarea->file }}">{{ $tarea->nameFile }}</a>			   
			   </td>
			   <td>
                    <table class="table table-hover">	
@foreach($datos[3][$cont] as $respuesta)                      
                         <tr align="center">
			             <td>
                              <p>{{ $respuesta->comentarios }}</p>
                              <strong>Archivo adjunto:</strong>                         
		                    <a href="{{ $respuesta->file }}">{{ $respuesta->nameFile }}</a>
			             </td>	   
                         </tr>
@endforeach                         
                    </table>	   
			   </td>				    
		      </tr>
<? $cont++; ?>		       
@endforeach
	          </tbody>
             </table>
             
             <button style="width:30px;height:30px" class="btn btn-info" disabled="disabled"></button> Tareas Paralelas
             <br><br>
             <i>* Las tareas están en orden descendiente </i>
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
