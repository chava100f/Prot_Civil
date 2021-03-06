<?php 

function obtener_mensaje() //código para obtener el nombre del usuario
{

    require_once("funciones.php");
    $conexion = conectar();

    $user=$_SESSION['logged_user'];

    $query = 'SELECT nombre, apellido_p, apellido_m FROM datos_personales WHERE email="'.$user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    $mensaje="";

    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $apellido_p = $dat['apellido_p'];
            $apellido_m = $dat['apellido_m'];
            $nombre = $dat['nombre'];
        }
    }

    $mensaje=$nombre." ".$apellido_p." ".$apellido_m."";     

    desconectar($conexion);

    return $mensaje;
}

function obtener_imagen_perfil() //código extra para conocer las vacunas internacionales basado en la teroria de la diferencia de conjuntos A-B
{  
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

    $query = 'SELECT fotografia FROM datos_personales WHERE id_num_reg="'.$id_usuario.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $dir_temp_foto = $dat['fotografia'];
        }
    }

    desconectar($conexion);

    return $dir_temp_foto;
}

function obtener_patrulla_actual()//código para obtener el nombre de la patrulla
{
    require_once("funciones.php");
    $conexion = conectar();

    $user=$_SESSION['logged_user'];

    $query = 'SELECT patrullas_id_patrullas FROM datos_personales WHERE email="'.$user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $id_patrulla = $dat['patrullas_id_patrullas'];
        }
    }

    $query = 'SELECT nombre FROM patrullas WHERE id_patrullas='.$id_patrulla;
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $nombre_patrulla = $dat['nombre'];
        }
    }

    desconectar($conexion);

    return $nombre_patrulla;
}

function obtener_jefe_patrulla()//código para obtener el nombre del jefe patrulla
{
    require_once("funciones.php");
    $conexion = conectar();

    $user=$_SESSION['logged_user'];

    $query = 'SELECT patrullas_id_patrullas FROM datos_personales WHERE email="'.$user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $id_patrulla = $dat['patrullas_id_patrullas'];
        }
    }

    $query = 'SELECT nombre, apellido_p, apellido_m FROM datos_personales WHERE patrullas_id_patrullas='.$id_patrulla.' AND tipo_cuenta="JEFE"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $nombre = $dat['nombre'];
            $apellido_p = $dat['apellido_p'];
            $apellido_m = $dat['apellido_m'];
        }
    }
    else
    {
        $nombre = "";
        $apellido_p = "";
        $apellido_m = "";
    }


    desconectar($conexion);

    return $nombre." ".$apellido_p." ".$apellido_m;
}

function obtener_porcentaje_datos_bd()//código para obtener el porcentaje de registro en la BD
{
    require_once("funciones.php");
    $conexion = conectar();

    $user=$_SESSION['logged_user'];

    $porcentaje=20;

    $query = 'SELECT id_num_reg FROM datos_personales WHERE email="'.$user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $id_user = $dat['id_num_reg'];
        }
    }

    $query = 'SELECT datos_personales_id_num_reg FROM datos_complementarios WHERE datos_personales_id_num_reg='.$id_user;
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $porcentaje = $porcentaje + 20;
        }
    }

    $query = 'SELECT datos_personales_id_num_reg FROM info_fisica WHERE datos_personales_id_num_reg='.$id_user;
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $porcentaje = $porcentaje + 20;
        }
    }

    $query = 'SELECT datos_personales_id_num_reg FROM info_medica WHERE datos_personales_id_num_reg='.$id_user;
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $porcentaje = $porcentaje + 20;
        }
    }

    $query = 'SELECT datos_personales_id_num_reg FROM antecedentes WHERE datos_personales_id_num_reg='.$id_user;
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $porcentaje = $porcentaje + 20;
        }
    }

    desconectar($conexion);

    return $porcentaje;
}

function obtener_patrulla_integrantes()//código para obtener el nombre de los integrantes de la patrulla
{
    require_once("funciones.php");
    $conexion = conectar();

    $user=$_SESSION['logged_user'];

    $query = 'SELECT patrullas_id_patrullas FROM datos_personales WHERE email="'.$user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $id_patrulla = $dat['patrullas_id_patrullas'];
        }
    }

    $query = 'SELECT nombre, apellido_p, apellido_m FROM datos_personales WHERE patrullas_id_patrullas='.$id_patrulla.' AND calidad_miembro="activo"';
    $consulta = ejecutarQuery($conexion, $query);
    $mensaje ="";
    $cont=1;
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $mensaje.="<tr><td>".$cont++."</td>";
            $mensaje.="<td>".$dat['nombre']."</td>";
            $mensaje.="<td>".$dat['apellido_p']."</td>";
            $mensaje.="<td>".$dat['apellido_m']."</td></tr>";
        }
    }
    else
    {
        $mensaje="<tr><td>".$cont."</td></tr>";
    }
    desconectar($conexion);
    return $mensaje;
}

    require_once("funciones.php");
    $conexion = conectar();

    $user=$_SESSION['logged_user'];
    $id_user="";

    $query = 'SELECT id_num_reg FROM datos_personales WHERE email="'.$user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $id_user = $dat['id_num_reg'];
        }
    }
    desconectar($conexion);

?>