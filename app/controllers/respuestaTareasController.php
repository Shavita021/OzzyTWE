<?php

class respuestaTareasController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
     	$email = Session::get('emailUsuario');
     	
          $tareasNormales = DB::table('usuario_Tareas')
            ->join('tareas', 'usuario_Tareas.idTarea', '=', 'tareas.id')
            ->join('procesos', 'tareas.idProceso', '=', 'procesos.id')
            ->select('procesos.id', 'procesos.nombre', 'tareas.diasLimite', 'tareas.fechaTermino')
            ->where('usuario_Tareas.emailUsuario', $email)//$email
            ->where('usuario_Tareas.idRespuesta', '0')
            ->where('tareas.estado', 'ejecutando')            
            ->where('procesos.estado', 'ejecutando')
            ->orderBy('tareas.fechaTermino', 'asc')->get();

               $hoy = date("y-m-d");
               $formatoHoy = date_create($hoy);
               
               $trClassTN = array();
            foreach($tareasNormales as $tareaNormal){
               $fechaTermino = date_create($tareaNormal->fechaTermino);
               $interval = date_diff($formatoHoy, $fechaTermino);
               $dias = $interval->format('%R%a');
               
               if($tareaNormal->diasLimite != 0){           
               $porcentaje = $dias/$tareaNormal->diasLimite;
               
                   if($porcentaje >= .7){
                       array_push($trClassTN, "success");	                     
                     }elseif($porcentaje >= 0 && $porcentaje < .3){
                       array_push($trClassTN, "warning");
                      }elseif($porcentaje < 0){
                       array_push($trClassTN, "danger");                       
                       }   
               }else{
                        array_push($trClassTN, "warning");              
               }                  
               }
                        
          $tareasParalelas = DB::table('usuario_TareasParalelas')
            ->join('tareasParalelas', 'usuario_TareasParalelas.idTarea', '=', 'tareasParalelas.id')
            ->join('tareas', 'tareasParalelas.idTareaNormal', '=', 'tareas.id')
            ->join('procesos', 'tareas.idProceso', '=', 'procesos.id')
            ->select('procesos.id', 'procesos.nombre', 'tareasParalelas.diasLimite' , 'tareasParalelas.fechaTermino')
            ->where('usuario_TareasParalelas.emailUsuario', $email)//$email
            ->where('usuario_TareasParalelas.idRespuesta', '0')
            ->where('tareasParalelas.estado', 'ejecutando')                        
            ->where('procesos.estado', 'ejecutando')
            ->orderBy('tareas.fechaTermino', 'asc')->get();            

               $trClassTP = array();
               
            foreach($tareasParalelas as $tareaParalela){
               $fechaTermino = date_create($tareaParalela->fechaTermino);
               $interval = date_diff($formatoHoy, $fechaTermino);
               $dias = $interval->format('%R%a');
               
               if($tareaParalela->diasLimite != 0){
               $porcentaje = $dias/$tareaParalela->diasLimite;
               
                   if($porcentaje >= .7){
                       array_push($trClassTP, "success");	                      
                     }elseif($porcentaje >= 0 && $porcentaje < .3){
                       array_push($trClassTP, "warning");                       
                      }elseif($porcentaje < 0){
                       array_push($trClassTP, "danger");                       
                       }   
               }else{
                       array_push($trClassTP, "warning");                                      
               }                  
               }            
            
		$returnDatos = array($tareasNormales,$tareasParalelas, $trClassTN, $trClassTP);
		
          if(Session::get('tipoSession') == 'usuarioNormal')
		return View::make('usuarioNormales.bandeja')->with('datos', $returnDatos);          
          else
		return View::make('respuestaTareas.bandeja')->with('datos', $returnDatos);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{     
	     $idProceso = Input::get('idProceso'); 
	     $cancelarProceso = Input::get('cancelarProceso');	     
	     
	     $rules = array(
			'comentarios' => 'required|max:200',
			'password' => 'required',			
		);
		
		$messages = array(
    'max' => 'Los comentarios debe tener  hasta 200 caracteres',	
    'required' => 'El campo es requerido',
    );
    
		$validator = Validator::make(Input::all(), $rules, $messages);

		// process the login
		if ($validator->fails()) {
			     return Redirect::to('/bandeja/responder/'.$idProceso)
				->withErrors($validator)->withInput(Input::all());
		} else {	
		
	          $tabla = Input::get('tabla');
	          $idTabla = Input::get('idTabla');
	          $comentarios = Input::get('comentarios');
		     $archivo = Input::file('archivo');
		     $password = Input::get('password');		     
		     $email = Session::get('emailUsuario');
		     
		    /* return var_dump($archivo->getSize());
		    if($archivo->getSize() > 10240){
		          Session::flash('errorArchivo', 'El archivo debe ser menor a 10Mb');
		          return Redirect::to('/procesos/create');		    
		    }*/
		    		     
		     $usuario = DB::table('adminSecundarios')->where('email', $email)->first();
		     if($usuario){}else{
		     $usuario = DB::table('usuarioNormales')->where('email', $email)->first();
		     }

		     if(!Hash::check($password,$usuario->password)){	
		          Session::flash('password', 'Contraseña incorrecta');
			     return Redirect::to('/bandeja/responder/'.$idProceso)->withInput(Input::all());
               }
               
//Borrar el proceso en caso de que se presione el boton declinar		
	          if(isset($cancelarProceso)){
	               $proceso = DB::table('procesos')->where('id', $idProceso)->first();
		          $tareas = DB::table('tareas')->where('idProceso', $idProceso)->get();
		
		          foreach($tareas as $tarea){
	                    $tareasParalelas = DB::table('tareasParalelas')->where('idTareaNormal', $tarea->id)->get();
	                    if($tareasParalelas){
	                         foreach($tareasParalelas as $tareaParalela){
	                              $respuestasParalelas = DB::table('usuario_TareasParalelas')->where('idTarea', $tareaParalela->id)->lists('idRespuesta');  
	                               
	                              foreach($respuestasParalelas as $respuesta){
	                              	$respuestaP = DB::table('respuestasTareasParalelas')->where('id',$respuesta)->first();
	                              	if($respuestaP)
	                              	File::delete(public_path().$respuestaP->file);		
	                                   DB::table('respuestasTareasParalelas')->where('id',$respuesta)->delete();
	                              }            
	                              
                                   File::delete(public_path().$tareaParalela->file);		
	                              DB::table('usuario_TareasParalelas')->where('idTarea',$tareaParalela->id)->delete();
	                              DB::table('tareasParalelas')->where('id',$tareaParalela->id)->delete();
	                         }
	                    }
	                    
	                         $respuestasNormales = DB::table('usuario_Tareas')->where('idTarea', $tarea->id)->lists('idRespuesta');
	                               
	                         foreach($respuestasNormales as $respuesta){
	                              $respuestaN = DB::table('respuestasTareas')->where('id',$respuesta)->first();
	                              if($respuestaN)
	                              File::delete(public_path().$respuestaN->file);		
	                              DB::table('respuestasTareas')->where('id',$respuesta)->delete();
	                         }    	          
	                    		
	                    File::delete(public_path().$tarea->file);	
		               DB::table('usuario_Tareas')->where('idTarea',$tarea->id)->delete();
	                    DB::table('tareas')->where('id',$tarea->id)->delete();		     
		          }
	               $emailCreador = DB::table('procesos')->where('id',$idProceso)->pluck('emailCreador');
                    $usuario = DB::table('adminMaestros')->where('email', $emailCreador)->first();
                    if($usuario){}else{
	               $usuario = DB::table('adminSecundarios')->where('email', $emailCreador)->first();
	               }
	               if($usuario){}else{
	                 $usuario = DB::table('usuarioNormales')->where('email', $emailCreador)->first();
	               }
	               
	               DB::table('procesos')->where('id',$idProceso)->delete();	               
	                
                    Mail::send('emails.tareaCancelada', array('firstname'=>$usuario->name,'nombreProceso' => $proceso->nombre, 'usuario' => $email, 'comentarios' => $comentarios), function($message) use ($usuario){$message->to($usuario->email, $usuario->name.' '.$usuario->plast_name)->subject('Tec WorkFlow Engine - Proceso Cancelado');});	
                    
	               Session::flash('message', 'Tarea declinada correctamente correctamente');
	               return Redirect::to('/bandeja');
	     
	          }               
		     
		     $path="";
               $nameFile ="Ninguno";               
               if(isset($archivo)){
                    $nameFile = $archivo->getClientOriginalName();               
                    $nombre = uniqid();
		          $nombre .= "_".$archivo->getClientOriginalName();
		          Input::file('archivo')->move('uploads', $nombre);	
		          $path = "/uploads/".$nombre;//////////////////////////////////////////////////   
		     }   
		     
		     $createdate= date('Y-m-d H:i:s');
// Insertar en tablas respuesta con respecto al tipo de tarea respondida		     
		     if($tabla == "usuario_Tareas"){
		     DB::table('respuestasTareas')->insert(array('comentarios' => strtoupper($comentarios),'file' => $path,'nameFile' => $nameFile, 'created_at' => $createdate));
		     $tarea = DB::table('respuestasTareas')->orderBy('created_at', 'desc')->first();
		     }else{
		     DB::table('respuestasTareasParalelas')->insert(array('comentarios' => strtoupper($comentarios),'file' => $path,'nameFile' => $nameFile, 'created_at' => $createdate));
		     $tarea = DB::table('respuestasTareasParalelas')->orderBy('created_at', 'desc')->first();
		     }
// Actualizamos la tabla de usuario_Tareas o usuario_TareasParalelas para ligarlo a la tabla de respuesta
		     $updatedDate = date('Y-m-d H:i:s');		     
		     DB::table($tabla)->where('id',$idTabla)->update(array('idRespuesta' => $tarea->id ,'updated_at' => $updatedDate));
		        
//comprobamos si se acabo la tarea y la cambiamos a terminada la tarea
               $bandera = "true";   
		     if($tabla == "usuario_Tareas"){
               $idTareaNormal = DB::table('usuario_Tareas')->where('id', $idTabla)->pluck('idTarea');
               $tareasNormales = DB::table('usuario_Tareas')->where('idTarea', $idTareaNormal)->get();
                    foreach($tareasNormales as $tareaNormal){
                         if($tareaNormal->idRespuesta == 0){
                              $bandera = "false";
                              break;
                         }
                    }                    
                    
               if($bandera == "true"){
		     DB::table('tareas')->where('id',$idTareaNormal)->update(array('estado' => 'terminada' ,'updated_at' => $updatedDate)); 
		     }
// comprobar si todas las tareas estan en terminada para terminar el proceso	
	     $comprobacionTareas = DB::table('tareas')->where('idProceso',$idProceso)->get();
	               $banderaProceso = "true";
	               foreach($comprobacionTareas as $cTarea){
	               
	                    $comprobacionTareasP = DB::table('tareasParalelas')->where('idTareaNormal',$cTarea->id)->get();
	                    foreach($comprobacionTareasP as $cTareaP){
	                         if($cTareaP->estado == "pendiente"){
	                              $banderaProceso = "false";
	                              break 2;
	                         }
	                    }
	                    
	                    if($cTarea->estado == "pendiente"){
	                    	$banderaProceso = "false";
	                         break;
	                    }
	               }
	               
	               
	               if($banderaProceso == "true"){
		     DB::table('procesos')->where('id',$idProceso)->update(array('estado' => 'terminada' ,'updated_at' => $updatedDate)); 	               
                    }               	               
  
		     }else{
// En caso de que sea usuario_TareaParalelas 
               $idTareaParalela = DB::table('usuario_TareasParalelas')->where('id', $idTabla)->pluck('idTarea');
               $tareasParalelas = DB::table('usuario_TareasParalelas')->where('idTarea', $idTareaParalela)->get();                            
                    $bandera = "true";  
                    foreach($tareasParalelas as $tareaParalela){
                         if($tareaParalela->idRespuesta == 0){
                              $bandera = "false";
                              break;
                         }
                    }
                    
               if($bandera == "true"){
		     DB::table('tareasParalelas')->where('id',$idTareaParalela)->update(array('estado' => 'terminada' ,'updated_at' => $updatedDate)); 
		     }
		     
                    $idTareaNormal = DB::table('tareasParalelas')->where('id', $idTareaParalela)->pluck('idTareaNormal');
                    $tareasParalelas = DB::table('tareasParalelas')->where('idTareaNormal', $idTareaNormal)->get();  	
                    foreach($tareasParalelas as $tareaParalela){
                         if($tareaParalela->estado == "ejecutando"){
                              $bandera = "false";
                              break;
                         }
                    }                                     	                            
// comprobar si todas las tareas estan en terminada para terminar el proceso	
                 if($bandera == "true"){
/////////////////////
	     $comprobacionTareas = DB::table('tareas')->where('idProceso',$idProceso)->get();
	               $banderaProceso = "true";
	               foreach($comprobacionTareas as $cTarea){
	               
	                    $comprobacionTareasP = DB::table('tareasParalelas')->where('idTareaNormal',$cTarea->id)->get();
	                    foreach($comprobacionTareasP as $cTareaP){
	                         if($cTareaP->estado == "pendiente"){
	                              $banderaProceso = "false";
	                              break 2;
	                         }
	                    }
	                    
	                    if($cTarea->estado == "pendiente"){
	                    	$banderaProceso = "false";
	                         break;
	                    }
	               }	               
	               
	               if($banderaProceso == "true"){
		     DB::table('procesos')->where('id',$idProceso)->update(array('estado' => 'terminada' ,'updated_at' => $updatedDate)); 	               
                    }
                  }
		     }		     		     
		     
		     
		     
		     
// Disparamos la siguiente tarea si es una tarea paralela la siguiente o no 	
	          $procesoBandera = DB::table('procesos')->where('id', $idProceso)->pluck('estado');
	          
	          if($bandera == "true" && $procesoBandera == "ejecutando"){
	          if($tabla == "usuario_Tareas"){
               $tareaSiguiente = DB::table('tareas')->where('idProceso',$idProceso)->whereNotIn('estado', array('terminada'))->orderBy('created_at', 'asc')->first();	          
	          }else{
               $tareaSiguiente = DB::table('tareas')->where('idProceso',$idProceso)->where('estado','pendiente')->orderBy('created_at', 'asc')->first();
               }	

               $tareasParalelas = DB::table('tareasParalelas')->where('idTareaNormal', $tareaSiguiente->id)->get();
               if($tareasParalelas){
	               foreach($tareasParalelas as $tareaParalela){
	               $usuarios = DB::table('usuario_TareasParalelas')->where('idTarea',$tareaParalela->id)->get();  
	                    foreach($usuarios as $usuario){
	                    $renglonUsuario = DB::table('adminSecundarios')->where('email', $usuario->emailUsuario)->first();
	                    if($renglonUsuario){}else{
	                          $renglonUsuario = DB::table('usuarioNormales')->where('email', $usuario->emailUsuario)->first();	                    
	                    }
                            Mail::send('emails.nuevaTarea', array('firstname'=>$renglonUsuario->name), function($message) use ($renglonUsuario){$message->to($renglonUsuario->email, $renglonUsuario->name.' '.$renglonUsuario->plast_name)->subject('Tec WorkFlow Engine - Nueva Tarea');});
	                    }
	                    
	                    $stringDias = $tareaParalela->diasLimite." days";
	                    	               
	                    $hoy = date("y-m-d");
                         $formatoHoy = date_create($hoy);
                         $fechaInicio = date_format($formatoHoy, 'Y-m-d');
                         date_add($formatoHoy, date_interval_create_from_date_string($stringDias));
                         $fechaTermino = date_format($formatoHoy, 'Y-m-d');
                         
		          DB::table('tareasParalelas')->where('id',$tareaParalela->id)->update(array('estado' => 'ejecutando', 'fechaInicio' => $fechaInicio, 'fechaTermino' => $fechaTermino));
	               }               
               }else{
               
	          $usuarios = DB::table('usuario_Tareas')->where('idTarea',$tareaSiguiente->id)->get();
	          foreach($usuarios as $usuario){
	               $renglonUsuario = DB::table('adminSecundarios')->where('email', $usuario->emailUsuario)->first();
	               if($renglonUsuario){}else{
	                    $renglonUsuario = DB::table('usuarioNormales')->where('email', $usuario->emailUsuario)->first();	                    
	                }
                    Mail::send('emails.nuevaTarea', array('firstname'=>$renglonUsuario->name), function($message) use ($renglonUsuario){$message->to($renglonUsuario->email, $renglonUsuario->name.' '.$renglonUsuario->plast_name)->subject('Tec WorkFlow Engine - Nueva Tarea');});	               
	          }
	          
	          	     $stringDias = $tareaSiguiente->diasLimite." days";
	          	     
	                    $hoy = date("y-m-d");
                         $formatoHoy = date_create($hoy);
                         $fechaInicio = date_format($formatoHoy, 'Y-m-d');
                         date_add($formatoHoy, date_interval_create_from_date_string($stringDias));
                         $fechaTermino = date_format($formatoHoy, 'Y-m-d');
                         
		     DB::table('tareas')->where('id',$tareaSiguiente->id)->update(array('estado' => 'ejecutando', 'fechaInicio' => $fechaInicio, 'fechaTermino' => $fechaTermino));               
               
               }
               }
                    		     
	     Session::flash('message', 'Tarea respondida correctamente');
	     return Redirect::to('/bandeja');
		
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	
	/**
	 * Metodo donde se vera la tarea que se tiene asignada asi como tambien las respuestas a las
	 * tareas anteriores a mi con respecto al flujo asi como tambien la forma para la respuesta.
	 *
	 * @param  int  $id
	 * @return Response
	 */	
	public function responder($id){
	     $email = Session::get('emailUsuario');
	     
	     // Obtener la tarea asignada del usuario en caso de ser una tarea normal o paralela
	     $tabla = "usuario_Tareas";
          $tareaAsignada = DB::table('usuario_Tareas')
            ->join('tareas', 'usuario_Tareas.idTarea', '=', 'tareas.id')
            ->join('procesos', 'tareas.idProceso', '=', 'procesos.id')
            ->select('usuario_Tareas.id','tareas.descripcion', 'tareas.file', 'tareas.nameFile')
            ->where('usuario_Tareas.emailUsuario', $email)//$email
            ->where('tareas.estado', 'ejecutando')  
            ->where('procesos.id', $id)                                     
            ->first();
          if($tareaAsignada){}else{
          $tareaAsignada = DB::table('usuario_TareasParalelas')
            ->join('tareasParalelas', 'usuario_TareasParalelas.idTarea', '=', 'tareasParalelas.id')
            ->join('tareas', 'tareasParalelas.idTareaNormal', '=', 'tareas.id')
            ->join('procesos', 'tareas.idProceso', '=', 'procesos.id')
            ->select('usuario_TareasParalelas.id','tareasParalelas.descripcion', 'tareasParalelas.file', 'tareasParalelas.nameFile')
            ->where('usuario_TareasParalelas.emailUsuario', $email)//$email
            ->where('tareasParalelas.estado', 'ejecutando')  
            ->where('procesos.id', $id)                                     
            ->first(); 
	     $tabla = "usuario_TareasParalelas";                     
          }     
	     
          //Obtener por medio de la union de dos querys todas las tareas que se han terminado del proceso con el id $id
          /*	     
          $query1 = DB::table('respuestasTareas')
            ->join('usuario_Tareas', 'respuestasTareas.id', '=', 'usuario_Tareas.idRespuesta')          
            ->join('tareas', 'usuario_Tareas.idTarea', '=', 'tareas.id')
            ->join('procesos', 'tareas.idProceso', '=', 'procesos.id')
            ->select('respuestasTareas.comentarios', 'respuestasTareas.file', 'respuestasTareas.nameFile')
            ->where('procesos.id', $id) 
            ->where('tareas.estado', 'terminada');
            
          $tareasRespondidas = DB::table('respuestasTareasParalelas')
            ->join('usuario_TareasParalelas', 'respuestasTareasParalelas.id', '=', 'usuario_TareasParalelas.idRespuesta')
            ->join('tareasParalelas', 'usuario_TareasParalelas.idTarea', '=', 'tareasParalelas.id')
            ->join('tareas', 'tareasParalelas.idTareaNormal', '=', 'tareas.id')
            ->join('procesos', 'tareas.idProceso', '=', 'procesos.id')
            ->select('respuestasTareasParalelas.comentarios', 'respuestasTareasParalelas.file', 'respuestasTareasParalelas.nameFile')
            ->where('procesos.id', $id)
            ->where('tareasParalelas.estado', 'terminada')                     
            ->union($query1)->get();*/

		$tareas = DB::table('tareas')->where('idProceso', $id)->get();
		
	     $tareasRespondidas = array();
	     $trClass = array();
	     
	     foreach($tareas as $tarea){
	          $tareasParalelas = DB::table('tareasParalelas')->where('idTareaNormal', $tarea->id)->get();
	          if($tareasParalelas){
                    foreach($tareasParalelas as $tareaParalela){
                        $tareaParalelaRespuestas = DB::table('respuestasTareasParalelas')
                        ->join('usuario_TareasParalelas', 'usuario_TareasParalelas.idRespuesta', '=', 'respuestasTareasParalelas.id')
                        ->join('tareasParalelas', 'tareasParalelas.id', '=', 'usuario_TareasParalelas.idTarea')    
                        ->select('respuestasTareasParalelas.comentarios', 'respuestasTareasParalelas.file', 'respuestasTareasParalelas.nameFile')
                        ->where('tareasParalelas.id', $tareaParalela->id)->get();
                        foreach($tareaParalelaRespuestas as $tareaParalelaRespuesta){
	                        array_push($tareasRespondidas, $tareaParalelaRespuesta);	  
	                        array_push($trClass, "info");	 
	                   }                             	                                               
                    }	          
	          }else{
                        $tareaRespuestas = DB::table('respuestasTareas')
                        ->join('usuario_Tareas', 'usuario_Tareas.idRespuesta', '=', 'respuestasTareas.id')
                        ->join('tareas', 'tareas.id', '=', 'usuario_Tareas.idTarea')    
                        ->select('respuestasTareas.comentarios', 'respuestasTareas.file', 'respuestasTareas.nameFile')
                        ->where('tareas.id', $tarea->id)->get();
                        foreach($tareaRespuestas as $tareaRespuesta){
	                        array_push($tareasRespondidas, $tareaRespuesta);	  
	                        array_push($trClass, "");	 
	                   }
	          }
	     }       
		$returnDatos = array($tareaAsignada,$tareasRespondidas,$trClass,$tabla,$id);            

          if(Session::get('tipoSession') == 'usuarioNormal')
          return View::make('usuarioNormales.responderTarea')->with('datos', $returnDatos);          
          else
          return View::make('respuestaTareas.responderTarea')->with('datos', $returnDatos);
	}
	

}
