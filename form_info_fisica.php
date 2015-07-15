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

        $sexo = mysqli_real_escape_string($conexion, strip_tags($_POST['sexo']));
        $estatura = mysqli_real_escape_string($conexion, strip_tags($_POST['estatura']));
        $peso = mysqli_real_escape_string($conexion, strip_tags($_POST['peso']));
        $complexion = mysqli_real_escape_string($conexion, strip_tags($_POST['complexion']));
        $cabello = mysqli_real_escape_string($conexion, strip_tags($_POST['cabello']));
        $ojos = mysqli_real_escape_string($conexion, strip_tags($_POST['ojos']));
        $cara = mysqli_real_escape_string($conexion, strip_tags($_POST['cara']));
        $nariz = mysqli_real_escape_string($conexion, strip_tags($_POST['nariz']));
        $senias = mysqli_real_escape_string($conexion, strip_tags($_POST['senias']));

        //TO DO Elaboración del Query (tratar de pasar esto a un Store procedure)!!!
        //Actualización de los datos en la tabla info_fisica
        $query = 'INSERT INTO info_fisica(genero, estatura, peso, complexion, cabello, ojos, cara, nariz, senias_particulares, datos_personales_id_num_reg)';
        $query = $query.' VALUES ("'.$sexo.'", '.$estatura.', '.$peso.', "'.$complexion.'", "'.$cabello.'", "'.$ojos.'", "'.$cara.'", "'.$nariz.'", "'.$senias.'", '.$id_user.')';

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
	<title>Actualización de Información Física</title>
    <script>
        
    </script>

</head>
<body>
	<h1> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h1>
	<form action = "form_info_fisica.php" method = "POST">
		<fieldset>
                <legend>Información Física</legend>

                <table>
                    <tr>
                        <td>Sexo:</td>
                        <td>
                            <input type="radio" name="sexo" value="hombre" checked> Hombre <br>
                            <input type="radio" name="sexo" value="mujer"> Mujer <br>
                            <input type="radio" name="sexo" value="otro"> Otro
                        </td>
                    </tr>
                	<tr>
                		<td>Estatura:</td>
                		<td>
                			<input type="number" id="estatura" name="estatura" maxlength="4" step="0.01" min="0.00" max="2.50"> metros
                		</td>
                	</tr>
                	<tr>
                		<td>Peso:</td>
                		<td>
                			<input type="number" id="peso" name="peso" maxlength="3" maxlength="6" step="0.01" min="0.00" max="200.00"> kg
                		</td>
                	</tr>
                	<tr>
                		<td>Complexión:</td>
                		<td>
                			<input type="text" id="complexion" name="complexion" maxlength="130">
                		</td>
                	</tr>
                	<tr>
                		<td>Cabello:</td>
                		<td>
                			<input type="text" id="cabello" name="cabello" maxlength="20" >
                		</td>
                	</tr>
                	<tr>
                		<td>Color de ojos:</td>
                		<td>
                			<input type="text" id="ojos" name="ojos" min="1" maxlength="20"> 
                		</td>
                	</tr>
                	<tr>
                		<td>Cara: </td>
                		<td><input  type="text" id="cara" name="cara" maxlength="30"> </td>
                	</tr>
                    <tr>
                        <td>Nariz: </td>
                		<td>
                			<input type="text" id="nariz" name="nariz" maxlength="20">
                		</td>
                	</tr>
                	<tr>
                		<td>Señas Particulares:</td>
                		<td>
                			<input type="text" id="senias" name="senias" maxlength="130">
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
