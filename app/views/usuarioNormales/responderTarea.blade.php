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
            <li style="top:50px"><a href="/bandejaProcesos"><i class="glyphicon glyphicon-list-alt"></i>  Bandeja de Procesos</a></li>             
            <li class="active" style="top:50px"><a href="/bandeja"><i class="glyphicon glyphicon-th-list"></i>  Bandeja de Tareas</a></li>                     
                        <li style="top:420px"><a href="/creditos" align="center" style="color:#FFFFFF"><strong>Créditos</strong></a></li>                    
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
                         <h2>Responder a mi Tarea</h2>
                    </td>
                    <td align="center">
                          @if (Session::has('message'))
                         <div class="alert alert-info"  style="width:300px;">{{ Session::get('message') }}</div>
                         @endif
                    </td>
                    </tr>  
                 </tbody>
              </table> 
<!---------------Tabla para mostrar mi tarea asignada y las que ya se respondieron ------------------>
              <br>
              <br>
               <table class="table">
	            <thead>
		        <tr align="center">
	      	   <td><b>Mi Tarea Asignada</b></td>
			   <td><b>Tareas que se han respondido previamente a la mía</b></td>
		       </tr>
	            </thead>
	           <tbody>

	           <tr class="" align="center">
			   <td>
                    <div style="background-color:#B1B1B1;padding:5px">
                         <p>{{ $datos[0]->descripcion }}</p>
                         <strong>Archivo adjunto:</strong>
		               <a href="{{ $datos[0]->file }}">{{ $datos[0]->nameFile }}</a>   
                    </div>
			   </td>
@if($datos[1])			   
			   <td>
                    <table class="table table-hover">
<?php $cont=0; ?>
@foreach($datos[1] as $tarea)                    
	               <tr class="{{ $datos[2][$cont] }}" align="center">
			        <td>
                         <p>{{ $tarea->comentarios }}</p>
                         <strong>Archivo adjunto:</strong>                         
		               <a href="{{ $tarea->file }}">{{ $tarea->nameFile }}</a>
			        </td>	
                    </tr>
<?php $cont++; ?>	                    
@endforeach                    
                    </table>
			   </td>
@else
                       <td>
                       Ninguna tarea respondida hasta el momento
                       </td>
@endif                       			   
		      </tr>

	          </tbody>
               </table>
<!------------------------------------Tabla para responder mi tarea ------------------------------->
{{ Form::open(array('action' => 'respuestaTareasController@store', 'files' => true)) }} 
               <br>
               <br>
                 <table class="table">
	            <thead>
		        <tr align="center">
	      	   <td><h4><b>Responder mi tarea asignada</b></h4></td>
		       </tr>
	            </thead>
	           <tbody>
	           <tr class="" align="center">
			   <td>
			     <div style="background-color:#B1B1B1;padding:10px;width:600px">
			          <table>
			          <tr>
			          <td style="padding:15px">
                         Comentarios:
                         </td>
                         <td style="padding:15px">
                    <textarea name="comentarios" class="form-control" rows="3" cols="50"></textarea>
                         </td>			     
                         </tr>
                         <tr>
                         <td></td><td style="padding:15px">
                         <i name="ddiv" style="color:#BF2D00">{{ $errors->first('comentarios')}}</i>
                         </td>
                         </tr>
                         <tr>
		               <td style="padding:15px">
                         Adjuntar archivo:
		               </td>
		               <td style="padding:15px">
                         <input type="file" name="archivo">
		               </td>                                                  
                         </tr>
                         <tr>
                         <td style="padding:15px">
                         Confirmar mi contraseña:
                         </td>
                         <td style="padding:15px">
                         <input type="password" name="password">                         
                         </td>
                         </tr>
                         <tr>
                         <td></td><td>
                         <i name="ddiv" style="color:#BF2D00">{{ $errors->first('password')}}{{ Session::get('password') }}</i>
                         </td>
                         </tr>
                         </table>
			     </div>
			   </td>
		      </tr>

	          </tbody>
               </table>
<button name="enviarRespuesta" class="btn btn-default btn-lg" onclick="if(!confirm('Desea responder la tarea?')){return false;};" style="position:absolute;margin-left:300px">Aceptar y Enviar</button>
<button name="cancelarProceso" class="btn btn-danger btn-lg" onclick="if(!confirm('Desea declinar la tarea?')){return false;};" style="position:absolute;margin-left:500px">Declinar Tarea</button>	
		     
		      <input type="hidden" name="tabla" value="{{ $datos[3] }}"/>
		      <input type="hidden" name="idTabla" value="{{ $datos[0]->id }}"/>
		      <input type="hidden" name="idProceso" value="{{ $datos[4] }}"/>		      		      
               {{ Form::close() }}                 
          <br><br><br><br>
             <button style="width:30px;height:30px" class="btn btn-info" disabled="disabled"></button> Tareas Paralelas
             <br><br>                               
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
