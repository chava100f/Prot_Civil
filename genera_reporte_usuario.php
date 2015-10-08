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
	$id_usuario_reporte = $_GET['id']; //lo obtiene por URL en el link de la tabla

  require_once("funciones.php");
  require_once(dirname(__FILE__).'/html2pdf/html2pdf.class.php');
  $pdf = new HTML2PDF('P','A4','fr','UTF-8');

  $conexion = conectar();

  $color_celda="<td bgcolor='#224FB0' style='color:white;'>";
  $color_celda_titulo="<td bgcolor='#224FB0' colspan='6' align='center' style='color:white;'>";
  $color_celda_esp1="<td bgcolor='#224FB0' colspan='3' style='color:white;'>";

  //Setting the variables 

  $nombre = "";
  $apellido_p = "";
  $apellido_m = "";
  $fecha_nac = "";
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
  $email = "";
  $tipo_cuenta = "";
  $calidad_miembro = "";
  $fotografia = "";
  $contacto1 = "";
  $contacto2 = "";
  $telefono_c1 = "";
  $telefono_c2 = "";
  $fecha_registro = "";
  $id_patrullas = "";

  $nombre_patrulla = "";

  $dom_estado = "";

  $estado_civil = "";
  $ocupacion = "";
  $escolaridad = "";
  $edad = "";
  $trabajo_escuela = "";
  $nacionalidad = "";
  $cartilla_num = "";
  $licencia_tipo = "";
  $licencia_num = "";
  $pasaporte = "";

  $tipo_sangre = "";
  $padecimientos_limitfisicas = "";
  $alergias = "";
  $servicio_medico = "";

  $genero = "";
  $estatura = "";
  $peso = "";
  $complexion = "";
  $cabello = "";
  $ojos = "";
  $cara = "";
  $nariz = "";
  $senias_particulares = "";

  $cargos_anteriores = "";
  $patrullero = "";
  $fecha_graduacion = "";
  $fecha_ingreso = "";
  $dir_ccpp = "";


  $query = 'SELECT * FROM datos_personales WHERE id_num_reg="'.$id_usuario_reporte.'"';
  $consulta = ejecutarQuery($conexion, $query);
  if (mysqli_num_rows($consulta)) {
      while ($dat = mysqli_fetch_array($consulta)){
          $nombre = $dat['nombre'];
          $apellido_p = $dat['apellido_p'];
          $apellido_m = $dat['apellido_m'];
          $fecha_nac = $dat['fecha_nac'];
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
          $email = $dat['email'];
          $tipo_cuenta = $dat['tipo_cuenta'];
          $calidad_miembro = $dat['calidad_miembro'];
          $fotografia = $dat['fotografia'];
          $contacto1 = $dat['contacto1'];
          $contacto2 = $dat['contacto2'];
          $telefono_c1 = $dat['telefono_c1'];
          $telefono_c2 = $dat['telefono_c2'];
          $fecha_registro = $dat['fecha_registro'];
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

  $query = 'SELECT * FROM datos_complementarios WHERE datos_personales_id_num_reg="'.$id_usuario_reporte.'"';
  $consulta = ejecutarQuery($conexion, $query);
  if (mysqli_num_rows($consulta)) {
      while ($dat = mysqli_fetch_array($consulta)){
          $estado_civil = $dat['estado_civil'];
          $ocupacion = $dat['ocupacion'];
          $escolaridad = $dat['escolaridad'];
          $edad = $dat['edad'];
          $trabajo_escuela = $dat['trabajo_escuela'];
          $nacionalidad = $dat['nacionalidad'];
          $cartilla_num = $dat['cartilla_num'];
          $licencia_tipo = $dat['licencia_tipo'];
          $licencia_num = $dat['licencia_num'];
          $pasaporte = $dat['pasaporte'];
      }
  }

  $query = 'SELECT * FROM info_medica WHERE datos_personales_id_num_reg="'.$id_usuario_reporte.'"';
  $consulta = ejecutarQuery($conexion, $query);
  if (mysqli_num_rows($consulta)) {
      while ($dat = mysqli_fetch_array($consulta)){
          $tipo_sangre = $dat['tipo_sangre'];
          $padecimientos_limitfisicas = $dat['padecimientos_limitfisicas'];
          $alergias = $dat['alergias'];
          $servicio_medico = $dat['servicio_medico'];
      }
  }

  $query = 'SELECT * FROM info_fisica WHERE datos_personales_id_num_reg="'.$id_usuario_reporte.'"';
  $consulta = ejecutarQuery($conexion, $query);
  if (mysqli_num_rows($consulta)) {
      while ($dat = mysqli_fetch_array($consulta)){
          $genero = $dat['genero'];
          $estatura = $dat['estatura'];
          $peso = $dat['peso'];
          $complexion = $dat['complexion'];
          $cabello = $dat['cabello'];
          $ojos = $dat['ojos'];
          $cara = $dat['cara'];
          $nariz = $dat['nariz'];
          $senias_particulares = $dat['senias_particulares'];
      }
  }

  $query = 'SELECT * FROM antecedentes WHERE datos_personales_id_num_reg="'.$id_usuario_reporte.'"';
  $consulta = ejecutarQuery($conexion, $query);
  if (mysqli_num_rows($consulta)) {
      while ($dat = mysqli_fetch_array($consulta)){
          $cargos_anteriores = $dat['cargos_anteriores'];
          $patrullero = $dat['patrullero'];
          $fecha_graduacion = $dat['fecha_graduacion'];
          $fecha_ingreso = $dat['fecha_ingreso'];
          $dir_ccpp = $dat['dir_ccpp'];
      }
  }

/*?>*/
$codigoHTML='
  <page backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
    <table border="1" align="left">
      <tr> 
        <td align="center">
          <img src="imagenes/brsam-logo.png"  style="width:100px;height:107px;"/>
        </td>
        <td colspan="4" align="center">
          <p><b>BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C.</b><br>
          RFC: BRS660309598<br>
          PREMIO NACIONAL DE PROTECCIÓN CIVIL 2009<br>
          PREMIO NACIONAL DE ACCIÓN VOLUNTARIA Y SOLIDARIADAD 2012<br>
          www.socorroalpinodemexico.org.mx<br></p>
        </td>
        <td align="center">
          <img src="imagenes/brsam-logo.png" style="width:100px;height:107px;"/>
        </td>
      </tr>
     
      <tr>
        <td rowspan="7" colspan="2" align="center">

      ';
              $codigo_mostrar = "<img src='".$fotografia."' style='width:180px;height:220px;'/>";
              $codigoHTML.=$codigo_mostrar;

       $codigoHTML.='
        </td>';
       $codigoHTML.=$color_celda;

       $codigoHTML.='<strong>Nombre</strong></td>
        <td colspan="3">';

              $codigo_mostrar = $nombre." ".$apellido_p." ".$apellido_m;
              $codigoHTML.=$codigo_mostrar;
      
      $codigoHTML.='
        </td>
      </tr>
      <tr>';

       $codigoHTML.=$color_celda;

       $codigoHTML.='<strong>ID del miembro</strong></td>
        <td colspan="3">';
          
              $codigo_mostrar = $id_usuario_reporte;
              $codigoHTML.=$codigo_mostrar;
      
      $codigoHTML.='
        </td>
      </tr>
      <tr>';

       $codigoHTML.=$color_celda;

       $codigoHTML.='<strong>Calidad de Miembro</strong></td>
        <td colspan="3">';
          
              $codigo_mostrar = strtoupper($calidad_miembro);
              $codigoHTML.=$codigo_mostrar;
      
      $codigoHTML.='
        </td>
      </tr>
      <tr>';

       $codigoHTML.=$color_celda;

       $codigoHTML.='<strong>Patrulla</strong></td>
        <td colspan="3">';
          
              $codigo_mostrar = $nombre_patrulla;
              $codigoHTML.=$codigo_mostrar;
      
      $codigoHTML.='
        </td>
      </tr>
      <tr>';

       $codigoHTML.=$color_celda;

       $codigoHTML.='<strong>Fecha de registro</strong></td>
        <td colspan="3">';
          
              $codigo_mostrar = substr($fecha_registro, -19,10);
              $codigoHTML.=$codigo_mostrar;

      $codigoHTML.='
        </td>
      </tr>
      <tr>';

       $codigoHTML.=$color_celda;

       $codigoHTML.='<strong>Domicilio</strong></td>
        <td colspan="3">';

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
        <td colspan="3">';

              $codigo_mostrar = "CASA: ".$telefono_casa."<br>";
              $codigo_mostrar .= "CELULAR: ".$telefono_celular."<br>";
              $codigo_mostrar .= "TRABAJO: ".$telefono_trabajo." - ext: ".$telefono_extension;
              $codigoHTML.=$codigo_mostrar;

      $codigoHTML.='
        </td>
      </tr>
      <tr>';

       $codigoHTML.=$color_celda;

       $codigoHTML.='<strong>Email</strong></td>
        <td colspan="5">';

              $codigo_mostrar = $email;
              $codigoHTML.=$codigo_mostrar;

      $codigoHTML.='
        </td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Fecha de Nacimiento</strong></td>
        <td colspan="2">';

              $codigo_mostrar = $fecha_nac;
              $codigoHTML.=$codigo_mostrar;

      $codigoHTML.='
        </td>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Edad</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = $edad;
              $codigoHTML.=$codigo_mostrar;
       
      $codigoHTML.='
        </td>
      </tr>    
       <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Estado Civil</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = ucfirst($estado_civil); //convierte la primer letra del string en Mayúscula
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Nacionalidad</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = $nacionalidad;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>  
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Escolaridad</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = $escolaridad; //convierte la primer letra del string en Mayúscula
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Ocupación</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = $ocupacion;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr> 
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Nombre del Trabajo o<br>Escuela actual</strong></td>
        <td colspan="5">';
          
              $codigo_mostrar = $trabajo_escuela;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Cartilla Militar</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = $cartilla_num;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Pasaporte</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = $pasaporte;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Licencia de Manejo</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = $licencia_num;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Tipo</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = $licencia_tipo;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda_titulo;

      $codigoHTML.='<strong>Información Médica</strong></td>
      </tr> 
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Tipo de Sangre</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = $tipo_sangre;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Servicio Médico</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = $servicio_medico;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda_esp1;

      $codigoHTML.='<strong>Vacunas Locales</strong></td>';

      $codigoHTML.=$color_celda_esp1;

      $codigoHTML.='<strong>Vacunas Internacionales</strong></td>
      </tr>
      <tr>
        <td colspan="3">';

              $vacunas = array();
              $vacuna_internacional="";
              $codigo_mostrar="<ul>";

              $query = 'SELECT * FROM vacunas WHERE datos_personales_id_num_reg="'.$id_usuario_reporte.'"';
              $consulta = ejecutarQuery($conexion, $query);
              $limite1 = 0;
              if (mysqli_num_rows($consulta)) {
                  while ($dat = mysqli_fetch_array($consulta)){
                      $vacunas[$limite1] = $dat['vacunas']; 
                      $limite1++;
                  }
              }   

              for($i=0;$i<$limite1;$i++) //ciclo para escribir el codigo de inserción en el formulario
              {
                if($i!=($limite1-1))
                {
                  $codigo_mostrar.= "<li>".$vacunas[$i]."</li>"; 
                }
                else
                {
                  $vacuna_internacional=$vacunas[$i];
                }
              }
              $codigo_mostrar .= "</ul>";
              $codigoHTML.=$codigo_mostrar;
        
      $codigoHTML.='</td>
        <td colspan="3">';
          
            if($vacuna_internacional!="")
            {
                $codigo_mostrar = "<ul><li>".$vacuna_internacional."</li></ul>";
                $codigoHTML.=$codigo_mostrar;
            }
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Padecimientos o<br> Limitaciones Físicas</strong></td>
        <td colspan="5">';
          
              $codigo_mostrar = $padecimientos_limitfisicas;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Alergias</strong></td>
        <td colspan="5">';
          
              $codigo_mostrar = $alergias;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda_titulo;

      $codigoHTML.='<strong>Información Física</strong></td>
      </tr> 
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Género</strong></td>
        <td>';
          
              $codigo_mostrar = strtoupper($genero);
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Estatura</strong></td>
        <td>';
          
              $codigo_mostrar = $estatura." m";
              $codigoHTML.=$codigo_mostrar;
          
        $codigoHTML.='</td>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Peso</strong></td>
        <td>';
          
              $codigo_mostrar = $peso." Kg";
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Complexión</strong></td>
        <td colspan="5">';
          
              $codigo_mostrar = $complexion;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Cabello</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = $cabello;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Cara</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = $cara;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Ojos color</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = $ojos;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Nariz</strong></td>
        <td colspan="2">';
          
              $codigo_mostrar = $nariz;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Señas particulares</strong></td>
        <td colspan="5">';
          
              $codigo_mostrar = $senias_particulares;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda_titulo;

      $codigoHTML.='<strong>Información de experiencia en patrullaje, rescate, etc.</strong></td>
      </tr> 
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Cargos Anteriores</strong></td>
        <td colspan="5">';
          
              $codigo_mostrar = $cargos_anteriores;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Patrullero</strong></td>
        <td>';
          
              $codigo_mostrar = strtoupper($patrullero);
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Fecha de Ingreso</strong></td>
        <td>';
          
              $codigo_mostrar = $fecha_ingreso;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Fecha de Graduación</strong></td>
        <td>';
          
              $codigo_mostrar = $fecha_graduacion;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda_esp1;

      $codigoHTML.='<strong>Experiencia</strong></td>';

      $codigoHTML.=$color_celda_esp1;

      $codigoHTML.='<strong>Otro tipo de experiencia a fin</strong></td>
      </tr>
      <tr>
        <td colspan="3">';

              $experiencia = array();
              $experiencia_extra="";
              $codigo_mostrar="<ul>";

              $query = 'SELECT * FROM experiencia WHERE datos_personales_id_num_reg="'.$id_usuario_reporte.'"';
              $consulta = ejecutarQuery($conexion, $query);
              $limite2 = 0;
              if (mysqli_num_rows($consulta)) {
                  while ($dat = mysqli_fetch_array($consulta)){
                      $experiencia[$limite2] = $dat['experiencia']; 
                      $limite2++;
                  }
              }   

              for($i=0;$i<$limite2;$i++) //ciclo para escribir el codigo de inserción en el formulario
              {
                if($i!=($limite2-1))
                {
                  $codigo_mostrar.= "<li>".$experiencia[$i]."</li>"; 
                }
                else
                {
                  $experiencia_extra=$experiencia[$i];
                }
              }
              $codigo_mostrar .= "</ul>";
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
        <td colspan="3">';
          
            if($experiencia_extra!="")
            {
                $codigo_mostrar = "<ul><li>".$experiencia_extra."</li></ul>";
                $codigoHTML.=$codigo_mostrar;
            }
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda_esp1;

      $codigoHTML.='<strong>Nombre del Dir.<br>C.C.P.P. o Calidad</strong></td>
        <td colspan="3">';
          
              $codigo_mostrar = $dir_ccpp;
              $codigoHTML.=$codigo_mostrar;
          
      $codigoHTML.='</td>
      </tr>
      <tr>';

      $codigoHTML.=$color_celda_titulo;

      $codigoHTML.='<strong>En caso de accidente comunicarse con</strong></td>
      </tr> 
      <tr>';

      $codigoHTML.=$color_celda;

      $codigoHTML.='<strong>Contacto 1</strong></td>
        <td colspan="3">';
          
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
        <td colspan="3">';
          
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
        <td>OBSERVACIONES:</td>
        <td colspan="5"></td>
      </tr>

      <tr>
        <td colspan="6"><div style="color: white;">BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C.</div></td>
      </tr>

      <tr>
        <td colspan="6"><div style="color: white;">BRIGADA DE RESCATE DEL SOCORRO ALPINO DE MÉXICO, A.C.</div></td>
      </tr>

      <tr>
        <td>ENTREGA<br>CURRICULUM</td>
        <td></td>
        <td>ENTREGA<br>DOCUMENTOS</td>
        <td></td>
        <td>ENTREGA<br>COMPROBANTE DE PAGO</td>
        <td></td>
      </tr>

      <tr>
        <td colspan="6">AVISO DE PRIVACIDAD<br>

            Toda aquella información personal que el elemento proporciona se encuentra sujeta
             a las normas de confidencialidad y privacidad y es almacenada en una base de datos
             de la Asociación. Los datos personales que usted comparta con la BRIGADA DE RESCATE
             DEL SOCORRO ALPINO DE MÉXICO, A.C. no serán difundidos, distribuidos o comercializados.
             Esta información confidencial no se compartirá con terceras partes, excepto que se
             tenga expresa autorización de quien la suscribe o cuando haya sido requerida por orden
             judicial para cumplir con las disposiciones procesales, su uso interno será con fines
             de administración de información y recursos humanos de la Brigada.

        </td>
      </tr>

      <tr>
        <td colspan="6">PRIMERO:<br>

            La B.R.S.A.M.A.C. no asume responsabilidad alguna al aceptar esta solicitud, 
            únicamente la recibe; por lo tanto el solicitante no queda automáticamente 
            registrado como miembro por el solo hecho de haber entregado esta solicitud 
            aun cuando hubiese pagado la cuota relativa. La B.R.S.A.M.A.C. se reserva el 
            derecho de aceptar al solicitante y de aceptarlo como miembro, será avalado 
            entregándole la credencial correspondiente al año en curso.

        </td>
      </tr>

      <tr>
        <td colspan="6">SEGUNDO:<br>

            <u>Al firmar la presente solicitud de registro el solicitante se compromete a 
            cumplir y hacer cumplir los estatutos y reglamento(s) de la B.R.S.A.M.A.C.</u><br>
            "Conforme a los mismos confirmo que durante mi permanencia dentro de esta 
            Institución en automático se renueve mi registro anual, el cual me comprometo 
            a cubrir la cuota anual correspondiente, con la finalidad de agilizar el trámite 
            cíclico hasta que por mi propio derecho desee continuar, hasta que así convenga 
            a mis interés entonces realizaré por escrito mi baja o retiro de esta Brigada, 
            con lo cual daré formal conclusión a mi relación con la misma".

        </td>
      </tr>

      <tr>
        <td colspan="6">TERCERO:<br>
            <div style="font-size: 11px;">SI EL SOLICITANTE ES MENOR DE EDAD</div>

            "Declaramos bajo protesta decir la verdad de los datos personales escritos en 
            esta solicitud de ingreso a la Brigada de Rescate del Socorro Alpino de México 
            A. C., corresponden al solicitante menor de edad de quien ejercemos legalmente 
            la patria potestad. Así mismo que lo autorizamos a ingresar a dicha Institución 
            y a participar en las actividades que desarrolla. Liberamos y eximimos a la 
            B.R.S.A.M.A.C., sus miembros y colaboradores de toda responsabilidad por los 
            daños prejuicios y lesiones que nuestro autorizado sufriera durante estas 
            actividades o por causa de ellas y asumimos las responsabilidades por los daños 
            que resultan debido a su intervención. Este permiso se lo otorgamos por todo el 
            tiempo que sea aspirante o miembro de la Brigada, sin menoscabo de que su 
            permanencia en ella tenga interrupciones largas o cortas, y hasta que sea mayor 
            de edad o lo cancelemos formalmente por escrito dirigido al Presidente de la 
            Institución".<br><br>

            <table>
              <tr>
                <td colspan="2">Nombre y firma de los padres o tutores</td>
              </tr>
              <tr>
                <td>NOMBRE</td>
                <td>NOMBRE</td>
              </tr>
              <tr>
                <td>___________________________________</td>
                <td>___________________________________</td>
              </tr>
              <tr>
                <td>FIRMA</td>
                <td>FIRMA</td>
              </tr>
            </table>

        </td>
      </tr>

      <tr>
        <td colspan="6">CUARTO:
            <div style="font-size: 11px;">PARA SOLICITANTES MAYOR DE EDAD</div>

            Libero y eximo a la B.R.S.A.M.A.C., sus miembros y colaboradores de toda 
            responsabilidad por los daños, prejuicios y lesiones que sufriera durante 
            sus actividades o por causa de ellas y asumo las responsabilidades por los 
            daños que resulten debido a mi intervención. Este permiso lo otorgo por todo 
            el tiempo que sea aspirante o miembro de la Brigada, sin menoscabo de que 
            mi permanencia en ella tenga interrupciones largas o cortas, para realizar 
            mi renuncia lo haré por escrito o me podrá ser revocada la calidad de miembro 
            en los casos previstos en los estatutos, reglamento o ley vigente.<br><br>

            <table width="100%">
              <tr>
                <td colspan="2">FIRMA</td>
              </tr>
              <tr>
                <td>___________________________________</td>
                <td>___________________________________</td>
              </tr>
              <tr>
                <td>Miembro BRSAM Patrulla/Delegación</td>
                <td>Vo. Bo. Jefe de Patrulla o Delegación</td>
              </tr>
            </table>

        </td>
      </tr>

    </table>
  <p>Original para la Secretaría<br>
  C.C.P. Tesorería<br> 
  Jefatura Operativa Nacional
  </p>
  <div align="center">
    Orozco y Berra #26 - 5, Col. Buenavista, Deleg. Cuauhtémoc, D.F.
  </div>
  </page>';


  desconectar($conexion);

  //echo $codigoHTML;

  //codigo para exportar a PDF
  
  $pdf->WriteHTML($codigoHTML);
  $nombre_archivo="Reporte_".$id_usuario_reporte.".pdf";
  $pdf->Output($nombre_archivo,'D');
  
}
    
?>
