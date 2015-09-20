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
    require("funciones_form_medico.php");

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
	<title>Actualización de Información Médica</title>
    <script>
        
    </script>

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

        <h3>Información Médica</h3>

        <fieldset>
           <form action = "form_medico.php" method = "POST" class="form-horizontal" >

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Tipo de Sangre:
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <select class="form-control"  name="sangre" id="sangre">
                        <option <?php if ($sangre == "A+" ) echo 'selected'; ?> value="A+">A+</option>                                
                        <option <?php if ($sangre == "A-" ) echo 'selected'; ?> value="A-">A-</option>
                        <option <?php if ($sangre == "B+" ) echo 'selected'; ?> value="B+">B+</option>
                        <option <?php if ($sangre == "B-" ) echo 'selected'; ?> value="B-">B-</option>
                        <option <?php if ($sangre == "AB+" ) echo 'selected'; ?> value="AB+">AB+</option>
                        <option <?php if ($sangre == "AB-" ) echo 'selected'; ?> value="AB-">AB-</option>
                        <option <?php if ($sangre == "O+" ) echo 'selected'; ?> value="O+">O+</option>
                        <option <?php if ($sangre == "O-" ) echo 'selected'; ?> value="O-">O-</option>                               
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12">
                    Vacunas Locales:
                </label>
            </div>

            <div class="form-group">
                <?php echo insertar_vacunas_web();//-------------------------------------------------------------------------------------------------------------- ?> 
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Vacunas Internacionales:
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <textarea class="form-control" id="vacuna_internacional" name="vacuna_internacional" maxlength="180" placeholder="Describir aquí"><?php echo insertar_vacunas_internacionales_web(); ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Padecimientos o Limitaciones físicas:
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <textarea class="form-control" id="padecimientos_limitfisicas" name="padecimientos_limitfisicas" maxlength="180" placeholder="Describir aquí"><?php echo $padecimientos_limitfisicas;?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Alergias:
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <textarea class="form-control" id="alergias" name="alergias" maxlength="180" placeholder="Describir aquí"><?php echo $alergias;?></textarea>
                </div>
            </div>
              
                
            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Servicio Médico:
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <select class="form-control" name="servicio_medico" id="servicio_medico">
                        <option <?php if ($servicio_medico == "IMSS" ) echo 'selected'; ?> value="IMSS">IMSS</option>
                        <option <?php if ($servicio_medico == "ISSSTE" ) echo 'selected'; ?> value="ISSSTE">ISSSTE</option>
                        <option <?php if ($servicio_medico == "PEMEX" ) echo 'selected'; ?> value="PEMEX">PEMEX</option>
                        <option <?php if ($servicio_medico == "SEGURO POPULAR" ) echo 'selected'; ?> value="SEGURO POPULAR">SEGURO POPULAR</option>
                        <option <?php if ($servicio_medico == "PARTICULAR" ) echo 'selected'; ?> value="PARTICULAR">PARTICULAR</option>
                    </select>
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
    <div class="col-xs-1 col-sm-2 col-md-1 col-lg-2"></div>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="fondo_encabezado.js" ></script>

</body>
</html>

<?php
}
?>
