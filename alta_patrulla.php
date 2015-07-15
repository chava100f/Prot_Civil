<?php
session_start();
if($_SESSION['logged'] == 'yes')
{
    $error_nombre_p="";

    if(isset($_POST['alta_patrulla'])) //código para validar los datos del formulario
    {   
        $nombre_patrulla = strip_tags($_POST['nombre_patrulla']);

        if($nombre_patrulla != "")
        {
			    $id_p=rand(100,1000);

        	require_once("funciones.php");
          $conexion = conectar();

          $nombre_patrulla = mysqli_real_escape_string($conexion, $nombre_patrulla);
    
        	$query = 'INSERT INTO patrullas(id_patrullas, nombre) VALUES ("'.$id_p.'", "'.$nombre_patrulla.'")';
        	$consulta = ejecutarQuery($conexion, $query);
        	desconectar($conexion);
        	
        	header("Location: alta_patrulla_respuesta.php?nombre=".$nombre_patrulla."&id_p=".$id_p."");
			    exit();
        }
        else
        {
        	$error_nombre_p = "El nombre de patrulla es inválido";
        }

    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<link rel="stylesheet" type="text/css" href="EstiloT0202.css">
	<title>Alta Patrulla</title>
</head>
<body>
</body>

	<h1> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h1>
	<h2>Alta nueva patrulla al sistema</h2>

	<form action = "alta_patrulla.php" method = "POST">
		<fieldset>
                <legend>Registrar nueva patrulla</legend>

       <table>
       		<tr>
       			<td>
       				Nombre:
       			</td>
       			<td>
       				<input type="text" name="nombre_patrulla" required/>
       			</td>
       			<td>
       		</tr>
       	</table>

        </fieldset>
        <br>
        <?php
        	echo $error_nombre_p;
        ?>

        <input type = "submit" value = "Dar de Alta" name = "alta_patrulla" width="100" height="50">
	</form>

</html>


<?php
}
else
	header('Location : index.php');
?>
