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
		     $idProceso = Input::get('idProceso');
		              
				$rules = array(
			'descripcionPaso' => 'required|max:200',
			'fechaLimite'      => 'required',
			'horaLimite' => 'required',
		     'usuariosTarea' => 'required',
			'amOpm' => 'required',
		);
		
		$messages = array(
    'alpha' => 'El campo debe contener solo letras',
    'descripcionPaso.max' => 'La descipcion debe tener  hasta 200 caracteres',
    'fechaLimite.required' => 'Campo de fecha requerido',		
    'required' => 'El campo es requerido',
    );
    
		$validator = Validator::make(Input::all(), $rules, $messages);

		// process the login
		if ($validator->fails()) {
		     if(isset($finalizarProceso)){
			     return Redirect::to('/procesos/tareas/create/'.$idProceso)
				->withErrors($validator);
			}else{
			     return Redirect::to('/procesos/tareas/create/'.$idProceso)
				->withErrors($validator);
			}	
		} else {
		    $descripcionPaso = Input::get('descripcionPaso');
		    $usuariosTarea = Input::get('usuariosTarea');
		    $fechaLimite = Input::get('fechaLimite');
		    $horaLimite = Input::get('horaLimite');
		    $amOpm = Input::get('amOpm');
		    $archivo = Input::file('archivo');
		    $rol = Input::get('rol');
               
               $nombreRol = DB::table('roles')->where('id', $rol)->pluck('nombre'); 
               
               //Crear un string con los usuarios de UsuariosTarea EXPLODE
               $responsables = "";/////////////////////////////////////////////////////////////////
               foreach($usuariosTarea as $usuario){
                    $responsables .= $usuario." ";
               }		     
		     
               
               //Crear formato para la columna datetime
              $datosFecha = explode("/", $fechaLimite);		    
		    $dateTime = $datosFecha[2]."-".$datosFecha[0]."-".$datosFecha[1]." ";
		    
		    if($amOpm=="PM" && $horaLimite != 00 && $horaLimite != 12){
		         $horaLimite += 12;
		         $horaLimite = $horaLimite.":00:00";
		    }else{
		          $horaLimite = $horaLimite.":00:00";
		    }
		    
		    $dateTime .= " ".$horaLimite;////////////////////////////////////////////////////
               
               $path="";
               $nameFile ="Ninguno";               
               if(isset($archivo)){
                    $nameFile = $archivo->getClientOriginalName();               
                    $nombre = uniqid();
		          $nombre .= "_".$archivo->getClientOriginalName();
		          Input::file('archivo')->move('uploads', $nombre);	
		          $path = "/uploads/".$nombre;//////////////////////////////////////////////////   
		     }    
		     
		                    DB::table('tareas')->insert(array('nombre' => strtoupper($descripcionPaso), 'descripcion' => strtoupper($descripcionPaso), 'fechaLimite' => $dateTime, 'responsable' => $responsables, 'estado' => 'pendiente', 'file' => $path, 'idProceso' => $idProceso, 'nameFile' => $nameFile, 'nombreRol' => $nombreRol));
		                    
		      if(isset($finalizarProceso)){
		      Session::flash('message', 'Proceso creado');
			     return Redirect::to('/procesos');
			}else{
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
          $tarea = DB::table('tareas')->where('id', $id)->first();
		$nombreProceso = DB::table('procesos')->where('id', $tarea->idProceso)->pluck('nombre');
		
		$returnDatos = array($tarea,$nombreProceso);
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
          
          $tarea = DB::table('tareas')->where('id', $id)->first();
		$nombreProceso = DB::table('procesos')->where('id', $tarea->idProceso)->pluck('nombre');
          $responsables = explode(" ", $tarea->responsable);
          
          $fechaTarea = explode(" ",$tarea->fechaLimite);
          $fechaPartes = explode("-",$fechaTarea[0]);
          $fecha = $fechaPartes[1]."/".$fechaPartes[2]."/".$fechaPartes[0];
          
          $horaTarea = explode(":",$fechaTarea[1]);
          $hora = $horaTarea[0];
          $amOpm = "AM";
          
          if($hora > 12){
          $hora = $hora-12;
          $amOpm = "PM";
          }

          $nombreRol = $tarea->nombreRol;
          
          $returnDatos = array($roles,$arrRolesUsuarios,$tarea,$nombreProceso,$responsables,$fecha,$hora,$amOpm,$nombreRol);
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
			'descripcionPaso' => 'required|max:200',
			'fechaLimite'      => 'required',
			'horaLimite' => 'required',
			'usuariosTarea' => 'required',
			'amOpm' => 'required',
		);
		
		$messages = array(
    'alpha' => 'El campo debe contener solo letras',
    'descripcionPaso.max' => 'La descipcion debe tener  hasta 200 caracteres',
    'fechaLimite.required' => 'Campo de fecha requerido',		
    'required' => 'El campo es requerido',
    );
    
		$validator = Validator::make(Input::all(), $rules, $messages);

		// process the login
		if ($validator->fails()) {
			     return Redirect::to('/procesos/tareas/'.$id.'/edit')
				->withErrors($validator)
				->withInput(Input::all());
		} else {
		    $tarea = DB::table('tareas')->where('id', $id)->first();

		    $descripcionPaso = Input::get('descripcionPaso');
		    $usuariosTarea = Input::get('usuariosTarea');
		    $fechaLimite = Input::get('fechaLimite');
		    $horaLimite = Input::get('horaLimite');
		    $amOpm = Input::get('amOpm');
		    $archivo = Input::file('archivo');
		    $rol = Input::get('rol');
               
               $nombreRol = DB::table('roles')->where('id', $rol)->pluck('nombre'); 
               
               //Crear un string con los usuarios de UsuariosTarea EXPLODE
               $responsables = "";/////////////////////////////////////////////////////////////////
               foreach($usuariosTarea as $usuario){
                    $responsables .= $usuario." ";
               }		     
		     
               
               //Crear formato para la columna datetime
              $datosFecha = explode("/", $fechaLimite);		    
		    $dateTime = $datosFecha[2]."-".$datosFecha[0]."-".$datosFecha[1]." ";
		    
		    if($amOpm=="PM" && $horaLimite != 00 && $horaLimite != 12){
		         $horaLimite += 12;
		         $horaLimite = $horaLimite.":00:00";
		    }else{
		          $horaLimite = $horaLimite.":00:00";
		    }
		    
		    $dateTime .= " ".$horaLimite;////////////////////////////////////////////////////
                             
               if(isset($archivo)){
                    File::delete(public_path().$tarea->file);
                    $path="";
                    $nameFile ="Ninguno"; 
                    $nameFile = $archivo->getClientOriginalName();               
                    $nombre = uniqid();
		          $nombre .= "_".$archivo->getClientOriginalName();
		          Input::file('archivo')->move('uploads', $nombre);	
		          $path = "/uploads/".$nombre;//////////////////////////////////////////////////

		          DB::table('tareas')->where('id',$id)->update(array('nombre' => strtoupper($descripcionPaso), 'descripcion' => strtoupper($descripcionPaso), 'fechaLimite' => $dateTime, 'responsable' => $responsables, 'estado' => 'pendiente', 'file' => $path, 'nameFile' => $nameFile, 'nombreRol' => $nombreRol));  
		     } else{
		          DB::table('tareas')->where('id',$id)->update(array('nombre' => strtoupper($descripcionPaso), 'descripcion' => strtoupper($descripcionPaso), 'fechaLimite' => $dateTime, 'responsable' => $responsables, 'estado' => 'pendiente', 'nombreRol' => $nombreRol)); 		     		     
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
	     
	     File::delete(public_path().$tarea->file);
	     DB::table('tareas')->where('id',$id)->delete();
	     
	     $tareasProceso = DB::table('tareas')->where('idProceso',$idProceso)->get();
	     
	     if($tareasProceso){	     	     
	          Session::flash('message', 'Tarea eliminada correctamente');
	          return Redirect::to('/procesos/'.$tarea->idProceso);
	     }else{
	          DB::table('procesos')->where('id',$id)->delete();	
	          Session::flash('message', 'Proceso eliminado correctamente');
	          return Redirect::to('/procesos');	     
	     }
	     
	}

}
