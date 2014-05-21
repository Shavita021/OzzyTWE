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
         <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">
         
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
                    {{ Form::open(array('action' => array('tareaController@update', $datos[2]->id),'method' => 'put','files' => true)) }}
                                   <h3>Proceso <strong>{{ $datos[3] }}</strong></h3>
                                   <br>
                           <div id="raiz" class="jumbotron" align="center" style="width:80%;height:490px;display:block; margin-left: auto;margin-right: auto;background-color:#B1B1B1;">
		                    <table align="left">
		                         <tbody>
		                              <tr>
		                                   <td style="padding:15px">
                                                  Descripción del Paso:
		                                   </td>
		                                   <td style="padding:15px">
                         <textarea name="descripcionPaso" class="form-control" rows="3" cols="50">{{ $datos[2]->descripcion }}</textarea>                                   
		                                   </td>	
		                                  <td><i name="ddiv" style="color:#7080CD">{{ $errors->first('descripcionPaso') }}</i></td>
		                                            
		                              </tr>
		                         </tbody>
		                    </table>
		                    <table align="left">
		                         <tbody>
		                              <tr>
		                                   <td style="padding:15px">
                                                  Asignado a:
		                                   </td>
		                                   <td style="padding:15px">
               <div style="width:240px; height: 100px; overflow-y: scroll;">
               @foreach($datos[0] as $key => $rol)     
               @if ($rol->nombre == $datos[5])
               <input type="radio" name="rol" value="{{ $rol->id }}" onClick="getUsers(this.value)" checked> {{ $rol->nombre }}<br>                 
               @else       	                                       
               <input type="radio" name="rol" value="{{ $rol->id }}" onClick="getUsers(this.value)"> {{ $rol->nombre }}<br>          
               @endif
               @endforeach
               </div>
                                             </td>
                                             <td style="padding:15px">
                <div id="usuarios" name="usuarios" style="width:240px; height: 100px; overflow-y: scroll;">
                <?php $cont = 0; ?>
                @foreach($datos[1] as $key => $rolUsuario)
                @if ($datos[0][$cont]->nombre == $datos[5])
                <div id="{{ $datos[0][$cont]->id }}" name="boxes">                 
                @else
                <div id="{{ $datos[0][$cont]->id }}" name="boxes" style="display: none;visibility: hidden;">       
                @endif
                @foreach($rolUsuario as $key => $usuario)
@if (in_array($usuario->email,$datos[4]) && $datos[0][$cont]->nombre == $datos[5])
<input type="checkbox" name="usuariosTarea[]" value="{{ $usuario->email }}" checked> {{ $usuario->name." ".$usuario->plast_name }}<br>
@else                              
<input type="checkbox" name="usuariosTarea[]" value="{{ $usuario->email }}"> {{ $usuario->name." ".$usuario->plast_name }}<br>
@endif                
                @endforeach 
                <?php $cont++; ?>
                </div>               
                @endforeach
                </div>
		                                   </td>
		                              </tr>
		                        </tbody>
		                     </table>
		                     <table align="left">
		                         </tbody>
		                              <tr>	
		                                   <td style="padding:15px">
                                                  Fecha Límite:                                        
                                             </td>
                                             <td>
                                             <input type="text" name="diasLimite" value="{{ $datos[2]->diasLimite }}"></input>
                                             </td>
		                                   <tr>
		                                   <td><i name="ddiv" style="color:#7080CD">{{ $errors->first('diasLimite')}}{{ Session::get('diasLimite') }}</i></td></tr>
		                              </tr>

		                         </tbody>
		                     </table>
		                     <table align="left">
		                         <tbody>
		                              <tr>
		                     		     <td style="padding:15px">
                                                  Archivo adjunto:
		                                   </td>
		                                   <td>
                                             <input type="file" name="archivo">
		                                   </td>
		                                   <td style="padding:15px">
		                                   <i style="color:#BF2D00">Al seleccionar un nuevo archivo remplazará el existente</i>
		                                   </td>
		                              </tr>


		                         </tbody>
		                     </table>      				    
		                 </div>
		                 
		                <div align="center">
<button name="guardarTarea" class="btn btn-default btn-lg" style="" onclick="if(!confirm('Desea guardar los cambios?')){return false;};" style="position:absolute;margin-left:375px">Guardar</button>	
		     
               {{ Form::close() }}
		                 </div>

               </div>
      

          </div><!-- /#wrapper -->

    
        <!-- JavaScript -->
    <script src="/js/jquery-1.10.2.js"></script>
    <script src="/js/bootstrap.js"></script> 
   
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
<script>
$(function() {
$( "#datepicker" ).datepicker();
});
</script>


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
