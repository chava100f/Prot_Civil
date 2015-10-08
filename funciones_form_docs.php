<?php

	require_once("funciones.php");
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

    //desconectar($conexion);

	function ver_archivos($id_u,$nombre_archivo)
	{
		$conexion3 = conectar();

		$query = "SELECT ".$nombre_archivo." FROM documentos WHERE datos_personales_id_num_reg=".$id_u.";";
		$consulta = ejecutarQuery($conexion3, $query);
	    if (mysqli_num_rows($consulta)) {
	        while ($dat = mysqli_fetch_array($consulta)){
	            $mensaje_funcion = $dat[$nombre_archivo];
	        }
	    }
	    if($mensaje_funcion=="" || is_null($mensaje_funcion))
	    {
	    	$mensaje_funcion='<div class="alert alert-warning" role="alert">El archivo aún no se ha subido.</div>';
	    }
	    else
	    {
	    	$link_archivo="<a href='".$mensaje_funcion."'>";
	    	$mensaje_funcion='<div class="alert alert-info" role="alert">El archivo ya se ha subido. para ver dar '.$link_archivo.'click aquí</a></div>';
	    }

	    desconectar($conexion3);

		return $mensaje_funcion;
	}

	function subir_archivo($id_u, $file_tmp, $file_type, $file_size, $nombre_archivo)
	{
		$mensaje_funcion = "";
	    $conexion2 = conectar();

		$target_dir = "documentos"; //la dirección para guardar los documentos

	    if(!file_exists($target_dir)) //Revisa que el directorio destino exista, si no entonces lo crea.
		{	
			//echo "No existe el directorio, se crea...";
			//chmod($target_dir, 0777 );
			mkdir($target_dir); //crea la carpeta 
		}

		$target_dir = "documentos/".$id_u; //la dirección para guardar los documentos del usuario
		$uploadOk = 1;

		$error="";

	    if($uploadOk!==0)
	    {
		    $imageFileType= substr($file_type, 6);// elimina el resultado de image/ y deja solo el tipo
		    $pdfFileType= substr($file_type, 12);// elimina el resultado de image/ y deja solo el tipo

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $pdfFileType != "pdf") {
			    $mensaje_funcion = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> El archivo no tiene el formato adecuado. '.$file_type.'</div>';
			    $uploadOk = 0;
			    // echo "no es formato de imagen ".$imageFileType;
			}
			if($pdfFileType=="pdf")
			{
				$imageFileType=$pdfFileType;
			}

			if($uploadOk!==0)
	    	{

				// Check file size
				if ($file_size > 2000000) 
				{// 2MB
				    $mensaje_funcion = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> El archivo tiene un peso mayor a 2 MB.</div>';
				    $uploadOk = 0;
				}

				if($uploadOk!==0)
	    		{

					if(!file_exists($target_dir)) //Revisa que el directorio destino exista, si no entonces lo crea.
					{	
						//echo "No existe el directorio, se crea...";
						//chmod( $target_dir, 0777 );
						mkdir($target_dir); //crea la carpeta 
					}
					$dato_bd_temporal="";

					//Busca que exista el regustro del usuario si no lo crea en la BD
					$query = 'SELECT datos_personales_id_num_reg FROM documentos WHERE datos_personales_id_num_reg='.$id_u.';';
				    $consulta = ejecutarQuery($conexion2, $query);
				    if (mysqli_num_rows($consulta)) 
				    {	
				    	while ($dat = mysqli_fetch_array($consulta)){
				            $dato_bd_temporal = $dat['datos_personales_id_num_reg'];
				        }
				    }
				    else{
				    	$dato_bd_temporal="";
				    }
				    if($dato_bd_temporal=="") //Si no encontro nada en la base entonces crea el registro...
				    {
						$query = 'INSERT INTO documentos(datos_personales_id_num_reg) VALUES ('.$id_u.');';
					    $consulta = ejecutarQuery($conexion2, $query);
				    }
				    else //Si lo encontro entonces borra el archivo existente para remplazarlo
				    {
				    	//Busca que exista el regustro del usuario si no lo crea en la BD
				    	$dir_temp_doc="";
						$query = 'SELECT '.$nombre_archivo.' FROM documentos WHERE datos_personales_id_num_reg="'.$id_u.'"';
					    $consulta = ejecutarQuery($conexion2, $query);
					    if (mysqli_num_rows($consulta)) 
					    {	
					    	while ($dat = mysqli_fetch_array($consulta)){
					            $dir_temp_doc = $dat[$nombre_archivo];
					        }
					    }
					    if($dir_temp_doc!="" || is_null(!$dir_temp_doc)) //revisa que si esta vacio el registro del archivo a subir en la BD
					    {
					    	$dir_temp_doc = realpath($dir_temp_doc); //obtiene la ruta completa del archivo
				        	unlink($dir_temp_doc); //elimina el archivo
					    }				        
				    }

					//agrega el nombre de la imagen junto con su formato
					$target_file = $target_dir."/".$nombre_archivo.".".$imageFileType;
					   
					// if everything is ok, try to upload file
				    if (move_uploaded_file($file_tmp, $target_file)) 
				    {
				        //agrega la ruta a la BD
				        $query = 'UPDATE documentos SET '.$nombre_archivo.' = "'.$target_file.'" WHERE datos_personales_id_num_reg="'.$id_u.'"';
				    	$consulta = ejecutarQuery($conexion2, $query);
				    	$mensaje_funcion = 'Exito';
				    } 
				    else 
				    {
				        $mensaje_funcion = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> el archivo no pudo subirse.</div>';
				    }
					
				}
				else// Check if $uploadOk is set to 0 by an error
				{
					$mensaje_funcion = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> el archivo no pudo subirse.</div>';
				}
			}
		}

		desconectar($conexion2);

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
    	//require("funciones.php");
	    //$conexion = conectar();

	    $user=$_SESSION['logged_user'];
	    $id_usuario="";

	    $query = 'SELECT id_num_reg FROM datos_personales WHERE email="'.$user.'"';
	    $consulta = ejecutarQuery($conexion, $query);
	    if (mysqli_num_rows($consulta)) {
	        while ($dat = mysqli_fetch_array($consulta)){
	            $id_usuario = $dat['id_num_reg'];
	        }
	    }

	    desconectar($conexion);
		//echo "<br><br><br><br><br><br><br><br><br><br><br><br>";

		//Se manda a llamar la funcion para subir los archivos

		//Sube acta de nacimiento 
		if($_FILES["acta_nacimiento"]["tmp_name"])
		{
			$respuesta_f=subir_archivo($id_usuario, $_FILES["acta_nacimiento"]["tmp_name"], $_FILES["acta_nacimiento"]["type"], $_FILES["acta_nacimiento"]["size"],"acta_nacimiento");

			if($respuesta_f==="Exito")
			{
				$mensaje_server_acta_nac = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>ACTA DE NACIMIENTO</strong> correctamente.</div>';
			}
			else 
			{
				$mensaje_server_acta_nac = $respuesta_f." ".$_FILES["acta_nacimiento"]["type"];
			}
		}
		

		//Sube CURP
		if($_FILES["curp"]["tmp_name"])
		{
			$respuesta_f=subir_archivo($id_usuario, $_FILES["curp"]["tmp_name"], $_FILES["curp"]["type"], $_FILES["curp"]["size"],"curp");

			if($respuesta_f==="Exito")
			{
				$mensaje_server_curp = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>CURP</strong> correctamente.</div>';
			}
			else 
			{
				$mensaje_server_curp = $respuesta_f." ".$_FILES["curp"]["type"];
			}
		}

		//Sube IFE 
		if($_FILES["ife"]["tmp_name"])
		{
			$respuesta_f=subir_archivo($id_usuario, $_FILES["ife"]["tmp_name"], $_FILES["ife"]["type"], $_FILES["ife"]["size"],"ife");

			if($respuesta_f==="Exito")
			{
				$mensaje_server_ife = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>IFE</strong> correctamente.</div>';
			}
			else 
			{
				$mensaje_server_ife = $respuesta_f." ".$_FILES["ife"]["type"];
			}
		}

		//Sube Comprobante de domicilio
		if($_FILES["comprobante_dom"]["tmp_name"])
		{
			$respuesta_f=subir_archivo($id_usuario, $_FILES["comprobante_dom"]["tmp_name"], $_FILES["comprobante_dom"]["type"], $_FILES["comprobante_dom"]["size"],"comprobante_dom");

			if($respuesta_f==="Exito")
			{
				$mensaje_server_comprobante_dom = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>COMPROBANTE DE DOMICILIO</strong> correctamente.</div>';
			}
			else 
			{
				$mensaje_server_comprobante_dom = $respuesta_f." ".$_FILES["comprobante_dom"]["type"];
			}
		}

		//Sube Curriculum 
		if($_FILES["curriculum"]["tmp_name"])
		{
			$respuesta_f=subir_archivo($id_usuario, $_FILES["curriculum"]["tmp_name"], $_FILES["curriculum"]["type"], $_FILES["curriculum"]["size"],"curriculum");

			if($respuesta_f==="Exito")
			{
				$mensaje_server_cv = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>CURRICULUM</strong> correctamente.</div>';
			}
			else 
			{
				$mensaje_server_cv = $respuesta_f." ".$_FILES["curriculum"]["type"];
			}
		}

		//Sube Licencia de manejo
		if($_FILES["licencia_manejo"]["tmp_name"])
		{
			$respuesta_f=subir_archivo($id_usuario, $_FILES["licencia_manejo"]["tmp_name"], $_FILES["licencia_manejo"]["type"], $_FILES["licencia_manejo"]["size"],"licencia_manejo");

			if($respuesta_f==="Exito")
			{
				$mensaje_server_lic_manejo = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>LICENCIA DE MANEJO</strong> correctamente.</div>';
			}
			else 
			{
				$mensaje_server_lic_manejo = $respuesta_f." ".$_FILES["licencia_manejo"]["type"];
			}
		}

		//Sube Cédula profesional
		if($_FILES["cedula_profesional"]["tmp_name"])
		{
			$respuesta_f=subir_archivo($id_usuario, $_FILES["cedula_profesional"]["tmp_name"], $_FILES["cedula_profesional"]["type"], $_FILES["cedula_profesional"]["size"],"cedula_profesional");

			if($respuesta_f==="Exito")
			{
				$mensaje_server_ced_prof = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>CÉDULA PROFESIONAL</strong> correctamente.</div>';
			}
			else 
			{
				$mensaje_server_ced_prof = $respuesta_f." ".$_FILES["cedula_profesional"]["type"];
			}
		}

		//Sube Cartilla servicio militar
		if($_FILES["cartilla_servicio_militar"]["tmp_name"])
		{
			$respuesta_f=subir_archivo($id_usuario, $_FILES["cartilla_servicio_militar"]["tmp_name"], $_FILES["cartilla_servicio_militar"]["type"], $_FILES["cartilla_servicio_militar"]["size"],"cartilla_servicio_militar");

			if($respuesta_f==="Exito")
			{
				$mensaje_server_cartilla_serv_mil = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>CARTILLA DEL SERVICIO MILITAR</strong> correctamente.</div>';
			}
			else 
			{
				$mensaje_server_cartilla_serv_mil = $respuesta_f." ".$_FILES["cartilla_servicio_militar"]["type"];
			}
		}

		//Sube Carnet o afiliación
		if($_FILES["carnet_afiliacion"]["tmp_name"])
		{
			$respuesta_f=subir_archivo($id_usuario, $_FILES["carnet_afiliacion"]["tmp_name"], $_FILES["carnet_afiliacion"]["type"], $_FILES["carnet_afiliacion"]["size"],"carnet_afiliacion");

			if($respuesta_f==="Exito")
			{
				$mensaje_server_carnet_afiliacion = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>CARNET O AFILIACIÓN</strong> correctamente.</div>';
			}
			else 
			{
				$mensaje_server_carnet_afiliacion = $respuesta_f." ".$_FILES["carnet_afiliacion"]["type"];
			}
		}

		//Sube Pasaporte
		if($_FILES["pasaporte"]["tmp_name"])
		{
			$respuesta_f=subir_archivo($id_usuario, $_FILES["pasaporte"]["tmp_name"], $_FILES["pasaporte"]["type"], $_FILES["pasaporte"]["size"],"pasaporte");

			if($respuesta_f==="Exito")
			{
				$mensaje_server_pasaporte = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha subido el archivo <strong>PASAPORTE</strong> correctamente.</div>';
			}
			else 
			{
				$mensaje_server_pasaporte = $respuesta_f." ".$_FILES["pasaporte"]["type"];
			}
		}
	        
   	}

?>


