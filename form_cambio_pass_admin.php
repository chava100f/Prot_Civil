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
    require("funciones_form_cambio_pass.php");

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
    <title>Cambio de contraseña</title>

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

        <h3>Cambio de contraseña</h3>

        <fieldset>
           <form id="formulario_password" name="formulario_password" action = "form_cambio_pass_admin.php" method = "POST" class="form-horizontal" >

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Ingrese su nueva contraseña:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="password" class="form-control" id="pass1" name="pass1" maxlength="10" pattern=".{5,10}" title="5 to 10 caracteres">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Confirme su contraseña:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="password" class="form-control" id="pass2" name="pass2" onkeypress='validate(event)' maxlength="10" onCopy="return false" onDrag="return false" onDrop="return false" onPaste="return false" autocomplete=off pattern=".{5,10}" title="5 to 10 caracteres">
                    </div>
                </div>

                <?php echo $mensaje_server; //error por si no coinciden las contraseñas ?>

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

