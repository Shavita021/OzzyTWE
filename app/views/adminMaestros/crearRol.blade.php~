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
            <li><a href="/usuarios"><i class="glyphicon glyphicon-user"></i> Administracion de Usuarios</a></li>
            <li class="active"><a href="/administracionRoles"><i class="glyphicon glyphicon-registration-mark"></i> Administracion de Roles</a></li>
            <li><a href="/procesos"><i class="glyphicon glyphicon-random"></i>  Administracion de Procesos</a></li>           
            <li style="top:30px"><a href="/bandeja"><i class="glyphicon glyphicon-th-list"></i>  Bandeja de Tareas</a></li>  
                        <li style="top:320px"><a href="/creditos" align="center" style="color:#FFFFFF"><strong>Creditos</strong></a></li>                                 
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
                         <h3>Crear Rol</h3>
                    </td>
                    <td name="ddiv" align="center">
                         @if (Session::has('errorCrearRol'))
                         <div class="alert alert-danger"  style="width:300px;">{{ Session::get('errorCrearRol') }}</div>
                         @endif
                    </td>
                    </tr>  
                 </tbody>
              </table> 
                    <br>
                    <table>
	                 <tbody>
	                 <tr>                    
               {{ Form::open(array('action' => 'rolController@store')) }}
                      <td style="padding:15px">
		               {{ Form::label('nombre', 'Nombre del Rol:') }}
		            </td>
		            <td style="padding:15px">
		               {{ Form::text('nombre', Input::old('nombre'), array('class' => 'form-control')) }}
		            <td><i name="ddiv" style="color:#7080CD">{{ $errors->first('nombre') }}</i></td>
		            </td>
		            </tr>
	                 <tr>
	                 <td style="padding:15px">
		               {{ Form::label('descripcion', 'Descripcion:') }}
		            </td>
		            <td style="padding:15px">
		               {{ Form::textarea('descripcion', Input::old('descripcion'), array('class' => 'form-control')) }}
		            <td><i name="ddiv" style="color:#7080CD">{{ $errors->first('descripcion') }}</i></td>
		            </td>
		            </tr>
		            <tr>
		            <td style="padding:15px;">
	               {{ Form::submit('Crear', array('class' => 'btn btn-default btn-lg')) }}
               {{ Form::close() }}
                      </td>
		            </tr>
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
