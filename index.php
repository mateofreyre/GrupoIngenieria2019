<?php

session_start();
if(!isset($_SESSION['rol'])){
	$_SESSION['rol']=2;
}

ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

require_once('controller/ResourceController.php');
require_once('controller/permission.php');
require_once('vendor/autoload.php');

require_once('model/PDORepository.php');
require_once('model/AdminRepository.php');
require_once('model/FotosPropiedadesRepository.php');
require_once('model/FotoPropiedad.php');

//require_once('model/UsuarioRepository.php');
require_once('model/UsuarioRepository.php');
require_once('model/Usuario.php');
require_once('model/PropiedadesRepository.php');
require_once('model/Propiedades.php');
require_once('model/Tarjeta.php');
require_once('model/TarjetaRepository.php');
require_once('model/SubastaRepository.php');
require_once('model/Subasta.php');
require_once('model/Pujador.php');
require_once('model/PujadorRepository.php');
require_once('model/Reservas.php');
require_once('model/ReservasRepository.php');
require_once('model/Admin.php');
require_once('model/SuscripcionRepository.php');
require_once('model/Suscripcion.php');

require_once('view/TwigView.php');
require_once('view/Mostrar_pagina_principal.php');
require_once('view/Home.php');
require_once('view/mostrar_perfil.php');
require_once('view/agregar_tarjeta.php');
require_once('view/listar_tarjetas.php');
require_once('view/Modificar_datos_usuario.php');
require_once('view/Ingresar_como_administrador.php');
require_once('view/Agregar_usuario.php');
require_once('view/Modificar_datos_usuario.php');
require_once('view/Modificar_mis_datos.php');
require_once('view/Agregar_propiedad.php');
require_once('view/Modificar_datos_propiedad.php');
require_once('view/Subastarpropiedad.php');
require_once('view/Listar_propiedades.php');
require_once('view/Listar_subastas.php');
require_once('view/Listar_usuarios.php');
require_once('view/Mostrar_contactanos.php');
require_once('view/Mostrar_pagina_premium.php');
require_once('view/Agregar_reserva.php');
require_once('view/Mostrar_precios.php');
require_once('view/Detalle_Subasta.php');
require_once('view/SubastarPropiedad.php');
require_once('view/Detallar_propiedad.php');

if(isset($_GET["action"])) {
	$current_rol = $_SESSION['rol'];
	$method = $_GET["action"];
	if(in_array($method, $permission_array[$current_rol])){
		ResourceController::getInstance()->$method();
	}
	else{
		echo "No se encuentra habilitado";
	}
}
else{
    ResourceController::getInstance()->home();
}
?>
