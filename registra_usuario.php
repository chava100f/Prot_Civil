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

                    $id_p = mysqli_real_escape_string($conexion, strip_tags($_POST['id_patrulla']));
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
                    $query = $query.' VALUES ("'.$nombres.'", "'.$apellido_p.'", "'.$apellido_m.'", "'.$fecha_nac.'", "'.$dom_calle.'", "'.$dom_num_ext.'", "'.$dom_num_int.'", "'.$dom_colonia.'", "'.$dom_del_mun.'", "'.$dom_estado.'", "'.$dom_cp.'", "'.$telefono_casa.'", "'.$telefono_celular.'", "'.$telefono_trabajo.'", "'.$telefono_extension.'", "'.$correo1.'", "'.$pass1.'","usuario",'.$id_p.')'; //sustituir el final para el id de la patrulla
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
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<link rel="stylesheet" type="text/css" href="EstiloT0202.css">
	<title>Login Alumno</title>
    <script>

        var id, nombre;

        function revisa_patrulla(str) { //Revisa con Ajax que exista la patrulla ingresada y habilita los campos para el registro

            if (str.length == 0) { 
                document.getElementById("mensaje_server").innerHTML = "";
                return;
            } else {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        
                        var respuesta = xmlhttp.responseText;

                        id = respuesta.substring(0, 1);
                        nombre = respuesta.substring(2,50);
                        
                        if(respuesta == "No se encontro Patrulla ingresada")
                        {
                            document.getElementById("mensaje_server").innerHTML = respuesta;
                            document.getElementById("nombres").disabled=true;
                            document.getElementById("apelldio_p").disabled=true;
                            document.getElementById("apellido_m").disabled=true;
                            document.getElementById("fecha_nac").disabled=true;
                            document.getElementById("dom_calle").disabled=true;
                            document.getElementById("dom_num_ext").disabled=true;
                            document.getElementById("dom_num_int").disabled=true;
                            document.getElementById("dom_colonia").disabled=true;
                            document.getElementById("dom_estado").disabled=true;
                            document.getElementById("dom_del_mun").disabled=true;
                            document.getElementById("dom_cp").disabled=true;
                            document.getElementById("telefono_casa").disabled=true;
                            document.getElementById("telefono_celular").disabled=true;
                            document.getElementById("telefono_trabajo").disabled=true;
                            document.getElementById("telefono_extension").disabled=true;
                            document.getElementById("correo1").disabled=true;
                            document.getElementById("correo2").disabled=true;
                            document.getElementById("pass1").disabled=true;
                            document.getElementById("pass2").disabled=true;
                            document.getElementById("registro").disabled=true;
                        }  
                        else
                        {

                            document.getElementById("mensaje_server").innerHTML = nombre;
                            document.getElementById("nombres").disabled=false;
                            document.getElementById("apelldio_p").disabled=false;
                            document.getElementById("apellido_m").disabled=false;
                            document.getElementById("fecha_nac").disabled=false;
                            document.getElementById("dom_calle").disabled=false;
                            document.getElementById("dom_num_ext").disabled=false;
                            document.getElementById("dom_num_int").disabled=false;
                            document.getElementById("dom_colonia").disabled=false;
                            document.getElementById("dom_estado").disabled=false;
                            document.getElementById("dom_del_mun").disabled=false;
                            document.getElementById("dom_cp").disabled=false;
                            document.getElementById("telefono_casa").disabled=false;
                            document.getElementById("telefono_celular").disabled=false;
                            document.getElementById("telefono_trabajo").disabled=false;
                            document.getElementById("telefono_extension").disabled=false;
                            document.getElementById("correo1").disabled=false;
                            document.getElementById("correo2").disabled=false;
                            document.getElementById("pass1").disabled=false;
                            document.getElementById("pass2").disabled=false;
                            document.getElementById("registro").disabled=false;
                            //ID de patrulla 
                            document.getElementById("id_patrulla").value=id;
                            
                        }

                    }
                }
                xmlhttp.open("GET", "revisa_patrulla.php?p=" + str, true);
                xmlhttp.send();
            }
        }

        
    </script>

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
                            <input type="text" name="patrulla" maxlength="10" required onkeyup="revisa_patrulla(this.value)">
                            <span id="mensaje_server"  value="" ></span>
                            <input type="hidden" id="id_patrulla" name="id_patrulla">
                        </td>
                    </tr>
                	<tr>
                		<td>Nombre(s):</td>
                		<td>
                			<input type="text" id="nombres" name="nombres" maxlength="35" required disabled>
                		</td>
                	</tr>
                	<tr>
                		<td>Apellido Paterno:</td>
                		<td>
                			<input type="text" id="apelldio_p" name="apellido_p" maxlength="35" required disabled>
                		</td>
                	</tr>
                	<tr>
                		<td>Apellido Materno:</td>
                		<td>
                			<input type="text" id="apellido_m" name="apellido_m" maxlength="35"  disabled>
                		</td>
                	</tr>
                	<tr>
                		<td>Fecha de nacimiento:</td>
                		<td>
                			<input type="date" id="fecha_nac" name="fecha_nac" maxlength="10" placeholder="dd/mm/aaaa"  disabled>
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
                			<input type="text" id="dom_calle" name="dom_calle" maxlength="35"  disabled> 
                		</td>
                	</tr>
                	<tr>
                		<td>Num. Ext: <input  type="text" id="dom_num_ext" name="dom_num_ext" maxlength="10"  disabled> </td>
                		<td>Num. Int: <input  type="text" id="dom_num_int" name="dom_num_int" maxlength="10"  disabled> </td>
                	</tr>
                	<tr>
                		<td>Colonia:</td>
                		<td>
                			<input type="text" id="dom_colonia" name="dom_colonia" maxlength="35"  disabled>
                		</td>
                	</tr>
                	<tr>
                		<td>Estado:</td>
                		<td>
                            
                            <select id="dom_estado" name="dom_estado"  disabled>

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
                            <input type="text" id="dom_del_mun" name="dom_del_mun" maxlength="60"  disabled>
                			
                		</td>
                	</tr>
                	
                	<tr>
                		<td>Código Postal:</td>
                		<td>
                			<input type="text" id="dom_cp" name="dom_cp" maxlength="5"  disabled>
                		</td>
                	</tr>
                	<tr><!-- TO DO Agregar codigo para la lada o el input type text-->
                		<td>Teléfono casa:</td>
                		<td>
                			<input type="text" id="telefono_casa" name="telefono_casa" maxlength="20"  disabled>
                	</tr>
                	<tr>
                		<td>Teléfono celular:</td>
                		<td>
                			<input type="text" id="telefono_celular" name="telefono_celular" maxlength="20"  disabled>
                	</tr>
                	<tr>
                		<td>Teléfono trabajo:</td>
                		<td>
                			<input type="text" id="telefono_trabajo" name="telefono_trabajo" maxlength="20"  disabled>
                	</tr>
                	<tr>
                		<td>Extensión del teléfono trabajo:</td>
                		<td>
                			<input type="text" id="telefono_extension" name="telefono_extension" maxlength="10"  disabled>
                	</tr>
                	<tr>
                		<td>Correo electrónico:</td>
                		<td>
                			<input type="text" id="correo1" name="correo1" maxlength="25" required  disabled>
                	</tr>
                	<tr>
                		<td>Confirmar correo electrónico:</td>
                		<td>
                			<input type="text"  id="correo2" name="correo2" onkeypress='validate(event)' maxlength="25"  required  onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete=off  disabled>
                	</tr>
                	<tr>
                		<td>Contraseña:</td>
                		<td>
                			<input type="password" id="pass1" name="pass1" maxlength="10" required disabled>
                	</tr>
                	<tr>
                		<td>Confirmar contraseña:</td>
                		<td>
                			<input type="password" id="pass2" name="pass2" onkeypress='validate(event)' maxlength="10" required  onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete=off  disabled>
                </table>

 		</fieldset>
 		<br>
		<input type = "submit" value = "Registrarse" id="registro" name = "registro" width="100" height="50" disabled>
	</form>

</body>
</html>