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
    require("funciones_form_docs.php");
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
	<title>Subir Documentos</title>
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

        <h3>Subir Documentos oficiales</h3>

        <fieldset>
           <form id="formulario_docs" name="formulario_docs" action="form_docs.php" method="POST" enctype="multipart/form-data" class="form-horizontal" >

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">Acta de Nacimiento:</label>
                 <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input class="file-loading" type="file" id="acta_nacimiento" name="acta_nacimiento" multiple="false" >
                </div>
            </div>
            <?php echo ver_archivos($id_usuario,"acta_nacimiento"); //mensaje para mostrar que ya se subio el archivo ?>
            <?php echo $mensaje_server_acta_nac; //error por si no se sube el archivo o aviso de que se logró correctamente ?>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">CURP:</label>
                 <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input class="file-loading" type="file" id="curp" name="curp" multiple="false" >
                </div>
            </div>

            <?php echo $mensaje_server_curp; //error por si no se sube el archivo o aviso de que se logró correctamente ?>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">IFE:</label>
                 <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input class="file-loading" type="file" id="ife" name="ife" multiple="false" >
                </div>
            </div>

            <?php echo $mensaje_server_ife; //error por si no se sube el archivo o aviso de que se logró correctamente ?>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">Comprobante de Domicilio:</label>
                 <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input class="file-loading" type="file" id="comprobante_dom" name="comprobante_dom" multiple="false" >
                </div>
            </div>

            <?php echo $mensaje_server_comprobante_dom; //error por si no se sube el archivo o aviso de que se logró correctamente ?>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">Curriculum:</label>
                 <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input class="file-loading" type="file" id="curriculum" name="curriculum" multiple="false" >
                </div>
            </div>

            <?php echo $mensaje_server_cv; //error por si no se sube el archivo o aviso de que se logró correctamente ?>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">Licencia de Manejo:</label>
                 <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input class="file-loading" type="file" id="licencia_manejo" name="licencia_manejo" multiple="false" >
                </div>
            </div>

            <?php echo $mensaje_server_lic_manejo; //error por si no se sube el archivo o aviso de que se logró correctamente ?>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">Cédula profesional:</label>
                 <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input class="file-loading" type="file" id="cedula_profesional" name="cedula_profesional" multiple="false" >
                </div>
            </div>

            <?php echo $mensaje_server_ced_prof; //error por si no se sube el archivo o aviso de que se logró correctamente ?>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">Cartilla del Servicio Militar:</label>
                 <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input class="file-loading" type="file" id="cartilla_servicio_militar" name="cartilla_servicio_militar" multiple="false" >
                </div>
            </div>

            <?php echo $mensaje_server_cartilla_serv_mil; //error por si no se sube el archivo o aviso de que se logró correctamente ?>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">Carnet o afiliación:</label>
                 <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input class="file-loading" type="file" id="carnet_afiliacion" name="carnet_afiliacion" multiple="false" >
                </div>
            </div>

            <?php echo $mensaje_server_carnet_afiliacion; //error por si no se sube el archivo o aviso de que se logró correctamente ?>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4 ">Pasaporte:</label>
                 <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <input class="file-loading" type="file" id="pasaporte" name="pasaporte" multiple="false" >
                </div>
            </div>

            <?php echo $mensaje_server_pasaporte; //error por si no se sube el archivo o aviso de que se logró correctamente ?>

            <div class="form-group">
                <label class="col-xs-12"> <h4><label class="label label-warning">Nota:</label></h4>Las caracterisiticas de los documentos son:
                        <ul>
                            <li>Ser de formato PDF, JPG, JPEG o PNG solamente.</li>
                            <li>Tener un tamaño no mayor a 2 MB</li>
                            <li>Ser a color, sin retoques, que el contraste tanto como el brillo hagan completamente legibles los documentos.</li>
                            <li>Los documentos deberán mostraste completos y sin ningún tipo de obstaculización para leer de manera efectiva los mismos.</li>
                        </ul>
                    Para más información o resolución de dudas pregunte a su jefe de patrulla o en su defecto al administrador del sitio.
                </label>
            </div>

            <div class="form-group">
                <div class="col-xs-offset-2 col-xs-8">
                    <input type = "submit" class="btn btn-primary btn-block" value = "Subir Documentos" id="actualizar" name = "actualizar" width="100" height="50">
                </div>
            </div>

            </form>

 		</fieldset>
 		
        <footer class="footer">
            <small>Última modificación Octubre 2015<br>Created by Salvador Antonio Cienfuegos Torres<br>s.cienfuegost@hotmail.com</small>
        </footer>
        
        </div>
        <div class="col-xs-1 col-sm-2 col-md-1 col-lg-2"></div>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="fondo_encabezado.js" ></script>
    <script src="js/fileinput.min.js"></script> <!-- https://github.com/kartik-v/bootstrap-fileinput -->
    <script src="js/fileinput_locale_es.js"></script> <!-- Código de validación local de los archivos con ayuda de bootstrap -->
    <script>
    $(document).on('ready', function() {

        $("#acta_nacimiento").fileinput({
            language: "es",
            allowedFileExtensions: ["pdf","jpg", "png", "jpeg"],
            maxFileSize: 2000, //Size is in KB, aceptable "MB"
            showUpload: false,
            maxFileCount: 1,
            previewClass: "bg-warning"
        });

        $("#curp").fileinput({
            language: "es",
            allowedFileExtensions: ["pdf","jpg", "png", "jpeg"],
            maxFileSize: 2000, //Size is in KB, aceptable "MB"
            showUpload: false,
            maxFileCount: 1,
            previewClass: "bg-warning"
        });

        $("#ife").fileinput({
            language: "es",
            allowedFileExtensions: ["pdf","jpg", "png", "jpeg"],
            maxFileSize: 2000, //Size is in KB, aceptable "MB"
            showUpload: false,
            maxFileCount: 1,
            previewClass: "bg-warning"
        });

        $("#comprobante_dom").fileinput({
            language: "es",
            allowedFileExtensions: ["pdf","jpg", "png", "jpeg"],
            maxFileSize: 2000, //Size is in KB, aceptable "MB"
            showUpload: false,
            maxFileCount: 1,
            previewClass: "bg-warning"
        });

        $("#curriculum").fileinput({
            language: "es",
            allowedFileExtensions: ["pdf","jpg", "png", "jpeg"],
            maxFileSize: 2000, //Size is in KB, aceptable "MB"
            showUpload: false,
            maxFileCount: 1,
            previewClass: "bg-warning"
        });

        $("#licencia_manejo").fileinput({
            language: "es",
            allowedFileExtensions: ["pdf","jpg", "png", "jpeg"],
            maxFileSize: 2000, //Size is in KB, aceptable "MB"
            showUpload: false,
            maxFileCount: 1,
            previewClass: "bg-warning"
        });

        $("#cedula_profesional").fileinput({
            language: "es",
            allowedFileExtensions: ["pdf","jpg", "png", "jpeg"],
            maxFileSize: 2000, //Size is in KB, aceptable "MB"
            showUpload: false,
            maxFileCount: 1,
            previewClass: "bg-warning"
        });

        $("#cartilla_servicio_militar").fileinput({
            language: "es",
            allowedFileExtensions: ["pdf","jpg", "png", "jpeg"],
            maxFileSize: 2000, //Size is in KB, aceptable "MB"
            showUpload: false,
            maxFileCount: 1,
            previewClass: "bg-warning"
        });

        $("#carnet_afiliacion").fileinput({
            language: "es",
            allowedFileExtensions: ["pdf","jpg", "png", "jpeg"],
            maxFileSize: 2000, //Size is in KB, aceptable "MB"
            showUpload: false,
            maxFileCount: 1,
            previewClass: "bg-warning"
        });

        $("#pasaporte").fileinput({
            language: "es",
            allowedFileExtensions: ["pdf","jpg", "png", "jpeg"],
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
