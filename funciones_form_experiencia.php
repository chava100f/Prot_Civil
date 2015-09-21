<?php

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
    $fecha_i="";
    $nom_dir = "";

    $query = 'SELECT * FROM antecedentes WHERE datos_personales_id_num_reg="'.$id_user.'"';
    $consulta = ejecutarQuery($conexion, $query);
    if (mysqli_num_rows($consulta)) {
        while ($dat = mysqli_fetch_array($consulta)){
            $cargos = $dat['cargos_anteriores'];                      
            $patrullero = $dat['patrullero'];
            $fecha_g = $dat['fecha_graduacion'];
            $fecha_i = $dat['fecha_ingreso'];
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
        $fecha_i = mysqli_real_escape_string($conexion, strip_tags($_POST['fecha_i']));
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
            $query = 'INSERT INTO antecedentes(cargos_anteriores, patrullero, fecha_graduacion, fecha_ingreso, dir_ccpp, datos_personales_id_num_reg)';
            $query = $query.' VALUES("'.$cargos.'","'.$patrullero.'", "'.$fecha_g.'", "'.$fecha_i.'", "'.$nom_dir.'",'.$id_user.')';
        }
        else //se actualizan los datos que ya existian en la BD
        {
            //Actualiza la tabla antecedentes
            $query = 'UPDATE antecedentes SET cargos_anteriores="'.$cargos.'", patrullero="'.$patrullero.'", fecha_graduacion="'.$fecha_g.'", fecha_ingreso="'.$fecha_i.'", dir_ccpp="'.$nom_dir.'" ';
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
        if($experiencia_otra!="")
        {
            $query='INSERT INTO experiencia(experiencia, datos_personales_id_num_reg) VALUES("'.$experiencia_otra.'",'.$id_user.');';
            $consulta = ejecutarQuery($conexion, $query);
        }

        desconectar($conexion);
        
        header("Location: index_usuario.php");
        exit();
    }
?>