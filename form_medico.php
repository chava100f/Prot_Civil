<?php 

session_start();
if($_SESSION['logged'] == 'yes')
{

    if(isset($_POST['actualizar'])) //código para validar los datos del formulario
    {   

        $user=$_SESSION['logged_user'];
        // Actualizacion de datos complementarios

        require_once("funciones.php");
        $conexion = conectar();
        
        $query = 'SELECT id_num_reg FROM datos_personales WHERE email="'.$user.'"';
        $consulta = ejecutarQuery($conexion, $query);
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $id_user = $dat['id_num_reg'];
            }
        }

        //Recoleccion de datos...

        $sangre = mysqli_real_escape_string($conexion, strip_tags($_POST['sangre']));
        $vacuna_local = mysqli_real_escape_string($conexion, strip_tags($_POST['vacuna_local']));
        $vacuna_internacional = mysqli_real_escape_string($conexion, strip_tags($_POST['vacuna_internacional']));
        $padecimientos_limitfisicas = mysqli_real_escape_string($conexion, strip_tags($_POST['padecimientos_limitfisicas']));
        $alergias = mysqli_real_escape_string($conexion, strip_tags($_POST['alergias']));
        $servicio_medico = mysqli_real_escape_string($conexion, strip_tags($_POST['servicio_medico']));

        //TO DO Elaboración del Query (tratar de pasar esto a un Store procedure)!!!
        //Actualización de los datos en la tabla info_medica
        $query = 'INSERT INTO info_medica(tipo_sangre, vacunas, vacunas_internacionales, padecimientos_limitfisicas, alergias, servicio_medico, datos_personales_id_num_reg)';
        $query = $query.' VALUES("'.$sangre.'", "'.$vacuna_local.'", "'.$vacuna_internacional.'", '.$padecimientos_limitfisicas.', "'.$alergias.'", "'.$servicio_medico.'",'.$id_user.')';

        $consulta = ejecutarQuery($conexion, $query);
        desconectar($conexion);
        
        header("Location: index_usuario.php");
        exit();
               
    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<link rel="stylesheet" type="text/css" href="EstiloT0202.css">
	<title>Actualización de Información Médica</title>
    <script>
        
    </script>

</head>
<body>
	<h1> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h1>
	<form action = "form_medico.php" method = "POST">
		<fieldset>
                <legend>Información Médica</legend>

                <table>
                    <tr>
                        <td>Tipo de Sangre:</td>
                        <td>
                            <input type="text" name="sangre" maxlength="3">
                        </td>
                    </tr>
                	<tr>
                		<td colspan="2">Vacunas:</td>
                    </tr>
                    <tr>
                		<td>Locales: 
                			<input type="text" id="vacuna_local" name="vacuna_local" maxlength="80">
                		</td>
                        <td>Internacionales: 
                            <input type="text" id="vacuna_internacional" name="vacuna_internacional" maxlength="80">
                        </td>
                	</tr>
                	<tr>
                		<td>Padecimientos o Limitaciones físicas:</td>
                		<td>
                			<input type="text" id="padecimientos_limitfisicas" name="padecimientos_limitfisicas" maxlength="180">
                		</td>
                	</tr>
                	<tr>
                		<td>Alergias:</td>
                		<td>
                			<input type="text" id="alergias" name="alergias" maxlength="130">
                		</td>
                	</tr>
                	<tr>
                		<td>Servicio Médico:</td>
                		<td>
                			<input type="text" id="servicio_medico" name="servicio_medico" maxlength="40" placeholder="IMSS, ISSSTE, Seguro Popular, etc">
                		</td>
                	</tr>
                </table>

 		</fieldset>
 		<br>
		<input type = "submit" value = "Actualizar Datos" id="actualizar" name = "actualizar" width="100" height="50">
	</form>

</body>
</html>

<?php
}
else
    header('Location : index.php');
?>
