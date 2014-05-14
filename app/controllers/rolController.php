<?php

class rolController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
	     $roles = DB::table('roles')->get();

		return View::make('adminMaestros.administracionRoles')->with("roles",$roles);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
			$rules = array(
			'nombre'       => 'required|alpha|max:20',
			'descripcion' => 'required|max:200',);
		
		     $messages = array(
		    'alpha' => 'El campo debe contener solo letras',
              'nombre.max' => 'El campo debe tener un maximo de 200 caracteres',
              'descripcion.max' => 'La descipcion debe tener  hasta 200 caracteres',		
              'required' => 'El campo es requerido',);
              
               $validator = Validator::make(Input::all(), $rules, $messages);
              
          if ($validator->fails()) {
			return Redirect::to('administracionRoles/crearRol')
				->withErrors($validator);
		} else {
		
		     $nombre = Input::get('nombre');
		     $descripcion = Input::get('descripcion');
		     
		     $rol = DB::table('roles')->where('nombre', $nombre)->first();
		     
		     if(isset($rol)){
		          Session::flash('errorCrearRol', 'Ya existe un rol con el mismo nombre');
		          return Redirect::to('administracionRoles/crearRol');
		     }
		     
	          DB::table('roles')->insert(array('nombre' => strtoupper($nombre), 'descripcion' => strtoupper($descripcion)));
	          Session::flash('message', 'Rol creado');
          return Redirect::to('administracionRoles');
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
          $rol = DB::table('roles')->where('id', $id)->first();
          return View::make('adminMaestros.editarRol')->with('rol', $rol);
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
			'nombre'       => 'required|max:200',
			'descripcion' => 'required|max:200',);
		
		     $messages = array(
              'nombre.max' => 'El campo debe tener un maximo de 200 caracteres',
              'descripcion.max' => 'El campo debe tener un maximo de 200 caracteres',		
              'required' => 'El campo es requerido',);
              
               $validator = Validator::make(Input::all(), $rules, $messages);
              
          if ($validator->fails()) {
			return Redirect::to('administracionRoles/' . $id . '/edit')->withErrors($validator)->withInput(Input::all());
		} else {
		
		     $nombre = Input::get('nombre');
		     $descripcion = Input::get('descripcion');

		     $rol = DB::table('roles')->where('id', $id)->first();
		     
		     if($rol->nombre != $nombre){
		          $busquedaRol = DB::table('roles')->where('nombre', $nombre)->first();
		          
		          if(isset($busquedaRol)){
		          Session::flash('errorCrearRol', 'Ya existe un rol con el mismo nombre');
		          return Redirect::to('administracionRoles/' . $id . '/edit')->withInput(Input::all());
		          }
		     }
		     
		    DB::table('roles')->where('id',$id)->update(array('nombre' => strtoupper($nombre), 'descripcion' => strtoupper($descripcion)));
		     
	          Session::flash('message', 'Rol editado correctamente');
          return Redirect::to('administracionRoles');
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
	       $relacionTareasNormales = DB::table('usuario_Tareas')
            ->join('usuario_roles', 'usuario_Tareas.emailUsuario', '=', 'usuario_roles.usuarioEmail')
            ->join('tareas', 'tareas.id', '=', 'usuario_Tareas.idTarea')
            ->join('procesos', 'procesos.id', '=', 'tareas.idProceso')            
            ->select('usuario_Tareas.emailUsuario')           
            ->where('usuario_roles.idRol', $id)
            ->whereNotIn('procesos.estado', array('terminada'))->get();            
            
	       $relacionTareasParalelas = DB::table('usuario_TareasParalelas')
            ->join('usuario_roles', 'usuario_TareasParalelas.emailUsuario', '=', 'usuario_roles.usuarioEmail')
            ->join('tareasParalelas', 'tareasParalelas.id', '=', 'usuario_TareasParalelas.idTarea')
            ->join('tareas', 'tareas.id', '=', 'tareasParalelas.idTareaNormal')
            ->join('procesos', 'procesos.id', '=', 'tareas.idProceso')
            ->select('usuario_TareasParalelas.emailUsuario')
            ->where('usuario_roles.idRol', $id)
            ->whereNotIn('procesos.estado', array('terminada'))->get();                        
            
            if($relacionTareasNormales || $relacionTareasParalelas){
		     Session::flash('errorEliminar', 'Error: Rol en un proceso en espera o ejecucion');
		     Session::flash('message', 'Error: Rol en un proceso en espera o ejecucion');
		     return Redirect::to('administracionRoles');            
            }                       
            	
		DB::table('roles')->where('id',$id)->delete();
		DB::table('usuario_roles')->where('idRol',$id)->delete();

		// redirect
		Session::flash('message', 'Rol eliminado correctamente');
		return Redirect::to('administracionRoles');
	}

}
