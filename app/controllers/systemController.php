<?php

class systemController extends \BaseController {

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
		//
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
		//
	}
	
	public function login()
	{
	
			$rules = array(
			'email'      => 'required|email',
			'password' => 'required'
		);
		
		$messages = array(
    'required' => 'El campo es requerido',
    'email' => 'El campo debe ser un correo electornico.',
    );

		$validator = Validator::make(Input::all(), $rules, $messages);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('/')
				->withErrors($validator)
				->withInput(Input::except('password'));
		}else{
		
		          // get all the adminMaestros

			          $email = Input::get('email');
			          $password = Input::get('password');
		
              $usuario = DB::table('adminMaestros')->where('email', $email)->first();
              
              if(isset($usuario)){
                   if(($usuario->password) == $password){	
                       Session::put('autorizacion', 'si');
                       Session::put('tipo', 'adminMaestro');
                       Session::put('sesionUsuario',$usuario->name);
                       return View::make('adminMaestros.inicio')->with('adminMaestro', $usuario);;
                   }else{
                       Session::flash('message', 'Contraseña incorrecta');
		             return View::make('index');
                   }
               }
               
              $usuario = DB::table('adminSecundarios')->where('email', $email)->first();
              
              if(isset($usuario)){
                  if(($usuario->password) == $password){	
                       Session::put('autorizacion', 'si');
                       Session::put('tipo', 'adminSecundario');
                       Session::put('sesionUsuario',$usuario->name);
                       return View::make('adminMaestros.inicio')->with('adminSecundario', $usuario);
                  }else{
                     Session::flash('message', 'Contraseña incorrecta');
		           return View::make('index');
                  }
              }
              
              $usuario = DB::table('usuarioNormales')->where('email', $email)->first();
              
              if(isset($usuario)){
                  if(($usuario->password) == $password){	
                       Session::put('autorizacion', 'si');
                       Session::put('tipo', 'usuarioNormal');
                       Session::put('sesionUsuario',$usuario->name);                       
                       return View::make('adminMaestros.inicio')->with('usuarioNormal', $usuario);
                  }else{
                     Session::flash('message', 'Contraseña incorrecta');
		           return View::make('index');
                  }
              }else{
                     Session::flash('message', 'Usuario no encontrado');
		           return View::make('index');
              }
    
	     }
	}
	
	
	
	
	
		public function logout()
	{
	      Session::flush();
	      return View::make('index');
	}
	
	
	
			public function mostrarUsuarios()
	{
		  $usuariosNormales = DB::table('usuarioNormales');
	   $adminSecundarios = DB::table('adminSecundarios')->unionAll($usuariosNormales)->get();
		 // load the view and pass the admins
		// load the view and pass the admins
		 			   // Session::flash('adminSecundarios', $adminSecundarios);
		 			  //  Session::flash('usuariosNormales', $usuariosNormales);
		return View::make('adminMaestros.buscar')->with("usuarios",$adminSecundarios);

	}
	
	
	
	
			public function busqueda()
	{
	  			$rules = array(
			'email'      => 'required|email',
		);
		
		$messages = array(
    'required' => 'El campo es requerido',
    'email' => 'El campo debe ser un correo electornico.',
    );

		$validator = Validator::make(Input::all(), $rules, $messages);

		// process the login
		if ($validator->fails()) {
		  Session::flash('message', 'Campo de busqueda incorrecto');
		  return $this->mostrarUsuarios();
		}else{
	
 			$email = Input::get('email');
 			
 			$usuario = DB::table('adminSecundarios')->where('email', $email)->first();
 			
 			if(isset($usuario)){
 			  $nombre = $usuario->name;
 			  $telefono = $usuario->phone_number;
 			  $id = $usuario->id;
 			  
 			    Session::flash('nombre', $nombre);
 			    Session::flash('email', $email);
 			    Session::flash('telefono', $telefono);
 			    Session::flash('id', $id);
		      return View::make('adminMaestros.busqueda');
 			}else{
 			 		$usuario = DB::table('usuarioNormales')->where('email', $email)->first();
 			}
 			
 			if(isset($usuario)){
 			  $nombre = $usuario->name;
 			  $telefono = $usuario->phone_number;
 			  $id = $usuario->id;
 			  
 			    Session::flash('nombre', $nombre);
 			    Session::flash('email', $email);
 			    Session::flash('telefono', $telefono);
 			    Session::flash('id', $id);
		      return View::make('adminMaestros.busqueda');
 			}else{
        	Session::flash('message', 'Datos incorrectos');
		      return View::make('adminMaestros.busqueda');
		  }
	}
	}

}
