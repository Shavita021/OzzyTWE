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
          <a class="navbar-brand" href="/inicio"><strong>WorkFlow Engine</strong></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li><a href="/inicio"><i class="glyphicon glyphicon-home"></i> Inicio</a></li>
            <li><a href="/usuarios"><i class="glyphicon glyphicon-user"></i> Administracion Usuarios</a></li>
            <li><a href="/administracionRoles"><i class="glyphicon glyphicon-registration-mark"></i> Administracion Roles</a></li>
            <li class="active"><a href="/procesos"><i class="glyphicon glyphicon-random"></i>  Procesos</a></li>     
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
                       {{ Form::open(array('action' => 'tareaController@store', 'files' => true)) }}
                           <h4 align="center">Tarea</h4>
                           <div id="raiz" class="jumbotron" align="center" style="width:80%;height:490px;display:block; margin-left: auto;margin-right: auto;background-color:#B1B1B1;">
		                    <table align="left">
		                         <tbody>
		                              <tr>
		                                   <td style="padding:15px">
                                                  Descripcion del Paso:
		                                   </td>
		                                   <td style="padding:15px">
                         <textarea name="descripcionPaso" class="form-control" rows="3" cols="50">

                         </textarea>                                   
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
               <input type="radio" name="rol" value="{{ $rol->id }}" onClick="getUsers(this.value)"> {{ $rol->nombre }}<br>
                @endforeach
               </div>
                                             </td>
                                             <td style="padding:15px">
                <div id="usuarios" name="usuarios" style="width:240px; height: 100px; overflow-y: scroll;">
                <?php $cont = 0; ?>
                @foreach($datos[1] as $key => $rolUsuario)
                <div id="{{ $datos[0][$cont]->id }}" name="boxes" style="display: none;visibility: hidden;">       
                @foreach($rolUsuario as $key => $usuario)
<input type="checkbox" name="usuariosTarea[]"  value="{{ $usuario->email }}" /> {{ $usuario->name." ".$usuario->plast_name }}<br>
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
                                                  Fecha Limite:
                                             
                                    <input type="text" id="datepicker" name="fechaLimite"></input>
                                             
                                             </td>
                                             <td style="padding:15px">
                                                  Hora limite:
                                             </td>
                                             <td>
                                             <select class="form-control" name="horaLimite">
                                             <option value="00">00:00</option>
                                             <option value="01">01:00</option>
                                             <option value="02">02:00</option>
                                             <option value="03">03:00</option>
                                             <option value="04">04:00</option>
                                             <option value="05">05:00</option>
                                             <option value="06">06:00</option>
                                             <option value="07">07:00</option> 
                                             <option value="08">08:00</option>
                                             <option value="09">09:00</option>
                                             <option value="10">10:00</option>
                                             <option value="11">11:00</option>
                                             <option value="12">12:00</option>                    
                                             </select>
                                             </td>
                                             <td>
                                             <input type="radio" name="amOpm" value="AM">AM
                                             <input type="radio" name="amOpm" value="PM">PM
		                                   </td>
		                                   <tr>
		                                   <td><i name="ddiv" style="color:#7080CD">{{ $errors->first('fechaLimite')}}</i></td></tr>
		                              </tr>

		                         </tbody>
		                     </table>
		                     <table align="left">
		                         <tbody>
		                              <tr>
		                     		     <td style="padding:15px">
                                                  Archivo adjunto:
		                                   </td>
		                                   <td style="padding:15px">
                                             <input type="file" name="archivo">
		                                   </td>
		                              </tr>
		                              
		                              <tr>
		                              <td>		
		                              </td>
		                              <td>                              

<button name="siguientePagina" class="btn btn-default btn-lg" onclick="if(!confirm('Desea crear una nueva tarea?')){return false;};" style="position:absolute;margin-left:375px"><span class="glyphicon glyphicon-arrow-right"> Nueva Tarea</span></button>	

		                                   </td>
		                              </tr>
		                         </tbody>
		                     </table>      				    
		                 </div>

		                 
		                 
		                 
		                <div align="center">
<button name="finalizarProceso" class="btn btn-default btn-lg" style="background-color:#030824;color:#FFFFFF" onclick="if(!confirm('Desea terminar el proceso?')){return false;};" style="position:absolute;margin-left:375px">Finalizar Proceso</button>	
		     
		     <input type="hidden" name="idProceso" value="{{ $datos[2] }}"/>
               {{ Form::close() }}
		                 </div>
	                <div id="prueba"></div>

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
