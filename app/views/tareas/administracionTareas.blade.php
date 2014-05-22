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
          <a class="navbar-brand" href="/adminMaestro"><strong>ITESM WorkFlow Engine</strong></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li><a href="/adminMaestro"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
            <li><a href="/usuarios"><i class="glyphicon glyphicon-user"></i> Administración de Usuarios</a></li>
            <li><a href="/administracionRoles"><i class="glyphicon glyphicon-registration-mark"></i> Administración de Roles</a></li>
            <li class="active"><a href="/procesos"><i class="glyphicon glyphicon-random"></i>  Administración de Procesos</a></li>          
            <li style="top:50px"><a href="/bandejaProcesos"><i class="glyphicon glyphicon-list-alt"></i>  Bandeja de Procesos</a></li>               
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
                         @if (Session::has('errorEliminar'))
                         <div class="alert alert-danger" style="width:300px;">{{ Session::get('message') }}</div>
                         @elseif (Session::has('message'))
                         <div class="alert alert-info" style="width:300px;">{{ Session::get('message') }}</div>
                         @endif
                    </td>
                    </tr>  
                 </tbody>
              </table> 
                  <br>
               <h4 align="center">Tareas</h4>
              <br>
               <table class="table table-hover">
	            <thead>
		        <tr align="center">
			   <td><b>Paso</b></td>		        
			   <td><b>Descripción</b></td>
			   <td><b>Ver</b></td>
@if($datos[1]->estado != 'ejecutando')			   	
			   <td><b>Editar</b></td>		
			   <td><b>Eliminar</b></td>
@endif			   			   
		       </tr>
	            </thead>
	           <tbody>
	           <?php $cont=1; ?>
@foreach($datos[0] as $key => $value)
	           <tr class="{{ $datos[2][$cont-1] }}" align="center">
			   <td align="left">Paso <? echo $cont; ?></td>	           
			   <td>{{ $value->descripcion }}</td>
			   <td>
			   @if($datos[2][$cont-1] == "info")
				<a class="btn btn-default btn-lg" href="{{ URL::to('procesos/tareas/paralela/' . $value->id) }}"><span class="glyphicon glyphicon-eye-open"></span></a>			   
			   @else
				<a class="btn btn-default btn-lg" href="{{ URL::to('procesos/tareas/' . $value->id) }}"><span class="glyphicon glyphicon-eye-open"></span></a>
			   @endif
			   </td>	
@if($datos[1]->estado != 'ejecutando')			   
			   <td>
			   @if($datos[2][$cont-1] == "info")
			   <a class="btn btn-default btn-lg" href="{{ URL::to('procesos/tareas/paralela/' . $value->id . '/edit') }}"><span class="glyphicon glyphicon-pencil"></span></a>			   
			   @else
			   <a class="btn btn-default btn-lg" href="{{ URL::to('procesos/tareas/' . $value->id . '/edit') }}"><span class="glyphicon glyphicon-pencil"></span></a>
			   @endif
			   </td>
			   <td>	
			   @if($datos[2][$cont-1] == "info")
			    {{ Form::open(array('url' => 'procesos/tareas/paralela/' . $value->id)) }}
			    {{ Form::hidden('_method', 'DELETE') }}
				<button type="submit" class="btn btn-default btn-lg" onclick="if(!confirm('Confirma la eliminacion del usuario')){return false;};"><span class="glyphicon glyphicon-trash"></span></button>
			    {{ Form::close() }}			   
			   @else			   	
			    {{ Form::open(array('url' => 'procesos/tareas/' . $value->id)) }}
			    {{ Form::hidden('_method', 'DELETE') }}
				<button type="submit" class="btn btn-default btn-lg" onclick="if(!confirm('Confirma la eliminación de la tarea?')){return false;};"><span class="glyphicon glyphicon-trash"></span></button>
			    {{ Form::close() }}
			   @endif
			    </td>
@endif			    
		       </tr>
<?php $cont++; ?>		       
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
