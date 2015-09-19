<?php

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

            $inyeccion_datos = $inyeccion_datos.'<label class="col-xs-9 col-sm-8 col-md-4">'.$vacunas_en_web[$i].'</label><div class="col-xs-3 col-sm-4 col-md-2">';

            if($aux!="") //código acgregado para poner "cheked" en los checkbox que estan en la BD
            {
                $inyeccion_datos.= '<input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="'.$vacunas_en_web[$i].'" class="form-control input-group-lg" checked></div>';
                $aux="";
            }
            else
            {
                $inyeccion_datos.= '<input type="checkbox" id="vacuna_local[]" name="vacuna_local[]" value="'.$vacunas_en_web[$i].'" class="form-control input-group-lg"></div>';
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