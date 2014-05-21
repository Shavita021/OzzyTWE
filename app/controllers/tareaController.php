<?php

class tareaController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
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

          $returnDatos = array($roles,$arrRolesUsuarios,$id);
		return View::make('tareas.crearTarea')->with("datos",$returnDatos);
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
		     $idProceso = Input::get('idProceso');
		              
				$rules = array(
			'descripcionPaso' => 'required|max:500',
			'diasLimite'      => 'required|numeric',
		     'usuariosTarea' => 'required',
		);
		
		$messages = array(
    'alpha' => 'El campo debe contener solo letras',
    'descripcionPaso.max' => 'La descipcion debe tener  hasta 500 caracteres',
    'diasLimite.required' => 'Campo de dias requerido',
    'numeric' => 'El campo debe ser numerico',	
    'required' => 'El campo es requerido',
    );
    
		$validator = Validator::make(Input::all(), $rules, $messages);
          $diasLimite = Input::get('diasLimite');
		if($diasLimite < 0)
		Session::flash('diasLimite', 'El campo no puede ser negativo');          
		// process the login
		if ($validator->fails() || $diasLimite < 0) {
			     return Redirect::to('/procesos/tareas/create/'.$idProceso)
				->withErrors($validator)->withInput(Input::all());
		} else {
		    $descripcionPaso = Input::get('descripcionPaso');
		    $usuariosTarea = Input::get('usuariosTarea');
		    $diasLimite = Input::get('diasLimite');
		    $archivo = Input::file('archivo');
		    $rol = Input::get('rol');
               
               $nombreRol = DB::table('roles')->where('id', $rol)->pluck('nombre'); 
               	     		                              
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

          $tarea = DB::table('tareas')->where('id', $id)->first();
		$nombreProceso = DB::table('procesos')->where('id', $tarea->idProceso)->pluck('nombre');
		$responsables = DB::table('usuario_Tareas')->where('idTarea', $id)->lists('emailUsuario');
		
		$usuarios = "";
		foreach($responsables as $responsable){
		$usuarios .= $responsable.". ";
		}
		
		$returnDatos = array($tarea,$nombreProceso,$usuarios);
		return View::make('tareas.show')->with("datos",$returnDatos);		
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
          $tarea = DB::table('tareas')->where('id', $id)->first();	
          $instanciasProcesos = DB::table('procesos')
            ->join('instanciasProcesos', 'instanciasProcesos.idProcesoOriginal', '=', 'procesos.id')
            ->select('instanciasProcesos.id')
            ->where('procesos.id', $tarea->idProceso)            
            ->whereIn('instanciasProcesos.estado', array('pendiente','ejecutando'))            
            ->first();
            
          if($instanciasProcesos){
		          Session::flash('errorEliminar', 'Error: Tarea en un proceso en ejecución');
	               Session::flash('message', 'Error: Tarea en un proceso en ejecución');
	               return Redirect::to('/procesos/'.$tarea->idProceso);             
          }
		
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
          
		$nombreProceso = DB::table('procesos')->where('id', $tarea->idProceso)->pluck('nombre');
          $responsables = DB::table('usuario_Tareas')->where('idTarea', $id)->lists('emailUsuario');
          
          $nombreRol = $tarea->nombreRol;
          
          $returnDatos = array($roles,$arrRolesUsuarios,$tarea,$nombreProceso,$responsables,$nombreRol);
		return View::make('tareas.edit')->with("datos",$returnDatos);
		
		
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		              
				$rules = array(
			'descripcionPaso' => 'required|max:500',
			'diasLimite'      => 'required|numeric',
		     'usuariosTarea' => 'required',
		);
		
		$messages = array(
    'alpha' => 'El campo debe contener solo letras',
    'descripcionPaso.max' => 'La descipcion debe tener  hasta 500 caracteres',
    'diasLimite.required' => 'Campo de dias requerido',
    'numeric' => 'El campo debe ser numerico',
    'usuariosTarea.required' => 'Selecciona almenos un usuario',        	
    'required' => 'El campo es requerido',
    );
    
		$validator = Validator::make(Input::all(), $rules, $messages);
          $diasLimite = Input::get('diasLimite');
		if($diasLimite < 0)
		Session::flash('diasLimite', 'El campo no puede ser negativo');          
		// process the login
		if ($validator->fails() || $diasLimite < 0) {
			     return Redirect::to('/procesos/tareas/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::all());
		} else {
		    $tarea = DB::table('tareas')->where('id', $id)->first();

		    $descripcionPaso = Input::get('descripcionPaso');
		    $usuariosTarea = Input::get('usuariosTarea');
		    $diasLimite = Input::get('diasLimite');
		    $archivo = Input::file('archivo');
		    $rol = Input::get('rol');
               
               $nombreRol = DB::table('roles')->where('id', $rol)->pluck('nombre');           

               $updatedDate = date('Y-m-d H:i:s');
                                               
               if(isset($archivo)){
                    File::delete(public_path().$tarea->file);
                    $path="";
                    $nameFile ="Ninguno"; 
                    $nameFile = $archivo->getClientOriginalName();               
                    $nombre = uniqid();
		          $nombre .= "_".$archivo->getClientOriginalName();
		          Input::file('archivo')->move('uploads', $nombre);	
		          $path = "/uploads/".$nombre;//////////////////////////////////////////////////

		          DB::table('tareas')->where('id',$id)->update(array('nombre' => strtoupper($descripcionPaso), 'descripcion' => strtoupper($descripcionPaso), 'diasLimite' => $diasLimite, 'estado' => 'pendiente', 'file' => $path, 'nameFile' => $nameFile, 'nombreRol' => $nombreRol, 'updated_at' => $updatedDate));  
		     } else{
		          DB::table('tareas')->where('id',$id)->update(array('nombre' => strtoupper($descripcionPaso), 'descripcion' => strtoupper($descripcionPaso), 'diasLimite' => $diasLimite, 'estado' => 'pendiente', 'nombreRol' => $nombreRol, 'updated_at' => $updatedDate)); 		     		     
		     }
		     
		    DB::table('usuario_Tareas')->where('idTarea',$id)->delete();
		    
               $createdate = date('Y-m-d H:i:s');	
               	    
		     foreach($usuariosTarea as $usuario){
		     DB::table('usuario_Tareas')->insert(array('emailUsuario' => $usuario, 'idTarea' => $id, 'created_at' => $createdate));
               }

		          Session::flash('message', 'Tarea editada correctamente');
			     return Redirect::to('/procesos/'.$tarea->idProceso);            
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
	     $tarea = DB::table('tareas')->where('id', $id)->first(); 	
	     $idProceso = $tarea->idProceso;	    	

		  $instanciasProcesos = DB::table('procesos')
            ->join('instanciasProcesos', 'instanciasProcesos.idProcesoOriginal', '=', 'procesos.id')
            ->select('instanciasProcesos.id')
            ->where('procesos.id', $idProceso)            
            ->whereIn('instanciasProcesos.estado', array('pendiente','ejecutando'))            
            ->first();
            
          if($instanciasProcesos){
		          Session::flash('errorEliminar', 'Error: Tarea en un proceso en ejecución');
	               Session::flash('message', 'Error: Tarea en un proceso en ejecución');
	               return Redirect::to('/procesos/'.$idProceso);                
          }
	          
	          /*$respuestasNormales = DB::table('usuario_Tareas')->where('idTarea', $tarea->id)->lists('idRespuesta');
	                          
	          foreach($respuestasNormales as $respuesta){
	               $respuestaP = DB::table('respuestasTareas')->where('id',$respuesta)->first();
	               if($respuestaP)
	               File::delete(public_path().$respuestaP->file);		
	               DB::table('respuestasTareas')->where('id',$respuesta)->delete();
	          } */  	     
	          
	          File::delete(public_path().$tarea->file);
		     DB::table('usuario_Tareas')->where('idTarea',$id)->delete();	     
	          DB::table('tareas')->where('id',$id)->delete();
	          
	          $tareasProceso = DB::table('tareas')->where('idProceso',$idProceso)->get();
	          
	          if($tareasProceso){	     	     
	               Session::flash('message', 'Tarea eliminada correctamente');
	               return Redirect::to('/procesos/'.$tarea->idProceso);
	          }else{
	               DB::table('procesos')->where('id',$idProceso)->delete();	
	               Session::flash('message', 'Proceso eliminado correctamente');
	               return Redirect::to('/procesos');	     
	          }    
	     
	}

}
