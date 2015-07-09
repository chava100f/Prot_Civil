<?php //codigo para AJAX en Registro de usuarios

	$patrulla = strip_tags($_REQUEST["p"]);

    require_once("funciones.php");
    $conexion = conectar();

    $query = 'SELECT id_patrullas, nombre, clave FROM patrullas WHERE clave="'.$patrulla.'"';
    $consulta = ejecutarQuery($conexion, $query);
    $mensaje="";

	if (mysqli_num_rows($consulta)) {
	    while ($dat = mysqli_fetch_array($consulta)){
	        $id = $dat['id_patrullas'];
	        $nombre = $dat['nombre'];
	        $clave = $dat['clave'];

	        $mensaje = $id."-".$nombre;
	    }
    }

    desconectar($conexion);

    
    // Salida si no encuentra nada en la  BD
	echo $mensaje === "" ? "No se encontro Patrulla ingresada" : $mensaje;

?>