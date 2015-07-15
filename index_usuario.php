<?php
session_start();
if($_SESSION['logged'] == 'yes')
{

	function obtener_mensaje() //código para llenar la tabla de las patrullas actuales en la BD.
    {

        require_once("funciones.php");
        $conexion = conectar();

        $user=$_SESSION['logged_user'];

        $query = 'SELECT nombre, apellido_p, apellido_m, patrullas_id_patrullas FROM datos_personales WHERE email="'.$user.'"';
        $consulta = ejecutarQuery($conexion, $query);
        $mensaje="";

        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $apellido_p = $dat['apellido_p'];
                $apellido_m = $dat['apellido_m'];
                $nombre = $dat['nombre'];
                $id_patrulla = $dat['patrullas_id_patrullas'];
            }
        }

        $mensaje="Bienvenido ".$nombre." ".$apellido_p." ".$apellido_m."";     

        desconectar($conexion);

        return $mensaje;
    }

    function obtener_patrulla_actual()
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

    function obtener_porcentaje_datos_bd()
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

        //TO DO revisar como subir los datos de experiencia y revisar que si se encuentren todos los datos que creo que faltan algunos de hecho hasta en la BD

        desconectar($conexion);

        return $porcentaje;
    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<link rel="stylesheet" type="text/css" href="EstiloT0202.css">
	<title>Index Usuario</title>
</head>
<body>
</body>

<h1> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h1>
<h2><?php echo obtener_mensaje(); ?></h2>
<h3> Patrulla actual: <u><?php echo obtener_patrulla_actual(); ?></u><h3/>
<br>
<h4>Porcentaje de Datos en el sistema <span style="color:green"> <?php echo obtener_porcentaje_datos_bd();?>% </span> </h4>
<br>
<h4><a href="form_complementario.php">Actualizar información Complementaria del perfil</a></h4>
<h4><a href="form_medico.php">Actualizar información Medica</a></h4>
<h4><a href="form_info_fisica.php">Actualizar información Fisica</a></h4>
<h4><a href="form_experiencia.php">Actualizar información de experiencia en Patrullaje y Rescate</a></h4>


</html>


<?php
}
else
	header('Location : index.php');
?>
