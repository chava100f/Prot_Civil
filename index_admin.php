<?php
//Codigo para revisar si la sesion a sido iniciada
session_start();
$basename = substr(strtolower(basename($_SERVER['PHP_SELF'])),0,strlen(basename($_SERVER['PHP_SELF']))-4);

if((empty($_SESSION['logged'])) && ($basename!="index"))
{
    header('Location: index.php');
    exit();
}//Si a inicado sesion entra en el "else"
else
{   

    $tipo_cuenta=$_SESSION['user_type'];

    if($tipo_cuenta=="USUARIO")
    {
        header("Location: index_usuario.php");
        exit();
    }
    
    if($tipo_cuenta=="JEFE")
    {
        header("Location: index_jefe_patrulla.php");
        exit();
    }

    require("funciones_menu_contextual.php"); 

	function obtener_patrullas() //código para llenar la tabla de las patrullas actuales en la BD.
    {

        require_once("funciones.php");
        $conexion = conectar();

        $query = 'SELECT DISTINCT patrullas.nombre, IFNULL((SELECT datos_personales.nombre FROM datos_personales WHERE datos_personales.tipo_cuenta="JEFE" AND datos_personales.patrullas_id_patrullas = id_patrullas),"NA") AS nombreJefe, patrullas.clave, patrullas.id_patrullas FROM patrullas;';
        $consulta = ejecutarQuery($conexion, $query);
        $opciones_e="";

        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $np = $dat['nombre'];
                $nj = $dat['nombreJefe'];
                $c = $dat['clave'];
                $id_patrullas = $dat['id_patrullas'];
                //Agregar codigo para mandar a modificar la patrulla seleccionada
                $opciones_e = $opciones_e.'<tr><td>'.$np.'</td><td>'.$nj.'</td><td>'.$c.'</td>';
                $opciones_e.='<td><a href="modificar_patrulla.php?id='.$id_patrullas.'" class="btn btn-info">Modificar</td</tr>';
            }
        }

        desconectar($conexion);

        return $opciones_e;
    }

    function obtener_usuarios() //código para llenar la tabla de los usuarios actuales en la BD.
    {

        require_once("funciones.php");
        $conexion = conectar();
        $query = 'SELECT datos_personales.id_num_reg, datos_personales.nombre, datos_personales.apellido_p, datos_personales.apellido_m, datos_personales.fotografia, patrullas.nombre AS patrulla, calidad_miembro, tipo_cuenta FROM datos_personales, patrullas WHERE datos_personales.patrullas_id_patrullas=patrullas.id_patrullas;';
        $consulta = ejecutarQuery($conexion, $query);
        $usuarios_tabla="";

        if (mysqli_num_rows($consulta)) {
            while ($dat = mysqli_fetch_array($consulta)){
                $id_num_reg = $dat['id_num_reg'];
                $nombre = $dat['nombre'];
                $apellido_p = $dat['apellido_p'];
                $apellido_m = $dat['apellido_m'];
                $fotografia = $dat['fotografia'];
                $patrullas_id_patrullas = $dat['patrulla'];
                $calidad_miembro = $dat['calidad_miembro'];
                $tipo_cuenta = $dat['tipo_cuenta'];

                //Agregar codigo para mandar a modificar la patrulla seleccionada
                $usuarios_tabla.='<tr><td><img src="'.$fotografia.'" style="width:50px;height:50px;" /></td>';
                $usuarios_tabla.='<td>'.$nombre." ".$apellido_p." ".$apellido_m.'</td>';
                $usuarios_tabla.='<td>'.$patrullas_id_patrullas.'</td>';
                $usuarios_tabla.='<td>'.strtoupper($calidad_miembro).'</td>';
                $usuarios_tabla.='<td>'.strtoupper($tipo_cuenta).'</td>';
                $usuarios_tabla.='<td><a href="modificar_usuario.php?id='.$id_num_reg.'" class="btn btn-info">Modificar</td</tr>';
            }
        }

        desconectar($conexion);

        return $usuarios_tabla;
    }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset = "utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index-estilo.css" >
	<title>Administracion</title>
</head>
<body>
    <!-- Menu contextual-->
    
    <?php echo obtener_menu();?>

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

    <div class="container" id="general-form">

        <div class="col-xs-0 col-md-1"></div>

        <div class="col-xs-12 col-md-10">

            <section class="row"> 
                <br>
                    <div class="col-xs-12 col-sm-12">
                        <h2>Patrullas</h2>
                    </div>

                    <div class="col-xs-12 col-sm-12">   
                        <div class="table-responsive">    
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>Nombre</th>
                                    <th>Jefe de Patrulla</th>
                                    <th>Clave</th>
                                    <th>Modificar Patrulla</th>
                                </thead>
                                <tbody>
                                    <?php echo obtener_patrullas(); ?>
                                </tbody>
                            </table>
                        </div>     
                    </div> 
                <br>
            </section>

            <section class="row"> 

                <div class="col-xs-12 col-sm-12">
                    <h2>Usuarios</h2>
                </div>

                <div class="col-xs-12 col-sm-12"> 
                    <div class="table-responsive">     
                        <table class="table table-hover table-striped">
                            <thead>
                                <th>Foto</th>
                                <th>Nombre</th>
                                <th>Patrulla</th>
                                <th>Estatus</th>
                                <th>Tipo de cuenta</th>
                                <th>Modificar Usuario</th>
                            </thead>
                                <?php echo obtener_usuarios(); ?>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div> 

            </section>
            
            <footer class="footer">
                
                    <small>Última modificación Agosto 2015</small>
                
            </footer>

        </div>

        <div class="col-xs-0 col-md-1"></div>

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="fondo_encabezado.js" ></script>
</body>

</html>


<?php
}

?>
