<?php
//Codigo para revisar si la sesion a sido iniciada
session_start();
$basename = substr(strtolower(basename($_SERVER['PHP_SELF'])),0,strlen(basename($_SERVER['PHP_SELF']))-4);

if((empty($_SESSION['logged'])) && ($basename!="index"))
{
    header('Location: index.php');
    exit();
}//Si a inicado sesion entra en el "else"
else
{
    require("funciones_modificar_usuario.php"); 
	require("funciones_menu_contextual.php"); 
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index-estilo.css" >
    <link rel="stylesheet" href="css/forms-estilo.css" >
	<title>Modificar Usuario</title>

</head>
<body>
    <!-- Menu contextual-->
    
    <?php echo obtener_menu()?>
    
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

        <div class="col-xs-1 col-sm-2 col-md-1 col-lg-2"></div>

        <div class="col-xs-10 col-sm-8 col-md-10 col-lg-8">

        <h3>Modificar usuario</h3>

        <fieldset>

            <?php echo '<form action = "modificar_usuario.php?id='.$id_user_modif.'" method = "POST" class="form-horizontal" >';?>

            <div class="form-group">

                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Nombre(s):
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" class="form-control" id="nombres" name="nombres" maxlength="35" value=<?php echo '"'.$nombres.'"'?> required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Apellido Paterno:
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" class="form-control" id="apelldio_p" name="apellido_p" maxlength="35" value=<?php echo '"'.$apellido_p.'"'?> required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Apellido Materno:
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input type="text" class="form-control" id="apellido_m" name="apellido_m" maxlength="35" value=<?php echo '"'.$apellido_m.'"'?> required>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Patrulla:
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <select id="patrulla" class="form-control" name="patrulla" required>
                        <?php echo $patrulla; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Tipo de Cuenta:
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <select id="tipo_cuenta_u" class="form-control" name="tipo_cuenta_u" required>
                        <option <?php if ($tipo_cuenta_u == "USUARIO" ) echo 'selected'; ?> value="USUARIO">USUARIO</option>
                        <option <?php if ($tipo_cuenta_u == "JEFE" ) echo 'selected'; ?> value="JEFE">JEFE</option>
                        <option <?php if ($tipo_cuenta_u == "ADMIN" ) echo 'selected'; ?> value="ADMIN">ADMIN</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Calidad de Miembro:
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <select id="calidad_miembro" class="form-control" name="calidad_miembro" required>
                        <option <?php if ($calidad_miembro == "ACTIVO" ) echo 'selected'; ?> value="ACTIVO">ACTIVO</option>
                        <option <?php if ($calidad_miembro == "INACTIVO" ) echo 'selected'; ?> value="INACTIVO">INACTIVO</option>
                        <option <?php if ($calidad_miembro == "BAJA" ) echo 'selected'; ?> value="BAJA">BAJA</option>
                        <option <?php if ($calidad_miembro == "SUSPENDIDO" ) echo 'selected'; ?> value="SUSPENDIDO">SUSPENDIDO</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
	            <label class="col-xs-12 col-sm-12">
	                El correo electrónico actual es: <u><?php echo $correo_actual; ?></u>
	            </label>
	        </div>

            <div class="form-group">
	            <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	                Correo electrónico nuevo:
	            </label>
	            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
	                <input type="email" class="form-control" id="correo1" name="correo1" maxlength="25">
	            </div>
	        </div>

	        <div class="form-group">
	            <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	                Confirmar correo electrónico:
	            </label>
	            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
	                <input type="email" class="form-control"  id="correo2" name="correo2" onkeypress='validate(event)' maxlength="25" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete=off>
	            </div>
	        </div>

	        <?php echo $error_email; //error por si no coinciden los correos electrónicos ?>
            <?php echo $exito; //error por si no coinciden los correos electrónicos ?>
            
            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-8">
                    <input type = "submit" class="btn btn-primary btn-block" value = "Actualizar Datos" id="actualizar" name = "actualizar" width="100" height="50">
                </div>
            </div>
               
            </form>

 		</fieldset>
 		
        <footer class="footer">

            <small>Última modificación Septiembre 2015</small>

        </footer>
        
    </div>
    <div class="col-xs-1 col-sm-2 col-md-1 col-lg-2"></div>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="fondo_encabezado.js" ></script>

</body>
</html>


<?php
}

?>
