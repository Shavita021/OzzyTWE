<html>
<head>
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
</head>
<body>
<div align="center" style="padding:10px;position:absolute;top:100px;margin-left:300px;height:70%;background-color:#030824;width:600px">
           <h1 align="center" style="color:#FFFFFF;font-size:150px"><strong>4O4</strong></h1>
           <h1 align="center" style="color:#FFFFFF;font-size:50px"><strong>Pagina no encontrada</strong></h1>
           <br>
           <h4 align="center" style="color:#FFFFFF;">Presione el boton de regresar en su explorador para regresar a la paguina anterior o simplemente presione el siguiente boton que lo llevara a la paguina de inicio.</h4>    
           <br>       
@if(Session::get('tipoSession') == 'adminMaestro')          
          <a href="/adminMaestro" class= "btn btn-default btn-lg"><span class="glyphicon glyphicon-home"></span> Inicio</a>
@elseif(Session::get('tipoSession') == 'usuarioNormal')
          <a href="/usuarioNormal" class= "btn btn-default btn-lg"><span class="glyphicon glyphicon-home"></span> Inicio</a>
@else
           <a href="/" class= "btn btn-default btn-lg"><span class="glyphicon glyphicon-home"></span> Inicio</a>       
@endif          
        </div>

        <br />
</body>        
</html>        
