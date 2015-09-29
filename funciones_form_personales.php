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

    $nombres = "";                 
    $apellido_p = "";
    $apellido_m = "";
    $fecha_nac = "";
    $dom_calle = "";
    $dom_num_ext = "";
    $dom_num_int = "";
    $dom_colonia = "";
    $dom_estado = "";
    $dom_del_mun = "";
    $dom_cp = "";
    $telefono_casa = "";
    $telefono_celular = "";
    $telefono_trabajo = "";
    $telefono_extension = "";

    $query = 'SELECT * FROM datos_personales WHERE id_num_reg="'.$id_user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $id_user = $dat['id_num_reg'];
            $nombres = $dat['nombre'];                      
            $apellido_p = $dat['apellido_p'];
            $apellido_m = $dat['apellido_m'];
            $fecha_nac = $dat['fecha_nac'];
            $dom_calle = $dat['dom_calle'];
            $dom_num_ext = $dat['dom_num_ext'];
            $dom_num_int = $dat['dom_num_int'];
            $dom_colonia = $dat['dom_col'];
            $dom_estado = $dat['dom_estado'];
            $dom_del_mun = $dat['dom_del_mun'];
            $dom_cp = $dat['dom_cp'];
            $telefono_casa = $dat['telefono_casa'];
            $telefono_celular = $dat['telefono_celular'];
            $telefono_trabajo = $dat['telefono_trabajo'];
            $telefono_extension = $dat['telefono_extension'];
        }
    }

    desconectar($conexion);

    //------------------------------------------------------------------------------------------------------

    function obtener_opcion_e() //código para llenar el catálogo de los estados.
    {

        $user1=$_SESSION['logged_user'];

        require_once("funciones.php");
        $conexion = conectar();
        
        $query = 'SELECT id_num_reg FROM datos_personales WHERE email="'.$user1.'"'; //obtener id de usuario
        $consulta = ejecutarQuery($conexion, $query);
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $id_user1 = $dat['id_num_reg'];
            }
        }

        $query = 'SELECT dom_estado FROM datos_personales WHERE id_num_reg="'.$id_user1.'"'; //obtener el estado registrado en la BD
        $consulta = ejecutarQuery($conexion, $query);
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $dom_estado = $dat['dom_estado'];
            }
        }

        $query = 'SELECT nombre, id FROM estados'; //seleccionar el estado que se había seleccionado
        $consulta = ejecutarQuery($conexion, $query);
        $opciones_e="";
        $contador=0;
        $seleccion="";

        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $id = $dat['id'];
                $nombre = $dat['nombre'];
                $contador++;

                if($dom_estado == $contador ) 
                {
                    $seleccion = 'selected'; 
                }
                else
                {
                 $seleccion= "";
                }

                $opciones_e = $opciones_e.'<option '.$seleccion.' value='.$id.'>'.$nombre.'</option>';
            }
        }

        desconectar($conexion);

        return $opciones_e;
    }
    //--------------------------------------------------------------------------------------------------------


    //Si se da Submit o Enviar primero se validan los datos y despues se incertan en la BD
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

        $fecha_nac = mysqli_real_escape_string($conexion, strip_tags($_POST['fecha_nac']));
        $dom_calle = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['dom_calle'])));
        $dom_num_ext = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['dom_num_ext'])));
        $dom_num_int = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['dom_num_int'])));
        $dom_colonia = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['dom_colonia'])));
        $dom_estado = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['dom_estado'])));
        $dom_del_mun = strtoupper(mysqli_real_escape_string($conexion, strip_tags($_POST['dom_del_mun'])));
        $dom_cp = mysqli_real_escape_string($conexion, strip_tags($_POST['dom_cp']));
        $telefono_casa = mysqli_real_escape_string($conexion, strip_tags($_POST['telefono_casa']));
        $telefono_celular = mysqli_real_escape_string($conexion, strip_tags($_POST['telefono_celular']));
        $telefono_trabajo = mysqli_real_escape_string($conexion, strip_tags($_POST['telefono_trabajo']));
        $telefono_extension = mysqli_real_escape_string($conexion, strip_tags($_POST['telefono_extension']));

        //TO DO Elaboración del Query (tratar de pasar esto a un Store procedure)!!!


        //Actualiza la tabla datos personales....

        $query = 'UPDATE datos_personales SET fecha_nac = "'.$fecha_nac.'", dom_calle = "'.$dom_calle.'", dom_num_ext = "'.$dom_num_ext.'", dom_num_int = "'.$dom_num_int.'", dom_col = "'.$dom_colonia.'",';
        $query .= 'dom_estado = "'.$dom_estado.'", dom_del_mun = "'.$dom_del_mun.'", dom_cp = "'.$dom_cp.'", telefono_casa = "'.$telefono_casa.'", telefono_celular = "'.$telefono_celular.'", ';
        $query .= 'telefono_trabajo = "'.$telefono_trabajo.'", telefono_extension = "'.$telefono_extension.'" ';  
        $query .= 'WHERE id_num_reg = "'.$id_user.'"';      
        $consulta = ejecutarQuery($conexion, $query);

        desconectar($conexion);
        
        header("Location: index_usuario.php");
        exit();
               
    }
?>