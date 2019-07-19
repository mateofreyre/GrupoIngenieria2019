<?php

	$permission_admin = array(
		"home", "logout", "ver_perfil", "agregar_tarjeta", "agregar_tarjeta_check", "agregar_usuario", "formulario_agregar_usuario", "listar_tarjetas", "eliminar_tarjeta_check", "listar_propiedades", "listar_subastas", "listar_usuarios","cancelar_subasta", "eliminar_subasta", "finalizar_subasta"
	);
	$permission_user = array(
		"home", "chequear_ingreso_usuario","listar_hotsale", "mostrar_pagina_principal", "modificar_mis_datos","modificar_usuario","check_modificar_usuario","alquilar_propiedad", "mostrar_perfil", "detalles_propiedad", "listar_propiedades_by_location", "logout", "Mostrar_pagina_premium","mostrar_contactanos", "ver_perfil", "agregar_tarjeta", "agregar_tarjeta_check", "modificar_vehiculo_check", "listar_tarjetas", "eliminar_tarjeta_check", "listar_propiedades", "listar_propiedades_by_location", "detalles_propiedad", "chequear_ingreso_usuario","check_modificar_mis_datos", "listar_subastas", "detalle_subasta", "agregar_oferta", "agregar_reserva","chequear_reserva", "detalle_hot_sale", "eliminar_hot_sale", "adjudicar_hot_sale"
	);
	$permission_visitante = array(
		"home", "loguearUsuario","mostrar_pagina_principal","listar_hotsale", "agregar_usuario", "chequear_precios", "login", "mostrar_precios", "mostrar_contactanos", "chequear_agregar_usuario","cambiar_tipo_usuario","formulario_ingresar_administrador","ver_imagenes_propiedad", "login_user_check", "agregar_tarjeta", "agregar_tarjeta_check", "chequear_administrador","formulario_agregar_propiedad", "check_agregar_propiedad","modificar_propiedad", "modificar_usuario","check_modificar_propiedad", "check_modificar_usuario","eliminar_propiedad", "formulario_subastar_propiedad", "chequear_subasta", "cambiar_estado_hotSale", "listar_propiedades", "listar_subastas", "cancelar_subasta", "eliminar_subasta", "finalizar_subasta", "detalle_subasta", "agregar_subasta", "agregar_oferta","formulario_agregar_usuario", "listar_usuarios", "chequear_ingreso_usuario", "detalle_hot_sale", "eliminar_hot_sale", "logout", "agregar_deshabilitacion", "chequear_deshabilitacion", "listar_semanas_deshabilitadas", "eliminar_reserva"
	);

	$permission_array = array( 0 => $permission_admin, 1 => $permission_user, 2 => $permission_visitante);

?>
