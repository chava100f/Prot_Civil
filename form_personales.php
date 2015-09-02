<?php 

//Codigo para revisar si la sesion a sido iniciada
session_start();
$basename = substr(strtolower(basename($_SERVER['PHP_SELF'])),0,strlen(basename($_SERVER['PHP_SELF']))-4);

if((empty($_SESSION['logged'])) && ($basename!="index"))
{
    header('Location: index.php');
    exit;
}//Si a inicado sesion entra en el "else"
else
{
    //código para obtener los datos de la BD y mostrarlos ----------------------------------------------

    $user=$_SESSION['logged_user'];

    require_once("funciones.php");
    $conexion = conectar();
    
    $query = 'SELECT id_num_reg FROM datos_personales WHERE email="'.$user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $id_user = $dat['id_num_reg'];
        }
    }

    $nombres = "";                 
    $apellido_p = "";
    $apellido_m = "";
    $fecha_nac = "";
    $dom_calle = "";
    $dom_num_ext = "";
    $dom_num_int = "";
    $dom_colonia = "";
    $dom_estado = "";
    $dom_del_mun = "";
    $dom_cp = "";
    $telefono_casa = "";
    $telefono_celular = "";
    $telefono_trabajo = "";
    $telefono_extension = "";

    $query = 'SELECT * FROM datos_personales WHERE id_num_reg="'.$id_user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $id_user = $dat['id_num_reg'];
            $nombres = $dat['nombre'];                      
            $apellido_p = $dat['apellido_p'];
            $apellido_m = $dat['apellido_m'];
            $fecha_nac = $dat['fecha_nac'];
            $dom_calle = $dat['dom_calle'];
            $dom_num_ext = $dat['dom_num_ext'];
            $dom_num_int = $dat['dom_num_int'];
            $dom_colonia = $dat['dom_col'];
            $dom_estado = $dat['dom_estado'];
            $dom_del_mun = $dat['dom_del_mun'];
            $dom_cp = $dat['dom_cp'];
            $telefono_casa = $dat['telefono_casa'];
            $telefono_celular = $dat['telefono_celular'];
            $telefono_trabajo = $dat['telefono_trabajo'];
            $telefono_extension = $dat['telefono_extension'];
        }
    }

    desconectar($conexion);

    //------------------------------------------------------------------------------------------------------

    function obtener_opcion_e() //código para llenar el catálogo de los estados.
    {

        $user1=$_SESSION['logged_user'];

        require_once("funciones.php");
        $conexion = conectar();
        
        $query = 'SELECT id_num_reg FROM datos_personales WHERE email="'.$user1.'"'; //obtener id de usuario
        $consulta = ejecutarQuery($conexion, $query);
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $id_user1 = $dat['id_num_reg'];
            }
        }

        $query = 'SELECT dom_estado FROM datos_personales WHERE id_num_reg="'.$id_user1.'"'; //obtener el estado registrado en la BD
        $consulta = ejecutarQuery($conexion, $query);
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $dom_estado = $dat['dom_estado'];
            }
        }

        $query = 'SELECT nombre, id FROM estados'; //seleccionar el estado que se había seleccionado
        $consulta = ejecutarQuery($conexion, $query);
        $opciones_e="";
        $contador=0;
        $seleccion="";

        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $id = $dat['id'];
                $nombre = $dat['nombre'];
                $contador++;

                if($dom_estado == $contador ) 
                {
                    $seleccion = 'selected'; 
                }
                else
                {
                 $seleccion= "";
                }

                $opciones_e = $opciones_e.'<option '.$seleccion.' value='.$id.'>'.$nombre.'</option>';
            }
        }

        desconectar($conexion);

        return $opciones_e;
    }
    //--------------------------------------------------------------------------------------------------------


    //Si se da Submit o Enviar primero se validan los datos y despues se incertan en la BD
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

        //TO DO Elaboración del Query (tratar de pasar esto a un Store procedure)!!!


        //Actualiza la tabla datos personales....

        $query = 'UPDATE datos_personales SET fecha_nac = "'.$fecha_nac.'", dom_calle = "'.$dom_calle.'", dom_num_ext = "'.$dom_num_ext.'", dom_num_int = "'.$dom_num_int.'", dom_col = "'.$dom_colonia.'",';
        $query .= 'dom_estado = "'.$dom_estado.'", dom_del_mun = "'.$dom_del_mun.'", dom_cp = "'.$dom_cp.'", telefono_casa = "'.$telefono_casa.'", telefono_celular = "'.$telefono_celular.'", ';
        $query .= 'telefono_trabajo = "'.$telefono_trabajo.'", telefono_extension = "'.$telefono_extension.'" ';  
        $query .= 'WHERE id_num_reg = "'.$id_user.'"';      
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
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css" >
    <link rel="stylesheet" href="css/index-estilo.css" >
    <link rel="stylesheet" href="css/forms-estilo.css" >
	<title>Actualización de Datos Personales Básicos</title>
    <script>
        
    </script>

</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <p class="navbar-brand">Información personal básica</p>
        </div>
        <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index_usuario.php">Inicio</a></li>
            <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                Modificar Datos <span class="caret"></span>
                </a>
                <ul class="dropdown-menu inverse-dropdown" >
                    <li><a href="form_personales.php">Información Personal Básica</a></li>
                    <li><a href="form_complementario.php">Información Complementaria</a></li>
                    <li><a href="form_medico.php">Información Medica</a></li>
                    <li><a href="form_info_fisica.php">Información Fisica</a></li>
                    <li><a href="form_experiencia.php">Información de Experiencia en Patrullaje y Rescate</a></li>
                </ul>
            </li>
            <li><a href="#">Cambiar contraseña</a></li>
            <li><a href="cerrar_sesion.php">Cerrar sesión</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Cabecera de la página -->
    <header id="header">
        <div class="container">
            <div class="col-xs-12 col-sm-12 col-md-2" >
                <img src="imagenes/brsam-logo.png" />
            </div>
            
            <h2 class="col-xs-12 col-sm-12 col-md-10"> BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C. </h2>
        
        </div>
    </header>

    <!--Comienza el contenido -->
    <br>
    <div class="container" id="general-form">

        <div class="col-xs-1 col-sm-2 col-md-2 col-lg-2"></div>

        <div class="col-xs-10 col-sm-8 col-md-8 col-lg-8">

        <h3>Datos Personales básicos</h3>

        <fieldset>
    	   <form action = "form_personales.php" method = "POST" class="form-horizontal" >

                <div class="form-group">

                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Nombre(s):
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="nombres" name="nombres" maxlength="35" disabled value=<?php echo '"'.$nombres.'"'?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Apellido Paterno:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="apelldio_p" name="apellido_p" maxlength="35" disabled value=<?php echo '"'.$apellido_p.'"'?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Apellido Materno:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="apellido_m" name="apellido_m" maxlength="35" disabled value=<?php echo '"'.$apellido_m.'"'?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Fecha de nacimiento:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

                            <div class="input-group date" data-date-format="dd/mm/yyyy">

                                <input type="text" class="form-control datepicker" id="fecha_nac" name="fecha_nac" pattern="\d{1,2}/\d{1,2}/\d{4}" placeholder="dd/mm/aaaa" value=<?php echo '"'.$fecha_nac.'"'?> />
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
                            <input type="text" class="form-control" id="dom_calle" name="dom_calle" maxlength="35" value=<?php echo '"'.$dom_calle.'"'?> > 
                        </div>
                    </div>

                    <div class="form-group">
                        <label  class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Num. Ext:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input  type="text" class="form-control" id="dom_num_ext" name="dom_num_ext" maxlength="10" value=<?php echo '"'.$dom_num_ext.'"'?> >
                        </div>
                    </div>
                    <div class="form-group">

                        <label  class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Num. Int:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input  type="text" class="form-control" id="dom_num_int" name="dom_num_int" maxlength="10" value=<?php echo '"'.$dom_num_int.'"'?> >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Colonia:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="dom_colonia" name="dom_colonia" maxlength="35" value=<?php echo '"'.$dom_colonia.'"'?> > 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Estado:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <select id="dom_estado" class="form-control" name="dom_estado" >

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
                            <input type="text" class="form-control" id="dom_del_mun" name="dom_del_mun" maxlength="60" value=<?php echo '"'.$dom_del_mun.'"'?> >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Código Postal:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="dom_cp" name="dom_cp" maxlength="5" value=<?php echo '"'.$dom_cp.'"'?> >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 centrado-element">
                            <b>Contacto</b> 
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <!-- TO DO Agregar codigo para la lada o el input type text-->
                            Tel. Casa:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">045</span>
                                <input type="text" class="form-control" id="telefono_casa" name="telefono_casa" maxlength="20" aria-describedby="basic-addon1" value=<?php echo '"'.$telefono_casa.'"'?>>
                            </div>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Tel. Celular:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">044</span>
                                <input type="text" class="form-control" id="telefono_celular" name="telefono_celular" maxlength="20" aria-describedby="basic-addon1" value=<?php echo '"'.$telefono_celular.'"'?>>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Tel. Trabajo:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="telefono_trabajo" name="telefono_trabajo" maxlength="20" value=<?php echo '"'.$telefono_trabajo.'"'?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Extensión del teléfono trabajo:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="telefono_extension" name="telefono_extension" maxlength="10" value=<?php echo '"'.$telefono_extension.'"'?>>
                        </div>
                    </div>
                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-8">
                        <input type = "submit" class="btn btn-primary btn-block" value = "Actualizar Datos" id="actualizar" name = "actualizar" width="100" height="50">
                    </div>
                </div>
        	</form>
        </fieldset>

        <footer class="footer">

            <small>Última modificación Agosto 2015</small>

        </footer>

        </div>
        <div class="col-xs-1 col-sm-2 col-md-2 col-lg-2"></div>

    </div>

    
        
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript"> 
        $(function(){ //script para dar formato al datepicker
            $('.datepicker').datepicker({
                format: "dd/mm/yyyy",
                language: "es"
            });
        });
    </script>
    <script type="text/javascript"> //función para hacer dinamigo el fondo 
     $(function(){
    
            var limit = 0; // 0 = infinite.
            var interval = 2;// Secs
            var images = [
                "imagenes/Fondos/1.jpg",
                "imagenes/Fondos/2.jpg",
                "imagenes/Fondos/3.jpg"
            ];

            var inde = 0; 
            var limitCount = 0;
            var myInterval = setInterval(function() {
               if (limit && limitCount >= limit-1) clearTimeout(myInterval);
               if (inde >= images.length) inde = 0;
                $('header').css({ "background-image":"url(" + images[inde]+ ")" });
               inde++;
               limitCount++;
            }, interval*5000);
        });    

    </script>
</body>
</html>

<?php
}

?>
