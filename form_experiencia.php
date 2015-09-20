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
    require("funciones_form_experiencia.php");

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
    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css" >
	<title>Actualización de Experiencia</title>
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

    <div class="col-xs-1 col-sm-2 col-md-2 col-lg-2"></div>

        <div class="col-xs-10 col-sm-8 col-md-8 col-lg-8">

        <h3>Información de experiencia en Patrullaje, Rescate, etc.</h3>

        <fieldset>
            <form action = "form_experiencia.php" method = "POST" class="form-horizontal" >
                
                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Cargos Anteriores:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input class="form-control" type="text" id="cargos" name="cargos" maxlength="50" value=<?php echo '"'.$cargos.'"'?> >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Patrullero:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <select id="patrullero" class="form-control" name="patrullero">
                            <option <?php if ($patrullero == "si" ) echo 'selected'; ?> value="si">SI</option>
                            <option <?php if ($patrullero == "no" ) echo 'selected'; ?> value="no">NO</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Fecha de graduación:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

                            <div class="input-group date" data-date-format="dd/mm/yyyy">

                                <input type="text" class="form-control datepicker" id="fecha_g" name="fecha_g"  placeholder="dd/mm/aaaa" value=<?php echo '"'.$fecha_g.'"'?> />
                                <span class="input-group-addon" id="datepicker1">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </span>

                            </div>

                        </div>
                    </div>

                <div class="form-group">
                    <label class="col-xs-12">
                        Experiencia:
                    </label>
                </div>

                <div class="form-group">
                    <?php echo insertar_experiencia_web();//-------------------------------------------------------------------------------------------------------------- ?> 
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Otra (Especificar):
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                         <textarea class="form-control" id="experiencia_otra" name="experiencia_otra" maxlength="180" placeholder="Describir aquí"><?php echo insertar_experiencia_otra_web(); ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Nombre del Dir. C.C.P.P. o calidad:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                         <input type="text" id="nom_dir" name="nom_dir" maxlength="50" class="form-control" value=<?php echo '"'.$nom_dir.'"'?> >
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
    <script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">
        $(function(){
            $('.datepicker').datepicker({
                format: "dd/mm/yyyy",
                language: "es"
            });
        });
    </script>
    <script type="text/javascript" src="fondo_encabezado.js" ></script>

</body>
</html>

<?php
}

?>
