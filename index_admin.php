<?php
session_start();
if($_SESSION['logged_admin'] == 'yes')
{
	function obtener_patrullas() //código para llenar la tabla de las patrullas actuales en la BD.
    {
    	//TO DO revisar como quedara lo del campo jefe de patrulla...

        require_once("funciones.php");
        $conexion = conectar();

        $query = 'SELECT id_patrullas, nombre, clave FROM patrullas';
        $consulta = ejecutarQuery($conexion, $query);
        $opciones_e="";

        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $id = $dat['id_patrullas'];
                $n = $dat['nombre'];
                $c = $dat['clave'];

                $opciones_e = $opciones_e.'<tr><td>'.$id.'</td><td>'.$n.'</td><td>'.$c.'</td></tr>';
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
<h2>Bienvenido Admin</h2>

<p><a href="alta_patrulla.php">Dar de alta una nueva patrulla al sistema</a></p>

<table border="1px">
	<tr>
		<th>Nombre</th>
		<th>Jefe de Patrulla</th>
		<th>Clave</th>
	</tr>
	<?php echo obtener_patrullas(); ?>
</table>

</html>


<?php
}
else
	header('Location : index.php');
?>
