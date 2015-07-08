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
		
		if (mysqli_num_rows($consulta)) {
			while ($dat = mysqli_fetch_array($consulta)){
				//Revisar tambien el tipo de perfil que se tiene y redireccionar dependiendo de este a la pagina adecuada!!!

				session_start();
				$_SESSION['logged'] = 'yes';
				
				desconectar($conexion);

				$tipo_cuenta = $dat['tipo_cuenta'];

				if($tipo_cuenta == "usuario")
				{
					$_SESSION['logged_user'] = $user;
					header("Location: index_usuario.php");
					exit();					
				}
				if($tipo_cuenta == "jefe")
				{
					$_SESSION['logged_jefe'] = $user;
					header("Location: index_jefe_patrulla.php");
					exit();					
				}

			}
		}
		else
		{
			desconectar($conexion);
			$error_login = '<p name="error_log"><b>El usuario o la contraseña son incorrectos.</b></p>';
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<link rel="stylesheet" type="text/css" href="EstiloT0202.css">
	<title>Login Alumno</title>
</head>
<body>
	<h1> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h1>
	<form action = "index.php" method = "POST">
		<fieldset>
                <legend>Ingresar</legend>
				<ul>		
                    <li>
					<label>Usuario:</label>
					 <input type = "textbox" name = "user">
					</li>
					<label>Contraseña:</label>
					<input type = "password" name = "pass">
					</li>
				</ul>

 		</fieldset>
		<br>
		<input type = "submit" value = "Entrar" name = "log" width="100" height="50">
	</form>

	<?php echo $error_login; //muestra el error de login ?>
	
	<p  class="hiper"><a href="registra_usuario.php">¿Aún No Te Registras? Registrarse en el Sistema</a></p> 


</body>
</html>