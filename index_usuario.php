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
    require("funciones_index_usuario.php"); //Aqui estan todas las funicones para obtener los datos de la BD para el index de usuario

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
          <p class="navbar-brand">Bienvenido Patrullero</p>
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
                    <li><a href="form_foto.php">Cambiar imagen de perfil</a></li>
                    <li><a href="form_cambio_pass.php">Cambiar contraseña</a></li>
                </ul>
            </li>
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
    <script type="text/javascript" src="fondo_encabezado.js" ></script>
    <script type="text/javascript"> //función para hacer dinamigo el fondo 
     $(function(){
            //codigo para obtener la imagen de perfil... TO DO agregar php 
            $("#menu-izq-foto").attr("src",<?php echo '"'.obtener_imagen_perfil().'"'; ?>);
            $("#progress-bar1").attr("style","width: "+<?php echo obtener_porcentaje_datos_bd(); ?>+"%;");
            $("#progress-bar1").attr("aria-valuenow",""+<?php echo obtener_porcentaje_datos_bd(); ?>+";");
        });    

    </script>
</body>

</html>


<?php
}

?>
