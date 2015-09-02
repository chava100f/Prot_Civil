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
    function insertar_experiencia_web() //código para poner los checkbox en la página
    {
        $experiencia_en_web = array("MEDIA MONTAÑA","ALTA MONTAÑA","ESPELEISMO","ESCALADA EN ROCA","BUCEO","PARACAIDISMO","PRIMEROS AUXILIOS","PRIMER RESPONDIENTE","TUM (URBANO)","TUM (MONTAÑA)","ENFERMERO","PARAMÉDICO","MÉDICO","RADIO EXPERIMENTADOR");
        $limite = count($experiencia_en_web);
        $inyeccion_datos="";

        $user=$_SESSION['logged_user'];

        require_once("funciones.php");
        $conexion = conectar();
        
        $query = 'SELECT id_num_reg FROM datos_personales WHERE email="'.$user.'"'; //código agregado para saber cuales son los checkbox seleccionados anteriormente...
        $consulta = ejecutarQuery($conexion, $query);
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $id_user = $dat['id_num_reg'];
            }
        }

        $experiencia = array();

        $query = 'SELECT * FROM experiencia WHERE datos_personales_id_num_reg="'.$id_user.'"';
        $consulta = ejecutarQuery($conexion, $query);
        $limite2 = 0;
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $experiencia[$limite2] = $dat['experiencia']; 
                $limite2++;
            }
        }     

        desconectar($conexion);

        $limite2 = count($experiencia);
        $aux ="";

        for($i=0;$i<$limite;$i++) //ciclo para escribir el codigo de inserción en el formulario
        {
            for($j=0;$j<$limite2;$j++) //ciclo para comparar si los valores del arreglo que tiene los datos de la BD son iguales con los datos de todas las experiencia que aparecen en el formulario
            {
                if($experiencia[$j]===$experiencia_en_web[$i])
                {
                    $aux = $experiencia[$j];
                }
            }

            $inyeccion_datos = $inyeccion_datos.'<label class="col-xs-10 col-sm-8 col-md-4">'.$experiencia_en_web[$i].'</label><div class="col-xs-2 col-sm-4 col-md-2">';

            if($aux!="") //código acgregado para poner "cheked" en los checkbox que estan en la BD
            {
                $inyeccion_datos.= '<input type="checkbox" id="experiencia[]" name="experiencia[]" value="'.$experiencia_en_web[$i].'" class="form-control" checked></div>';
                $aux="";
            }
            else
            {
                $inyeccion_datos.= '<input type="checkbox" id="experiencia[]" name="experiencia[]" value="'.$experiencia_en_web[$i].'" class="form-control"></div>';
            }
        }

        return $inyeccion_datos;
    }

    function insertar_experiencia_otra_web() //código extra para conocer las experiencia internacionales basado en la teroria de la diferencia de conjuntos A-B
    {
        $experiencia_en_web = array("MEDIA MONTAÑA","ALTA MONTAÑA","ESPELEISMO","ESCALADA EN ROCA","BUCEO","PARACAIDISMO","PRIMEROS AUXILIOS","PRIMER RESPONDIENTE","TUM (URBANO)","TUM (MONTAÑA)","ENFERMERO","PARAMÉDICO","MÉDICO","RADIO EXPERIMENTADOR");
        
        $user=$_SESSION['logged_user'];

        require_once("funciones.php");
        $conexion = conectar();
        
        $query = 'SELECT id_num_reg FROM datos_personales WHERE email="'.$user.'"'; //código agregado para saber cuales son los checkbox seleccionados anteriormente...
        $consulta = ejecutarQuery($conexion, $query);
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $id_user = $dat['id_num_reg'];
            }
        }

        $experiencia = array();

        $query = 'SELECT * FROM experiencia WHERE datos_personales_id_num_reg="'.$id_user.'"';
        $consulta = ejecutarQuery($conexion, $query);
        $limite2 = 0;
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $experiencia[$limite2] = $dat['experiencia']; 
                $limite2++;
            }
        }     

        desconectar($conexion);

        $aux = implode("",array_diff($experiencia, $experiencia_en_web)); //código que hace la diferencia y convierte el resultado a String.

        return $aux;

    }
    //--------------------------------------------------------------------------------------------------------

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

    $cargos = "";                 
    $patrullero = "";
    $fecha_g ="";
    $nom_dir = "";

    $query = 'SELECT * FROM antecedentes WHERE datos_personales_id_num_reg="'.$id_user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $cargos = $dat['cargos_anteriores'];                      
            $patrullero = $dat['patrullero'];
            $fecha_g = $dat['fecha_graduacion'];
            $nom_dir = $dat['dir_ccpp'];
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

        $cargos = mysqli_real_escape_string($conexion, strip_tags($_POST['cargos']));
        $patrullero = mysqli_real_escape_string($conexion, strip_tags($_POST['patrullero']));
        $fecha_g = mysqli_real_escape_string($conexion, strip_tags($_POST['fecha_g']));
        $experiencia =$_POST['experiencia'];
        $experiencia_otra = mysqli_real_escape_string($conexion, strip_tags($_POST['experiencia_otra']));
        $nom_dir = mysqli_real_escape_string($conexion, strip_tags($_POST['nom_dir']));

        //TO DO Elaboración del Query (tratar de pasar esto a un Store procedure)!!!
        //Actualización de los datos en la tabla info_medica

        $contador = 0; //variable para revisar si ya esta registrado el usuario, si sí se actualizan los datos, si no se inserta un nuevo registro en la BD

        $query = 'SELECT * FROM antecedentes WHERE datos_personales_id_num_reg="'.$id_user.'"';
        $consulta = ejecutarQuery($conexion, $query);
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $contador = 1;
            }
        }

        if($contador === 0) //se inserta un nuevo registro en la BD
        {
            //Inserta nuevo registro en la tabla antecedentes
            $query = 'INSERT INTO antecedentes(cargos_anteriores, patrullero, fecha_graduacion, dir_ccpp, datos_personales_id_num_reg)';
            $query = $query.' VALUES("'.$cargos.'","'.$patrullero.'", "'.$fecha_g.'", "'.$nom_dir.'",'.$id_user.')';
        }
        else //se actualizan los datos que ya existian en la BD
        {
            //Actualiza la tabla antecedentes
            $query = 'UPDATE antecedentes SET cargos_anteriores="'.$cargos.'", patrullero="'.$patrullero.'", fecha_graduacion="'.$fecha_g.'", dir_ccpp="'.$nom_dir.'" ';
            $query .= 'WHERE datos_personales_id_num_reg = "'.$id_user.'"';  
        }

        $consulta = ejecutarQuery($conexion, $query);
        
        //Cuenta los datos de los checkbox para insertarlos en la tabla experiencia
        $count = count($experiencia);

        //Borra los registros que existan con el id asociado para poder insertar la actualización y no tener problemas para actualizar la tabla 
        if($count>=0)
        {           
            $query='DELETE FROM experiencia WHERE datos_personales_id_num_reg='.$id_user.';';
            $consulta = ejecutarQuery($conexion, $query);
        }
            
        //Inserta los datos de los checkbox en la tabla experiencia
        for ($i = 0; $i < $count; $i++)
        {
            $query='INSERT INTO experiencia(experiencia, datos_personales_id_num_reg) VALUES("'.$experiencia[$i].'",'.$id_user.');';
            $consulta = ejecutarQuery($conexion, $query);
        }
        //Revisa si la variable experiencia internacionales tiene algo escrito, si sí lo inserta en la base de datos
        if($vacuna_internacional!="")
        {
            $query='INSERT INTO experiencia(experiencia, datos_personales_id_num_reg) VALUES("'.$experiencia_otra.'",'.$id_user.');';
            $consulta = ejecutarQuery($conexion, $query);
        }

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
    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css" >
	<title>Actualización de Experiencia</title>
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
          <p class="navbar-brand">Experiencia</p>
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
