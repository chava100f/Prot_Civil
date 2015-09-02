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

    $user=$_SESSION['logged_user'];

    require_once("funciones.php");
    $conexion = conectar();
    
    $query = 'SELECT id_num_reg FROM datos_personales WHERE email="'.$user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $id_user = $dat['id_num_reg'];
        }
    }

    $sexo = "";                 
    $estatura = "";
    $peso = "";
    $complexion ="";
    $cabello = "";
    $ojos = "";
    $cara = "";
    $nariz = "";
    $senias = "";

    $query = 'SELECT * FROM info_fisica WHERE datos_personales_id_num_reg="'.$id_user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $sexo = $dat['genero'];                      
            $estatura = $dat['estatura'];
            $peso = $dat['peso'];
            $complexion = $dat['complexion'];
            $cabello = $dat['cabello'];
            $ojos = $dat['ojos'];
            $cara = $dat['cara'];
            $nariz = $dat['nariz'];
            $senias = $dat['senias_particulares'];
        }
    }  

    desconectar($conexion);

    //--------------------------------------------------------------------------------------------

    if(isset($_POST['actualizar'])) //código para validar los datos del formulario
    {   

        $user=$_SESSION['logged_user'];
        // Actualizacion de datos complementarios

        require_once("funciones.php");
        $conexion = conectar();
        
        $query = 'SELECT id_num_reg FROM datos_personales WHERE email="'.$user.'"';
        $consulta = ejecutarQuery($conexion, $query);
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $id_user = $dat['id_num_reg'];
            }
        }

        //Recoleccion de datos...

        $sexo = mysqli_real_escape_string($conexion, strip_tags($_POST['sexo']));
        $estatura = mysqli_real_escape_string($conexion, strip_tags($_POST['estatura']));
        $peso = mysqli_real_escape_string($conexion, strip_tags($_POST['peso']));
        $complexion = mysqli_real_escape_string($conexion, strip_tags($_POST['complexion']));
        $cabello = mysqli_real_escape_string($conexion, strip_tags($_POST['cabello']));
        $ojos = mysqli_real_escape_string($conexion, strip_tags($_POST['ojos']));
        $cara = mysqli_real_escape_string($conexion, strip_tags($_POST['cara']));
        $nariz = mysqli_real_escape_string($conexion, strip_tags($_POST['nariz']));
        $senias = mysqli_real_escape_string($conexion, strip_tags($_POST['senias']));

        //TO DO Elaboración del Query (tratar de pasar esto a un Store procedure)!!!
        //Actualización de los datos en la tabla info_fisica

        $contador = 0; //variable para revisar si ya esta registrado el usuario, si sí se actualizan los datos, si no se inserta un nuevo registro en la BD

        $query = 'SELECT * FROM info_fisica WHERE datos_personales_id_num_reg="'.$id_user.'"';
        $consulta = ejecutarQuery($conexion, $query);
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $contador = 1;
            }
        }

        if($contador === 0) //se inserta un nuevo registro en la BD
        {
            //Inserta nuevo registro en la tabla info_fisica
            $query = 'INSERT INTO info_fisica(genero, estatura, peso, complexion, cabello, ojos, cara, nariz, senias_particulares, datos_personales_id_num_reg)';
            $query = $query.' VALUES ("'.$sexo.'", '.$estatura.', '.$peso.', "'.$complexion.'", "'.$cabello.'", "'.$ojos.'", "'.$cara.'", "'.$nariz.'", "'.$senias.'", '.$id_user.')';
        }
        else //se actualizan los datos que ya existian en la BD
        {
            //Actualiza la tabla info_fisica
            $query = 'UPDATE info_fisica SET genero="'.$sexo.'", estatura="'.$estatura.'", peso="'.$peso.'", complexion="'.$complexion.'", cabello="'.$cabello.'", ';
            $query.= 'ojos="'.$ojos.'", cara="'.$cara.'", nariz="'.$nariz.'", senias_particulares="'.$senias.'" ';
            $query .= 'WHERE datos_personales_id_num_reg = "'.$id_user.'"';  
        }

        $consulta = ejecutarQuery($conexion, $query);
        desconectar($conexion);
        
        header("Location: index_usuario.php");
        exit();
               
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
	<title>Actualización de Información Física</title>
    <script>
        
    </script>

</head>
<body>
	   <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <p class="navbar-brand">Información física</p>
        </div>
        <div id="navbar" class="navbar-collapse collapse" aria-expanded="false" style="height: 1px;">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="index_usuario.php">Inicio</a></li>
            <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                Modificar Datos <span class="caret"></span>
                </a>
                <ul class="dropdown-menu inverse-dropdown" >
                    <li><a href="form_personales.php">Información Personal Básica</a></li>
                    <li><a href="form_complementario.php">Información Complementaria</a></li>
                    <li><a href="form_medico.php">Información Medica</a></li>
                    <li><a href="form_info_fisica.php">Información Fisica</a></li>
                    <li><a href="form_experiencia.php">Información de Experiencia en Patrullaje y Rescate</a></li>
                </ul>
            </li>
            <li><a href="#">Cambiar contraseña</a></li>
            <li><a href="cerrar_sesion.php">Cerrar sesión</a></li>
          </ul>
        </div>
      </div>
    </nav>
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
                            <option <?php if ($sexo == "hombre" ) echo 'selected'; ?> value="hombre" >HOMBRE</option>
                            <option <?php if ($sexo == "mujer" ) echo 'selected'; ?> value="mujer">MUJER</option>
                            <option <?php if ($sexo == "otro" ) echo 'selected'; ?> value="otro">OTRO</option>
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

            <small>Última modificación Agosto 2015</small>

        </footer>

        </div>
        <div class="col-xs-1 col-sm-2 col-md-2 col-lg-2"></div>

    </div>




    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript"> //función para hacer dinamigo el fondo 
     $(function(){
    
            var limit = 0; // 0 = infinite.
            var interval = 2;// Secs
            var images = [
                "imagenes/Fondos/1.jpg",
                "imagenes/Fondos/2.jpg",
                "imagenes/Fondos/3.jpg"
            ];

            var inde = 0; 
            var limitCount = 0;
            var myInterval = setInterval(function() {
               if (limit && limitCount >= limit-1) clearTimeout(myInterval);
               if (inde >= images.length) inde = 0;
                $('header').css({ "background-image":"url(" + images[inde]+ ")" });
               inde++;
               limitCount++;
            }, interval*5000);
        });    

    </script>
</body>
</html>

<?php
}

?>
