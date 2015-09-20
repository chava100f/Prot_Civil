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

    require("funciones_menu_contextual.php"); 

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
    
    <?php echo obtener_menu()?>
    
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
