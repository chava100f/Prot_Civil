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

                    //TO DO Elaboración del Query (tratar de pasar esto a un Store procedure)!!!
                    
                    $query = 'INSERT INTO datos_personales(nombre, apellido_p, apellido_m, fecha_nac, dom_calle, dom_num_ext, dom_num_int, dom_col, dom_del_mun, dom_estado, dom_cp, telefono_casa, telefono_celular, telefono_trabajo, telefono_extension, email, contrasenia, tipo_cuenta, calidad_miembro, fecha_registro, patrullas_id_patrullas)';
                    $query = $query.' VALUES ("'.$nombres.'", "'.$apellido_p.'", "'.$apellido_m.'", "'.$fecha_nac.'", "'.$dom_calle.'", "'.$dom_num_ext.'", "'.$dom_num_int.'", "'.$dom_colonia.'", "'.$dom_del_mun.'", "'.$dom_estado.'", "'.$dom_cp.'", "'.$telefono_casa.'", "'.$telefono_celular.'", "'.$telefono_trabajo.'", "'.$telefono_extension.'", "'.$correo1.'", "'.$pass1.'","usuario", "activo", now(),'.$id_p.')'; 
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
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css" >
    <link rel="stylesheet" href="css/forms-estilo.css" >
    <!-- Custom styles for this template -->
	<title>Registro de Usuarios</title>
    

</head>
<body>
	<div class="container" >
        <header class="header-index">
            
            <img src="imagenes/brsam-logo.png" />
            <h2> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h2>
            
        </header>
    </div>

    <div class="container" id="general-form">
        
        <div class="col-xs-1 col-sm-3 col-md-3 col-lg-3"></div>

        <div class="col-xs-10 col-sm-6 col-md-6 col-lg-6">

            <h3>Registro</h3>

            <fieldset>
	           <form action = "registra_usuario.php" method = "POST" class="form-horizontal" role="form">
                    
                    <div class="form-group">

                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Introduzca el ID de patrulla:
                        </label>

                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <div class="input-group">
                                <input type="text" class="form-control" name="patrulla" maxlength="10" required onkeyup="revisa_patrulla(this.value)" aria-describedby="addon" >
                                <span class="input-group-addon" id="mensaje_server"></span>
                            </div>
                            <input type="hidden" id="id_patrulla" name="id_patrulla">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Nombre(s):
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="nombres" name="nombres" maxlength="35" required disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Apellido Paterno:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="apelldio_p" name="apellido_p" maxlength="35" required disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Apellido Materno:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="apellido_m" name="apellido_m" maxlength="35"  disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Fecha de nacimiento:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

                            <div class="input-group date" data-date-format="dd/mm/yyyy">

                                <input type="text" class="form-control datepicker" id="fecha_nac" name="fecha_nac"  placeholder="dd/mm/aaaa" disabled/>
                                <span class="input-group-addon" id="datepicker1">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </span>

                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 centrado-element">
                            <b>Dirección</b> <br>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Calle o Avenida:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="dom_calle" name="dom_calle" maxlength="35"  disabled> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label  class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Num. Ext:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input  type="text" class="form-control" id="dom_num_ext" name="dom_num_ext" maxlength="10"  disabled>
                        </div>
                    </div>
                    <div class="form-group">

                        <label  class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Num. Int:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input  type="text" class="form-control" id="dom_num_int" name="dom_num_int" maxlength="10"  disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Colonia:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="dom_colonia" name="dom_colonia" maxlength="35"  disabled> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Estado:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <select id="dom_estado" class="form-control" name="dom_estado"  disabled>

                                <?php //código para llenar el catálogo de los estados.
                                    echo obtener_opcion_e();
                                ?>

                            </select> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Delegación o Municipio:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <?php 
                            //Tentativa para manejar en un futuro con la BD 
                                /*<select name="dom_del_mun">
                                    <option value="m1">Municipio 1</option>
                                    ...
                                </select>*/
                            ?>
                            <input type="text" class="form-control" id="dom_del_mun" name="dom_del_mun" maxlength="60"  disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Código Postal:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="dom_cp" name="dom_cp" maxlength="5"  disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 centrado-element">
                            <b>Contacto</b> <br>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <!-- TO DO Agregar codigo para la lada o el input type text-->
                            Tel. Casa:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="telefono_casa" name="telefono_casa" maxlength="20"  disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Tel. Celular:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="telefono_celular" name="telefono_celular" maxlength="20"  disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Tel. Trabajo:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="telefono_trabajo" name="telefono_trabajo" maxlength="20"  disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Extensión del teléfono trabajo:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="telefono_extension" name="telefono_extension" maxlength="10"  disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 centrado-element">
                            <b>Usuario y contraseña</b> <br>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Correo electrónico:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="correo1" name="correo1" maxlength="25" required  disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Confirmar correo electrónico:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control"  id="correo2" name="correo2" onkeypress='validate(event)' maxlength="25"  required  onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete=off  disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Contraseña:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="password" class="form-control" id="pass1" name="pass1" maxlength="10" required disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Confirmar contraseña:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="password" class="form-control" id="pass2" name="pass2" onkeypress='validate(event)' maxlength="10" required  onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete=off  disabled>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-offset-2 col-xs-8">
                            <input type = "submit" class="btn btn-primary btn-block" value = "Registrarse" id="registro" name = "registro" disabled>
                        </div>
                    </div>

                </form>
            </fieldset>

            <footer class="footer">
                <small>Última modificación Julio 2015</small>
            </footer>

        </div>

        <div class="col-xs-1 col-sm-3 col-md-3 col-lg-3"></div>
    </div>
    
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('.datepicker').datepicker({
                format: "dd/mm/yyyy",
                language: "es"
            });
        });
    </script>
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

                        id = respuesta.substring(0, 3);
                        nombre = respuesta.substring(4,50);
                        
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
</body>
</html>