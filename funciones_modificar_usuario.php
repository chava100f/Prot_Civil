<?php

	require_once("funciones.php");
    $conexion = conectar();

    try {
	    $id_user_modif = $_GET['id'];
	} catch (Exception $e) {
	    header("Location: index_admin.php");
        exit();
	}

    $error_email="";
    $exito="";

    $query = 'SELECT nombre, apellido_p, apellido_m, patrullas_id_patrullas, tipo_cuenta, calidad_miembro, email FROM datos_personales WHERE id_num_reg="'.$id_user_modif.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $nombres = $dat['nombre'];
            $apellido_p = $dat['apellido_p'];
            $apellido_m = $dat['apellido_m'];
            $id_patrulla_u = $dat['patrullas_id_patrullas'];
            $tipo_cuenta_u = $dat['tipo_cuenta'];
            $calidad_miembro = $dat['calidad_miembro'];
            $correo_actual = $dat['email'];
        }
    }

    $query = 'SELECT id_patrullas, nombre FROM patrullas';
    $consulta = ejecutarQuery($conexion, $query);
    $patrulla='';
    $seleccion="";

    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $id_patrullas = $dat['id_patrullas'];
            $nombre_p = $dat['nombre'];

            if($id_patrulla_u == $id_patrullas ) 
            {
                $seleccion = 'selected'; 
            }
            else
            {
             $seleccion= "";
            }

            $patrulla = $patrulla.'<option '.$seleccion.' value="'.$id_patrullas.'">'.$nombre_p.'</option>';
        }
    }

    desconectar($conexion);

    //Si se da Submit o Enviar primero se validan los datos y despues se incertan en la BD
    if(isset($_POST['actualizar'])) //código para validar los datos del formulario
    {   

        $id_user_modif = $_GET['id'];
        // Actualizacion de datos complementarios

        require_once("funciones.php");
        $conexion = conectar();

        //Recoleccion de datos...

        $correo1 = mysqli_real_escape_string($conexion, strip_tags($_POST['correo1']));
        $correo2 = mysqli_real_escape_string($conexion, strip_tags($_POST['correo2']));

        $nombres_u = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['nombres'])));
        $apellido_p_u = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['apellido_p'])));
        $apellido_m_u = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['apellido_m'])));
        $patrulla_u = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['patrulla'])));
        $tipo_cuenta_u = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['tipo_cuenta_u'])));
        $calidad_miembro_u = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['calidad_miembro'])));


        //Codigo para evitar que existan dos jefes en una patrulla

        $otro_jefe="";

        if($tipo_cuenta_u==="JEFE")
        {
	        $query = 'SELECT nombre FROM datos_personales WHERE tipo_cuenta="JEFE" AND patrullas_id_patrullas="'.$patrulla_u.'"';
		    $consulta = ejecutarQuery($conexion, $query);
		    if (mysqli_num_rows($consulta)) {
		        while ($dat = mysqli_fetch_array($consulta)){
		            $otro_jefe = $dat['nombre'];
		        }
		    }
		}

	    if($otro_jefe==="")
	    {

	        if($correo1=="" && $correo2=="") //Revisa si se inserto algo en los campos de email, si no, solo actualiza lo demas
	        {
	        	$query = 'UPDATE datos_personales SET nombre = "'.$nombres_u.'", apellido_p = "'.$apellido_p_u.'", apellido_m = "'.$apellido_m_u.'", ';
		        $query .= 'patrullas_id_patrullas = "'.$patrulla_u.'", tipo_cuenta = "'.$tipo_cuenta_u.'", calidad_miembro = "'.$calidad_miembro_u.'" ';
		        $query .= 'WHERE id_num_reg = "'.$id_user_modif.'"';      
		        $consulta = ejecutarQuery($conexion, $query);
		        $exito="1";


	        }
	        else
	        {
	        	if($correo1===$correo2) //Si se inserto algo en los campos de email, se valida que sean iguales antes de actualizar junto con lo demas
		        {
			        //Actualiza la tabla datos personales....

			        $query = 'UPDATE datos_personales SET nombre = "'.$nombres_u.'", apellido_p = "'.$apellido_p_u.'", apellido_m = "'.$apellido_m_u.'", email = "'.$correo1.'",';
			        $query .= 'patrullas_id_patrullas = "'.$patrulla_u.'", tipo_cuenta = "'.$tipo_cuenta_u.'", calidad_miembro = "'.$calidad_miembro_u.'" ';
			        $query .= 'WHERE id_num_reg = "'.$id_user_modif.'"';      
			        $consulta = ejecutarQuery($conexion, $query);
			        $exito="1";
			        $correo_actual=$correo1;
		        }
		        else
		        {
		        	$error_email = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> Los correos no coinciden.</div>';
		        }
	        }

	        if($exito=="1") //Muestra el mensaje de Exito y se conservan los datos para evitar confusiones de que se actualizo o no.
	        {
	        	$exito = '<div class="alert alert-success" role="alert"><strong>¡Éxito!</strong> El usuario ha actualizado correctamente.</div>';
	        	$nombres = $nombres_u;
	        	$apellido_p = $apellido_p_u;
	        	$apellido_m = $apellido_m_u;

	        	$query = 'SELECT id_patrullas, nombre FROM patrullas';
			    $consulta = ejecutarQuery($conexion, $query);
			    $patrulla='';
			    $seleccion="";

			    if (mysqli_num_rows($consulta)) {
			        while ($dat = mysqli_fetch_array($consulta)){
			            $id_patrullas = $dat['id_patrullas'];
			            $nombre_p = $dat['nombre'];

			            if($patrulla_u == $id_patrullas ) 
			            {
			                $seleccion = 'selected'; 
			            }
			            else
			            {
			             $seleccion= "";
			            }

			            $patrulla = $patrulla.'<option '.$seleccion.' value="'.$id_patrullas.'">'.$nombre_p.'</option>';
			        }
	    		}

	    		$tipo_cuenta_u=$tipo_cuenta_u;
	    		$calidad_miembro=$calidad_miembro_u;

	        }
	    }
	    else //Muestra el error si existe otro jefe de patrulla...
	    {
	    	$error_email = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> Ya existe un Jefe para la patrulla '.$nombre_p.'</div>';
	    }
		desconectar($conexion);
    }
?>