<?php
session_start();
if($_SESSION['logged'] == 'yes')
{
	function obtener_mensaje() //código para llenar la tabla de las patrullas actuales en la BD.
    {
    	//TO DO revisar como quedara lo del campo jefe de patrulla...

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
                $patrulla = $dat['patrullas_id_patrullas'];
            }
        }

        $mensaje="Bienvenido ".$nombre." ".$apellido_p." ".$apellido_m."";

        desconectar($conexion);

        return $mensaje;
    }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<link rel="stylesheet" type="text/css" href="EstiloT0202.css">
	<title>Index Usuario</title>
</head>
<body>
</body>

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

</html>


<?php
}
else
	header('Location : index.php');
?>
