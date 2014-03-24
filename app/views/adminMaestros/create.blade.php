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
          <a class="navbar-brand" href="/inicio"><strong>WorkFlow Engine</strong></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li><a href="/inicio"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
            <li class="active"><a href="/Usuarios"><i class="glyphicon glyphicon-user"></i> Administracion Usuarios</a></li>
            <li><a href="/administracionRoles"><i class="glyphicon glyphicon-registration-mark"></i> Administracion Roles</a></li>
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
                         <h3>Crear Usuario</h3>
                    </td>
                    <td align="center">
                         @if (Session::has('errorRegistro'))
                         <div class="alert alert-danger"  style="width:300px;">{{ Session::get('errorRegistro') }}</div>
                         @endif
                    </td>
                    </tr>  
                 </tbody>
              </table> 
                    <br>
                    <table>
	                 <tbody>
	                 <tr>                    
               {{ Form::open(array('action' => 'adminMaestroController@store')) }}
                      <td style="padding:15px">
		               {{ Form::label('name', 'Nombre:') }}
		            </td>
		            <td style="padding:15px">
		               {{ Form::text('name', Input::old('name'), array('class' => 'form-control')) }}
		            <td><i style="color:#7080CD">{{ $errors->first('name') }}</i></td>
		            </td>
		            </tr>
	                 <tr>
	                 <td style="padding:15px">
		               {{ Form::label('middleName', 'Segundo Nombre:') }}
		            </td>
		            <td style="padding:15px">
		               {{ Form::text('middleName', Input::old('middleName'), array('class' => 'form-control')) }}
		            <td><i style="color:#7080CD">{{ $errors->first('middleName') }}</i></td>
		            </td>
		            </tr>
                      <tr>
                      <td style="padding:15px">
		               {{ Form::label('plast_name', 'Apellido Paterno:') }}
		            </td>
		            <td style="padding:15px">
		               {{ Form::text('plast_name', Input::old('plast_name'), array('class' => 'form-control')) }}
		            <td><i style="color:#7080CD">{{ $errors->first('plast_name') }}</i></td>
		            </td>
		            </tr>
                      <tr>
                      <td style="padding:15px">
		               {{ Form::label('mlast_name', 'Apellido Materno:') }}
		            </td>
		            <td style="padding:15px">
		               {{ Form::text('mlast_name', Input::old('mlast_name'), array('class' => 'form-control')) }}
		            <td><i style="color:#7080CD">{{ $errors->first('mlast_name') }}</i></td>		         
		            </td>
		            </tr>
                      <tr>
                      <td style="padding:15px">
		               {{ Form::label('email', 'Email:') }}
		            </td>
		            <td style="padding:15px">
		               {{ Form::email('email', Input::old('email'), array('class' => 'form-control')) }}
		            <td><i style="color:#7080CD">{{ $errors->first('email') }}</i></td>		              
		            </td>
		            </tr>
                      <tr>
                      <td style="padding:15px">
	                 {{ Form::label('password', 'Contraseña:') }}
	                 </td>
	                 <td style="padding:15px">
	                 {{ Form::password('password1', array('class' => 'form-control', 'placeholder' => 'Password')) }}
		            <td><i style="color:#7080CD">{{ $errors->first('password1') }}</i></td>	                 
	                 </td>
	                 </tr>
	                 <tr>
	                 <td style="padding:15px">
	                 {{ Form::label('password', 'Confirmar Contraseña:') }}
	                 </td>
	                 <td style="padding:15px">
	                 {{ Form::password('password2', array('class' => 'form-control', 'placeholder' => 'Password')) }}
	                 </td>
	                 </tr>
                      <tr>
                      <td style="padding:15px">
		               {{ Form::label('phone_number', 'Telefono:') }}
		            </td>
		            <td style="padding:15px">
		               {{ Form::text('phone_number', Input::old('phone_number'), array('class' => 'form-control')) }}
		            <td><i style="color:#7080CD">{{ $errors->first('phone_number') }}</i></td>		              
		            </td>
                      </tr>
                      <tr>
                      <td style="padding:15px">
		               {{ Form::label('location', 'Ubicacion:') }}
		            </td>
		            <td style="padding:15px">
		               {{ Form::text('location', Input::old('location'), array('class' => 'form-control')) }}
		            </td>
		            </tr>
                      <tr>
                      <td style="padding:15px">
	                 {{ Form::label('tipo', 'Tipo de Usuario:') }}
	                 </td>
	                 <td style="padding:15px">
	                 {{ Form::select('tipo', array('adminSecundario' => 'Administrador Secundario', 'usuarioNormal' => 'Usuario Normal')) }}
	                 </td>
	                 </tr>
	                  <tr>
	                 <td style="padding:15px">
	                 {{ Form::label('tipo', 'Roles:') }}
	                 </td>
                      <td>
<div style="width:300px; height: 100px; overflow-y: scroll;">
@foreach($roles as $key => $value)	                                       
<input type="checkbox" name="roles[]" value="{{ $value->id }}"> {{ $value->nombre }}<br>
@endforeach
</div>
                      </td>
                      </tr>                      
	                 <tr>
	                 <td style="padding:15px">
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

  </body>
</html>
@else
{{	header("Location: /");
	exit();
	}}
@endif
@endif
