<?php
session_start();
if($_SESSION['logged'] == 'yes')
{

        $nombre = $_GET['nombre'];
        $clave = $_GET['clave'];

        $n="";
        $c="";

        require_once("funciones.php");
        $conexion = conectar();


        $query = 'SELECT nombre, clave FROM patrullas WHERE nombre = "'.$nombre.'" AND clave = "'.$clave.'"';
        $consulta = ejecutarQuery($conexion, $query);

        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $n = $dat['nombre'];
                $c = $dat['clave'];
            }
        }

        desconectar($conexion);

        $mensaje="";

        if($n!=$nombre)
        {   
            $mensaje = "Ocurrio un error al dar de alta la patrulla intente de nuevo";
        }
        else
        {
            $mensaje = "La patrulla ".$n." a sido agregada con la clave <b><u>".$c."</u></b>";
        }

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<link rel="stylesheet" type="text/css" href="EstiloT0202.css">
	<title>Alta Patrulla Respuesta</title>
</head>
<body>
</body>

	<h1> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h1>
	<h2>Alta nueva patrulla al sistema</h2>

	<h3>
        <?php echo $mensaje; ?>
    </h3>

    <h4><a href="alta_patrulla.php">Agregar otra patrulla al sistema</a></h4>
</html>


<?php
}
else
	header('Location : index.php');
?>