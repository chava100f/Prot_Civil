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
		//echo "<br><br><br><br><br><br><br><br><br><br><br><br>";

	    $target_dir = "documentos"; //la dirección para guardar los documentos

	    if(!file_exists($target_dir)) //Revisa que el directorio destino exista, si no entonces lo crea.
		{	
			//echo "No existe el directorio, se crea...";
			mkdir($target_dir); //crea la carpeta 
		}

		$target_dir = "documentos/".$id_usuario; //la dirección para guardar la imagen de perfil del usuario
		$uploadOk = 1;

		$error="";

		// Check if image file is a actual image or fake image
		
	    $check = getimagesize($_FILES["foto_perfil"]["tmp_name"]);
	    if($check !== false) {
	        //echo "File is an image - ".$check["mime"].".";
	        $uploadOk = 1;
	        //echo "primer if check if false";
	    } else {
	        $mensaje_server = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> El archivo no es una imagen.</div>';
	        $uploadOk = 0;
	        //echo "primer else check if false";
	    }

	    if($uploadOk!==0)
	    {
		    $imageFileType= substr($_FILES["foto_perfil"]["type"], 6);// elimina el resultado de image/ y deja solo el tipo

			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
			    $mensaje_server = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> El archivo no tiene el formato adecuado.</div>';
			    $uploadOk = 0;
			    // echo "no es formato de imagen ".$imageFileType;
			}

			if($uploadOk!==0)
	    	{

				// Check file size
				if ($_FILES["foto_perfil"]["size"] > 2000000) {// 2MB
				    $mensaje_server = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> El archivo tiene un peso mayor a 2 MB.</div>';
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
						$query = 'UPDATE datos_personales SET fotografia = "" WHERE id_num_reg="'.$id_usuario.'"';
					    $consulta = ejecutarQuery($conexion, $query);
					    $bandera_crea_dir = 0;
					}

					$dir_temp_foto ="";

					if($bandera_crea_dir!==0) //si no se acaba de crear la carpeta y limpar el registro de la BD...
					{	//se debera obtener la direccion de la imagen de perfil el la BD

						//echo "Se acaba de limpiar la BD y se borro el archivo...";
						$query = 'SELECT fotografia FROM datos_personales WHERE id_num_reg="'.$id_usuario.'"';
					    $consulta = ejecutarQuery($conexion, $query);
					    if (mysqli_num_rows($consulta)) {
					        while ($dat = mysqli_fetch_array($consulta)){
					            $dir_temp_foto = $dat['fotografia'];
					        }
					    }

					    $dir_temp_foto = realpath($dir_temp_foto); //obtiene la ruta completa del archivo

					    //Codigo para obtener permisos de admin para eliminar el archivo antes de remplazarlo...
						chmod( $dir_temp_foto, 0777 );
					    unlink($dir_temp_foto); //elimina el archivo
					    //echo "unlink(".$dir_temp_foto;
					    
					    //elimina la ruta de la foto en la BD
					    $query = 'UPDATE datos_personales SET fotografia = "" WHERE id_num_reg="'.$id_usuario.'"';
					    $consulta = ejecutarQuery($conexion, $query);
					}

					//agrega el nombre de la imagen junto con su formato
					$target_file = $target_dir."/foto_perfil.".$imageFileType;
					
					// Check if $uploadOk is set to 0 by an error
					if ($uploadOk == 0) {
					    $mensaje_server = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> la imagen no pudo subirse.</div>';
					// if everything is ok, try to upload file
					} else {
					    if (move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $target_file)) {
					        //echo "The file ". basename( $_FILES["foto_perfil"]["name"]). " has been uploaded.";

					        //agrega la ruta a la BD
					        $query = 'UPDATE datos_personales SET fotografia = "'.$target_file.'" WHERE id_num_reg="'.$id_usuario.'"';
					    	$consulta = ejecutarQuery($conexion, $query);
					    	$mensaje_server = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> se ha cambiado la imagen de perfil correctamente.</div>';
					    } else {
					        $mensaje_server = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> la imagen no pudo subirse.</div>';
					    }
					}
				}
			}
		}

		desconectar($conexion);
        
   	}

?>


