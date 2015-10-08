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
    require("funciones_menu_contextual.php"); 

    $error_nombre_p="";

    $mensaje_server = "";

    if(isset($_POST['alta_patrulla'])) //código para validar los datos del formulario
    {   
        $nombre_patrulla = strip_tags($_POST['nombre_patrulla']);

        if($nombre_patrulla != "")
        {
          $id_p = strip_tags($_POST['clave_p']);

          if(strlen($id_p)>=4 && strlen($id_p)<=6)
          {
          	require("funciones.php");
            $conexion = conectar();

            $nombre_patrulla = mysqli_real_escape_string($conexion, $nombre_patrulla);
            $id_p = mysqli_real_escape_string($conexion, $id_p);

            $bandera_alta="";

            //Revisa que no exista ya esa patrulla en la BD
            $query = 'SELECT id_patrullas FROM patrullas WHERE nombre = "'.$nombre_patrulla.'";';
            $consulta = ejecutarQuery($conexion, $query);
            if (mysqli_num_rows($consulta)) {
              while ($dat = mysqli_fetch_array($consulta)){
                  $c = $dat['id_patrullas'];
              }
                $bandera_alta =1;
            }

            if($bandera_alta!=1)//Si no se activo la bandera puede dar de alta la patrulla
            {
            	$query = 'INSERT INTO patrullas(clave, nombre) VALUES ("'.$id_p.'", "'.$nombre_patrulla.'")';
            	$consulta = ejecutarQuery($conexion, $query);
            	
              //Revisa que se haya subido correctamente la patrulla a la BD
              $query = 'SELECT clave, nombre FROM patrullas WHERE nombre = "'.$nombre_patrulla.'" AND clave = "'.$id_p.'"';
              $consulta = ejecutarQuery($conexion, $query);

              if (mysqli_num_rows($consulta)) {
                  while ($dat = mysqli_fetch_array($consulta)){
                      $nombre_patrulla = $dat['nombre'];
                      $clave = $dat['clave'];
                  }
                  $mensaje_server = '<div class="alert  alert-success" role="alert"><strong>¡Éxito!</strong> La patrulla <b>'.$nombre_patrulla.'</b> ha sido agregada con la clave <b><u>'.$clave.'</u></b></div>';
              }
              else
              {
                  $mensaje_server = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> No se pudo dar de alta la patrulla intente de nuevo.</div>';
              }
          	}
            else
            {
                $mensaje_server = '<div class="alert alert-danger" role="alert"><strong>Error:</strong> La patrulla '.$nombre_patrulla.' ya existe, intente con otro nombre.</div>';
            }
          	//header("Location: alta_patrulla_respuesta.php?nombre=".$nombre_patrulla."&id_p=".$id_p."");
  			    //exit();

            desconectar($conexion);
          } 
          else
          {
            $error_nombre_p = "<div class='alert alert-danger' role='alert'><strong>Error:</strong> La longitud de la clave de patrulla debe ser entre 4 a 6 caracteres.</div>";
          }

        }
        else
        {
        	$error_nombre_p = "<div class='alert alert-danger' role='alert'><strong>Error:</strong> El nombre de patrulla es inválido.</div>";
        }

    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/index-estilo.css" >
  <link rel="stylesheet" href="css/forms-estilo.css" >
	<title>Alta Patrulla</title>
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

        <h3>Dar de alta a patrulla nueva al sistema</h3>

        <fieldset>
           <form id="formulario_alta" name="formulario_alta" action = "alta_patrulla.php" method = "POST" class="form-horizontal" >

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Nombre de la nueva patrulla:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="nombre_patrulla" name="nombre_patrulla" maxlength="20" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Clave de la nueva patrulla:
                    </label>
                    <div class="col-xs-6 col-sm-8 col-md-6">
                        <input type="text" class="form-control" id="clave_p" name="clave_p" minlength="4" maxlength="6" required placeholder="De 4 a 6 caracteres" style='font-family: serif;'>
                    </div>
                    <div class="col-xs-6 col-sm-4 col-md-2">
                      <button type="button" class="btn btn-success btn-block" onclick="obtiene_clave_p()">Aleatorio</button>
                    </div>
                </div>

                

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        
                    </label>
                </div>

                <?php echo $error_nombre_p; //error por si no se pone ningun nombre a la patrulla ?>
                <?php echo $mensaje_server; //muestra mensaje de exito o error si se crea la patrulla X ?>

                <div class="form-group">
                    <div class="col-xs-offset-2 col-xs-8">
                        <input type = "submit" class="btn btn-primary btn-block" value = "Dar de Alta" id="alta_patrulla" name = "alta_patrulla" width="100" height="50">
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
