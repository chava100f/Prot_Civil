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
    require("funciones_form_info_fisica.php");

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
	<title>Actualización de Información Física</title>
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

        <h3>Información Física</h3>

        <fieldset>
           <form action = "form_info_fisica.php" method = "POST" class="form-horizontal" >

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Sexo:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <select id="sexo" class="form-control" name="sexo">
                            <option <?php if ($sexo == "HOMBRE" ) echo 'selected'; ?> value="HOMBRE" >HOMBRE</option>
                            <option <?php if ($sexo == "MUJER" ) echo 'selected'; ?> value="MUJER">MUJER</option>
                            <option <?php if ($sexo == "OTRO" ) echo 'selected'; ?> value="OTRO">OTRO</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Estatura:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input class="form-control" type="number" id="estatura" name="estatura" maxlength="4" step="0.01" min="0.00" max="2.50" placeholder="Estatura en metros" value=<?php echo '"'.$estatura.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Peso:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input class="form-control" type="number" id="peso" name="peso" maxlength="3" maxlength="6" step="0.01" min="0.00" max="200.00" placeholder="Peso en Kilogramos" value=<?php echo '"'.$peso.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Complexión:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input class="form-control" type="text" id="complexion" name="complexion" maxlength="130" value=<?php echo '"'.$complexion.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Cabello:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input class="form-control" type="text" id="cabello" name="cabello" maxlength="20" value=<?php echo '"'.$cabello.'"'?> >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Color de ojos:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input class="form-control" type="text" id="ojos" name="ojos" min="1" maxlength="20" value=<?php echo '"'.$ojos.'"'?> > 
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Cara:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input class="form-control" type="text" id="cara" name="cara" maxlength="30" value=<?php echo '"'.$cara.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Nariz:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input class="form-control" type="text" id="nariz" name="nariz" maxlength="20" value=<?php echo '"'.$nariz.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Señas Particulares:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">                        
                         <textarea class="form-control" id="senias" name="senias" maxlength="180" placeholder="Describir aquí"><?php echo $senias;?></textarea>
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
            <small>Última modificación Octubre 2015<br>Created by Salvador Antonio Cienfuegos Torres<br>s.cienfuegost@hotmail.com</small>
        </footer>

        </div>
        <div class="col-xs-1 col-sm-2 col-md-2 col-lg-2"></div>

    </div>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="fondo_encabezado.js" ></script>
</body>
</html>

<?php
}

?>
