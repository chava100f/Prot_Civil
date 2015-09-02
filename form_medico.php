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
    function insertar_vacunas_web() //código para poner los checkbox en la página
    {
        $vacunas_en_web = array("BCG","HEPATITIS B","PENTAVALENTE ACELULAR","NEUMOCOCO","ROTAVIRUS","SRP","SR","Td","DPT","Tdpa","VPH","INFLUENCA INACTIVADA","POLIOMIELITIS TIPO SABIN","VARICELA","HEPATITIS A");
        $limite = count($vacunas_en_web);
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

        $vacunas = array();

        $query = 'SELECT * FROM vacunas WHERE datos_personales_id_num_reg="'.$id_user.'"';
        $consulta = ejecutarQuery($conexion, $query);
        $limite2 = 0;
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $vacunas[$limite2] = $dat['vacunas']; 
                $limite2++;
            }
        }     

        desconectar($conexion);

        $limite2 = count($vacunas);
        $aux ="";

        for($i=0;$i<$limite;$i++) //ciclo para escribir el codigo de inserción en el formulario
        {
            for($j=0;$j<$limite2;$j++) //ciclo para comparar si los valores del arreglo que tiene los datos de la BD son iguales con los datos de todas las vacunas que aparecen en el formulario
            {
                if($vacunas[$j]===$vacunas_en_web[$i])
                {
                    $aux = $vacunas[$j];
                }
            }

            $inyeccion_datos = $inyeccion_datos.'<label class="col-xs-10 col-sm-8 col-md-4">'.$vacunas_en_web[$i].'</label><div class="col-xs-2 col-sm-4 col-md-2">';

            if($aux!="") //código acgregado para poner "cheked" en los checkbox que estan en la BD
            {
                $inyeccion_datos.= '<input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="'.$vacunas_en_web[$i].'" class="form-control" checked></div>';
                $aux="";
            }
            else
            {
                $inyeccion_datos.= '<input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="'.$vacunas_en_web[$i].'" class="form-control"></div>';
            }
        }

        return $inyeccion_datos;
    }

    function insertar_vacunas_internacionales_web() //código extra para conocer las vacunas internacionales basado en la teroria de la diferencia de conjuntos A-B
    {
        $vacunas_en_web = array("BCG","HEPATITIS B","PENTAVALENTE ACELULAR","NEUMOCOCO","ROTAVIRUS","SRP","SR","Td","DPT","Tdpa","VPH","INFLUENCA INACTIVADA","POLIOMIELITIS TIPO SABIN","VARICELA","HEPATITIS A");
        
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

        $vacunas = array();

        $query = 'SELECT * FROM vacunas WHERE datos_personales_id_num_reg="'.$id_user.'"';
        $consulta = ejecutarQuery($conexion, $query);
        $limite2 = 0;
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $vacunas[$limite2] = $dat['vacunas']; 
                $limite2++;
            }
        }     

        desconectar($conexion);

        $aux = implode("",array_diff($vacunas, $vacunas_en_web)); //código que hace la diferencia y convierte el resultado a String.

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

    $sangre = "";                 
    $padecimientos_limitfisicas = "";
    $alergias ="";
    $servicio_medico = "";

    $query = 'SELECT * FROM info_medica WHERE datos_personales_id_num_reg="'.$id_user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $sangre = $dat['tipo_sangre'];                      
            $padecimientos_limitfisicas = $dat['padecimientos_limitfisicas'];
            $alergias = $dat['alergias'];
            $servicio_medico = $dat['servicio_medico'];
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

        $sangre = mysqli_real_escape_string($conexion, strip_tags($_POST['sangre']));
        $vacuna_local =$_POST['vacuna_local'];
        $vacuna_internacional = mysqli_real_escape_string($conexion, strip_tags($_POST['vacuna_internacional']));
        $padecimientos_limitfisicas = mysqli_real_escape_string($conexion, strip_tags($_POST['padecimientos_limitfisicas']));
        $alergias = mysqli_real_escape_string($conexion, strip_tags($_POST['alergias']));
        $servicio_medico = mysqli_real_escape_string($conexion, strip_tags($_POST['servicio_medico']));

        //TO DO Elaboración del Query (tratar de pasar esto a un Store procedure)!!!
        //Actualización de los datos en la tabla info_medica

        $contador = 0; //variable para revisar si ya esta registrado el usuario, si sí se actualizan los datos, si no se inserta un nuevo registro en la BD

        $query = 'SELECT * FROM info_medica WHERE datos_personales_id_num_reg="'.$id_user.'"';
        $consulta = ejecutarQuery($conexion, $query);
        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $contador = 1;
            }
        }

        if($contador === 0) //se inserta un nuevo registro en la BD
        {
            //Inserta nuevo registro en la tabla info_medica
            $query = 'INSERT INTO info_medica(tipo_sangre, padecimientos_limitfisicas, alergias, servicio_medico, datos_personales_id_num_reg)';
            $query = $query.' VALUES("'.$sangre.'","'.$padecimientos_limitfisicas.'", "'.$alergias.'", "'.$servicio_medico.'",'.$id_user.')';
        }
        else //se actualizan los datos que ya existian en la BD
        {
            //Actualiza la tabla info_medica
            $query = 'UPDATE info_medica SET tipo_sangre="'.$sangre.'", padecimientos_limitfisicas="'.$padecimientos_limitfisicas.'", alergias="'.$alergias.'", servicio_medico="'.$servicio_medico.'" ';
            $query .= 'WHERE datos_personales_id_num_reg = "'.$id_user.'"';  
        }

        $consulta = ejecutarQuery($conexion, $query);
        
        //Cuenta los datos de los checkbox para insertarlos en la tabla vacunas
        $count = count($vacuna_local);

        //Borra los registros que existan con el id asociado para poder insertar la actualización y no tener problemas para actualizar la tabla 
        if($count>=0)
        {           
            $query='DELETE FROM vacunas WHERE datos_personales_id_num_reg='.$id_user.';';
            $consulta = ejecutarQuery($conexion, $query);
        }
            
        //Inserta los datos de los checkbox en la tabla vacunas
        for ($i = 0; $i < $count; $i++)
        {
            $query='INSERT INTO vacunas(vacunas, datos_personales_id_num_reg) VALUES("'.$vacuna_local[$i].'",'.$id_user.');';
            $consulta = ejecutarQuery($conexion, $query);
        }
        //Revisa si la variable vacunas internacionales tiene algo escrito, si sí lo inserta en la base de datos
        if($vacuna_internacional!="")
        {
            $query='INSERT INTO vacunas(vacunas, datos_personales_id_num_reg) VALUES("'.$vacuna_internacional.'",'.$id_user.');';
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
	<title>Actualización de Información Médica</title>
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
          <p class="navbar-brand">Información médica</p>
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

        <div class="col-xs-1 col-sm-2 col-md-1 col-lg-2"></div>

        <div class="col-xs-10 col-sm-8 col-md-10 col-lg-8">

        <h3>Información Médica</h3>

        <fieldset>
           <form action = "form_medico.php" method = "POST" class="form-horizontal" >

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Tipo de Sangre:
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <select class="form-control"  name="sangre" id="sangre">
                        <option <?php if ($sangre == "A+" ) echo 'selected'; ?> value="A+">A+</option>                                
                        <option <?php if ($sangre == "A-" ) echo 'selected'; ?> value="A-">A-</option>
                        <option <?php if ($sangre == "B+" ) echo 'selected'; ?> value="B+">B+</option>
                        <option <?php if ($sangre == "B-" ) echo 'selected'; ?> value="B-">B-</option>
                        <option <?php if ($sangre == "AB+" ) echo 'selected'; ?> value="AB+">AB+</option>
                        <option <?php if ($sangre == "AB-" ) echo 'selected'; ?> value="AB-">AB-</option>
                        <option <?php if ($sangre == "O+" ) echo 'selected'; ?> value="O+">O+</option>
                        <option <?php if ($sangre == "O-" ) echo 'selected'; ?> value="O-">O-</option>                               
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12">
                    Vacunas Locales:
                </label>
            </div>

            <div class="form-group">
                <?php echo insertar_vacunas_web();//-------------------------------------------------------------------------------------------------------------- ?> 
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Vacunas Internacionales:
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <textarea class="form-control" id="vacuna_internacional" name="vacuna_internacional" maxlength="180" placeholder="Describir aquí"><?php echo insertar_vacunas_internacionales_web(); ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Padecimientos o Limitaciones físicas:
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <textarea class="form-control" id="padecimientos_limitfisicas" name="padecimientos_limitfisicas" maxlength="180" placeholder="Describir aquí"><?php echo $padecimientos_limitfisicas;?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Alergias:
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <textarea class="form-control" id="alergias" name="alergias" maxlength="180" placeholder="Describir aquí"><?php echo $alergias;?></textarea>
                </div>
            </div>
              
                
            <div class="form-group">
                <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                    Servicio Médico:
                </label>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <select class="form-control" name="servicio_medico" id="servicio_medico">
                        <option <?php if ($servicio_medico == "IMSS" ) echo 'selected'; ?> value="IMSS">IMSS</option>
                        <option <?php if ($servicio_medico == "ISSSTE" ) echo 'selected'; ?> value="ISSSTE">ISSSTE</option>
                        <option <?php if ($servicio_medico == "PEMEX" ) echo 'selected'; ?> value="PEMEX">PEMEX</option>
                        <option <?php if ($servicio_medico == "SEGURO POPULAR" ) echo 'selected'; ?> value="SEGURO POPULAR">SEGURO POPULAR</option>
                        <option <?php if ($servicio_medico == "PARTICULAR" ) echo 'selected'; ?> value="PARTICULAR">PARTICULAR</option>
                    </select>
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
