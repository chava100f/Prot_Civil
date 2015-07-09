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

        $nacionalidad = mysqli_real_escape_string($conexion, strip_tags($_POST['nacionalidad']));
        $ocupacion = mysqli_real_escape_string($conexion, strip_tags($_POST['ocupacion']));
        $escolaridad = mysqli_real_escape_string($conexion, strip_tags($_POST['escolaridad']));
        $estado_civil = mysqli_real_escape_string($conexion, strip_tags($_POST['estado_civil']));
        $trabajo_escuela = mysqli_real_escape_string($conexion, strip_tags($_POST['trabajo_escuela']));
        $edad = mysqli_real_escape_string($conexion, strip_tags($_POST['edad']));
        $cartilla = mysqli_real_escape_string($conexion, strip_tags($_POST['cartilla']));
        $licencia_tipo = mysqli_real_escape_string($conexion, strip_tags($_POST['licencia_tipo']));
        $licencia_num = mysqli_real_escape_string($conexion, strip_tags($_POST['licencia_num']));
        $pasaporte = mysqli_real_escape_string($conexion, strip_tags($_POST['pasaporte']));
        $correo_rs = mysqli_real_escape_string($conexion, strip_tags($_POST['correo_rs']));
        $contacto1 = mysqli_real_escape_string($conexion, strip_tags($_POST['contacto1']));
        $tel_con1 = mysqli_real_escape_string($conexion, strip_tags($_POST['tel_con1']));
        $contacto2 = mysqli_real_escape_string($conexion, strip_tags($_POST['contacto2']));
        $tel_con2 = mysqli_real_escape_string($conexion, strip_tags($_POST['tel_con2']));

        //TO DO Elaboración del Query (tratar de pasar esto a un Store procedure)!!!

        //Actualiza la tabla datos_complementarios
        $query = 'INSERT INTO datos_complementarios(estado_civil, ocupacion, escolaridad, edad, trabajo_escuela, nacionalidad, cartilla_num, licencia_tipo, licencia_num, pasaporte, datos_personales_id_num_reg)';
        $query = $query.' VALUES ("'.$estado_civil.'", "'.$ocupacion.'", "'.$escolaridad.'", '.$edad.', "'.$trabajo_escuela.'", "'.$nacionalidad.'", "'.$cartilla.'", "'.$licencia_tipo.'", "'.$licencia_num.'", "'.$pasaporte.'", '.$id_user.')';
        $consulta = ejecutarQuery($conexion, $query);

        //Actualiza la tabla datos personales con los datos que faltaban
        $query = 'INSERT INTO datos_personales(email_red_social, contacto1, contacto2, telefono_c1, telefono_c2)';
        $query = $query.' VALUES ("'.$correo_rs.'", "'.$contacto1.'", "'.$contacto2.'", '.$tel_con1.', "'.$tel_con2.'")';
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
	<title>Actualización de Datos Complementarios</title>
    <script>
        
    </script>

</head>
<body>
	<h1> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h1>
	<form action = "form_complementario.php" method = "POST">
		<fieldset>
                <legend>Datos Complementarios</legend>

                <table>
                    <tr>
                        <td>Nacionalidad:</td>
                        <td>
                            <input type="text" id="nacionalidad" name="nacionalidad" maxlength="20">
                        </td>
                    </tr>
                	<tr>
                		<td>Ocupación:</td>
                		<td>
                			<input type="text" id="ocupacion" name="ocupacion" maxlength="35">
                		</td>
                	</tr>
                	<tr>
                		<td>Escolaridad:</td>
                		<td>
                			<input type="text" id="escolaridad" name="escolaridad" maxlength="35">
                		</td>
                	</tr>
                	<tr>
                		<td>Estado Civil:</td>
                		<td>
                			<select id="estado_civil" name="estado_civil">
                                <option value="soltero">Soltero(a)</option>
                                <option value="casado">Casado(a)</option>
                                <option value="divorciado">Divorciado(a)</option>
                                <option value="viudo">Viudo(a)</option>
                            </select>
                		</td>
                	</tr>
                	<tr>
                		<td>Nombre del Trabajo o Escuela:</td>
                		<td>
                			<input type="text" id="trabajo_escuela" name="trabajo_escuela" maxlength="30" >
                		</td>
                	</tr>
                	<tr>
                		<td>Edad:</td>
                		<td>
                			<input type="number" id="edad" name="edad" min="1" max="99"> 
                		</td>
                	</tr>
                	<tr>
                		<td>Cartilla Militar: </td>
                		<td><input  type="text" id="cartilla" name="cartilla" maxlength="10"> </td>
                	</tr>
                	<tr>
                        <!--TO DO Tal vez agregar la opcion de si o no y habilidar los campos para llenar...-->
                		<td colspan="2">Licencia de manejo:</td>
                    </tr>
                    <tr>
                        <td>Tipo:
                        </td>
                		<td>
                			<input type="text" id="licencia_tipo" name="licencia_tipo" maxlength="3">
                		</td>
                	</tr>
                	<tr>
                		<td>Numero:</td>
                		<td>
                			<input type="text" id="licencia_num" name="licencia_num" maxlength="20">
                		</td>
                	</tr>
                	<tr>
                		<td>Pasaporte:</td>
                		<td>
                            <input type="text" id="pasaporte" name="pasaporte" maxlength="15"  >
                		</td>
                	</tr>
                	
                	<tr>
                		<td>Un correo que utiliza en sus redes sociales (Facebook, Twitter, Google+, etc):</td>
                		<td>
                			<input type="text" id="correo_rs" name="correo_rs" maxlength="30"  >
                		</td>
                	</tr>
                    <tr>
                        <!--TO DO Al igual que en el registro agregar los text box para las ladas...-->
                        <td colspan="2">En caso de accidente comunicarse con:</td>
                    </tr>
                	<tr>

                		<td>Nombre del primer contacto:
                	    <input type="text" id="contacto1" name="contacto1" maxlength="70"  >
                        </td>
                        <td>Teléfono:
                        <input type="text" id="tel_con1" name="tel_con1" maxlength="13"  >
                        </td>
                	</tr>
                    <tr>

                        <td>Nombre del segundo contacto:
                        <input type="text" id="contacto2" name="contacto2" maxlength="70"  >
                        </td>
                        <td>Teléfono:
                        <input type="text" id="tel_con2" name="tel_con2" maxlength="13"  >
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
