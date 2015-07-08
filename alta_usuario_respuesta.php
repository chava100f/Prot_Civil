<?php

    $nombre = $_GET['nombre'];
    $ap = $_GET['ap'];
    $am = $_GET['am'];

    $n="";
    $ap_bd="";

    require_once("funciones.php");
    $conexion = conectar();


    $query = 'SELECT nombre, apellido_p, email FROM datos_personales WHERE nombre = "'.$nombre.'" AND apellido_p = "'.$ap.'"';
    $consulta = ejecutarQuery($conexion, $query);

    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $n = $dat['nombre'];
            $ap_bd = $dat['apellido_p'];
            $email = $dat['email'];
        }
    }

    desconectar($conexion);

    $mensaje="";

    if($n!=$nombre)
    {   
        $mensaje = "Ocurrio un error al dar de alta la patrulla intente de nuevo";
    }
    else
    {
        $mensaje = "El usuario ".$n." ".$ap." ".$am." a sido agregado Exitosamente <br> Con el usuario: <b>".$email."</b>";
    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<link rel="stylesheet" type="text/css" href="EstiloT0202.css">
	<title>Alta Patrulla Respuesta</title>
</head>
<body>
</body>

	<h1> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h1>
	<h2>Alta nueva patrulla al sistema</h2>

	<h3>
        <b><?php echo $mensaje; ?></b>
    </h3>

    <h4><a href="index.php">Regresar a la pagina de log in</a></h4>
</html>
