<?php 

	function obtener_menu() //Identifica el tipo de perfil del usuario y selecciona el menu contextual adecuado
	{
		$tipo_cuenta=$_SESSION['user_type'];
		$menu="";

		if($tipo_cuenta=="USUARIO")
		{
			$menu = "<nav class='navbar navbar-inverse navbar-fixed-top'>
			      <div class='container-fluid'>
			        <div class='navbar-header'>
			          <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar' aria-expanded='false' aria-controls='navbar'>
			            <span class='sr-only'>Toggle navigation</span>
			            <span class='icon-bar'></span>
			            <span class='icon-bar'></span>
			            <span class='icon-bar'></span>
			          </button>
			          <p class='navbar-brand'>Bienvenido Patrullero</p>
			        </div>
			        <div id='navbar' class='navbar-collapse collapse' aria-expanded='false' style='height: 1px;'>
			          <ul class='nav navbar-nav navbar-right'>
			            <li><a href='index_usuario.php'>Inicio</a></li>
			            <li role='presentation' class='dropdown'>
			                <a class='dropdown-toggle' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='false'>
			                Modificar Datos <span class='caret'></span>
			                </a>
			                <ul class='dropdown-menu inverse-dropdown' >
			                    <li><a href='form_personales.php'>Información Personal Básica</a></li>
			                    <li><a href='form_complementario.php'>Información Complementaria del perfil</a></li>
			                    <li><a href='form_medico.php'>Información Medica</a></li>
			                    <li><a href='form_info_fisica.php'>Información Fisica</a></li>
			                    <li><a href='form_experiencia.php'>Información de experiencia en Patrullaje y Rescate</a></li>
			                    <li><a href='form_foto.php'>Cambiar imagen de perfil</a></li>
			                    <li><a href='form_cambio_pass.php'>Cambiar contraseña</a></li>
			                </ul>
			            </li>
			            <li><a href='cerrar_sesion.php'>Cerrar sesión</a></li>
			          </ul>
			        </div>
			      </div>
			    </nav>";
		}
		if($tipo_cuenta=="JEFE")
		{	
			$menu = "<nav class='navbar navbar-inverse navbar-fixed-top'>
			      <div class='container-fluid'>
			        <div class='navbar-header'>
			          <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar' aria-expanded='false' aria-controls='navbar'>
			            <span class='sr-only'>Toggle navigation</span>
			            <span class='icon-bar'></span>
			            <span class='icon-bar'></span>
			            <span class='icon-bar'></span>
			          </button>
			          <p class='navbar-brand'>Bienvenido Jefe de Patrulla</p>
			        </div>
			        <div id='navbar' class='navbar-collapse collapse' aria-expanded='false' style='height: 1px;'>
			          <ul class='nav navbar-nav navbar-right'>
			            <li><a href='index_jefe_patrulla.php'>Inicio</a></li>
			            <li role='presentation' class='dropdown'>
			                <a class='dropdown-toggle' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='false'>
			                Modificar Datos <span class='caret'></span>
			                </a>
			                <ul class='dropdown-menu inverse-dropdown' >
			                    <li><a href='form_personales.php'>Información Personal Básica</a></li>
			                    <li><a href='form_complementario.php'>Información Complementaria del perfil</a></li>
			                    <li><a href='form_medico.php'>Información Medica</a></li>
			                    <li><a href='form_info_fisica.php'>Información Fisica</a></li>
			                    <li><a href='form_experiencia.php'>Información de experiencia en Patrullaje y Rescate</a></li>
			                    <li><a href='form_foto.php'>Cambiar imagen de perfil</a></li>
			                    <li><a href='form_cambio_pass.php'>Cambiar contraseña</a></li>
			                </ul>
			            </li>
			            <li><a href='cerrar_sesion.php'>Cerrar sesión</a></li>
			          </ul>
			        </div>
			      </div>
			    </nav>";

		}
		if($tipo_cuenta=="ADMIN")
		{	
			$menu = "<nav class='navbar navbar-inverse navbar-fixed-top'>
			      <div class='container-fluid'>
			        <div class='navbar-header'>
			          <button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar' aria-expanded='false' aria-controls='navbar'>
			            <span class='sr-only'>Toggle navigation</span>
			            <span class='icon-bar'></span>
			            <span class='icon-bar'></span>
			            <span class='icon-bar'></span>
			          </button>
			          <p class='navbar-brand'>Bienvenido Administrador</p>
			        </div>
			        <div id='navbar' class='navbar-collapse collapse' aria-expanded='false' style='height: 1px;'>
			          <ul class='nav navbar-nav navbar-right'>
			            <li><a href='index_admin.php'>Inicio</a></li>
	                    <li><a href='form_cambio_pass_admin.php'>Cambiar contraseña</a></li>
			            <li role='presentation' class='dropdown'>
			                <a class='dropdown-toggle' data-toggle='dropdown' href='#' role='button' aria-haspopup='true' aria-expanded='false'>
			                Buscar <span class='caret'></span>
			                </a>
			                <ul class='dropdown-menu inverse-dropdown' >
			                    <li><a href='busca_usuario.php'>Usuario</a></li>
			                    <li><a href='busca_patrulla.php'>Patrulla</a></li>
			                </ul>
			            </li>
			            <li><a href='alta_patrulla.php'>Alta Patrulla</a></li>
			            <li><a href='cerrar_sesion.php'>Cerrar sesión</a></li>
			          </ul>
			        </div>
			      </div>
			    </nav>";
		}	

		return $menu;
	}

?>