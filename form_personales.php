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
    //código para obtener los datos de la BD y mostrarlos ----------------------------------------------
    require("funciones_form_personales.php");

    require("funciones_menu_contextual.php"); 
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap-datepicker.min.css" >
    <link rel="stylesheet" href="css/index-estilo.css" >
    <link rel="stylesheet" href="css/forms-estilo.css" >
	<title>Actualización de Datos Personales Básicos</title>
    <script>
        
    </script>

</head>
<body>
	<!-- Menu contextual-->
    
    <?php echo obtener_menu()?>
    
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

        <h3>Datos Personales básicos</h3>

        <fieldset>
    	   <form action = "form_personales.php" method = "POST" class="form-horizontal" >

                    <div class="form-group">

                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Nombre(s):
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="nombres" name="nombres" maxlength="35" disabled value=<?php echo '"'.$nombres.'"'?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Apellido Paterno:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="apelldio_p" name="apellido_p" maxlength="35" disabled value=<?php echo '"'.$apellido_p.'"'?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Apellido Materno:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="apellido_m" name="apellido_m" maxlength="35" disabled value=<?php echo '"'.$apellido_m.'"'?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Fecha de nacimiento:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

                            <div class="input-group date">

                                <input type="text" class="form-control datepicker" id="fecha_nac" name="fecha_nac" pattern="\d{1,2}/\d{1,2}/\d{4}" placeholder="dd/mm/aaaa" value=<?php echo '"'.$fecha_nac.'"'?> />
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                </span>

                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 centrado-element">
                            <b>Dirección</b> <br>
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Calle o Avenida:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="dom_calle" name="dom_calle" maxlength="35" value=<?php echo '"'.$dom_calle.'"'?> > 
                        </div>
                    </div>

                    <div class="form-group">
                        <label  class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Num. Ext:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input  type="text" class="form-control" id="dom_num_ext" name="dom_num_ext" maxlength="10" value=<?php echo '"'.$dom_num_ext.'"'?> >
                        </div>
                    </div>
                    <div class="form-group">

                        <label  class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Num. Int:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input  type="text" class="form-control" id="dom_num_int" name="dom_num_int" maxlength="10" value=<?php echo '"'.$dom_num_int.'"'?> >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Colonia:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="dom_colonia" name="dom_colonia" maxlength="35" value=<?php echo '"'.$dom_colonia.'"'?> > 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Estado:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <select id="dom_estado" class="form-control" name="dom_estado" >

                                <?php //código para llenar el catálogo de los estados.
                                    echo obtener_opcion_e();
                                ?>

                            </select> 
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Delegación o Municipio:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <?php 
                            //Tentativa para manejar en un futuro con la BD 
                                /*<select name="dom_del_mun">
                                    <option value="m1">Municipio 1</option>
                                    ...
                                </select>*/
                            ?>
                            <input type="text" class="form-control" id="dom_del_mun" name="dom_del_mun" maxlength="60" value=<?php echo '"'.$dom_del_mun.'"'?> >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Código Postal:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="dom_cp" name="dom_cp" maxlength="5" value=<?php echo '"'.$dom_cp.'"'?> >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 centrado-element">
                            <b>Contacto</b> 
                        </label>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            <!-- TO DO Agregar codigo para la lada o el input type text-->
                            Tel. Casa:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">045</span>
                                <input type="text" class="form-control" id="telefono_casa" name="telefono_casa" maxlength="20" aria-describedby="basic-addon1" value=<?php echo '"'.$telefono_casa.'"'?>>
                            </div>
                        </div>
                    </div>



                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Tel. Celular:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">044</span>
                                <input type="text" class="form-control" id="telefono_celular" name="telefono_celular" maxlength="20" aria-describedby="basic-addon1" value=<?php echo '"'.$telefono_celular.'"'?>>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Tel. Trabajo:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="telefono_trabajo" name="telefono_trabajo" maxlength="20" value=<?php echo '"'.$telefono_trabajo.'"'?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                            Extensión del teléfono trabajo:
                        </label>
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                            <input type="text" class="form-control" id="telefono_extension" name="telefono_extension" maxlength="10" value=<?php echo '"'.$telefono_extension.'"'?>>
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
        <div class="col-xs-1 col-sm-2 col-md-2 col-lg-2"></div>

    </div>

    
        
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.es.js"></script>
    <script type="text/javascript"> 
        $(function(){ //script para dar formato al datepicker
            $('.input-group.date').datepicker({
                format: "dd/mm/yyyy", 
                startView: 2,         
                language: "es"   
            });
        });
    </script>
    <script type="text/javascript" src="fondo_encabezado.js" ></script>
</body>
</html>

<?php
}

?>
