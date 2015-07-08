<?php 
    function obtener_opcion_e() //código para llenar el catálogo de los estados.
    {

        require_once("funciones.php");
        $conexion = conectar();

        $query = 'SELECT nombre, id FROM estados';
        $consulta = ejecutarQuery($conexion, $query);
        $opciones_e="";

        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $id = $dat['id'];
                $nombre = $dat['nombre'];

                $opciones_e = $opciones_e.'<option value='.$id.'>'.$nombre.'</option>';
            }
        }

        desconectar($conexion);

        return $opciones_e;
    }

    $error_pass = '';
    $error_email = '';
    $error_na = "";
    $error_patrulla = "";

    if(isset($_POST['registro'])) //código para validar los datos del formulario
    {   
        $patrulla = strip_tags($_POST['patrulla']);

        //TO DO codigo para verificar el codigo de patrulla en la BD

        if($patrulla != "")
        {

        $pass1 = strip_tags($_POST['pass1']);
        $pass2 = strip_tags($_POST['pass2']);

            if($pass1 === $pass2)// valida contraseñas
            {
                $correo1 = strip_tags($_POST['correo1']);
                $correo2 = strip_tags($_POST['correo2']);

                if($correo1 === $correo2) //valida los correos 
                {
                    $nombres = strip_tags($_POST['nombres']);
                    $apellido_p = strip_tags($_POST['apellido_p']);

                    if($nombres != "" and  $apellido_p != "") //valida que no haya datos falsos en nombre y apellido paterno
                    {
                        // ALTA A USUARIO NUEVO
                        require_once("funciones.php");
                        $conexion = conectar();
                        
                        //Recoleccion de datos...

                        $nombres = mysqli_real_escape_string($conexion, $nombres);
                        $apellido_p = mysqli_real_escape_string($conexion, $apellido_p);
                        $apellido_m = mysqli_real_escape_string($conexion, strip_tags($_POST['apellido_m']));
                        $fecha_nac = mysqli_real_escape_string($conexion, strip_tags($_POST['fecha_nac']));
                        $dom_calle = mysqli_real_escape_string($conexion, strip_tags($_POST['dom_calle']));
                        $dom_num_ext = mysqli_real_escape_string($conexion, strip_tags($_POST['dom_num_ext']));
                        $dom_num_int = mysqli_real_escape_string($conexion, strip_tags($_POST['dom_num_int']));
                        $dom_colonia = mysqli_real_escape_string($conexion, strip_tags($_POST['dom_colonia']));
                        $dom_estado = mysqli_real_escape_string($conexion, strip_tags($_POST['dom_estado']));
                        $dom_del_mun = mysqli_real_escape_string($conexion, strip_tags($_POST['dom_del_mun']));
                        $dom_cp = mysqli_real_escape_string($conexion, strip_tags($_POST['dom_cp']));
                        $telefono_casa = mysqli_real_escape_string($conexion, strip_tags($_POST['telefono_casa']));
                        $telefono_celular = mysqli_real_escape_string($conexion, strip_tags($_POST['telefono_celular']));
                        $telefono_trabajo = mysqli_real_escape_string($conexion, strip_tags($_POST['telefono_trabajo']));
                        $telefono_extension = mysqli_real_escape_string($conexion, strip_tags($_POST['telefono_extension']));
                        $correo1 = mysqli_real_escape_string($conexion, $correo1);
                        $pass1 = mysqli_real_escape_string($conexion, $pass1);

                        //Elaboración del Query (tratar de pasar esto a un Store procedure)!!!
                        //TO DO  hacer le codigo para insertar los datos en la BD..
                        
                        $query = 'INSERT INTO datos_personales(nombre, apellido_p, apellido_m, fecha_nac, dom_calle, dom_num_ext, dom_num_int, dom_col, dom_del_mun, dom_estado, dom_cp, telefono_casa, telefono_celular, telefono_trabajo, telefono_extension, email, contrasenia, tipo_cuenta, patrullas_id_patrullas)';
                        $query = $query.' VALUES ("'.$nombres.'", "'.$apellido_p.'", "'.$apellido_m.'", "'.$fecha_nac.'", "'.$dom_calle.'", "'.$dom_num_ext.'", "'.$dom_num_int.'", "'.$dom_colonia.'", "'.$dom_del_mun.'", "'.$dom_estado.'", "'.$dom_cp.'", "'.$telefono_casa.'", "'.$telefono_celular.'", "'.$telefono_trabajo.'", "'.$telefono_extension.'", "'.$correo1.'", "'.$pass1.'","usuario",1)'; //sustituir el final para el id de la patrulla
                        $consulta = ejecutarQuery($conexion, $query);
                            
                        desconectar($conexion);
                        
                        header("Location: alta_usuario_respuesta.php?nombre=".$nombres."&ap=".$apellido_p."&am=".$apellido_m."");
                        exit();
                            
                    }
                    else
                    {
                        $error_na = 'Faltan datos favor de revisar el nombre o apellidos';
                    }
                }
                else
                {
                    $error_email = 'Los correos electrónicos no coinciden';
                }

            }
            else
            {
                $error_pass = 'Las contraseñas no coinciden';
            }
        }
        else
        {
            $error_patrulla = 'El código de patrulla ingresado no existe';
        }

    }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<link rel="stylesheet" type="text/css" href="EstiloT0202.css">
	<title>Login Alumno</title>
</head>
<body>
	<h1> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h1>
	<form action = "registra_usuario.php" method = "POST">
		<fieldset>
                <legend>Registro</legend>

                <table>
                    <tr>
                        <td>Introduzca el ID de patrulla:</td>
                        <td>
                            <input type="text" name="patrulla" maxlength="10" required>
                        </td>
                    </tr>
                	<tr>
                		<td>Nombre(s):</td>
                		<td>
                			<input type="text" name="nombres" maxlength="35" required>
                		</td>
                	</tr>
                	<tr>
                		<td>Apellido Paterno:</td>
                		<td>
                			<input type="text" name="apellido_p" maxlength="35" required>
                		</td>
                	</tr>
                	<tr>
                		<td>Apellido Materno:</td>
                		<td>
                			<input type="text" name="apellido_m" maxlength="35">
                		</td>
                	</tr>
                	<tr>
                		<td>Fecha de nacimiento:</td>
                		<td>
                			<input type="date" name="fecha_nac" maxlength="10" placeholder="dd/mm/aaaa">
                		</td>
                	</tr>
                	<tr>	
                		<td colspan="2">
                			<b>Dirección</b>
                		</td>
                	</tr>	
                	<tr>
                		<td>Calle o Avenida:</td>
                		<td>
                			<input type="text" name="dom_calle" maxlength="35">
                		</td>
                	</tr>
                	<tr>
                		<td>Num. Ext: <input  type="text" name="dom_num_ext" maxlength="10"> </td>
                		<td>Num. Int: <input  type="text" name="dom_num_int" maxlength="10"> </td>
                	</tr>
                	<tr>
                		<td>Colonia:</td>
                		<td>
                			<input type="text" name="dom_colonia" maxlength="35">
                		</td>
                	</tr>
                	<tr>
                		<td>Estado:</td>
                		<td>
                            
                            <select name="dom_estado">

                            <?php //código para llenar el catálogo de los estados.
                                echo obtener_opcion_e();
                            ?>

    				        </select>   
                			
                		</td>
                	</tr>
                	<tr>
                		<td>Delegación o Municipio:</td>
                		<td>
                            <?php 
                            //Tentativa para manejar en un futuro con la BD 
                                /*<select name="dom_del_mun">
                                    <option value="m1">Municipio 1</option>
                                    ...
                                </select>*/
                            ?>
                            <input type="text" name="dom_del_mun" maxlength="60">
                			
                		</td>
                	</tr>
                	
                	<tr>
                		<td>Código Postal:</td>
                		<td>
                			<input type="text" name="dom_cp" maxlength="5">
                		</td>
                	</tr>
                	<tr>
                		<td>Teléfono casa:</td>
                		<td>
                			<input type="text" name="telefono_casa" maxlength="20">
                	</tr>
                	<tr>
                		<td>Teléfono celular:</td>
                		<td>
                			<input type="text" name="telefono_celular" maxlength="20">
                	</tr>
                	<tr>
                		<td>Teléfono trabajo:</td>
                		<td>
                			<input type="text" name="telefono_trabajo" maxlength="20">
                	</tr>
                	<tr>
                		<td>Extensión del teléfono trabajo:</td>
                		<td>
                			<input type="text" name="telefono_extension" maxlength="10">
                	</tr>
                	<tr>
                		<td>Correo electrónico:</td>
                		<td>
                			<input type="text" name="correo1" maxlength="25" required >
                	</tr>
                	<tr>
                		<td>Confirmar correo electrónico:</td>
                		<td>
                			<input type="text" name="correo2" onkeypress='validate(event)' maxlength="25"  required  onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete=off >
                	</tr>
                	<tr>
                		<td>Contraseña:</td>
                		<td>
                			<input type="password" name="pass1" maxlength="10" required>
                	</tr>
                	<tr>
                		<td>Confirmar contraseña:</td>
                		<td>
                			<input type="password" name="pass2" onkeypress='validate(event)' maxlength="10" required  onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete=off >
                </table>

 		</fieldset>
 		<br>
		<input type = "submit" value = "Registrarse" name = "registro" width="100" height="50">
	</form>

</body>
</html>