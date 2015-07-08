<?php
function conectar()
{

	$con = mysqli_connect("localhost","root","admin","bd_proteccion_civil");

	// Check connection
	if (mysqli_connect_errno())
	  {
	  echo "Fallo al conectar con MySQL: " . mysqli_connect_error();
	  }

	 return $con;
}

function desconectar($conexion){mysqli_close($conexion);}

function ejecutarQuery($conexion, $query)
{

	$consulta = mysqli_query($conexion, $query);
	return $consulta; 
}

?>