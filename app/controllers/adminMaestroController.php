<?php

class adminMaestroController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// get all the adminMaestros
    $adminMaestros = DB::table('adminMaestros')->get();

		// load the view and pass the admins
		return View::make('adminMaestros.index')
			->with('adminMaestros', $adminMaestros);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('adminMaestros.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
				// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'name'       => 'required',
			'email'      => 'required|email',
			'phone_number' => 'required|numeric',
			'tipo' => 'required'
		);
		
		$messages = array(
    'required' => 'El campo es requerido',
    'email' => 'El campo debe ser un correo electornico.',
    'phone_number' => 'Debe contener numeros',
    );
    
		$validator = Validator::make(Input::all(), $rules, $messages);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('adminMaestro/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
			$name = Input::get('name');
			$email = Input::get('email');
			$phone_number = Input::get('phone_number');
			$tipo = Input::get('tipo');

			switch($tipo){
			
			case "adminSecundario":
			  DB::table('adminSecundarios')->insert(
        array('name' => $name,'email' => $email, 'phone_number' => $phone_number));
			  Session::flash('message', 'Administrador Secundario Creado');
			  return Redirect::to('/inicio');
			break;
			
			case "usuarioNormal":
			  DB::table('usuarioNormales')->insert(
        array('name' => $name,'email' => $email, 'phone_number' => $phone_number));
			  Session::flash('message', 'Usuario Normal Creado');
			  return Redirect::to('/inicio');
			break;
			
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
				// get the nerd
    $adminMaestro = DB::table('adminMaestros')->where('id', $id)->first();

		// show the view and pass the nerd to it
		return View::make('adminMaestros.show')
			->with('adminMaestro', $adminMaestro);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
				// get the admin
    $adminMaestro = DB::table('adminMaestros')->where('id', $id)->first();

		// show the edit form and pass the admin
		return View::make('adminMaestros.edit')
			->with('adminMaestro', $adminMaestro);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
				// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'name'       => 'required',
			'email'      => 'required|email',
			'phone_number' => 'required|numeric'
		);
		
		$messages = array(
    'required' => 'El :attribute es requerido.',
    'numeric' => 'El :attribute deben ser numeros.',
    );

		$validator = Validator::make(Input::all(), $rules, $messages);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('adminMaestro/' . $id . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// store
    
			$name= Input::get('name');
			$email = Input::get('email');
			$phone_number = Input::get('phone_number');

      DB::table('adminMaestros')->where('id', $id)->update(array('name' => $name,'email' => $email,   'phone_number' => $phone_number));

			// redirect
			Session::flash('message', 'Editado Correctamente');
			return Redirect::to('inicio');
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
				// delete
  DB::table('adminMaestros')->where('id',$id)->delete();

		// redirect
		Session::flash('message', 'Usuario eliminado correctamente');
		return Redirect::to('inicio');
	}


}
