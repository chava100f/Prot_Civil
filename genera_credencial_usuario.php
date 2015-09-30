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
	$id_usuario_credencial = $_GET['id']; //lo obtiene por URL en el link de la tabla

  require_once("funciones.php");
  require_once("dompdf/dompdf_config.inc.php");

  $conexion = conectar();

  $color_celda="<td bgcolor='#224FB0' style='color:white;'>";
  $color_celda_titulo="<td bgcolor='#224FB0' colspan='6' align='center' style='color:white;'>";
  $color_celda_esp1="<td bgcolor='#224FB0' colspan='3' style='color:white;'>";

  //Setting the variables

  $nombre = "";
  $apellido_p = "";
  $apellido_m = "";
  $dom_calle = "";
  $dom_num_ext = "";
  $dom_num_int = "";
  $dom_col = "";
  $dom_del_mun = "";
  $id_dom_estado = "";
  $dom_cp = "";
  $telefono_casa = "";
  $telefono_celular = "";
  $telefono_trabajo = "";
  $telefono_extension = "";
  $fotografia = "";
  $contacto1 = "";
  $contacto2 = "";
  $telefono_c1 = "";
  $telefono_c2 = "";
  $id_patrullas = "";
  $nombre_patrulla = "";
  $dom_estado = "";
  $tipo_sangre = "";
  $alergias = "";
  $servicio_medico = "";


  $query = 'SELECT * FROM datos_personales WHERE id_num_reg="'.$id_usuario_credencial.'"';
  $consulta = ejecutarQuery($conexion, $query);
  if (mysqli_num_rows($consulta)) {
      while ($dat = mysqli_fetch_array($consulta)){
          $nombre = $dat['nombre'];
          $apellido_p = $dat['apellido_p'];
          $apellido_m = $dat['apellido_m'];
          $dom_calle = $dat['dom_calle'];
          $dom_num_ext = $dat['dom_num_ext'];
          $dom_num_int = $dat['dom_num_int'];
          $dom_col = $dat['dom_col'];
          $dom_del_mun = $dat['dom_del_mun'];
          $id_dom_estado = $dat['dom_estado'];
          $dom_cp = $dat['dom_cp'];
          $telefono_casa = $dat['telefono_casa'];
          $telefono_celular = $dat['telefono_celular'];
          $telefono_trabajo = $dat['telefono_trabajo'];
          $telefono_extension = $dat['telefono_extension'];
          $fotografia = $dat['fotografia'];
          $contacto1 = $dat['contacto1'];
          $contacto2 = $dat['contacto2'];
          $telefono_c1 = $dat['telefono_c1'];
          $telefono_c2 = $dat['telefono_c2'];
          $id_patrullas = $dat['patrullas_id_patrullas'];
      }
  }

  $query = 'SELECT nombre FROM patrullas WHERE id_patrullas='.$id_patrullas.';'; //seleccionar el estado que se había seleccionado
  $consulta = ejecutarQuery($conexion, $query);
  if (mysqli_num_rows($consulta)) {
      while ($dat = mysqli_fetch_array($consulta)){
          $nombre_patrulla = $dat['nombre'];
      }
  }

  $query = 'SELECT nombre FROM estados WHERE id='.$id_dom_estado.';'; //seleccionar el estado que se había seleccionado
  $consulta = ejecutarQuery($conexion, $query);
  if (mysqli_num_rows($consulta)) {
      while ($dat = mysqli_fetch_array($consulta)){
          $dom_estado = $dat['nombre'];
      }
  }

  $query = 'SELECT tipo_sangre, alergias, servicio_medico FROM info_medica WHERE datos_personales_id_num_reg="'.$id_usuario_credencial.'"';
  $consulta = ejecutarQuery($conexion, $query);
  if (mysqli_num_rows($consulta)) {
      while ($dat = mysqli_fetch_array($consulta)){
          $tipo_sangre = $dat['tipo_sangre'];
          $alergias = $dat['alergias'];
          $servicio_medico = $dat['servicio_medico'];
      }
  }

/*?>*/
$codigoHTML='
<!DOCTYPE html>
<html>
<head>
	<meta charset = "utf-8">
	<title>Credencial PDF</title>
  <style type="text/css">

    body {
      font-size: 14px;
    }
  </style>

</head>
<body>
	<div align="center">
    <table width="100%" border="1">
      <tr> 
        <td align="center" width="20%">
          <img src="imagenes/brsam-logo.png"  style="width:100px;height:107px;"/>
        </td>
        <td colspan="3" width="80%" align="center">
          <div style="color: white; font-size: 4px;">BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C.</div><br>
          <p><b>BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C.</b><br>
          RFC: BRS660309598<br>
          PREMIO NACIONAL DE PROTECCIÓN CIVIL 2009<br>
          PREMIO NACIONAL DE ACCIÓN VOLUNTARIA Y SOLIDARIADAD 2012<br>
          www.socorroalpinodemexico.org.mx</p>
        </td>
      </tr>
     
      <tr>
        <td rowspan="4" align="center">';

              $codigo_mostrar = "<img src='".$fotografia."' style='width:120px;height:150px;'/>";
              $codigoHTML.=$codigo_mostrar;

       $codigoHTML.='
        </td>';
       $codigoHTML.=$color_celda;

       $codigoHTML.='<strong>Nombre</strong></td>
        <td colspan="2">';

              $codigo_mostrar = $nombre." ".$apellido_p." ".$apellido_m;
              $codigoHTML.=$codigo_mostrar;
      
      $codigoHTML.='
        </td>
      </tr>
      <tr>';

       $codigoHTML.=$color_celda;

       $codigoHTML.='<strong>Patrulla</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = $nombre_patrulla;
              $codigoHTML.=$codigo_mostrar;
      
      $codigoHTML.='
        </td>
      </tr>
      <tr>';

       $codigoHTML.=$color_celda;

       $codigoHTML.='<strong>Direccion</strong></td>
        <td colspan="2">';

              $codigo_mostrar = $dom_calle." #".$dom_num_ext;

              if($dom_num_int!="")
              {
                $codigo_mostrar.=" INT. ".$dom_num_int." ";
              }

              $codigo_mostrar.= "<br>COL. ". $dom_col.", ".$dom_del_mun.", ".$dom_estado; 
              $codigoHTML.=$codigo_mostrar;

      $codigoHTML.='
        </td>
      </tr>
      <tr>';

       $codigoHTML.=$color_celda;

       $codigoHTML.='<strong>Telefonos</strong></td>
        <td colspan="2">';

              $codigo_mostrar = "CASA: ".$telefono_casa."<br>";
              $codigo_mostrar .= "CELULAR: ".$telefono_celular."<br>";
              $codigo_mostrar .= "TRABAJO: ".$telefono_trabajo." - ext: ".$telefono_extension;
              $codigoHTML.=$codigo_mostrar;

      $codigoHTML.='
        </td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Alergias</strong></td>
        <td colspan="3">';
          
              $codigo_mostrar = $alergias;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Servicio Médico</strong></td>
        <td>';
          
              $codigo_mostrar = $servicio_medico;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>';

      $codigoHTML.=$color_celda;

       $codigoHTML.='<strong>Tipo de Sangre</strong></td>
        <td>';
          
              $codigo_mostrar = $tipo_sangre;
              $codigoHTML.=$codigo_mostrar;
      
      $codigoHTML.='
        </td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Contacto 1</strong></td>
        <td>';
          
              $codigo_mostrar = $contacto1;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Telefono</strong></td>
        <td>';
          
              $codigo_mostrar = $telefono_c1;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Contacto 2</strong></td>
        <td>';
          
              $codigo_mostrar = $contacto2;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Telefono</strong></td>
        <td>';
          
              $codigo_mostrar = $telefono_c2;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>
        <td colspan="4" align="center">
          Orozco y Berra #26 - 5, Col. Buenavista, Deleg. Cuauhtémoc, D.F.
        </td>
      </tr>
    </table>
</div>
</body>
</html>';


  desconectar($conexion);

  //echo $codigoHTML;

  //codigo para exportar a PDF
  
  $codigoHTML=utf8_decode($codigoHTML);
  $dompdf=new DOMPDF();
  $dompdf->load_html($codigoHTML);
  ini_set("memory_limit","128M");
  $dompdf->render();
  $nombre_reporte="Credencial_".$id_usuario_credencial.".pdf";
  $dompdf->stream($nombre_reporte);

}
    
?>
