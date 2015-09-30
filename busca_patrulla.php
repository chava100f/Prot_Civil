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
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
  <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/index-estilo.css" >
  <link rel="stylesheet" href="css/forms-estilo.css" >
	<title>Busca patrullas</title>
</head>
<body>

	<!-- Menu contextual-->
    
    <?php echo obtener_menu();?>
    
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

        <h3>Busca Patrulla</h3>

        <fieldset>
            <form action = "busca_patrulla.php" method = "POST" class="form-horizontal" >

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Nombre de la patrulla a buscar:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="nombre_patrulla" name="nombre_patrulla" maxlength="50" onkeyup="busca_patrulla(this.value)">
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12">   
                    <div class="table-responsive" id="busca_p_respuesta" name="busca_p_respuesta">    
                        
                    </div>     
                </div> 

                <?php //echo $mensaje_server; //muestra mensaje de exito o error si se crea la patrulla X ?>

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
    <script>

        var id, nombre;

        function busca_patrulla(str)  //Método en AJAX para buscar a las patrullas, si existe aparece una tabla con los nombre de las posibles coincidencias si no solo un mensaje de error
        {

            if (str.length == 0) 
            { 
                document.getElementById("mensaje_server").innerHTML = "";
                document.getElementById("busca_p_respuesta").innerHTML = "";
                return;
            } 
            else 
            {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() 
                {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
                    {
                        var respuesta = xmlhttp.responseText;
                        
                        document.getElementById("busca_p_respuesta").innerHTML = respuesta;
                    }
                }
                xmlhttp.open("GET", "busca_patrulla_server.php?n=" + str, true);
                xmlhttp.send();
            }
        }
 
    </script>
</body>
</html>


<?php
}
?>
