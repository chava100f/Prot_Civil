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
    require("funciones_modificar_patrulla.php"); 
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
	<title>Modifica Patrulla</title>
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

        <h3>Modificar Patrulla</h3>

        <fieldset>
            <?php echo '<form action = "modificar_patrulla.php?id='.$id_patrulla.'" method = "POST" class="form-horizontal" >';?>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Nombre de la nueva patrulla:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="nombre_patrulla" name="nombre_patrulla" maxlength="20" required value=<?php echo '"'.$nombre_patrulla.'"'?> >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Clave de la nueva patrulla:
                    </label>
                    <div class="col-xs-6 col-sm-8 col-md-6">
                        <input type="text" class="form-control" id="clave_p" name="clave_p" minlength="4" maxlength="6" required placeholder="De 4 a 6 caracteres" style='font-family: serif;' value=<?php echo '"'.$clave_p.'"'?> >
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md-2">
                      <button type="button" class="btn btn-success btn-block" onclick="obtiene_clave_p()">Aleatorio</button>
                    </div>
                </div>

                

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        
                    </label>
                </div>

                <?php echo $mensaje_server; //muestra mensaje de exito o error si se crea la patrulla X ?>

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
        <div class="col-xs-1 col-sm-2 col-md-1 col-lg-2"></div>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="fondo_encabezado.js" ></script>
    <script type="text/javascript">
      function obtiene_clave_p()
      {
          var text = "";
          var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

          for( var i=0; i < 6; i++ )
              {text += possible.charAt(Math.floor(Math.random() * possible.length));}

          document.getElementById("clave_p").value=text; 
      }
    </script>
</body>
</html>


<?php
}
?>
