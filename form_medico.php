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
        $vacuna_local =$_POST['vacuna_local'];
        $vacuna_internacional = mysqli_real_escape_string($conexion, strip_tags($_POST['vacuna_internacional']));
        $padecimientos_limitfisicas = mysqli_real_escape_string($conexion, strip_tags($_POST['padecimientos_limitfisicas']));
        $alergias = mysqli_real_escape_string($conexion, strip_tags($_POST['alergias']));
        $servicio_medico = mysqli_real_escape_string($conexion, strip_tags($_POST['servicio_medico']));

        //TO DO Elaboración del Query (tratar de pasar esto a un Store procedure)!!!
        //Actualización de los datos en la tabla info_medica

        $query = 'INSERT INTO info_medica(tipo_sangre, padecimientos_limitfisicas, alergias, servicio_medico, datos_personales_id_num_reg)';
        $query = $query.' VALUES("'.$sangre.'","'.$padecimientos_limitfisicas.'", "'.$alergias.'", "'.$servicio_medico.'",'.$id_user.')';
        $consulta = ejecutarQuery($conexion, $query);
        
        //Cuenta los datos de los checkbox para insertarlos en la tabla vacunas
        $count = count($vacuna_local);

        //Inserta los datos de los checkbox en la tabla vacunas
        for ($i = 0; $i < $count; $i++)
        {
            $query="";
            $consulta="";
            $query='INSERT INTO vacunas(vacunas, datos_personales_id_num_reg) VALUES("'.$vacuna_local[$i].'",'.$id_user.');';
           
            $consulta = ejecutarQuery($conexion, $query);

        }
        //Revisa si la variable vacunas internacionales tiene algo escrito, si sí lo inserta en la base de datos
        if($vacuna_internacional!="")
        {
            $query='INSERT INTO vacunas(vacunas, datos_personales_id_num_reg) VALUES("'.$vacuna_internacional.'",'.$id_user.');';
            $consulta = ejecutarQuery($conexion, $query);
        }

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
                            <select name="sangre" id="sangre">
                                <option value="A+">A+</option>                                
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>                               
                            </select>
                        </td>
                    </tr>
                	<tr>
                		<td>Vacunas Locales:</td>
                		<td> 
                			<input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="BCG">BCG<br>
                            <input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="HEPATITIS B"> HEPATITIS B<br>
                            <input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="PENTAVALENTE ACELULAR">PENTAVALENTE ACELULAR<br>
                            <input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="NEUMOCOCO">NEUMOCOCO<br>
                            <input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="ROTAVIRUS">ROTAVIRUS<br>
                            <input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="SRP">SRP<br>
                            <input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="SR">SR<br>
                            <input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="Td">Td<br>
                            <input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="DPT">DPT<br>
                            <input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="Tdpa">Tdpa<br>
                            <input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="VPH">VPH<br>
                            <input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="INFLUENCA INACTIVADA">INFLUENCA INACTIVADA<br>
                            <input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="POLIOMIELITIS TIPO SABIN">POLIOMIELITIS TIPO SABIN<br>
                            <input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="VARICELA">VARICELA<br>
                            <input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="HEPATITIS A">HEPATITIS A<br>
                		</td>
                        
                	</tr>
                    <tr>
                        <td>Vacunas Internacionales:</td>
                        <td>    
                            <textarea style="width: 300px; height: 75px;" id="vacuna_internacional" name="vacuna_internacional" maxlength="180" placeholder="Describir aquí"></textarea>
                        </td>
                    </tr>
                	<tr>
                		<td>Padecimientos o Limitaciones físicas:</td>
                		<td>
                			<textarea style="width: 300px; height: 75px;" id="padecimientos_limitfisicas" name="padecimientos_limitfisicas" maxlength="180" placeholder="Describir aquí"></textarea>
                		</td>
                	</tr>
                	<tr>
                		<td>Alergias:</td>
                		<td>
                            <textarea style="width: 300px; height: 75px;" id="alergias" name="alergias" maxlength="180" placeholder="Describir aquí"></textarea>
                		</td>
                	</tr>
                	<tr>
                		<td>Servicio Médico:</td>
                		<td>
                            <select name="servicio_medico" id="servicio_medico">
                                <option value="IMSS">IMSS</option>
                                <option value="ISSSTE">ISSSTE</option>
                                <option value="PEMEX">PEMEX</option>
                                <option value="SEGURO POPUKAR">SEGURO POPULAR</option>
                                <option value="PARTICULAR">PARTICULAR</option>
                            </select>
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
