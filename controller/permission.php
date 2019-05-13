<?php

	$permission_admin = array();
	$permission_user = array("home", "logout", "ver_perfil", "agregar_tarjeta", "agregar_tarjeta_check", "agregar_vehiculo", "agregar_vehiculo_check", "listar_vehiculos", "modificar_vehiculo", "modificar_vehiculo_check", "listar_tarjetas", "eliminar_tarjeta_check", "agregar_viaje", "chequear_agregar_viaje");
	$permission_visitante = array("home", "loguearUsuario", "agregar_usuario", "login", "chequear_agregar_usuario", "login_user_check", "agregar_tarjeta", "agregar_tarjeta_check");

	$permission_array = array( 0 => $permission_admin, 1 => $permission_user, 2 => $permission_visitante);

?>
