<?php

class tareaParalelaController extends \BaseController {

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
		return View::make('tareasParalelas.crearTarea')->with("datos",$returnDatos);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
               $finalizarParalela = Input::get('finalizarParalela');
		     $finalizarProceso = Input::get('finalizarProceso');
		     $tareaParalela = Input::get('tareaParalela');		     		     
		     $idTareaNormal = Input::get('idTareaNormal');
		              
				$rules = array(
			'descripcionPaso' => 'required|max:200',
			'diasLimite'      => 'required|numeric',
		     'usuariosTarea' => 'required',
		);
		
		$messages = array(
    'alpha' => 'El campo debe contener solo letras',
    'descripcionPaso.max' => 'La descipcion debe tener  hasta 200 caracteres',
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
			     return Redirect::to('/procesos/tareas/create/paralela/'.$idTareaNormal)
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
		     
		                    DB::table('tareasParalelas')->insert(array('nombre' => strtoupper($descripcionPaso), 'descripcion' => strtoupper($descripcionPaso), 'diasLimite' => $diasLimite, 'estado' => 'pendiente', 'file' => $path, 'idTareaNormal' => $idTareaNormal, 'nameFile' => $nameFile, 'nombreRol' => $nombreRol, 'created_at' => $createdate));
		                    
		     $tareaParalelaProceso = DB::table('tareasParalelas')->orderBy('created_at', 'desc')->first();                   
               foreach($usuariosTarea as $usuario){
		     DB::table('usuario_TareasParalelas')->insert(array('emailUsuario' => $usuario, 'idTarea' => $tareaParalelaProceso->id, 'created_at' => $createdate));
               }		                    
		                    
		      if(isset($finalizarProceso)){
		      Session::flash('message', 'Proceso creado');
			     return Redirect::to('/procesos');
			}elseif(isset($tareaParalela)){
			     return Redirect::to('/procesos/tareas/create/paralela/'.$idTareaNormal);		
			}else{
			     $idProceso = DB::table('tareas')->where('id', $idTareaNormal)->pluck('idProceso');  
			     return Redirect::to('/procesos/tareas/create/'.$idProceso);                    
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
          $tareaParalela = DB::table('tareasParalelas')->where('id', $id)->first();
		$idProceso = DB::table('tareas')->where('id', $tareaParalela->idTareaNormal)->pluck('idProceso');    
		$nombreProceso = DB::table('procesos')->where('id', $idProceso)->pluck('nombre');
		$responsables = DB::table('usuario_TareasParalelas')->where('idTarea', $id)->lists('emailUsuario');
		
		$usuarios = "";
		foreach($responsables as $responsable){
		$usuarios .= $responsable.". ";
		}		
		
		$returnDatos = array($tareaParalela,$nombreProceso,$usuarios);
		return View::make('tareasParalelas.show')->with("datos",$returnDatos);	
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
          $tareaParalela = DB::table('tareasParalelas')->where('id', $id)->first();
          $idProceso = DB::table('tareas')->where('id', $tareaParalela->idTareaNormal)->pluck('idProceso');
		$estadoProceso = DB::table('procesos')->where('id', $idProceso)->pluck('estado');
		
		if($estadoProceso == "pendiente"){	
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
          
		$nombreProceso = DB::table('procesos')->where('id', $idProceso)->pluck('nombre');
          $responsables = DB::table('usuario_TareasParalelas')->where('idTarea', $id)->lists('emailUsuario');
          
          $nombreRol = $tareaParalela->nombreRol;
          
          $returnDatos = array($roles,$arrRolesUsuarios,$tareaParalela,$nombreProceso,$responsables,$nombreRol);
		return View::make('tareasParalelas.edit')->with("datos",$returnDatos);
		
		}else{
		          Session::flash('errorEliminar', 'Error: Tarea en un proceso en ejecucion');
	               Session::flash('message', 'Error: Tarea en un proceso en ejecucion');
	               return Redirect::to('/procesos');   		
		}	
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
			'descripcionPaso' => 'required|max:200',
			'diasLimite'      => 'required|numeric',
		     'usuariosTarea' => 'required',
		);
		
		$messages = array(
    'alpha' => 'El campo debe contener solo letras',
    'descripcionPaso.max' => 'La descipcion debe tener  hasta 200 caracteres',
    'diasLimite.required' => 'Campo de dias requerido',
    'usuariosTarea.required' => 'Selecciona almenos un usuario',        
    'numeric' => 'El campo debe ser numerico',	
    'required' => 'El campo es requerido',
    );
    
		$validator = Validator::make(Input::all(), $rules, $messages);
		    $diasLimite = Input::get('diasLimite');
		if($diasLimite < 0)
		Session::flash('diasLimite', 'El campo no puede ser negativo');		    

		if ($validator->fails() || $diasLimite < 0) {
			     return Redirect::to('/procesos/tareas/paralela/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::all());
		} else {
		    $tareaParalela = DB::table('tareasParalelas')->where('id', $id)->first();
              $idProceso = DB::table('tareas')->where('id', $tareaParalela->idTareaNormal)->pluck('idProceso');  
          
		    $descripcionPaso = Input::get('descripcionPaso');
		    $usuariosTarea = Input::get('usuariosTarea');
		    $diasLimite = Input::get('diasLimite');
		    $archivo = Input::file('archivo');
		    $rol = Input::get('rol');
               
               $nombreRol = DB::table('roles')->where('id', $rol)->pluck('nombre');                  

               $updatedDate = date('Y-m-d H:i:s');
                                               
               if(isset($archivo)){
                    File::delete(public_path().$tareaParalela->file);
                    $path="";
                    $nameFile ="Ninguno"; 
                    $nameFile = $archivo->getClientOriginalName();               
                    $nombre = uniqid();
		          $nombre .= "_".$archivo->getClientOriginalName();
		          Input::file('archivo')->move('uploads', $nombre);	
		          $path = "/uploads/".$nombre;//////////////////////////////////////////////////

		          DB::table('tareasParalelas')->where('id',$id)->update(array('nombre' => strtoupper($descripcionPaso), 'descripcion' => strtoupper($descripcionPaso), 'diasLimite' => $diasLimite, 'estado' => 'pendiente', 'file' => $path, 'nameFile' => $nameFile, 'nombreRol' => $nombreRol, 'updated_at' => $updatedDate));  
		     } else{
		          DB::table('tareasParalelas')->where('id',$id)->update(array('nombre' => strtoupper($descripcionPaso), 'descripcion' => strtoupper($descripcionPaso), 'diasLimite' => $diasLimite, 'estado' => 'pendiente', 'nombreRol' => $nombreRol, 'updated_at' => $updatedDate)); 		     		     
		     }
		     
		     DB::table('usuario_TareasParalelas')->where('idTarea',$id)->delete();
		    
               $createdate = date('Y-m-d H:i:s');	
               		    
		     foreach($usuariosTarea as $usuario){
		     DB::table('usuario_TareasParalelas')->insert(array('emailUsuario' => $usuario, 'idTarea' => $id, 'created_at' => $createdate));
               }

		          Session::flash('message', 'Tarea editada correctamente');
			     return Redirect::to('/procesos/'.$idProceso);            
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
	          $tareaParalela = DB::table('tareasParalelas')->where('id', $id)->first(); 
	          $idTareaNormal = $tareaParalela->idTareaNormal;	
          $idProceso = DB::table('tareas')->where('id', $idTareaNormal)->pluck('idProceso');
		$estadoProceso = DB::table('procesos')->where('id', $idProceso)->pluck('estado');
		if($estadoProceso == 'pendiente'){				     
	          
	          $respuestasParalelas = DB::table('usuario_TareasParalelas')->where('idTarea', $tareaParalela->id)->lists('idRespuesta');  
	                          
	               foreach($respuestasParalelas as $respuesta){
	                    $respuestaP = DB::table('respuestasTareasParalelas')->where('id',$respuesta)->first();
	                    if($respuestaP)
	                    File::delete(public_path().$respuestaP->file);		
	                    DB::table('respuestasTareasParalelas')->where('id',$respuesta)->delete();
	               }  
	               	     
	          File::delete(public_path().$tareaParalela->file);
		     DB::table('usuario_TareasParalelas')->where('idTarea',$id)->delete();	     
	          DB::table('tareasParalelas')->where('id',$id)->delete();
	              	     
	          
	          $tareasParalelasNormal = DB::table('tareasParalelas')->where('idTareaNormal',$idTareaNormal)->get();
	          
	          if($tareasParalelasNormal){	     	     
	               Session::flash('message', 'Tarea eliminada correctamente');
	               return Redirect::to('/procesos/'.$idProceso);
	          }
	          
	          DB::table('tareas')->where('id',$idTareaNormal)->delete();
	          $tareasProceso = DB::table('tareas')->where('idProceso',$idProceso)->get();     
	          
	          if($tareasProceso){	
	               Session::flash('message', 'Tarea eliminada correctamente');
	               return Redirect::to('/procesos/'.$idProceso);
	          }else{
	               DB::table('procesos')->where('id',$idProceso)->delete();	
	               Session::flash('message', 'Proceso eliminado correctamente');
	               return Redirect::to('/procesos');	 	     
	          }	
	     }else{
		          Session::flash('errorEliminar', 'Error: Tarea en un proceso en ejecucion');
	               Session::flash('message', 'Error: Tarea en un proceso en ejecucion');
	               return Redirect::to('/procesos/'.$idProceso);    
	     }     
	}

}
