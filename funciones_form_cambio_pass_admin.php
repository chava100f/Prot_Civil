<?php
	
	$mensaje_server = "";

    if(isset($_POST["actualizar"])) 
    {
    	require("funciones.php");
	    $conexion = conectar();

	    $user=$_SESSION['logged_user'];

	    $pass1 = strip_tags($_POST['pass1']);
        $pass2 = strip_tags($_POST['pass2']);

        if($pass1 === $pass2) //valida los passs 
        {
        	$pass1 = mysqli_real_escape_string($conexion, $pass1);
        	$query = 'UPDATE super_usuario SET contrasenia = "'.$pass1.'" WHERE admin="'.$user.'"';
            $consulta = ejecutarQuery($conexion, $query);

            $mensaje_server = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha cambiado la contraseña correctamente.</div>';
    	}

        else
        {
            $mensaje_server = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> Las contraseñas no coinciden.</div>';
        }
        desconectar($conexion);
   	}

?>