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
	     $roles = DB::table('roles')->get();
		return View::make('adminMaestros.create')->with('roles', $roles);
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
			'name'       => 'required|alpha|max:20',
			'middleName' => 'alpha|max:20',
			'plast_name' => 'required|alpha|max:20',
			'mlast_name' => 'required|alpha|max:20',
			'email'      => 'required|email',
			'password1' => 'required|digits_between:6,20',
			'phone_number' => 'required|numeric|digits_between:1,20',
			'tipo' => 'required',
		);
		
		$messages = array(
    'alpha' => 'El campo debe contener solo letras',
    'password1.digits_between' => 'El campo debe ser minimo de 6 y maximo de 20',
    'phone_number.digits_between' => 'El campo debe tener un maximo de 20 caracteres',		
    'required' => 'El campo es requerido',
    'email' => 'El campo debe ser un correo electornico.',
    'numeric' => 'El campo debe contener numeros',
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
		     $middleName = Input::get('middleName');
			$plast_name = Input::get('plast_name');
			$mlast_name = Input::get('mlast_name');
			$email = Input::get('email');
		  $password1 = Input::get('password1');
			$password2 = Input::get('password2');
			$phone_number = Input::get('phone_number');
			$location = Input::get('location');
			$tipo = Input::get('tipo');
			$roles = Input::get('roles');
			
			
			    $adminMaestro = DB::table('adminMaestros')->where('email', $email)->first();
			    $adminSecundario = DB::table('adminSecundarios')->where('email', $email)->first();
			    $usuarioNormal = DB::table('usuarioNormales')->where('email', $email)->first();
			    
			    if(isset($adminMaestro) OR isset($adminSecundario) OR isset($usuarioNormal)){
			      Session::flash('errorRegistro', 'El correo electronico ingresado ya existe');
			    	return Redirect::to('adminMaestro/create')->withInput(Input::except('password1','password2'));
			    }
			
			if($password1 != $password2){
				Session::flash('errorRegistro', 'Porfavor ingresa las contraseñas iguales');
				return Redirect::to('adminMaestro/create')->withInput(Input::except('password1','password2'));
			}
			$hashedPassword = Hash::make($password1);

			switch($tipo){
			
			case "adminSecundario":
			
			  DB::table('adminSecundarios')->insert(
        array('name' => strtoupper($name), 'middleName' => strtoupper($middleName), 'plast_name' => strtoupper($plast_name) , 'mlast_name' => strtoupper($mlast_name) ,'email' => strtolower($email), 'password' => $hashedPassword, 'phone_number' => $phone_number, 'location' => $location));
        
                    foreach ($roles as $id) {
                        DB::table('usuario_roles')->insert(array('usuarioEmail' => $email , 'idRol' => $id )); 
                    }
        
        Mail::send('emails.bienvenida', array('firstname'=>strtoupper($name), 'email'=>$email, 'password'=>$password1), function($message){
            $message->to(Input::get('email'), Input::get('name').' '.Input::get('plast_name'))->subject('Bienvenido a Tec WorkFlow Engine');});
        
			  Session::flash('message', 'Administrador Secundario Creado');
			  return Redirect::to('/Usuarios');
			break;
			
			case "usuarioNormal":
			
			  DB::table('usuarioNormales')->insert(
        array('name' => strtoupper($name), 'middleName' => strtoupper($middleName), 'plast_name' => strtoupper($plast_name) , 'mlast_name' => strtoupper($mlast_name) ,'email' => strtolower($email), 'password' => $hashedPassword, 'phone_number' => $phone_number, 'location' => $location));
        
                     foreach ($roles as $id) {
                        DB::table('usuario_roles')->insert(array('usuarioEmail' => $email , 'idRol' => $id )); 
                    }
        
                Mail::send('emails.bienvenida', array('firstname'=>strtoupper($name), 'email'=>$email, 'password'=>$password1), function($message){
            $message->to(Input::get('email'), Input::get('name').' '.Input::get('plast_name'))->subject('Bienvenido a Tec WorkFlow Engine');});
        
			  Session::flash('message', 'Usuario Normal Creado');
			  return Redirect::to('/Usuarios');
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
	public function show($email)
	{

         $usuario = DB::table('adminSecundarios')->where('email', $email)->first();
         if(isset($usuario)){
         
             $idroles = DB::table('usuario_roles')->where('usuarioEmail', $email)->lists('idRol');

                  if(isset($idroles[0])){
                  $roles = DB::table('roles')->whereIn('id', $idroles)->lists('nombre');
                  }else{
                  $roles = array("Ninguno");
                  }
                  $datos = array($usuario,$roles);
             
         		  Session::flash('tipo', 'Administrador Secundario');
             return View::make('adminMaestros.show')->with('datos', $datos);
             
         }else{
         
         $usuario = DB::table('usuarioNormales')->where('email', $email)->first();
         
         }
		
		     if(isset($usuario)){
		
	             $idroles = DB::table('usuario_roles')->where('usuarioEmail', $email)->lists('idRol');
             //$roles = DB::table('roles')->whereIn('id', $idroles)->lists('nombre');
                  if(isset($idroles[0])){
                  $roles = DB::table('roles')->whereIn('id', $idroles)->lists('nombre');
                  }else{
                  $roles = array("Ninguno");
                  }
                  $datos = array($usuario,$roles);
		         Session::flash('tipo', 'Usuario Normal');
               return View::make('adminMaestros.show')->with('datos', $datos);
               }
    
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($email)
	{
				// get the admin
    $usuario = DB::table('adminSecundarios')->where('email', $email)->first();
    
    if(isset($usuario)){
        return View::make('adminMaestros.edit')->with('usuario', $usuario);
    }else{
    $usuario = DB::table('usuarioNormales')->where('email', $email)->first();
    }
		
		if(isset($usuario)){
        return View::make('adminMaestros.edit')->with('usuario', $usuario);
    }
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($email)
	{
				// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'name'       => 'required|alpha|max:20',
			'middleName' => 'alpha|max:20',
			'plast_name' => 'required|alpha|max:20',
			'mlast_name' => 'required|alpha|max:20',
			'email'      => 'required|email',
			'password1' => 'required|digits_between:6,20',
			'phone_number' => 'required|numeric|digits_between:1,20',
			'tipo' => 'required',
		);
		
		$messages = array(
    'alpha' => 'El campo debe contener solo letras',
    'password1.digits_between' => 'El campo debe ser minimo de 6 y maximo de 20',
    'phone_number.digits_between' => 'El campo debe tener un maximo de 20 caracteres',		
    'required' => 'El campo es requerido',
    'email' => 'El campo debe ser un correo electornico.',
    'numeric' => 'El campo debe contener numeros',
    );

		$validator = Validator::make(Input::all(), $rules, $messages);

		// process the login
		if ($validator->fails()) {
			return Redirect::to('adminMaestro/' . $email . '/edit')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
    
			$name = Input::get('name');
			$middleName = Input::get('middleName');
			$plast_name = Input::get('plast_name');
			$mlast_name = Input::get('mlast_name');
			$newemail = Input::get('email');
		  $password1 = Input::get('password1');
			$password2 = Input::get('password2');
			$phone_number = Input::get('phone_number');
			$location = Input::get('location');
			$tipo = Input::get('tipo');

      if($email != $newemail){
      //BUSCAMOS EL USUARIO QUE TENGA EL EMAIL QUE SE QUIERE EDITAR Y EN CASO DE ECONTRARLO REGRASAMOS ERROR
          $adminMaestro = DB::table('adminMaestros')->where('email', $newemail)->first();
			    $adminSecundario = DB::table('adminSecundarios')->where('email', $newemail)->first();
			    $usuarioNormal = DB::table('usuarioNormales')->where('email', $newemail)->first();
			    
			    if(isset($adminMaestro) OR isset($adminSecundario) OR isset($usuarioNormal)){
			      Session::flash('errorRegistro', 'El correo electronico ingresado ya existe');
			    	return Redirect::to('adminMaestro/' . $email . '/edit')->withInput(Input::except('password1','password2'));
			    }
			}
			
			//BUSCAMOS EL USUARIO PARA VER QUE TIPO DE USUARIO ES Y ASI PODER REASIGNARLO EN EL OTRO TIPO DE USUARIO SI ASI SE QUIERE
			
			    $adminMaestro = DB::table('adminMaestros')->where('email', $email)->first();
			    $adminSecundario = DB::table('adminSecundarios')->where('email', $email)->first();
			    $usuarioNormal = DB::table('usuarioNormales')->where('email', $email)->first();
			    if(isset($adminMaestro)){
			    $tipoAnterior = 'adminMaestro';
			    }elseif(isset($adminSecundario)){
			    $tipoAnterior = 'adminSecundario';
			    }elseif(isset($usuarioNormal)){
			    $tipoAnterior = 'usuarioNormal';
			    }
			    
			
			if($password1 != $password2){
				Session::flash('errorRegistro', 'Porfavor ingresa las contraseñas iguales');
							return Redirect::to('adminMaestro/' . $email . '/edit')->withInput(Input::except('password1','password2'));
			}
			    $hashedPassword = Hash::make($password1);
			//FALTA ACTUALIZAR EN CASO DE QUE SE DECIDCA CAMBIAR DE TIPO DE USUARIO, PORQUE SI SE SELECCIONA EL MISMO TIPO DE USUARIO SI SE ACTUALIZA BIEN PERO SI SE SELECCIONA EL OTRO TIPO DE USUARIO NO.
			
			if($tipoAnterior == $tipo){
						    switch($tipo){
			
			    case "adminSecundario":
			      DB::table('adminSecundarios')->where('email',$email)->update(
        array('name' => strtoupper($name), 'middleName' => strtoupper($middleName), 'plast_name' => strtoupper($plast_name) , 'mlast_name' => strtoupper($mlast_name) ,'email' => strtolower($email), 'password' => $hashedPassword, 'phone_number' => $phone_number, 'location' => $location));
            
                            Mail::send('emails.editar', array('firstname'=>strtoupper($name), 'email'=>$newemail, 'password'=>$password1), function($message){
            $message->to(Input::get('email'), Input::get('name').' '.Input::get('plast_name'))->subject('Tec WorkFlow Engine');});
            
			    Session::flash('message', 'Editado Correctamente');
			      return Redirect::to('/Usuarios');
			    break;
			
			    case "usuarioNormal":
			      DB::table('usuarioNormales')->where('email',$email)->update(
        array('name' => strtoupper($name), 'middleName' => strtoupper($middleName), 'plast_name' => strtoupper($plast_name) , 'mlast_name' => strtoupper($mlast_name) ,'email' => strtolower($email), 'password' => $hashedPassword, 'phone_number' => $phone_number, 'location' => $location));
            
                            Mail::send('emails.editar', array('firstname'=>strtoupper($name), 'email'=>$mewemail, 'password'=>$password1), function($message){
            $message->to(Input::get('email'), Input::get('name').' '.Input::get('plast_name'))->subject('Tec WorkFlow Engine');});
            
			    Session::flash('message', 'Editado Correctamente');
			      return Redirect::to('/Usuarios');
			    break;
			
			    }
			}else{
					  switch($tipoAnterior){
					      case "adminSecundario":
					        DB::table('adminSecundarios')->where('email',$email)->delete();
					        DB::table('usuarioNormales')->insert(
        array('name' => strtoupper($name), 'middleName' => strtoupper($middleName), 'plast_name' => strtoupper($plast_name) , 'mlast_name' => strtoupper($mlast_name) ,'email' => strtolower($email), 'password' => $hashedPassword, 'phone_number' => $phone_number, 'location' => $location));
        
                            Mail::send('emails.editar', array('firstname'=>strtoupper($name), 'email'=>$newemail, 'password'=>$password1), function($message){
            $message->to(Input::get('email'), Input::get('name').' '.Input::get('plast_name'))->subject('Tec WorkFlow Engine');});
        
        			    Session::flash('message', 'Editado Correctamente');
			            return Redirect::to('/Usuarios');
					      break;
					      
					      case "usuarioNormal":
					        DB::table('usuarioNormales')->where('email',$email)->delete();
					        DB::table('adminSecundarios')->insert(
        array('name' => strtoupper($name), 'middleName' => strtoupper($middleName), 'plast_name' => strtoupper($plast_name) , 'mlast_name' => strtoupper($mlast_name) ,'email' => strtolower($email), 'password' => $hashedPassword, 'phone_number' => $phone_number, 'location' => $location));
        
                            Mail::send('emails.editar', array('firstname'=>strtoupper($name), 'email'=>$newemail, 'password'=>$password1), function($message){
            $message->to(Input::get('email'), Input::get('name').' '.Input::get('plast_name'))->subject('Tec WorkFlow Engine');});
        
        			    Session::flash('message', 'Editado Correctamente');
			            return Redirect::to('/Usuarios');
					      break;					  
					  }
			}
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($email)
	{
				// delete
  DB::table('adminSecundarios')->where('email',$email)->delete();
    DB::table('usuarioNormales')->where('email',$email)->delete();

		// redirect
		Session::flash('message', 'Usuario eliminado correctamente');
		return Redirect::to('/Usuarios');
	}


}
