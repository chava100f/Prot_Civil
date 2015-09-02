<?php 

//Codigo para revisar si la sesion a sido iniciada
session_start();
$basename = substr(strtolower(basename($_SERVER['PHP_SELF'])),0,strlen(basename($_SERVER['PHP_SELF']))-4);

if((empty($_SESSION['logged'])) && ($basename!="index"))
{
    header('Location: index.php');
    exit;
}//Si a inicado sesion entra en el "else"
else
{

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

        $nacionalidad = mysqli_real_escape_string($conexion, strip_tags($_POST['nacionalidad']));
        $ocupacion = mysqli_real_escape_string($conexion, strip_tags($_POST['ocupacion']));
        $escolaridad = mysqli_real_escape_string($conexion, strip_tags($_POST['escolaridad']));
        $estado_civil = mysqli_real_escape_string($conexion, strip_tags($_POST['estado_civil']));
        $trabajo_escuela = mysqli_real_escape_string($conexion, strip_tags($_POST['trabajo_escuela']));
        $edad = mysqli_real_escape_string($conexion, strip_tags($_POST['edad']));
        $cartilla = mysqli_real_escape_string($conexion, strip_tags($_POST['cartilla']));
        $licencia_tipo = mysqli_real_escape_string($conexion, strip_tags($_POST['licencia_tipo']));
        $licencia_num = mysqli_real_escape_string($conexion, strip_tags($_POST['licencia_num']));
        $pasaporte = mysqli_real_escape_string($conexion, strip_tags($_POST['pasaporte']));
        $correo_rs = mysqli_real_escape_string($conexion, strip_tags($_POST['correo_rs']));
        $contacto1 = mysqli_real_escape_string($conexion, strip_tags($_POST['contacto1']));
        $tel_con1 = mysqli_real_escape_string($conexion, strip_tags($_POST['tel_con1']));
        $contacto2 = mysqli_real_escape_string($conexion, strip_tags($_POST['contacto2']));
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

<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index-estilo.css" >
    <link rel="stylesheet" href="css/forms-estilo.css" >
	<title>Actualización de Datos Complementarios</title>
    <script>
        
    </script>

</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <p class="navbar-brand">Información complementaria</p>
        </div>
        <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index_usuario.php">Inicio</a></li>
            <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                Modificar Datos <span class="caret"></span>
                </a>
                <ul class="dropdown-menu inverse-dropdown" >
                    <li><a href="form_personales.php">Información Personal Básica</a></li>
                    <li><a href="form_complementario.php">Información Complementaria</a></li>
                    <li><a href="form_medico.php">Información Medica</a></li>
                    <li><a href="form_info_fisica.php">Información Fisica</a></li>
                    <li><a href="form_experiencia.php">Información de Experiencia en Patrullaje y Rescate</a></li>
                </ul>
            </li>
            <li><a href="#">Cambiar contraseña</a></li>
            <li><a href="cerrar_sesion.php">Cerrar sesión</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Cabecera de la página -->
    <header id="header">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-2" >
                <img src="imagenes/brsam-logo.png" />
            </div>
            <h2 class="col-xs-12 col-sm-12 col-md-10"> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h2>
        
        </div>
    </header>

    <!--Comienza el contenido -->
    <br>
    <div class="container" id="general-form">

        <div class="col-xs-1 col-sm-2 col-md-2 col-lg-2"></div>

        <div class="col-xs-10 col-sm-8 col-md-8 col-lg-8">

        <h3>Datos Complementarios</h3>

        <fieldset>
    	   <form action = "form_complementario.php" method = "POST" class="form-horizontal" >

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Nacionalidad:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" maxlength="20" value=<?php echo '"'.$nacionalidad.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Ocupación:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="ocupacion" name="ocupacion" maxlength="35" value=<?php echo '"'.$ocupacion.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Escolaridad:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="escolaridad" name="escolaridad" maxlength="35" value=<?php echo '"'.$escolaridad.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Estado Civil:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <select id="estado_civil" class="form-control" name="estado_civil">
                            <option <?php if ($estado_civil == "soltero" ) echo 'selected'; ?> value="soltero">SOLTERO(A)</option>
                            <option <?php if ($estado_civil == "casado" ) echo 'selected'; ?> value="casado">CASADO(A)</option>
                            <option <?php if ($estado_civil == "divorciado" ) echo 'selected'; ?> value="divorciado">DIVORCIADO(A)</option>
                            <option <?php if ($estado_civil == "viudo" ) echo 'selected'; ?> value="viudo">VIUDO(A)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Edad:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="edad" name="edad" min="1" max="99" value=<?php echo '"'.$edad.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Cartilla Militar:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input  type="text" class="form-control" id="cartilla" name="cartilla" maxlength="10" value=<?php echo '"'.$cartilla.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Nombre del Trabajo o Escuela:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="trabajo_escuela" name="trabajo_escuela" maxlength="30" value=<?php echo '"'.$trabajo_escuela.'"'?> >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 centrado-element">
                        Licencia de manejo:
                    </label>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Tipo:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                         <select id="licencia_tipo" class="form-control" name="licencia_tipo">
                            <option <?php if ($licencia_tipo == "AUTOMOVILISTA" ) echo 'selected'; ?> value="AUTOMOVILISTA">AUTOMOVILISTA</option>
                            <option <?php if ($licencia_tipo == "CHOFER DE SERVICIO PARTICULAR" ) echo 'selected'; ?> value="CHOFER DE SERVICIO PARTICULAR">CHOFER DE SERVICIO PARTICULAR</option>
                            <option <?php if ($licencia_tipo == "MOTOCICLISTA" ) echo 'selected'; ?> value="MOTOCICLISTA">MOTOCICLISTA</option>
                            <option <?php if ($licencia_tipo == "PERMISO PROVICIONAL A" ) echo 'selected'; ?> value="PERMISO PROVICIONAL A">PERMISO PROVICIONAL A</option>
                            <option <?php if ($licencia_tipo == "PERMISO PROVICIONAL B" ) echo 'selected'; ?> value="PERMISO PROVICIONAL B">PERMISO PROVICIONAL B</option>
                            <option <?php if ($licencia_tipo == "DUPLICADO" ) echo 'selected'; ?> value="DUPLICADO">DUPLICADO</option>
                            <option <?php if ($licencia_tipo == "SERVICIO PÚBLICO" ) echo 'selected'; ?> value="SERVICIO PÚBLICO">SERVICIO PÚBLICO</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Numero:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="licencia_num" name="licencia_num" maxlength="20" value=<?php echo '"'.$licencia_num.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Pasaporte:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="pasaporte" name="pasaporte" maxlength="15" value=<?php echo '"'.$pasaporte.'"'?> >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Correo que utiliza en sus redes sociales (Facebook, Twitter, Google+, etc):
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="email" class="form-control" id="correo_rs" name="correo_rs" maxlength="30" value=<?php echo '"'.$correo_rs.'"'?> >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 centrado-element">
                        En caso de accidente comunicarse con:
                    </label>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Nombre:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="contacto1" name="contacto1" maxlength="70" value=<?php echo '"'.$contacto1.'"'?> >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Teléfono:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="tel_con1" name="tel_con1" maxlength="13" value=<?php echo '"'.$tel_con1.'"'?> >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Nombre:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="contacto2" name="contacto2" maxlength="70" value=<?php echo '"'.$contacto2.'"'?> >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Teléfono:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="tel_con2" name="tel_con2" maxlength="13" value=<?php echo '"'.$tel_con2.'"'?> >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-8">
                        <input type = "submit" class="btn btn-primary btn-block" value = "Actualizar Datos" id="actualizar" name = "actualizar" width="100" height="50">
                    </div>
                </div>
        	</form>
        </fieldset>

        <footer class="footer">

            <small>Última modificación Agosto 2015</small>

        </footer>

        </div>
        <div class="col-xs-1 col-sm-2 col-md-2 col-lg-2"></div>

    </div>

    
        
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript"> //función para hacer dinamigo el fondo 
     $(function(){
    
            var limit = 0; // 0 = infinite.
            var interval = 2;// Secs
            var images = [
                "imagenes/Fondos/1.jpg",
                "imagenes/Fondos/2.jpg",
                "imagenes/Fondos/3.jpg"
            ];

            var inde = 0; 
            var limitCount = 0;
            var myInterval = setInterval(function() {
               if (limit && limitCount >= limit-1) clearTimeout(myInterval);
               if (inde >= images.length) inde = 0;
                $('header').css({ "background-image":"url(" + images[inde]+ ")" });
               inde++;
               limitCount++;
            }, interval*5000);
        });    

    </script>
</body>
</html>

<?php
}

?>
