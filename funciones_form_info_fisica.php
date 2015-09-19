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

    $sexo = "";                 
    $estatura = "";
    $peso = "";
    $complexion ="";
    $cabello = "";
    $ojos = "";
    $cara = "";
    $nariz = "";
    $senias = "";

    $query = 'SELECT * FROM info_fisica WHERE datos_personales_id_num_reg="'.$id_user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $sexo = $dat['genero'];                      
            $estatura = $dat['estatura'];
            $peso = $dat['peso'];
            $complexion = $dat['complexion'];
            $cabello = $dat['cabello'];
            $ojos = $dat['ojos'];
            $cara = $dat['cara'];
            $nariz = $dat['nariz'];
            $senias = $dat['senias_particulares'];
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

        $sexo = mysqli_real_escape_string($conexion, strip_tags($_POST['sexo']));
        $estatura = mysqli_real_escape_string($conexion, strip_tags($_POST['estatura']));
        $peso = mysqli_real_escape_string($conexion, strip_tags($_POST['peso']));
        $complexion = mysqli_real_escape_string($conexion, strip_tags($_POST['complexion']));
        $cabello = mysqli_real_escape_string($conexion, strip_tags($_POST['cabello']));
        $ojos = mysqli_real_escape_string($conexion, strip_tags($_POST['ojos']));
        $cara = mysqli_real_escape_string($conexion, strip_tags($_POST['cara']));
        $nariz = mysqli_real_escape_string($conexion, strip_tags($_POST['nariz']));
        $senias = mysqli_real_escape_string($conexion, strip_tags($_POST['senias']));

        //TO DO Elaboración del Query (tratar de pasar esto a un Store procedure)!!!
        //Actualización de los datos en la tabla info_fisica

        $contador = 0; //variable para revisar si ya esta registrado el usuario, si sí se actualizan los datos, si no se inserta un nuevo registro en la BD

        $query = 'SELECT * FROM info_fisica WHERE datos_personales_id_num_reg="'.$id_user.'"';
        $consulta = ejecutarQuery($conexion, $query);
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $contador = 1;
            }
        }

        if($contador === 0) //se inserta un nuevo registro en la BD
        {
            //Inserta nuevo registro en la tabla info_fisica
            $query = 'INSERT INTO info_fisica(genero, estatura, peso, complexion, cabello, ojos, cara, nariz, senias_particulares, datos_personales_id_num_reg)';
            $query = $query.' VALUES ("'.$sexo.'", '.$estatura.', '.$peso.', "'.$complexion.'", "'.$cabello.'", "'.$ojos.'", "'.$cara.'", "'.$nariz.'", "'.$senias.'", '.$id_user.')';
        }
        else //se actualizan los datos que ya existian en la BD
        {
            //Actualiza la tabla info_fisica
            $query = 'UPDATE info_fisica SET genero="'.$sexo.'", estatura="'.$estatura.'", peso="'.$peso.'", complexion="'.$complexion.'", cabello="'.$cabello.'", ';
            $query.= 'ojos="'.$ojos.'", cara="'.$cara.'", nariz="'.$nariz.'", senias_particulares="'.$senias.'" ';
            $query .= 'WHERE datos_personales_id_num_reg = "'.$id_user.'"';  
        }

        $consulta = ejecutarQuery($conexion, $query);
        desconectar($conexion);
        
        header("Location: index_usuario.php");
        exit();
               
    }
?>