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
            <li class="active"><a href="/usuarios"><i class="glyphicon glyphicon-user"></i> Administración de Usuarios</a></li>
            <li><a href="/administracionRoles"><i class="glyphicon glyphicon-registration-mark"></i> Administración de Roles</a></li>
            <li><a href="/procesos"><i class="glyphicon glyphicon-random"></i>  Administración de Procesos</a></li>                 
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
                         <h3>Edicion del usuario {{ $usuario->name }}</h3>
                    </td>
                    <td name="ddiv" align="center">
                         @if (Session::has('errorRegistro'))
                         <div class="alert alert-danger" style="width:300px;">{{ Session::get('errorRegistro') }}</div>
                         @endif
                    </td>
                    </tr>  
                 </tbody>
              </table> 
              <br>
                    
                      <table>
	                 <tbody>                 

                    {{ Form::open(array('action' => array('systemController@update', $usuario->email),'method' => 'put')) }}               
                      <tr>
                      <td style="padding:15px">
		               {{ Form::label('email', 'Email:') }}
		            </td>
		            <td style="padding:15px">
		               {{ Form::email('email', $usuario->email, array('class' => 'form-control')) }}
		            <td><i name="ddiv" style="color:#7080CD">{{ $errors->first('email') }}</i></td>		               
		            </td>
		            </tr>
                      <tr>
                      <td style="padding:15px">
	                 {{ Form::label('password1', 'Contraseña:') }}
	                 </td>
	                 <td style="padding:15px">
	                 {{ Form::password('password1', array('class' => 'form-control', 'placeholder' => 'Password')) }}
		            </td>
		            <td><i name="ddiv" style="color:#7080CD">{{ $errors->first('password1') }}</i>
		            </td>	                 
	                 </tr>
	                 <tr>
	                 <td style="padding:15px">
	                 {{ Form::label('password2', 'Confirmar Contraseña:') }}
	                 </td>
	                 <td style="padding:15px">
	                 {{ Form::password('password2', array('class' => 'form-control', 'placeholder' => 'Password')) }}
	                 </td>
	                 <td><i style="color:#7080CD">Dejar los campos vacios en caso <br> de no querer editar la contraseña</i></td>
	                 </tr>
	                 <tr>
	                 <td style="padding:15px">
<button type="submit" class= "btn btn-default btn-lg" onclick="if(!confirm('Desea guardar los cambios?')){return false;};" title="Delete this Item">Guardar</a>
                      </td>
                      </tr>
                      </tbody>
                      </table>
                                   {{ Form::close() }}
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
