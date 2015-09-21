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

    $tipo_cuenta=$_SESSION['user_type'];

    if($tipo_cuenta=="usuario")
    {
        header("Location: index_usuario.php");
        exit();
    }
    
    if($tipo_cuenta=="jefe")
    {
        header("Location: index_jefe_patrullaa.php");
        exit();
    }

    require("funciones_menu_contextual.php"); 

	function obtener_patrullas() //código para llenar la tabla de las patrullas actuales en la BD.
    {

        require_once("funciones.php");
        $conexion = conectar();

        $query = 'SELECT DISTINCT nombre, IFNULL((SELECT datos_personales.nombre FROM datos_personales, patrullas WHERE datos_personales.tipo_cuenta="jefe" AND datos_personales.patrullas_id_patrullas = id_patrullas),"NA") AS nombreJefe, id_patrullas FROM patrullas;';
        $consulta = ejecutarQuery($conexion, $query);
        $opciones_e="";

        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $np = $dat['nombre'];
                $nj = $dat['nombreJefe'];
                $c = $dat['id_patrullas'];
                //Agregar codigo para mandar a modificar la patrulla seleccionada
                $opciones_e = $opciones_e.'<tr><td>'.$np.'</td><td>'.$nj.'</td><td>'.$c.'</td><td>Modificar</td</tr>';
            }
        }

        desconectar($conexion);

        return $opciones_e;
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset = "utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index-estilo.css" >
	<title>Administracion</title>
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
<h2>Bienvenido Administrador</h2>

<p><a href="alta_patrulla.php">Dar de alta una nueva patrulla al sistema</a></p>

<table border="1px">
	<tr>
		<th>Nombre</th>
		<th>Jefe de Patrulla</th>
		<th>Clave</th>
        <th>Modificar Patrulla</th>
	</tr>
	<?php echo obtener_patrullas(); ?>
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
