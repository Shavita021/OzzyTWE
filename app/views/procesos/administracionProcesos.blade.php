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
            <li><a href="usuarios"><i class="glyphicon glyphicon-user"></i> Administración de Usuarios</a></li>
            <li><a href="administracionRoles"><i class="glyphicon glyphicon-registration-mark"></i> Administración de Roles</a></li>
            <li class="active"><a href="procesos"><i class="glyphicon glyphicon-random"></i>  Administración de Procesos</a></li>          
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
                    <h2><strong>Procesos</strong></h2>
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
                  <div class="container"">
                     <table style="width:80%">
	                 <tbody>
	                    <tr>
	                    <td><a class="btn btn-default btn-lg" href="procesos/create"><span class="glyphicon glyphicon-random"> Crear Proceso</span></a>
	                    </td>
	                      </tr>
	                </tbody>
	            </table>      
                 </div>
<!--------------------------------------------------------------------------------------------->     
              <br>
              <br>
              <h3>Procesos Ejecutándose</h3>
               <table class="table table-striped table-hover">
	            <thead>
		        <tr align="center">
	      	   <td><b>Folio</b></td>		        
	      	   <td><b>Nombre</b></td>
			   <td><b>Descripción</b></td>
			   <td><b>Usuario</b></td>			   
			   <td><b>Abrir</b></td>	
			   <td><b>Parar y Eliminar</b></td>			   
		       </tr>
	            </thead>
	           <tbody>
@foreach($procesos[0] as $key => $value)
	           <tr class="warning" align="center">
			   <td align="left">{{ $value->id }}</td>	           
			   <td>{{ $value->nombre }}</td>
			   <td>{{ $value->descripcion }}</td>
			   <td>{{ $value->emailCreador }}</td>			   
			   <td>
				<a class="btn btn-default btn-lg" href="{{ URL::to('procesos/instancia/admin/' . $value->id) }}"><span class="glyphicon glyphicon-folder-open"></span></a>			
			   </td>	
			   <td>		
{{ Form::open(array('action' => array('procesoController@eliminarInstancia',$value->id), 'method' => 'delete')) }}
				<button type="submit" class="btn btn-default btn-lg" onclick="if(!confirm('Confirma la eliminación del proceso?')){return false;};"><span class="glyphicon glyphicon-remove"></span></button>
			    {{ Form::close() }}
			    </td>
		       </tr>
@endforeach
	          </tbody>
             </table>                          
<!--------------------------------------------------------------------------------------------->
                    <br>
                    <br>
                    <h3>Procesos Terminados</h3>
                <table class="table table-striped table-hover">
	            <thead>
		        <tr align="center">
	      	   <td><b>Folio</b></td>		        
	      	   <td><b>Nombre</b></td>
			   <td><b>Descripción</b></td>
			   <td><b>Usuario</b></td>			   
			   <td><b>Abrir</b></td>
			   <td><b>Eliminar</b></td>			   			   			   
		       </tr>
	            </thead>
	           <tbody>
@foreach($procesos[2] as $key => $value)
	           <tr align="center">
			   <td>{{ $value->id }}</td>	           
			   <td>{{ $value->nombre }}</td>
			   <td>{{ $value->descripcion }}</td>
			   <td>{{ $value->emailCreador }}</td>			   
			   <td>
				<a class="btn btn-default btn-lg" href="{{ URL::to('procesos/instancia/admin/' . $value->id) }}"><span class="glyphicon glyphicon-folder-open"></span></a>	
			   </td>	
			   <td>		
{{ Form::open(array('action' => array('procesoController@eliminarInstancia',$value->id), 'method' => 'delete')) }}
				<button type="submit" class="btn btn-default btn-lg" onclick="if(!confirm('Confirma la eliminación del proceso?')){return false;};"><span class="glyphicon glyphicon-trash"></span></button>
			    {{ Form::close() }}
			    </td>			   
		       </tr>
@endforeach
	          </tbody>
             </table>     
<!---------------------------------Procesos Declinados--------------------------------------->
                    <br>
                    <br>
                    <h3>Procesos Declinados</h3>
                <table class="table table-striped table-hover">
	            <thead>
		        <tr align="center">
	      	   <td><b>Folio</b></td>		        
	      	   <td><b>Nombre</b></td>
			   <td><b>Descripción</b></td>
			   <td><b>Usuario</b></td>			   
			   <td><b>Abrir</b></td>
			   <td><b>Eliminar</b></td>			   			   			   
		       </tr>
	            </thead>
	           <tbody>
@foreach($procesos[3] as $key => $value)
	           <tr align="center">
			   <td>{{ $value->id }}</td>	           
			   <td>{{ $value->nombre }}</td>
			   <td>{{ $value->descripcion }}</td>
			   <td>{{ $value->emailCreador }}</td>			   
			   <td>
				<a class="btn btn-default btn-lg" href="{{ URL::to('procesos/instancia/admin/' . $value->id) }}"><span class="glyphicon glyphicon-folder-open"></span></a>	
			   </td>	
			   <td>		
{{ Form::open(array('action' => array('procesoController@eliminarInstancia',$value->id), 'method' => 'delete')) }}
				<button type="submit" class="btn btn-default btn-lg" onclick="if(!confirm('Confirma la eliminación del proceso?')){return false;};"><span class="glyphicon glyphicon-trash"></span></button>
			    {{ Form::close() }}
			    </td>			   
		       </tr>
@endforeach
	          </tbody>
             </table>                 
<!--------------------------------------------------------------------------------------------->
                    <br>
                    <br>
                    <h3>Procesos Creados</h3>
                <table class="table table-striped table-hover">
	            <thead>
		        <tr align="center">
	      	   <td><b>Nombre</b></td>
			   <td><b>Descripción</b></td>
			   <td><b>Abrir</b></td>	
			   <td><b>Eliminar</b></td>			   
		       </tr>
	            </thead>
	           <tbody>
@foreach($procesos[1] as $key => $value)
	           <tr align="center">
			   <td>{{ $value->nombre }}</td>
			   <td>{{ $value->descripcion }}</td>
			   <td>
				<a class="btn btn-default btn-lg" href="{{ URL::to('procesos/' . $value->id) }}"><span class="glyphicon glyphicon-folder-open"></span></a>
			   </td>	
			   <td>		
			    {{ Form::open(array('url' => 'procesos/' . $value->id)) }}
			    {{ Form::hidden('_method', 'DELETE') }}
				<button type="submit" class="btn btn-default btn-lg" onclick="if(!confirm('Confirma la eliminación del proceso?')){return false;};"><span class="glyphicon glyphicon-trash"></span></button>
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
