<?php

class procesoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	     //Obtenemos todos los procesos corriendo y los pasamos a la vista de administacion Pocesos para desplegarlos ahi
		$procesosEjecutando = DB::table('procesos')->where('estado', 'ejecutando')->get();
		$procesosPendiente = DB::table('procesos')->where('estado', 'pendiente')->get();
		$procesosTerminados = DB::table('procesos')->where('estado', 'terminada')->get();		
		$returnDatos = array($procesosEjecutando,$procesosPendiente,$procesosTerminados);
		
	     return View::make('procesos.administracionProcesos')->with("procesos",$returnDatos);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
	     $size = DB::table('roles')->count();
	     $arrRolesUsuarios = array();
	     
          $roles = DB::table('roles')->get();
          $indice = 0;

               for ($i = 0; $i < $size; $i++){
                    $datos = DB::select('SELECT *
                                  FROM (SELECT *
                                        FROM adminSecundarios
                                        UNION
                                        SELECT *
                                        FROM usuarioNormales) b
                                  WHERE b.email IN (SELECT usuarioEmail 
                                                    FROM usuario_roles 
                                                    WHERE idRol = ?)', array($roles[$i]->id)); 
                    array_push($arrRolesUsuarios, $datos);
               }

          $returnDatos = array($roles,$arrRolesUsuarios);
		return View::make('procesos.crearProceso')->with("datos",$returnDatos);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
	
			$siguientePagina = Input::get('siguientePagina');
		     $finalizarProceso = Input::get('finalizarProceso');
		     $tareaParalela = Input::get('tareaParalela');		     

		              
				$rules = array(
			'nombreProceso' => 'required|max:20',
			'descripcionProceso' => 'max:200',
			'descripcionPaso' => 'required|max:200',
			'diasLimite'      => 'required|numeric',
		     'usuariosTarea' => 'required',
		);
		
		$messages = array(
    'alpha' => 'El campo debe contener solo letras',
    'nombreProceso.max' => 'El campo debe tener un maximo de 200 caracteres',
    'descripcionPaso.max' => 'La descipcion debe tener  hasta 200 caracteres',
    'descripcionProceso.max' => 'La descipcion debe tener  hasta 200 caracteres',
    'diasLimite.required' => 'Campo de diass requerido',
    'usuariosTarea.required' => 'Selecciona almenos un usuario',    
    'numeric' => 'El campo debe ser numerico y mayor o igual a 0',		
    'required' => 'El campo es requerido',   
    );
    
		$validator = Validator::make(Input::all(), $rules, $messages);
		$diasLimite = Input::get('diasLimite');
		if($diasLimite < 0)
		Session::flash('diasLimite', 'El campo no puede ser negativo');
		// process the login
		if ($validator->fails() || $diasLimite < 0) {
			     return Redirect::to('/procesos/create')
				->withErrors($validator)->withInput(Input::all());
		} else {
		    $nombreProceso = Input::get('nombreProceso');
		    $descripcionProceso = Input::get('descripcionProceso');
		    $descripcionPaso = Input::get('descripcionPaso');
		    $usuariosTarea = Input::get('usuariosTarea');
		    $diasLimite = Input::get('diasLimite');
		    $archivo = Input::file('archivo');
		    $rol = Input::get('rol');
		    $emailCreador = Session::get('emailUsuario');		    
		    
		    /*if($archivo->getSize() > 10240){
		          Session::flash('errorArchivo', 'El archivo debe ser menor a 10Mb');
		          return Redirect::to('/procesos/create');		    
		    }*/		    
		     $nombreRol = DB::table('roles')->where('id', $rol)->pluck('nombre'); 
		    
		     $proceso = DB::table('procesos')->where('nombre', $nombreProceso)->first();
		     
		     if(isset($proceso)){
		          Session::flash('errorCrearProceso', 'Ya existe un proceso con el mismo nombre');
		          return Redirect::to('/procesos/create');
		     }
		     
		     $createdate= date('Y-m-d H:i:s');   
		     		     
		     DB::table('procesos')->insert(array('nombre' => strtoupper($nombreProceso), 'descripcion' => strtoupper($descripcionProceso), 'emailCreador' => $emailCreador,'estado' => 'pendiente', 'created_at' => $createdate));
		     
               $idProceso = DB::table('procesos')->where('nombre', $nombreProceso)->pluck('id'); 		                   
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
		     
		     DB::table('tareas')->insert(array('nombre' => strtoupper($descripcionPaso), 'descripcion' => strtoupper($descripcionPaso), 'diasLimite' => $diasLimite, 'estado' => 'pendiente', 'file' => $path, 'idProceso' => $idProceso, 'nameFile' => $nameFile, 'nombreRol' => $nombreRol, 'created_at' => $createdate));
		     
		     $tareaProceso = DB::table('tareas')->orderBy('created_at', 'desc')->first();
		                    
               foreach($usuariosTarea as $usuario){
		     DB::table('usuario_Tareas')->insert(array('emailUsuario' => $usuario, 'idTarea' => $tareaProceso->id, 'created_at' => $createdate));
               }		                    
		                    
		      if(isset($finalizarProceso)){
		      Session::flash('message', 'Proceso creado');
			     return Redirect::to('/procesos');
			}elseif(isset($siguientePagina)){
			     return Redirect::to('/procesos/tareas/create/'.$idProceso);
			}else{  
			$codigo = uniqid();
		     $createdate= date('Y-m-d H:i:s');   			
                    DB::table('tareas')->insert(array('nombre' => $codigo,'idProceso' => $idProceso,'created_at' => $createdate));
               $idTareaNormal = DB::table('tareas')->where('nombre', $codigo)->pluck('id');
			     return Redirect::to('/procesos/tareas/create/paralela/'.$idTareaNormal);	
			}             
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
		$tareas = DB::table('tareas')->where('idProceso', $id)->get();
		$Proceso = DB::table('procesos')->where('id', $id)->first();
		
	     $tareasTotales = array();
	     $trClass = array();

          if($Proceso->estado == "pendiente"){	     
	          foreach($tareas as $tarea){
	               $tareasParalelas = DB::table('tareasParalelas')->where('idTareaNormal', $tarea->id)->get();
	               if($tareasParalelas){
                         foreach($tareasParalelas as $tareaParalela){
	                        array_push($tareasTotales, $tareaParalela);	  
	                        array_push($trClass, "info");	                              	                                               
                         }	          
	               }else{
	                    array_push($tareasTotales, $tarea);
	                        array_push($trClass, "");
	               }
	          }
	          
		     $returnDatos = array($tareasTotales,$Proceso,$trClass);
		     return View::make('tareas.administracionTareas')->with('datos', $returnDatos);
		
		}else{
		     $respuestasTotales = array();
	          foreach($tareas as $tarea){
	               $tareasParalelas = DB::table('tareasParalelas')->where('idTareaNormal', $tarea->id)->get();
	               if($tareasParalelas){
                         foreach($tareasParalelas as $tareaParalela){
	                        array_push($tareasTotales, $tareaParalela);	  
	                        array_push($trClass, "info");
	                        
          $respuestaParalela = DB::table('respuestasTareasParalelas')
            ->join('usuario_TareasParalelas', 'usuario_TareasParalelas.idRespuesta', '=', 'respuestasTareasParalelas.id')          
            ->join('tareasParalelas', 'usuario_TareasParalelas.idTarea', '=', 'tareasParalelas.id')
            ->select('respuestasTareasParalelas.comentarios','respuestasTareasParalelas.file', 'respuestasTareasParalelas.nameFile')
            ->where('tareasParalelas.id', $tareaParalela->id)->get(); 	                        

	                    array_push($respuestasTotales, $respuestaParalela);       	                                               
                         }	          
	               }else{
	                    array_push($tareasTotales, $tarea);
	                        array_push($trClass, "");
	                        
          $respuestaNormal = DB::table('respuestasTareas')
            ->join('usuario_Tareas', 'usuario_Tareas.idRespuesta', '=', 'respuestasTareas.id')          
            ->join('tareas', 'usuario_Tareas.idTarea', '=', 'tareas.id')
            ->select('respuestasTareas.comentarios','respuestasTareas.file', 'respuestasTareas.nameFile')
            ->where('tareas.id', $tarea->id)->get(); 	   
            
	                    array_push($respuestasTotales, $respuestaNormal);
	               }
	          }
	          
		     $returnDatos = array($tareasTotales,$Proceso,$trClass,$respuestasTotales);
		     return View::make('procesos.mostrarProceso')->with('datos', $returnDatos);
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
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
		$tareas = DB::table('tareas')->where('idProceso', $id)->get();
		
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
		
	     DB::table('procesos')->where('id',$id)->delete();	
	     Session::flash('message', 'Proceso eliminado correctamente');
	     return Redirect::to('/procesos');	     	     	
	}
	
	/** Funcion para ajax
	 *  Realiza la peticion para extraer los usuario con respecto al rol
	 */ 
	public function usuariosRoles()
	{
	     $rol = Input::get('rol');
          
         // $usuarios = DB::table('usuario_roles')->where('idRol', $rol)->lists('usuarioEmail');
          $usuarios = DB::select('SELECT *
                                  FROM (SELECT *
                                        FROM adminSecundarios
                                        UNION
                                        SELECT *
                                        FROM usuarioNormales) b
                                  WHERE b.email IN (SELECT usuarioEmail 
                                                    FROM usuario_roles 
                                                    WHERE idRol = ?)', array($rol)); 
          $salida = "";                                                          
          foreach($usuarios as $usuario){
	          $salida .= "<input type='checkbox' name='usuariosTarea[]' value='".$usuario->email."'>"." ".$usuario->name." ".$usuario->plast_name."</input><br>";
	     }
	     
	     echo $salida;
	}

	/** Funcion para iniciar la ejecucion de un Proceso
	 *  
	 */ 	
     public function iniciarProceso($id)
	{
	     $proceso = DB::table('procesos')->where('id', $id)->first();
	     
	if($proceso->estado != 'ejecutando'){
	     $tarea = DB::table('tareas')->where('idProceso',$id)->orderBy('created_at', 'asc')->first();
	     $tareasParalelasNormal = DB::table('tareasParalelas')->where('idTareaNormal',$tarea->id)->get();
	     if($tareasParalelasNormal){
	          foreach($tareasParalelasNormal as $tareaParalela){
	               $usuarios = DB::table('usuario_TareasParalelas')->where('idTarea',$tareaParalela->id)->get();
	               foreach($usuarios as $usuario){
	                    $renglonUsuario = DB::table('adminSecundarios')->where('email', $usuario->emailUsuario)->first();
	                    if($renglonUsuario){}else{
	                          $renglonUsuario = DB::table('usuarioNormales')->where('email', $usuario->emailUsuario)->first();	                    
	                    }
                            Mail::send('emails.nuevaTarea', array('firstname'=>$renglonUsuario->name), function($message) use ($renglonUsuario){$message->to($renglonUsuario->email, $renglonUsuario->name.' '.$renglonUsuario->plast_name)->subject('Tec WorkFlow Engine - Nueva Tarea');});
	               }
	               
	               $stringDias = $tarea->diasLimite." days";
                         $hoy = date("y-m-d");
                         $formatoHoy = date_create($hoy);
                         $fechaInicio = date_format($formatoHoy, 'Y-m-d');
                         date_add($formatoHoy, date_interval_create_from_date_string($stringDias));
                         $fechaTermino = date_format($formatoHoy, 'Y-m-d');
                         
		          DB::table('tareasParalelas')->where('id',$tareaParalela->id)->update(array('estado' => 'ejecutando','fechaInicio' => $fechaInicio,'fechaTermino' => $fechaTermino));
	          }
	     }else{
	     
	     
	     
	          $usuarios = DB::table('usuario_Tareas')->where('idTarea',$tarea->id)->get();
	          foreach($usuarios as $usuario){
	               $renglonUsuario = DB::table('adminSecundarios')->where('email', $usuario->emailUsuario)->first();
	               if($renglonUsuario){}else{
	                    $renglonUsuario = DB::table('usuarioNormales')->where('email', $usuario->emailUsuario)->first();	                    
	                }
                    Mail::send('emails.nuevaTarea', array('firstname'=>$renglonUsuario->name), function($message) use ($renglonUsuario){$message->to($renglonUsuario->email, $renglonUsuario->name.' '.$renglonUsuario->plast_name)->subject('Tec WorkFlow Engine - Nueva Tarea');});	               
	          }
	          
	               $stringDias = $tarea->diasLimite." days";
	                    $hoy = date("y-m-d");
                         $formatoHoy = date_create($hoy);
                         $fechaInicio = date_format($formatoHoy, 'Y-m-d');
                         date_add($formatoHoy, date_interval_create_from_date_string($stringDias));
                         $fechaTermino = date_format($formatoHoy, 'Y-m-d');
                         
		     DB::table('tareas')->where('id',$tarea->id)->update(array('estado' => 'ejecutando','fechaInicio' => $fechaInicio,'fechaTermino' => $fechaTermino));
	     }
	     
		DB::table('procesos')->where('id',$id)->update(array('estado' => 'ejecutando')); 
	     Session::flash('message', 'El proceso '.$proceso->nombre.' inició');
	     return Redirect::to('/procesos');			
	}else{
	     Session::flash('message', 'El proceso '.$proceso->nombre.' esta en ejecucion');
	     return Redirect::to('/procesos');	  	
	}	
   	     	
	}

}
