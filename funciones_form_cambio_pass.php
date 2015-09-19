<?php
	
	$mensaje_server = "";

    if(isset($_POST["actualizar"])) 
    {
    	require("funciones.php");
	    $conexion = conectar();

	    $user=$_SESSION['logged_user'];
	    $id_usuario="";

	    $query = 'SELECT id_num_reg FROM datos_personales WHERE email="'.$user.'"';
	    $consulta = ejecutarQuery($conexion, $query);
	    if (mysqli_num_rows($consulta)) {
	        while ($dat = mysqli_fetch_array($consulta)){
	            $id_usuario = $dat['id_num_reg'];
	        }
	    }

	    $correo1 = strip_tags($_POST['pass1']);
        $correo2 = strip_tags($_POST['pass2']);

        if($correo1 === $correo2) //valida los correos 
        {
        	$correo1 = mysqli_real_escape_string($conexion, $correo1);
        	$query = 'UPDATE datos_personales SET contrasenia = "'.$correo1.'" WHERE id_num_reg="'.$id_usuario.'"';
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


