<?php 
	$error_login='';
	
	if(isset($_POST['log'])) //código para validar el perfil y el usuario...
	{   
		require_once("funciones.php");
		$conexion = conectar();
		
		$user = mysqli_real_escape_string($conexion, strip_tags($_POST['user']));
		$pass = mysqli_real_escape_string($conexion, strip_tags($_POST['pass']));

		$query = 'SELECT email, tipo_cuenta FROM datos_personales WHERE email="'.$user.'" AND contrasenia="'.$pass.'"';
		//$query = 'SELECT nombre FROM super_usuario WHERE nombre = "'.$user.'" AND contrasenia = "'.$pass.'"';
		$consulta = ejecutarQuery($conexion, $query);
		
		if (mysqli_num_rows($consulta)) 
		{
			while ($dat = mysqli_fetch_array($consulta))
			{
				//Revisar tambien el tipo de perfil que se tiene y redireccionar dependiendo de este a la pagina adecuada!!!

				session_start();
				$_SESSION['logged'] = 'yes';
				
				desconectar($conexion);

				$tipo_cuenta = $dat['tipo_cuenta'];
				$_SESSION['user_type'] = $tipo_cuenta; //determina el tipo de cuenta que es el usuario para el menu

				if($tipo_cuenta == "USUARIO")
				{
					$_SESSION['logged_user'] = $user;
					header("Location: index_usuario.php");
					exit();					
				}
				if($tipo_cuenta == "JEFE")
				{
					$_SESSION['logged_user'] = $user;
					header("Location: index_jefe_patrulla.php");
					exit();					
				}
				if($tipo_cuenta == "ADMIN")
				{
					$_SESSION['logged_user'] = $user;
					header("Location: index_admin.php");
					exit();					
				}
			}
		}
		else
		{	
			$query = 'SELECT admin FROM super_usuario WHERE admin = "'.$user.'" AND contrasenia = "'.$pass.'"';
			$consulta = ejecutarQuery($conexion, $query);

			if (mysqli_num_rows($consulta)) 
			{
				while ($dat = mysqli_fetch_array($consulta))
				{
					session_start();
					$_SESSION['logged'] = 'yes';
					$_SESSION['logged_user'] = $user;
					$_SESSION['user_type'] = "ADMIN";
				}

				desconectar($conexion);
				header("Location: index_admin.php");
				exit();	
			}
			else
			{
				desconectar($conexion);
				$error_login = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> El usuario o la contraseña son incorrectos.</div>';
			}
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset = "utf-8">
	<title>Login Alumno</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	
	<!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/signin.css" >

</head>
<body>
	<div class="container" >
		<header class="header-index">
			
			<img src="imagenes/brsam-logo.png" />
			<h2> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h2>
			
		</header>
	</div>
	
	<br/>
	
	<div class="container" id="login-form">
		<div class="col-xs-1 col-sm-2 col-md-4 col-lg-4"></div>

		<div class="col-xs-11 col-sm-8 col-md-4 col-lg-4">
			<h3>Inicio de sesión:</h3>

			<fieldset>			
				<form  action="index.php" method="POST" >

				<input type="text" id="user" name="user" class="form-control" placeholder="Ingresar Usuario" required>
				<input type="password" id="pass" name="pass" class="form-control" placeholder="Ingresar Contraseña" required>
				<br/>
				<?php echo $error_login; //muestra el error de login ?>

				<div class="row">

					<p class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
						<span class="info">!</span>
						<a href="registra_usuario.php">Registrarse</a>   
						<br/>
						<span class="info">!</span>
					   	<a href="olvido_password.php">Recuperar contraseña</a>
				   	</p>

				   	<p class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
						<input type="submit" name="log" value="Entrar"/>
					</p>
			   	</div>
				</form>
			</fieldset>

			<footer class="footer">
				<small>Última modificación Agosto 2015</small>
			</footer>
		</div>

		<div class="col-xs-1 col-sm-2 col-md-4 col-lg-4"></div>
	</div>
	
    <!-- Javascript -->
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript"> //función para hacer dinamigo el fondo 
     $(function(){
    
		var limit = 0; // 0 = infinite.
		var interval = 2;// Secs
		var images = [
		    "imagenes/Fondos/1.jpg",
		    "imagenes/Fondos/2.jpg",
		    "imagenes/Fondos/3.jpg"
		];

		var inde = 0; 
		var limitCount = 0;
		var myInterval = setInterval(function() {
		   if (limit && limitCount >= limit-1) clearTimeout(myInterval);
		   if (inde >= images.length) inde = 0;
		    $('body').css({ "background-image":"url(" + images[inde]+ ")" });
		   inde++;
		   limitCount++;
		}, interval*10000);

		});
    </script>
</body>
</html>