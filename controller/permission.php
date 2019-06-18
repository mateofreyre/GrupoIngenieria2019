<?php

	$permission_admin = array(
		"home", "logout", "ver_perfil", "agregar_tarjeta", "agregar_tarjeta_check", "agregar_usuario", "formulario_agregar_usuario", "listar_tarjetas", "eliminar_tarjeta_check", "listar_propiedades", "listar_subastas", "listar_usuarios","cancelar_subasta", "eliminar_subasta", "finalizar_subasta"
	);
	$permission_user = array(
		"home", "logout", "ver_perfil", "agregar_tarjeta", "agregar_tarjeta_check", "modificar_vehiculo_check", "listar_tarjetas", "eliminar_tarjeta_check", "listar_propiedades", "listar_propiedades_by_location", "detalles_propiedad", "chequear_ingreso_usuario"
	);
	$permission_visitante = array(
		"home", "loguearUsuario", "agregar_usuario", "chequear_precios", "login", "mostrar_precios", "mostrar_contactanos", "chequear_agregar_usuario","cambiar_tipo_usuario","formulario_ingresar_administrador", "login_user_check", "agregar_tarjeta", "agregar_tarjeta_check", "chequear_administrador","formulario_agregar_propiedad", "check_agregar_propiedad","modificar_propiedad", "modificar_usuario","check_modificar_propiedad", "check_modificar_usuario","eliminar_propiedad", "formulario_subastar_propiedad", "chequear_subasta", "cambiar_estado_hotSale", "listar_propiedades", "listar_subastas", "cancelar_subasta", "eliminar_subasta", "finalizar_subasta", "detalle_subasta", "agregar_subasta", "agregar_oferta","formulario_agregar_usuario", "listar_usuarios", "chequear_ingreso_usuario"
	);

	$permission_array = array( 0 => $permission_admin, 1 => $permission_user, 2 => $permission_visitante);

?>
