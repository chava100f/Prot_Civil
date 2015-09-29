<?php

	require_once("funciones.php");
    $conexion = conectar();

    try {
	    $id_patrulla = $_GET['id'];
	} catch (Exception $e) {
	    header("Location: index_admin.php");
        exit();
	}

    
    $mensaje_server="";

    $query = 'SELECT nombre, clave FROM patrullas WHERE id_patrullas="'.$id_patrulla.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $nombre_patrulla = $dat['nombre'];
            $clave_p = $dat['clave'];
        }
    }

    desconectar($conexion);

    //Si se da Submit o Enviar primero se validan los datos y despues se incertan en la BD
    if(isset($_POST['actualizar'])) //código para validar los datos del formulario
    {   

        $id_patrulla = $_GET['id'];

        require_once("funciones.php");
        $conexion = conectar();

        //Recoleccion de datos...

        $nombre_patrulla = mysqli_real_escape_string($conexion, strip_tags($_POST['nombre_patrulla']));
        $clave_p = mysqli_real_escape_string($conexion, strip_tags($_POST['clave_p']));


        if($nombre_patrulla != "")
        {	
        	if(strlen($clave_p)>=4 && strlen($clave_p)<=6)
          	{
	        	$query = 'UPDATE patrullas SET nombre = "'.$nombre_patrulla.'", clave = "'.$clave_p.'" ';
		        $query .= 'WHERE id_patrullas = "'.$id_patrulla.'"';      
		        $consulta = ejecutarQuery($conexion, $query);

		        $mensaje_server = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> La patrulla ha actualizada correctamente.</u></b></div>';
		    }
		    else
		    {
		    	$mensaje_server = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> La longitud de la clave de patrulla debe ser entre 4 a 6 caracteres.</div>';
		    }
        }
        else
        {
	      	$mensaje_server = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> El nombre de la patrulla no es válido, intente de nuevo.</div>';
        }

		desconectar($conexion);
    }
?>