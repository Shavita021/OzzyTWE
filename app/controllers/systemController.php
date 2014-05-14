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
	public function edit()
	{
	     $email = Session::get('emailUsuario');
		$usuario = DB::table('adminMaestros')->where('email', $email)->first();
		
		return View::make('adminMaestros.editSuperUser')->with('usuario', $usuario);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($email)
	{
				$rules = array(
			'email'      => 'required|email',
			'password1' => 'digits_between:6,20',
		);
		
		$messages = array(
    'password1.digits_between' => 'El campo debe ser minimo de 6 y maximo de 20',
    'required' => 'El campo es requerido',
    'email' => 'El campo debe ser un correo electornico.',
    );

		$validator = Validator::make(Input::all(), $rules, $messages);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('/edit')
				->withErrors($validator);
		}else{
		     $newemail = Input::get('email');
		     $password1 = Input::get('password1');
			$password2 = Input::get('password2');
			
               if($email != $newemail){
      //BUSCAMOS EL USUARIO QUE TENGA EL EMAIL QUE SE QUIERE EDITAR Y EN CASO DE ECONTRARLO REGRASAMOS ERROR
                    $adminMaestro = DB::table('adminMaestros')->where('email', $newemail)->first();
			     $adminSecundario = DB::table('adminSecundarios')->where('email', $newemail)->first();
			     $usuarioNormal = DB::table('usuarioNormales')->where('email', $newemail)->first();
			    
			     if(isset($adminMaestro) OR isset($adminSecundario) OR isset($usuarioNormal)){
			     Session::flash('errorRegistro', 'El correo electronico ingresado ya existe');
			    	return Redirect::to('/edit');
			    }
			}
			
			if($password1 != $password2){
				Session::flash('errorRegistro', 'Porfavor ingresa las contraseñas iguales');
				return Redirect::to('/edit');
			}
				
		$usuario = DB::table('adminMaestros')->where('email', $email)->first();
		
			if($password1 == "" && $password2 == ""){
			    $hashedPassword = $usuario->password;
			}else{
			    $hashedPassword = Hash::make($password1);
			}
			
			      DB::table('adminMaestros')->where('email',$email)->update(array('email' => strtolower($newemail), 'password' => $hashedPassword));
        
                     Mail::send('emails.editar', array('firstname'=> $usuario->name, 'email'=>$newemail, 'password'=>$password1), function($message) use ($usuario){
            $message->to(Input::get('email'), $usuario->name)->subject('Tec WorkFlow Engine');});
            
                     Session::flash('message', 'Usuario Root editado correctamente');
			      return Redirect::to('adminMaestro');
			
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
    'email' => 'El campo debe ser un correo electronico.',
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
                   if(Hash::check($password,$usuario->password)){	
                       Session::put('autorizacion', 'si');
                       Session::put('tipoSession', 'adminMaestro');
                       Session::put('sesionUsuario',$usuario->name);
                       Session::put('emailUsuario',$usuario->email);                       
                       return Redirect::to('adminMaestro');
                   }else{
                       Session::flash('message', 'Contraseña incorrecta');
		             return View::make('index');
                   }
               }
               
              $usuario = DB::table('adminSecundarios')->where('email', $email)->first();

              if(isset($usuario)){
                  if(Hash::check($password,$usuario->password)){	
                       Session::put('autorizacion', 'si');
                       Session::put('tipoSession', 'adminSecundario');
                       Session::put('sesionUsuario',$usuario->name);
                       Session::put('emailUsuario',$usuario->email);                         
                       return Redirect::to('adminMaestro');
                  }else{
                     Session::flash('message', 'Contraseña incorrecta');
		           return View::make('index');
                  }
              }
              
              $usuario = DB::table('usuarioNormales')->where('email', $email)->first();
              
              if(isset($usuario)){
                  if(Hash::check($password,$usuario->password)){	
                       Session::put('autorizacion', 'si');
                       Session::put('tipoSession', 'usuarioNormal');
                       Session::put('sesionUsuario',$usuario->name); 
                       Session::put('emailUsuario',$usuario->email);                          
                       return Redirect::to('usuarioNormal');
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
           return Redirect::to('/');
	}
	
	
	
	
	
	
		public function recuperarContraseña()
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
			return Redirect::to('/recuperarContraseña')
				->withErrors($validator)
				->withInput(Input::all());
		}else{
		
	          $email = Input::get('email');
	          
	          $adminMaestro = DB::table('adminMaestros')->where('email', $email)->first();
	          $adminSecundario = DB::table('adminSecundarios')->where('email', $email)->first();
	          $usuarioNormal = DB::table('usuarioNormales')->where('email', $email)->first();

	          
               if(isset($adminMaestro)){
                    $usuario = $adminMaestro;
                    $tabla = "adminMaestros";
               }elseif(isset($adminSecundario)){
                    $usuario = $adminSecundario;
                    $tabla = "adminSecundarios";
               }elseif(isset($usuarioNormal)){
                    $usuario = $usuarioNormal;
                    $tabla = "usuarioNormales";
               }else{
	               Session::flash('message', 'El usuario no existe');
	            	return Redirect::to('/recuperarContraseña')->withInput(Input::all());
	          }
	          
	          $password = uniqid();
	          $hashedPassword = Hash::make($password);
	          
	          DB::table($tabla)->where('email',$email)->update(array('password' => $hashedPassword));
	          
	          Mail::send('emails.recuperarContraseña', array('firstname'=>strtoupper($usuario->name), 'email'=>$email, 'password'=>$password), function($message){
            $message->to(Input::get('email'))->subject('Recuperacion de Contraseña');});
            
               return Redirect::to('/');
		
		}
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
		  Session::flash('errorMail', 'Busqueda incorrecta');
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
