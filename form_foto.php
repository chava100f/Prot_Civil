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
    require("funciones_form_foto.php");

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
    <link href="css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
	<title>Cambio imagen de perfil</title>
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

        <h3>Cambio de imagen de perfil</h3>

        <fieldset>
           <form id="formulario_img" name="formulario_img" action="form_foto.php" method="POST" enctype="multipart/form-data" class="form-horizontal" >

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">Selecciona un archivo:</label>
                 <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input class="file-loading" type="file" id="foto_perfil" name="foto_perfil" multiple="false" required>
                </div>
            </div>

            <?php echo $mensaje_server; //error por si no se sube la imagen o aviso de que se logró correctamente ?>

            <div class="form-group">
                <label class="col-xs-12"> <h4><label class="label label-warning">Nota:</label></h4>Las caracterisiticas de la imagen de perfil son:
                        <ul>
                            <li>Ser de formato JPG, JPEG o PNG solamente.</li>
                            <li>Tener un tamaño no mayor a 2 MB</li>
                            <li>Mostrar en primer plano la cabeza y los hombros del solicitante(aproximadamente de las clavículas hacia arriba).</li>
                            <li>Ser a color, sin retoques, que los contrastes y tonos coincidan con los tonos naturales de la piel.</li>
                            <li>Cabeza y cara descubierta, sin gorras, sombreros, diademas, moños, turbantes, lentes de ningún tipo y peinados que oculten el contorno de la cara, el rostro o las orejas.</li>
                            <li>El solicitante debe aparecer con la cabeza derecha y viendo directamente a la cámara, tener la boca cerrada sin sonrisa y mantener una expresión neutra (evite poses artísticas).</li>
                        </ul>
                    Las características generales de la imagen de perfil son las mismas que las solicitadas en las fotografías para el trámite de pasaporte. Para más información de <a href="http://sre.gob.mx/fotografias">click aquí</a>.
                </label>
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
    <script src="js/fileinput.min.js"></script> <!-- https://github.com/kartik-v/bootstrap-fileinput -->
    <script src="js/fileinput_locale_es.js"></script>
    <script>
    $(document).on('ready', function() {

        $("#foto_perfil").fileinput({
            language: "es",
            allowedFileExtensions: ["jpg", "png", "jpeg"],
            maxFileSize: 2000, //Size is in KB, aceptable "MB"
            showUpload: false,
            maxFileCount: 1,
            previewClass: "bg-warning"
        });
    });
    </script>

</body>
</html>

<?php
}
?>
