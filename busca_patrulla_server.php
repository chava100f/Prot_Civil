<?php //codigo para AJAX en la busqueda de Patrullas

	$n_p = strip_tags($_REQUEST["n"]);

    require_once("funciones.php");
    $conexion = conectar();

    $query = "SELECT DISTINCT patrullas.nombre, IFNULL((SELECT datos_personales.nombre FROM datos_personales WHERE datos_personales.tipo_cuenta='JEFE' AND datos_personales.patrullas_id_patrullas = id_patrullas),'NA') AS nombreJefe, patrullas.clave, patrullas.id_patrullas FROM patrullas WHERE nombre LIKE '%".$n_p."%'";
    $consulta = ejecutarQuery($conexion, $query);
    $mensaje="";

	if (mysqli_num_rows($consulta)) {

		$mensaje='<div class="table-responsive">    
            <table class="table table-hover table-striped">
                <thead>
                    <th>Nombre</th>
                    <th>Jefe de Patrulla</th>
                    <th>Clave</th>
                    <th>Modificar Patrulla</th>
                </thead>
              	<tbody >';

	    while ($dat = mysqli_fetch_array($consulta)){
	        $nombre = $dat['nombre'];
	        $nombreJefe = $dat['nombreJefe'];
	        $clave = $dat['clave'];
	        $id_patrullas = $dat['id_patrullas'];

	        $mensaje.='<tr><td>'.$nombre.'</td><td>'.$nombreJefe.'</td><td>'.$clave.'</td>';;
	        $mensaje.= '<td><a href="modificar_patrulla.php?id='.$id_patrullas.'" class="btn btn-info">Modificar</td</tr>';
	    }

	    $mensaje.='</tbody>
                </table>';   
    }

    desconectar($conexion);

    // REspuesta de la base de datos, primero pregunta si la variable no tiene nada
    //si no envia la leyenda "patrulla no encontrada "
    //si si envia lo que se encuentre en la variable $mensaje la cual es una tabla
	echo $mensaje === "" ? "Patrulla no encontrada" : $mensaje;

?>