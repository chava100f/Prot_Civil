<?php //codigo para AJAX en la busqueda de Patrullas

	$usuario_b = strip_tags($_REQUEST["n"]);

    require_once("funciones.php");
    $conexion = conectar();

    $query = "SELECT datos_personales.id_num_reg, datos_personales.nombre, datos_personales.apellido_p, datos_personales.apellido_m, datos_personales.fotografia, patrullas.nombre AS patrulla, datos_personales.calidad_miembro, datos_personales.tipo_cuenta FROM datos_personales, patrullas WHERE datos_personales.nombre LIKE '%".$usuario_b."%' OR datos_personales.apellido_p LIKE '%".$usuario_b."%' OR datos_personales.apellido_m LIKE '%".$usuario_b."%'";
    $consulta = ejecutarQuery($conexion, $query);
    $mensaje="";

	if (mysqli_num_rows($consulta)) 
    {

		$mensaje='<div class="table-responsive">    
            <table class="table table-hover table-striped">
                <thead>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Patrulla</th>
                    <th>Estatus</th>
                    <th>Tipo de cuenta</th>
                    <th>Modificar Usuario</th>
                </thead>
              	<tbody >';

	    while ($dat = mysqli_fetch_array($consulta)){
	        $nombre = $dat['nombre'];
	        $apellido_p = $dat['apellido_p'];
	        $apellido_m = $dat['apellido_m'];
	        $id_num_reg = $dat['id_num_reg'];
            $fotografia = $dat['fotografia'];
            $patrulla = $dat['patrulla'];
            $calidad_miembro = $dat['calidad_miembro'];
            $tipo_cuenta = $dat['tipo_cuenta'];

            $mensaje.='<tr><td><img src="'.$fotografia.'" style="width:50px;height:50px;" /></td>';
            $mensaje.='<td>'.$nombre." ".$apellido_p." ".$apellido_m.'</td>';
            $mensaje.='<td>'.$patrulla.'</td>';
            $mensaje.='<td>'.strtoupper($calidad_miembro).'</td>';
            $mensaje.='<td>'.strtoupper($tipo_cuenta).'</td>';
            $mensaje.='<td><a href="modificar_usuario.php?id='.$id_num_reg.'" class="btn btn-info">Modificar</td</tr>';
	    }

	    $mensaje.='</tbody>
                </table>';   
    }

    desconectar($conexion);

    // REspuesta de la base de datos, primero pregunta si la variable no tiene nada
    //si no envia la leyenda "patrulla no encontrada "
    //si si envia lo que se encuentre en la variable $mensaje la cual es una tabla
	echo $mensaje === "" ? "Usuario no encontrado" : $mensaje;

?>