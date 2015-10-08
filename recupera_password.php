<?php
    
    $mensaje="";

    if(isset($_POST['enviar'])) //código recuperar contraseña
    {   
        require_once("funciones.php");
        $conexion = conectar();

        //Recoleccion de datos...
        $correo = mysqli_real_escape_string($conexion, strip_tags($_POST['correo']));
        
        $query = 'SELECT contrasenia, nombre, apellido_p, apellido_m FROM datos_personales WHERE email="'.$correo.'"';
        $pass="";
        $consulta = ejecutarQuery($conexion, $query);
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $pass = $dat['contrasenia'];
                $nombre = $dat['nombre'];
                $ap_p = $dat['apellido_p'];
                $ap_m = $dat['apellido_m'];
            }
        }
        if($pass=="" || is_null($pass)) //valida que exista el correo a mandar la contraseña
        {
            $mensaje='<div class="alert alert-danger" role="alert"><strong>Error:</strong> El usuario con el correo "'.$correo.'" no fue encontrado.</div>';
        }
        else //Envia el correo 
        {
            //Asunto del correo
            $asunto="Recuperar contraseña, BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C.";
            // the message
            $msg = "
                Hola, ".$nombre." ".$ap_p." ".$ap_m." \n
                La contraseña para el sitio de BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. es la siguiente:\n\n

                <b>".$pass."</b>\n\n

                Si usted no solicito su contraseña, puede ignorar este mensaje.\n\n
                Gracias.
            ";

            // send email
            mail($correo,$asunto,$msg);

            $mensaje='<div class="alert alert-success" role="alert"><strong>¡Éxito!</strong> Se ha enviado la contraseña al correo: "'.$correo.'"</div>';
        }

    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/forms-estilo.css" >
	<title>Recuperar contraseña</title>
</head>
<body>

	<div class="container" id="general-form">
        <header class="header-index">
            
            <img src="imagenes/brsam-logo.png" />
            <h2> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h2>
            
        </header>
    </div>

    <div class="container col-xs-offset-3 col-xs-6" id="general-form" >

        <h3>Recuperar contraseña</h3>

        <fieldset>
            <form id="form_recuperar_pass" name="form_recuperar_pass" action="recupera_password.php" method="POST" class="form-horizontal" >
            
                <?php echo $mensaje; ?>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Intruduzca su correo eléctronico para enviarle un correo con su contraseña:
                    </label>
                   <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input class="form-control" type="email" id="correo" name="correo" maxlength="100">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-8">
                        <input type = "submit" class="btn btn-primary btn-block" value = "Enviar" id="enviar" name = "enviar" width="100" height="50">
                    </div>
                </div>
            </form>
        </fieldset>

        <footer class="footer">
            <small>Última modificación Octubre 2015<br>Created by Salvador Antonio Cienfuegos Torres<br>s.cienfuegost@hotmail.com</small>
        </footer>
    </div>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
