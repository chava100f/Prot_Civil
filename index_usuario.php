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

	function obtener_mensaje() //código para obtener el nombre del usuario
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

        $mensaje=$nombre." ".$apellido_p." ".$apellido_m."";     

        desconectar($conexion);

        return $mensaje;
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

        $query = 'SELECT nombre, apellido_p, apellido_m FROM datos_personales WHERE patrullas_id_patrullas='.$id_patrulla.' AND tipo_cuenta="jefe"';
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

        //TO DO revisar como subir los datos de experiencia y revisar que si se encuentren todos los datos que creo que faltan algunos de hecho hasta en la BD

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

        $query = 'SELECT nombre, apellido_p, apellido_m FROM datos_personales WHERE patrullas_id_patrullas='.$id_patrulla.' AND tipo_cuenta="usuario"';
        $consulta = ejecutarQuery($conexion, $query);
        $mensaje ="";
        $cont=1;
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $mensaje="<tr><td>".$cont++."</td>";
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


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index-estilo.css" >
	<title>Inicio Usuario</title>
</head>
<body>
    <!-- Menu contextual-->
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <p class="navbar-brand">Bienveido Patrullero</p>
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
                    <li><a href="form_complementario.php">Información Complementaria del perfil</a></li>
                    <li><a href="form_medico.php">Información Medica</a></li>
                    <li><a href="form_info_fisica.php">Información Fisica</a></li>
                    <li><a href="form_experiencia.php">Información de experiencia en Patrullaje y Rescate</a></li>
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

        <section class="row">
            
                <aside class="col-xs-12 col-sm-5 col-md-3" id="menu-izq">
                    <div id="menu-izq-perfil">
                        <img src="#" id="menu-izq-foto">
                        <br><br>
                        <h3><?php echo obtener_mensaje(); ?></h3>
                        <h5>Registro completado a un...</h5>
                    </div>
                    
                    <div class="progress">
                      <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;" id="progress-bar1">
                        <?php echo obtener_porcentaje_datos_bd();?>%
                      </div>
                    </div>
                </aside>
            

            <article class="col-xs-12 col-sm-7 col-md-9">
                <h2 class="sub-header"><?php echo obtener_patrulla_actual(); ?></h2>  

                <p id="principal">
                    <label>Jefe de Patrulla:</label>
                    <?php echo obtener_jefe_patrulla();?><br/><br/>
                    <label>Integrates de la Patrulla:</label>
                </p> 
                <div class="table-responsive">
                  <table class="table table-hover table-striped">
                    <thead>
                        <th>#</th>
                        <th>Nombre(s)</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                    </thead>
                    <tbody>
                        <?php echo obtener_patrulla_integrantes(); ?>
                    </tbody>
                  </table>
                </div>                

            </article>

        </section>

        
        <footer class="footer">
            
                <small>Última modificación Agosto 2015</small>
            
        </footer>
        
    



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
            //codigo para obtener la imagen de perfil... TO DO agregar php 
            $("#menu-izq-foto").attr("src","imagenes/epic_link.jpg");
            $("#progress-bar1").attr("style","width: "+<?php echo obtener_porcentaje_datos_bd(); ?>+"%;");
            $("#progress-bar1").attr("aria-valuenow",""+<?php echo obtener_porcentaje_datos_bd(); ?>+";");
        });    

    </script>
</body>

</html>


<?php
}

?>
