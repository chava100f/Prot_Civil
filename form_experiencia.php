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

        $cargos = mysqli_real_escape_string($conexion, strip_tags($_POST['cargos']));
        $patrullero = mysqli_real_escape_string($conexion, strip_tags($_POST['patrullero']));
        $fecha_g = mysqli_real_escape_string($conexion, strip_tags($_POST['fecha_g']));
        $experiencia =$_POST['experiencia'];
        $experiencia_otra = mysqli_real_escape_string($conexion, strip_tags($_POST['experiencia_otra']));
        $nom_dir = mysqli_real_escape_string($conexion, strip_tags($_POST['nom_dir']));

        //TO DO Elaboración del Query (tratar de pasar esto a un Store procedure)!!!
        //Actualización de los datos en la tabla info_medica

        $query = 'INSERT INTO antecedentes(cargos_anteriores, patrullero, fecha_graduacion, dir_ccpp, datos_personales_id_num_reg)';
        $query = $query.' VALUES("'.$cargos.'","'.$patrullero.'", "'.$fecha_g.'", "'.$nom_dir.'",'.$id_user.')';
        $consulta = ejecutarQuery($conexion, $query);
        
        //Cuenta los datos de los checkbox para insertarlos en la tabla experiencia
        $count = count($experiencia);

        //Inserta los datos de los checkbox en la tabla experiencia
        for ($i = 0; $i < $count; $i++)
        {
            $query="";
            $consulta="";
            $query='INSERT INTO experiencia(experiencia, datos_personales_id_num_reg) VALUES("'.$experiencia[$i].'",'.$id_user.');';
           
            $consulta = ejecutarQuery($conexion, $query);

        }
        //Revisa si la variable experiencia otras tiene algo escrito, si sí lo inserta en la base de datos
        if($experiencia_otra!="")
        {
            $query='INSERT INTO experiencia(experiencia, datos_personales_id_num_reg) VALUES("'.$experiencia_otra.'",'.$id_user.');';
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
	<title>Actualización de Datos Complementarios</title>
    <script>
        
    </script>

</head>
<body>
	<h1> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h1>
	<form action = "form_experiencia.php" method = "POST">
		<fieldset>
                <legend>Información de experiencia en Patrullaje, Rescate, etc.</legend>

                <table>
                    <tr>
                        <td>Cargos Anteriores:</td>
                        <td>
                            <input type="text" id="cargos" name="cargos" maxlength="50">
                        </td>
                    </tr>
                	<tr>
                		<td>Patrullero:</td>
                		<td>
                			<input type="checkbox" id="patrullero" name="patrullero" value="si">Si<br>
                            <input type="checkbox" id="patrullero" name="patrullero" value="no">No<br>
                		</td>
                	</tr>
                	<tr>
                		<td>Fecha graduación:</td>
                		<td>
                			<input type="date" id="fecha_g" name="fecha_g" maxlength="35">
                		</td>
                	</tr>
                    <tr>
                        <td>Experiencia:</td>
                        <td> 
                            <input type="checkbox" id="experiencia[]" name="experiencia[]" value="MEDIA MONTAÑA">MEDIA MONTAÑA<br>
                            <input type="checkbox" id="experiencia[]" name="experiencia[]" value="ALTA MONTAÑA">ALTA MONTAÑA<br>
                            <input type="checkbox" id="experiencia[]" name="experiencia[]" value="ESPELEISMO">ESPELEISMO<br>
                            <input type="checkbox" id="experiencia[]" name="experiencia[]" value="ESCALADA EN ROCA">ESCALADA EN ROCA<br>
                            <input type="checkbox" id="experiencia[]" name="experiencia[]" value="BUCEO">BUCEO<br>
                            <input type="checkbox" id="experiencia[]" name="experiencia[]" value="PARACAIDISMO">PARACAIDISMO<br>
                            <input type="checkbox" id="experiencia[]" name="experiencia[]" value="PRIMEROS AUXILIOS">PRIMEROS AUXILIOS<br>
                            <input type="checkbox" id="experiencia[]" name="experiencia[]" value="PRIMER RESPONDIENTE">PRIMER RESPONDIENTE<br>
                            <input type="checkbox" id="experiencia[]" name="experiencia[]" value="TUM (URBANO)">TUM (URBANO)<br>
                            <input type="checkbox" id="experiencia[]" name="experiencia[]" value="TUM (MONTAÑA)">TUM (MONTAÑA)<br>
                            <input type="checkbox" id="experiencia[]" name="experiencia[]" value="ENFERMERO">ENFERMERO<br>
                            <input type="checkbox" id="experiencia[]" name="experiencia[]" value="PARAMÉDICO">PARAMÉDICO<br>
                            <input type="checkbox" id="experiencia[]" name="experiencia[]" value="MÉDICO">MÉDICO<br>
                            <input type="checkbox" id="experiencia[]" name="experiencia[]" value="RADIO EXPERIMENTADOR">RADIO EXPERIMENTADOR<br>                            
                        </td>
                    </tr>
                    <tr>
                        <td>Otra (Especificar):</td>
                        <td>    
                            <textarea style="width: 300px; height: 75px;" id="experiencia_otra" name="experiencia_otra" maxlength="180" placeholder="Describir aquí"></textarea>
                        </td>
                    </tr>
                	<tr>
                		<td>Nombre del Dir. C.C.P.P. o calidad:</td>
                		<td>
                			<input type="text" id="nom_dir" name="nom_dir" maxlength="50" >
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
