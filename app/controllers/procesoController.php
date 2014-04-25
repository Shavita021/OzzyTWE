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
		$procesos = DB::table('procesos')->get();
	     return View::make('procesos.administracionProcesos')->with("procesos",$procesos);
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

		              
				$rules = array(
			'nombreProceso' => 'required|max:20',
			'descripcionProceso' => 'max:200',
			'descripcionPaso' => 'required|max:200',
			'fechaLimite'      => 'required',
			'horaLimite' => 'required',
		     'usuariosTarea' => 'required',
			'amOpm' => 'required',
		);
		
		$messages = array(
    'alpha' => 'El campo debe contener solo letras',
    'nombreProceso.max' => 'El campo debe tener un maximo de 200 caracteres',
    'descripcionPaso.max' => 'La descipcion debe tener  hasta 200 caracteres',
    'descripcionProceso.max' => 'La descipcion debe tener  hasta 200 caracteres',
    'fechaLimite.required' => 'Campo de fecha requerido',		
    'required' => 'El campo es requerido',
    );
    
		$validator = Validator::make(Input::all(), $rules, $messages);

		// process the login
		if ($validator->fails()) {
		     if(isset($finalizarProceso)){
			     return Redirect::to('/procesos/create')
				->withErrors($validator);
			}else{
			     return Redirect::to('/procesos/create')
				->withErrors($validator);
			}	
		} else {
		    $nombreProceso = Input::get('nombreProceso');
		    $descripcionProceso = Input::get('descripcionProceso');
		    $descripcionPaso = Input::get('descripcionPaso');
		    $usuariosTarea = Input::get('usuariosTarea');
		    $fechaLimite = Input::get('fechaLimite');
		    $horaLimite = Input::get('horaLimite');
		    $amOpm = Input::get('amOpm');
		    $archivo = Input::file('archivo');
		    $rol = Input::get('rol');
		    
		     $nombreRol = DB::table('roles')->where('id', $rol)->pluck('nombre'); 
		    
		     $proceso = DB::table('procesos')->where('nombre', $nombreProceso)->first();
		     
		     if(isset($proceso)){
		          Session::flash('errorCrearProceso', 'Ya existe un proceso con el mismo nombre');
		          return Redirect::to('/procesos/create');
		     }
		     
		     DB::table('procesos')->insert(array('nombre' => strtoupper($nombreProceso), 'descripcion' => strtoupper($descripcionProceso)));
		     
               $idProceso = DB::table('procesos')->where('nombre', $nombreProceso)->pluck('id'); 
               
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
		$tareas = DB::table('tareas')->where('idProceso', $id)->get();
		$nombreProceso = DB::table('procesos')->where('id', $id)->pluck('nombre');
		
		$returnDatos = array($tareas,$nombreProceso);
		return View::make('tareas.administracionTareas')->with('datos', $returnDatos);
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
	          File::delete(public_path().$tarea->file);		
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

}
