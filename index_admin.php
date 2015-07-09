<?php
session_start();
if($_SESSION['logged'] == 'yes')
{
	function obtener_patrullas() //código para llenar la tabla de las patrullas actuales en la BD.
    {

        require_once("funciones.php");
        $conexion = conectar();

        $query = 'SELECT DISTINCT patrullas.nombre, IFNULL((SELECT datos_personales.nombre FROM datos_personales WHERE datos_personales.tipo_cuenta="jefe" AND id_patrullas = datos_personales.patrullas_id_patrullas ),"NA") as nombreJefe, patrullas.clave FROM patrullas, datos_personales';
        $consulta = ejecutarQuery($conexion, $query);
        $opciones_e="";

        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $np = $dat['nombre'];
                $nj = $dat['nombreJefe'];
                $c = $dat['clave'];
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
	<link rel="stylesheet" type="text/css" href="EstiloT0202.css">
	<title>Administracion</title>
</head>
<body>
</body>

<h1> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h1>
<h2>Bienvenido Admin <?php echo $_SESSION['logged_admin'] ;?></h2>

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

</html>


<?php
}
else
	header('Location : index.php');
?>
