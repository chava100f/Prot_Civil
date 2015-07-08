<?php
session_start();
if($_SESSION['logged'] == 'yes')
{

	 function obtener_catalogo_jefes() //código para llenar el catálogo de los jefes de patrulla
    {

        require_once("funciones.php");
        $conexion = conectar();

        $query = 'SELECT nombre, id_num_reg FROM datos_personales WHERE tipo_cuenta = "jefe"';
        $consulta = ejecutarQuery($conexion, $query);
        $opciones_jefes="";

        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $id_num_reg = $dat['id_num_reg'];
                $nombre = $dat['nombre'];

                $opciones_jefes = $opciones_jefes.'<option value='.$id_num_reg.'>'.$nombre.'</option>';
            }
        }

        desconectar($conexion);

        return $opciones_jefes;
    }

    $error_nombre_p="";

    if(isset($_POST['alta_patrulla'])) //código para validar los datos del formulario
    {   
        $nombre_patrulla = strip_tags($_POST['nombre_patrulla']);
        $jefe_patrulla = strip_tags($_POST['jefe_patrulla']);

        if($nombre_patrulla != "")
        {
			    $clave=rand(100,1000);

        	require_once("funciones.php");
          $conexion = conectar();

          $nombre_patrulla = mysqli_real_escape_string($conexion, $nombre_patrulla);

        	if($jefe_patrulla==0)
        	{

	        	$query = 'INSERT INTO patrullas(nombre, clave) VALUES ("'.$nombre_patrulla.'", "'.$clave.'")';
	        	$consulta = ejecutarQuery($conexion, $query);
	        	desconectar($conexion);
	        	
	        	header("Location: alta_patrulla_respuesta.php?nombre=".$nombre_patrulla."&clave=".$clave."");
				    exit();

    			}
    			else
    			{ //TO DO REvisar esta funcionalidad de agregar la patrulla al jefe de patrulla...

	        	$jefe_patrulla = mysqli_real_escape_string($conexion, $jefe_patrulla);
	        	$query = 'INSERT INTO patrullas(nombre, clave) VALUES ("'.$nombre_patrulla.'", "'.$clave.'")';
	        	$consulta = ejecutarQuery($conexion, $query);
	        	desconectar($conexion);
	        	
	        	header("Location: alta_patrulla_respuesta.php?nombre=".$nombre_patrulla."&clave=".$clave."");
				    exit();
			     }

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
       		<tr>
       			<td>
       				Si conoce el nombre del jefe de patrulla seleccione de la siguiente lista de jefes de patrulla:
       			</td>
       			<td>
	                <select name="jefe_patrulla">
	                	<option value="0"> - </option>
	                <?php //código para llenar el catálogo de los estados.
	                    echo obtener_catalogo_jefes();
	                ?>

			        </select> 
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
