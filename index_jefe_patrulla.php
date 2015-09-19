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
	function obtener_mensaje() //código para llenar la tabla de las patrullas actuales en la BD.
    {
    	//TO DO revisar como quedara lo del campo jefe de patrulla...

        require_once("funciones.php");
        $conexion = conectar();

        $user=$_SESSION['logged_jefe'];

        $query = 'SELECT nombre, apellido_p, apellido_m, patrullas_id_patrullas FROM datos_personales WHERE email="'.$user.'"';
        $consulta = ejecutarQuery($conexion, $query);
        $mensaje="";

        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $apellido_p = $dat['apellido_p'];
                $apellido_m = $dat['apellido_m'];
                $nombre = $dat['nombre'];
                $patrulla = $dat['patrullas_id_patrullas'];
            }
        }

        $mensaje="Bienvenido Jefe de patrulla ".$nombre." ".$apellido_p." ".$apellido_m;

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
    <title>Inicio Jefe de Patrulla</title>
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


<h1> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h1>
<h2><?php echo obtener_mensaje(); ?></h2>
<h3> Patrulla actual<h3/>

<table border="1px">
	<tr>
		<th>Nombre</th>
		<th>Jefe de Patrulla</th>
		<th>Clave</th>
	</tr>
	<?php //echo obtener_patrullas(); ?>
</table>

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
