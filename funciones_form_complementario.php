<?php 
	
    //código para obtener los datos de la BD y mostrarlos ----------------------------------------------

    $user=$_SESSION['logged_user'];

    require_once("funciones.php");
    $conexion = conectar();
    
    $query = 'SELECT id_num_reg FROM datos_personales WHERE email="'.$user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $id_user = $dat['id_num_reg'];
        }
    }

    $nacionalidad = "";                 
    $ocupacion = "";
    $escolaridad = "";
    $estado_civil ="";
    $trabajo_escuela = "";
    $edad = "";
    $cartilla = "";
    $licencia_tipo = "";
    $licencia_num = "";
    $pasaporte = "";
    $correo_rs = "";
    $contacto1 = "";
    $tel_con1 = "";
    $contacto2 = "";
    $tel_con2 = "";

    $query = 'SELECT * FROM datos_complementarios WHERE datos_personales_id_num_reg="'.$id_user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $nacionalidad = $dat['nacionalidad'];                      
            $ocupacion = $dat['ocupacion'];
            $escolaridad = $dat['escolaridad'];
            $estado_civil = $dat['estado_civil'];
            $trabajo_escuela = $dat['trabajo_escuela'];
            $edad = $dat['edad'];
            $cartilla = $dat['cartilla_num'];
            $licencia_tipo = $dat['licencia_tipo'];
            $licencia_num = $dat['licencia_num'];
            $pasaporte = $dat['pasaporte'];
        }
    }

    $query = 'SELECT * FROM datos_personales WHERE id_num_reg="'.$id_user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $correo_rs = $dat['email_red_social'];
            $contacto1 = $dat['contacto1'];
            $tel_con1 = $dat['telefono_c1'];
            $contacto2 = $dat['contacto2'];
            $tel_con2 = $dat['telefono_c2'];
        }
    }         

    desconectar($conexion);

    //--------------------------------------------------------------------------------------------

    if(isset($_POST['actualizar'])) //código para validar los datos del formulario
    {   

        $user=$_SESSION['logged_user'];
        // Actualizacion de datos complementarios

        require_once("funciones.php");
        $conexion = conectar();
        
        $query = 'SELECT id_num_reg FROM datos_personales WHERE email="'.$user.'"';
        $consulta = ejecutarQuery($conexion, $query);
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $id_user = $dat['id_num_reg'];
            }
        }


        //Recoleccion de datos...

        $nacionalidad = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['nacionalidad'])));
        $ocupacion = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['ocupacion'])));
        $escolaridad = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['escolaridad'])));
        $estado_civil = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['estado_civil'])));
        $trabajo_escuela = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['trabajo_escuela'])));
        $edad = mysqli_real_escape_string($conexion, strip_tags($_POST['edad']));
        $cartilla = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['cartilla'])));
        $licencia_tipo = mysqli_real_escape_string($conexion, strip_tags($_POST['licencia_tipo']));
        $licencia_num = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['licencia_num'])));
        $pasaporte = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['pasaporte'])));
        $correo_rs = mysqli_real_escape_string($conexion, strip_tags($_POST['correo_rs']));
        $contacto1 = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['contacto1'])));
        $tel_con1 = mysqli_real_escape_string($conexion, strip_tags($_POST['tel_con1']));
        $contacto2 = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['contacto2'])));
        $tel_con2 = mysqli_real_escape_string($conexion, strip_tags($_POST['tel_con2']));

        //TO DO Elaboración del Query (tratar de pasar esto a un Store procedure)!!!

        $contador = 0; //variable para revisar si ya esta registrado el usuario, si sí se actualizan los datos, si no se inserta un nuevo registro en la BD

        $query = 'SELECT * FROM datos_complementarios WHERE datos_personales_id_num_reg="'.$id_user.'"';
        $consulta = ejecutarQuery($conexion, $query);
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $contador = 1;
            }
        }

        if($contador === 0) //se inserta un nuevo registro en la BD
        {
            //Inserta nuevo registro en la tabla datos_complementarios
            $query = 'INSERT INTO datos_complementarios(estado_civil, ocupacion, escolaridad, edad, trabajo_escuela, nacionalidad, cartilla_num, licencia_tipo, licencia_num, pasaporte, datos_personales_id_num_reg)';
            $query = $query.' VALUES ("'.$estado_civil.'", "'.$ocupacion.'", "'.$escolaridad.'", '.$edad.', "'.$trabajo_escuela.'", "'.$nacionalidad.'", "'.$cartilla.'", "'.$licencia_tipo.'", "'.$licencia_num.'", "'.$pasaporte.'", '.$id_user.')';
            $consulta = ejecutarQuery($conexion, $query);

            //Actualiza la tabla datos personales con los datos que faltaban
            $query = 'UPDATE datos_personales SET email_red_social = "'.$correo_rs.'", contacto1 = "'.$contacto1.'", contacto2 = "'.$contacto2.'", telefono_c1 = "'.$tel_con1.'", telefono_c2 = "'.$tel_con2.'" WHERE id_num_reg = "'.$id_user.'"';
            $consulta = ejecutarQuery($conexion, $query);
        }
        else //se actualizan los datos que ya existian en la BD
        {
            //Actualiza la tabla datos_complementarios
            $query = 'UPDATE datos_complementarios SET estado_civil="'.$estado_civil.'", ocupacion="'.$ocupacion.'", escolaridad="'.$escolaridad.'", edad="'.$edad.'", trabajo_escuela="'.$trabajo_escuela.'", ';
            $query .= 'nacionalidad="'.$nacionalidad.'", cartilla_num="'.$cartilla.'", licencia_tipo="'.$licencia_tipo.'", licencia_num="'.$licencia_num.'", pasaporte="'.$pasaporte.'" ';
            $query .= 'WHERE datos_personales_id_num_reg = "'.$id_user.'"';  
            $consulta = ejecutarQuery($conexion, $query);

            //Actualiza la tabla datos personales con los datos que faltaban
            $query = 'UPDATE datos_personales SET email_red_social = "'.$correo_rs.'", contacto1 = "'.$contacto1.'", contacto2 = "'.$contacto2.'", telefono_c1 = "'.$tel_con1.'", telefono_c2 = "'.$tel_con2.'" WHERE id_num_reg = "'.$id_user.'"';
            $consulta = ejecutarQuery($conexion, $query);
        }

        desconectar($conexion);
        
        header("Location: index_usuario.php");
        exit();
               
    }
?>