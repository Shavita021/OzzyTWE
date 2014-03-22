<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tec WorkFlow Engine</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div>
               <div style="height:130px;"></div>
          <div style="height:400px;background-color:#030824;">
          <br><br>
          <div style="padding:20;width:300px;margin-left:250px;float:left">
               {{ Form::open(array('action' => 'systemController@login', 'method' => 'post')) }}
                       <br><br>
                       <label for="email" style="color:#FFFFFF">Email:</label>
	                   	{{ Form::email('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => 'e-mail')) }}
	                   	<i style="color:#7080CD">{{ $errors->first('email') }}</i>
	                   	<br><br>
	                   	<label for="password" style="color:#FFFFFF">Contraseña:</label>
	                   		    	{{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
	                   	<i style="color:#7080CD">{{ $errors->first('password') }}</i>
                       <br><br>
                       <div align='center'>
<button type="submit" class= "btn btn-default btn-lg">Entrar</a>
	                     {{ Form::close() }}
                       </div>
                       <br>
                         <div align='center'>
                          @if (Session::has('message'))
	                    <i style="color:#7080CD;font-size:25px">{{ Session::get('message') }}</i>
                          @endif
                          </div>
           </div>
           <div >
           <h1 align="center" style="color:#FFFFFF;font-size:80px"><strong>Ozzy</strong></h1>
           <h1 align="center" style="color:#FFFFFF;font-size:50px">WorkFlow</h1>
           <h1 align="center" style="color:#FFFFFF;font-size:50px">Engine</h1>
           </div>
           </div>

    </div> <!-- /container -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
