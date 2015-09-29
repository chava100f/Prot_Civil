<?php //codigo para AJAX en Registro de usuarios

	$clave = strip_tags($_REQUEST["c"]);

    require_once("funciones.php");
    $conexion = conectar();

    $query = 'SELECT id_patrullas, nombre FROM patrullas WHERE clave="'.$clave.'"';
    $consulta = ejecutarQuery($conexion, $query);
    $mensaje="";

	if (mysqli_num_rows($consulta)) {
	    while ($dat = mysqli_fetch_array($consulta)){
	        $id_patrullas = $dat['id_patrullas'];
	        $nombre = $dat['nombre'];

	        $mensaje = $id_patrullas."-".$nombre;
	    }
    }

    desconectar($conexion);

    
    // Salida si no encuentra nada en la  BD
	echo $mensaje === "" ? "Patrulla inexistente" : $mensaje;

?>