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
        $mensaje = "<div class='alert alert-danger' role='alert'> Ocurrió un <strong>error</strong> al dar de alta la patrulla intente de nuevo</div>";
    }
    else
    {
        $mensaje = "<div class='alert alert-success' role='alert'> El usuario ".$n." ".$ap." ".$am." a sido agregado Exitosamente <br> Con el usuario: <strong>".$email."</strong> </div>";
    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/forms-estilo.css" >
	<title>Alta Usuario Respuesta</title>
</head>
<body>

	<div class="container" id="general-form">
        <header class="header-index">
            
            <img src="imagenes/brsam-logo.png" />
            <h2> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h2>
            
        </header>
    </div>

    <div class="container col-xs-offset-3 col-xs-6" id="general-form" >

        <h3>Alta nueva patrulla al sistema</h3>

        <fieldset class="form-horizontal">
            
            <?php echo $mensaje; ?>

            <a href="index.php">
                <button type="button" class="btn btn-lg btn-primary btn-block" name="log">Regresar a la página de inicio de sesión</button>
            </a>
        
        </fieldset>

        <footer class="footer">
            <small>Última modificación Julio 2015</small>
        </footer>
    </div>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
