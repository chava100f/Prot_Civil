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
    require("funciones_form_complementario.php");

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
	<title>Actualización de Datos Complementarios</title>
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

        <h3>Datos Complementarios</h3>

        <fieldset>
    	   <form action = "form_complementario.php" method = "POST" class="form-horizontal" >

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Nacionalidad:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" maxlength="20" value=<?php echo '"'.$nacionalidad.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Ocupación:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="ocupacion" name="ocupacion" maxlength="35" value=<?php echo '"'.$ocupacion.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Escolaridad:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="escolaridad" name="escolaridad" maxlength="35" value=<?php echo '"'.$escolaridad.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Estado Civil:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <select id="estado_civil" class="form-control" name="estado_civil">
                            <option <?php if ($estado_civil == "SOLTERO" ) echo 'selected'; ?> value="SOLTERO">SOLTERO(A)</option>
                            <option <?php if ($estado_civil == "CASADO" ) echo 'selected'; ?> value="CASADO">CASADO(A)</option>
                            <option <?php if ($estado_civil == "DIVORCIADO" ) echo 'selected'; ?> value="DIVORCIADO">DIVORCIADO(A)</option>
                            <option <?php if ($estado_civil == "VIUDO" ) echo 'selected'; ?> value="VIUDO">VIUDO(A)</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Edad:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="edad" name="edad" min="1" max="99" value=<?php echo '"'.$edad.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Cartilla Militar:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input  type="text" class="form-control" id="cartilla" name="cartilla" maxlength="10" value=<?php echo '"'.$cartilla.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Nombre del Trabajo o Escuela:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="trabajo_escuela" name="trabajo_escuela" maxlength="30" value=<?php echo '"'.$trabajo_escuela.'"'?> >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 centrado-element">
                        Licencia de manejo:
                    </label>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Tipo:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                         <select id="licencia_tipo" class="form-control" name="licencia_tipo">
                            <option <?php if ($licencia_tipo == "AUTOMOVILISTA" ) echo 'selected'; ?> value="AUTOMOVILISTA">AUTOMOVILISTA</option>
                            <option <?php if ($licencia_tipo == "CHOFER DE SERVICIO PARTICULAR" ) echo 'selected'; ?> value="CHOFER DE SERVICIO PARTICULAR">CHOFER DE SERVICIO PARTICULAR</option>
                            <option <?php if ($licencia_tipo == "MOTOCICLISTA" ) echo 'selected'; ?> value="MOTOCICLISTA">MOTOCICLISTA</option>
                            <option <?php if ($licencia_tipo == "PERMISO PROVICIONAL A" ) echo 'selected'; ?> value="PERMISO PROVICIONAL A">PERMISO PROVICIONAL A</option>
                            <option <?php if ($licencia_tipo == "PERMISO PROVICIONAL B" ) echo 'selected'; ?> value="PERMISO PROVICIONAL B">PERMISO PROVICIONAL B</option>
                            <option <?php if ($licencia_tipo == "DUPLICADO" ) echo 'selected'; ?> value="DUPLICADO">DUPLICADO</option>
                            <option <?php if ($licencia_tipo == "SERVICIO PÚBLICO" ) echo 'selected'; ?> value="SERVICIO PÚBLICO">SERVICIO PÚBLICO</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Numero:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="licencia_num" name="licencia_num" maxlength="20" value=<?php echo '"'.$licencia_num.'"'?>>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Pasaporte:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="pasaporte" name="pasaporte" maxlength="15" value=<?php echo '"'.$pasaporte.'"'?> >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Correo que utiliza en sus redes sociales (Facebook, Twitter, Google+, etc):
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="email" class="form-control" id="correo_rs" name="correo_rs" maxlength="30" value=<?php echo '"'.$correo_rs.'"'?> >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 centrado-element">
                        En caso de accidente comunicarse con:
                    </label>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Nombre:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="contacto1" name="contacto1" maxlength="70" placeholder="Apellido Paterno - Apellido Materno - Nombre(s)" value=<?php echo '"'.$contacto1.'"'?> >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Teléfono:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="tel_con1" name="tel_con1" maxlength="13" value=<?php echo '"'.$tel_con1.'"'?> >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Nombre:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="contacto2" name="contacto2" maxlength="70" placeholder="Apellido Paterno - Apellido Materno - Nombre(s)" value=<?php echo '"'.$contacto2.'"'?> >
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                        Teléfono:
                    </label>
                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                        <input type="text" class="form-control" id="tel_con2" name="tel_con2" maxlength="13" value=<?php echo '"'.$tel_con2.'"'?> >
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
