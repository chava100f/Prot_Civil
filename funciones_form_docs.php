<?php

	function subir_archivo($id_u, $nombre_archivo, $file_tmp, $file_type, $file_size)
	{
		$mensaje_funcion = "";
		$target_dir = "documentos/".$id_u; //la dirección para guardar los documentos del usuario
		$uploadOk = 1;

		$error="";

		// Check if image file is a actual image or fake image
		/*
	    $check = getimagesize($file_tmp);
	    if($check !== false) {
	        //echo "File is an image - ".$check["mime"].".";
	        $uploadOk = 1;
	        //echo "primer if check if false";
	    } else {
	        $mensaje_funcion = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> El archivo no es válido.</div>';
	        $uploadOk = 0;
	        //echo "primer else check if false";
	    }*/

	    if($uploadOk!==0)
	    {
		    $imageFileType= substr($file_type, 6);// elimina el resultado de image/ y deja solo el tipo

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf") {
			    $mensaje_funcion = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> El archivo no tiene el formato adecuado. '.$file_type.'</div>';
			    $uploadOk = 0;
			    // echo "no es formato de imagen ".$imageFileType;
			}

			if($uploadOk!==0)
	    	{

				// Check file size
				if ($file_size > 2000000) {// 2MB
				    $mensaje_funcion = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> El archivo tiene un peso mayor a 2 MB.</div>';
				    $uploadOk = 0;
				}

				if($uploadOk!==0)
	    		{

					$bandera_crea_dir=1;

					if(!file_exists($target_dir)) //Revisa que el directorio destino exista, si no entonces lo crea.
					{	
						//echo "No existe el directorio, se crea...";
						mkdir($target_dir); //crea la carpeta 

						//Como medida preventiva actualiza el registro en la BD donde se supone esta la dirección para la imagen de perfil
						$query = 'UPDATE documentos SET '.$nombre_archivo.' = "" WHERE datos_personales_id_num_reg="'.$id_u.'"';
					    $consulta = ejecutarQuery($conexion, $query);
					    $bandera_crea_dir = 0;
					}

					$dir_temp_foto ="";

					if($bandera_crea_dir!==0) //si no se acaba de crear la carpeta y limpar el registro de la BD...
					{	//se debera obtener la direccion de la imagen de perfil el la BD

						//echo "Se acaba de limpiar la BD y se borro el archivo...";
						$query = 'SELECT '.$nombre_archivo.' FROM documentos WHERE datos_personales_id_num_reg="'.$id_u.'"';
					    $consulta = ejecutarQuery($conexion, $query);
					    if (mysqli_num_rows($consulta)) {
					        while ($dat = mysqli_fetch_array($consulta)){
					            $dir_temp_foto = $dat[$nombre_archivo];
					        }
					    }

					    $dir_temp_foto = realpath($dir_temp_foto); //obtiene la ruta completa del archivo

					    //Codigo para obtener permisos de admin para eliminar el archivo antes de remplazarlo...
						chmod( $dir_temp_foto, 0777 );
					    unlink($dir_temp_foto); //elimina el archivo
					    //echo "unlink(".$dir_temp_foto;
					    
					    //elimina la ruta de la foto en la BD
					    $query = 'UPDATE documentos SET '.$nombre_archivo.' = "" WHERE datos_personales_id_num_reg="'.$id_u.'"';
					    $consulta = ejecutarQuery($conexion, $query);
					}

					//agrega el nombre de la imagen junto con su formato
					$target_file = $target_dir."/".$nombre_archivo.$imageFileType;
					
					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
					    $mensaje_funcion = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> el archivo no pudo subirse.</div>';
					// if everything is ok, try to upload file
					} else {
					    if (move_uploaded_file($file_tmp, $target_file)) {
					        //echo "The file ". basename( $_FILES["foto_perfil"]["name"]). " has been uploaded.";

					        //agrega la ruta a la BD
					        $query = 'UPDATE documentos SET '.$nombre_archivo.' = "'.$target_file.'" WHERE datos_personales_id_num_reg="'.$id_u.'"';
					    	$consulta = ejecutarQuery($conexion, $query);
					    	$mensaje_funcion = 'Exito';
					    } else {
					        $mensaje_funcion = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> el archivo no pudo subirse.</div>';
					    }
					}
				}
			}
		}

		return $mensaje_funcion;
	}

	$mensaje_server_acta_nac = "";
	$mensaje_server_curp = "";
	$mensaje_server_ife = "";
	$mensaje_server_comprobante_dom = "";
	$mensaje_server_cv = "";
	$mensaje_server_lic_manejo = "";
	$mensaje_server_ced_prof = "";
	$mensaje_server_cartilla_serv_mil = "";
	$mensaje_server_carnet_afiliacion = "";
	$mensaje_server_pasaporte = "";

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
		//echo "<br><br><br><br><br><br><br><br><br><br><br><br>";

	    $target_dir = "documentos"; //la dirección para guardar los documentos

	    if(!file_exists($target_dir)) //Revisa que el directorio destino exista, si no entonces lo crea.
		{	
			//echo "No existe el directorio, se crea...";
			mkdir($target_dir); //crea la carpeta 
		}

		//Se manda a llamar la funcion para subir los archivos

		//Sube acta de nacimiento 
		$respuesta_f=subir_archivo($id_usuario, $_FILES["acta_nacimiento"]["tmp_name"], $_FILES["acta_nacimiento"]["type"], $_FILES["acta_nacimiento"]["size"],"acta_nacimiento");

		if($respuesta_f==="Exito")
		{
			$mensaje_server_acta_nac = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>ACTA DE NACIMIENTO</strong> correctamente.</div>';
		}
		else
		{
			$mensaje_server_acta_nac = $respuesta_f;
		}
		/*

		//Sube CURP
		$respuesta_f=subir_archivo($id_usuario, $_FILES["curp"]["tmp_name"], $_FILES["curp"]["type"], $_FILES["curp"]["size"],"curp");

		if($respuesta_f==="Exito")
		{
			$mensaje_server_curp = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>CURP</strong> correctamente.</div>';
		}

		//Sube IFE 
		$respuesta_f=subir_archivo($id_usuario, $_FILES["ife"]["tmp_name"], $_FILES["ife"]["type"], $_FILES["ife"]["size"],"ife");

		if($respuesta_f==="Exito")
		{
			$mensaje_server_ife = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>IFE</strong> correctamente.</div>';
		}

		//Sube Comprobante de domicilio
		$respuesta_f=subir_archivo($id_usuario, $_FILES["comprobante_dom"]["tmp_name"], $_FILES["comprobante_dom"]["type"], $_FILES["comprobante_dom"]["size"],"comprobante_dom");

		if($respuesta_f==="Exito")
		{
			$mensaje_server_comprobante_dom = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>COMPROBANTE DE DOMICILIO</strong> correctamente.</div>';
		}

		//Sube Curriculum 
		$respuesta_f=subir_archivo($id_usuario, $_FILES["curriculum"]["tmp_name"], $_FILES["curriculum"]["type"], $_FILES["curriculum"]["size"],"curriculum");

		if($respuesta_f==="Exito")
		{
			$mensaje_server_cv = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>CURRICULUM</strong> correctamente.</div>';
		}

		//Sube Licencia de manejo
		$respuesta_f=subir_archivo($id_usuario, $_FILES["licencia_manejo"]["tmp_name"], $_FILES["licencia_manejo"]["type"], $_FILES["licencia_manejo"]["size"],"licencia_manejo");

		if($respuesta_f==="Exito")
		{
			$mensaje_server_lic_manejo = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>LICENCIA DE MANEJO</strong> correctamente.</div>';
		}

		//Sube Cédula profesional
		$respuesta_f=subir_archivo($id_usuario, $_FILES["cedula_profesional"]["tmp_name"], $_FILES["cedula_profesional"]["type"], $_FILES["cedula_profesional"]["size"],"cedula_profesional");

		if($respuesta_f==="Exito")
		{
			$mensaje_server_ced_prof = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>CÉDULA PROFESIONAL</strong> correctamente.</div>';
		}

		//Sube Cartilla servicio militar
		$respuesta_f=subir_archivo($id_usuario, $_FILES["cartilla_servicio_militar"]["tmp_name"], $_FILES["cartilla_servicio_militar"]["type"], $_FILES["cartilla_servicio_militar"]["size"],"cartilla_servicio_militar");

		if($respuesta_f==="Exito")
		{
			$mensaje_server_cartilla_serv_mil = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>CARTILLA DEL SERVICIO MILITAR</strong> correctamente.</div>';
		}

		//Sube Carnet o afiliación
		$respuesta_f=subir_archivo($id_usuario, $_FILES["carnet_afiliacion"]["tmp_name"], $_FILES["carnet_afiliacion"]["type"], $_FILES["carnet_afiliacion"]["size"],"carnet_afiliacion");

		if($respuesta_f==="Exito")
		{
			$mensaje_server_carnet_afiliacion = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>CARNET O AFILIACIÓN</strong> correctamente.</div>';
		}

		//Sube Pasaporte
		$respuesta_f=subir_archivo($id_usuario, $_FILES["pasaporte"]["tmp_name"], $_FILES["pasaporte"]["type"], $_FILES["pasaporte"]["size"],"pasaporte");

		if($respuesta_f==="Exito")
		{
			$mensaje_server_pasaporte = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>PASAPORTE</strong> correctamente.</div>';
		}
		*/

		desconectar($conexion);
        
   	}

?>


