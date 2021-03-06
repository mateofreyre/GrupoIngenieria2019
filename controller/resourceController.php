<?php


class ResourceController {

	private static $instance;
	public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }


	//PAGINAS COMUNES
	public function home(){
		$view = new Home();
		$aux=1;
		$view->show($aux);
	}

	public function mostrar_pagina_principal(){
		$view = new Mostrar_pagina_principal();
		if($_SESSION['rol'] == 2){
			$ok=1;
			$view -> show($ok);
			return true;
		}
		$usuario= UsuarioRepository::getInstance()-> buscarUsuarioPorId($_SESSION['usuario']->getId());

		$view -> show($usuario);
	}

	public function formulario_ingresar_administrador(){
		$view = new Ingresar_como_administrador();
		$view -> show();
	}

	public function mostrar_contactanos(){
		$view = new Mostrar_contactanos();
		if($_SESSION['rol'] == 2){
			$ok=1;
			$view -> show($ok);
			return true;
		}
		$usuario= UsuarioRepository::getInstance()-> buscarUsuarioPorId($_SESSION['usuario']->getId());

		$view -> show($usuario);
	}

	public function Mostrar_pagina_premium(){
		$view = new Mostrar_pagina_premium();
		if($_SESSION['rol'] == 2){
			$ok=1;
			$view -> show($ok);
			return true;
		}
		$usuario= UsuarioRepository::getInstance()-> buscarUsuarioPorId($_SESSION['usuario']->getId());

		$view -> show($usuario);
	}

	public function mostrar_precios(){
		$model = SuscripcionRepository::getInstance()->devolver_precio();
		$view = new Mostrar_precios();
		if($_SESSION['rol'] == 2){
			$ok=1;
			$view -> show($model,	$ok);
			return true;
		}
		$usuario= UsuarioRepository::getInstance()-> buscarUsuarioPorId($_SESSION['usuario']->getId());

		$view -> show($model, $usuario);
	}

	public function chequear_precios(){
		$model = SuscripcionRepository::getInstance()-> chequear_precios();
		if($model){
			self::getInstance()->mostrar_precios();
		}

	}

    //ADMINISTRADOR

    public function chequear_administrador(){
    	$codigo = $_POST['codigo'];
    	$model = AdminRepository::getInstance()-> chequear_codigo($codigo);
    	if($model){

    		self::getInstance()->Mostrar_pagina_principal();
    	}
    	else{
    		self::getInstance()-> home();
    	}
    }

	public function cambiar_tipo_usuario(){
		$model = UsuarioRepository::getInstance()-> cambiar_suscripcion();
		self::getInstance()-> listar_usuarios();

	}

	///////////////////PROPIEDADES ABM Y LISTAR/////////////////////////

	public function listar_propiedades(){
		$model = PropiedadesRepository::getInstance()->listar_propiedades();

		$view = new Listar_propiedades();

		if($_SESSION['rol'] == 2){
			$ok=1;
			$view -> show($model,$ok);
			return true;
		}
		$usuario= UsuarioRepository::getInstance()-> buscarUsuarioPorId($_SESSION['usuario']->getId());
		$view -> show($model, $usuario);
	}

	public function listar_propiedades_by_location(){
		$model = PropiedadesRepository::getInstance()->listar_propiedades_by_location();
		$view = new Listar_propiedades();
		if($_SESSION['rol'] == 2){
			$ok=1;
			$view -> show($model,$ok);
			return true;
		}
		$usuario= UsuarioRepository::getInstance()-> buscarUsuarioPorId($_SESSION['usuario']->getId());

		$view -> show($model,$usuario);
	}

	public function eliminar_propiedad(){
		$model = PropiedadesRepository::getInstance()-> eliminar_propiedad();
		self::getInstance()-> listar_propiedades();
	}

	public function formulario_agregar_propiedad(){
		$view = new Agregar_propiedad();
		$view -> show();
	}

	public function check_agregar_propiedad(){
		$model = PropiedadesRepository::getInstance()->agregar_propiedad();
		if($model){
			self::getInstance()-> listar_propiedades();
		}
		else{
			self::getInstance()-> formulario_agregar_propiedad();
		}
	}

	public function ver_imagenes_propiedad(){
		$model = PropiedadesRepository::getInstance()->buscar_propiedad();
		$id_propiedad = $model->getId();
		$fotos = FotosPropiedadesRepository::getInstance()-> fotos_propiedad($id_propiedad);
		$view = new Mostrar_galeria();
		$view -> show($fotos);
	}

	public function detalles_propiedad(){
		$model = PropiedadesRepository::getInstance()->buscar_propiedad();
		$view = new Detallar_propiedades();
		if($_SESSION['rol'] == 2){
			$ok=1;
			$view -> show($subasta, $mejor_oferta[0]->getMonto(),$ok);
			return true;
		}
		$view-> show($model, $_SESSION['usuario']);
	}

	public function cambiar_estado_hotSale(){
		$model = PropiedadesRepository::getInstance()-> cambiar_estado_hotSale();
		self::getInstance()->listar_propiedades();
	}

	public function modificar_propiedad(){
		$model = PropiedadesRepository::getInstance()->buscar_propiedad();
		$id_propiedad = $model->getId();
		$fotos = FotosPropiedadesRepository::getInstance()-> fotos_propiedad($id_propiedad);
		$view = new Modificar_datos_propiedad();
		$view -> show($model,$fotos);
	}

	public function check_modificar_propiedad(){
		$model = PropiedadesRepository::getInstance()->modificar_datos_propiedad();
		self::getInstance()-> listar_propiedades();
	}

	///////////////////////SUBASTAS//////////////////////////

	public function listar_subastas(){
		$model_subastas = SubastaRepository::getInstance()->listar_subastas();
		$view = new Listar_subastas();
		if($_SESSION['rol'] == 2){
			$ok=1;
			$view -> show($model_subastas,$ok);
			return true;
		}
		$usuario= UsuarioRepository::getInstance()-> buscarUsuarioPorId($_SESSION['usuario']->getId());

		$view -> show($model_subastas, $usuario);
	}

	public function formulario_subastar_propiedad(){
		$model_propiedad = PropiedadesRepository::getInstance()->buscar_propiedad();
		$view = new SubastarPropiedad();
		$view -> show($model_propiedad);
	}

	public function chequear_subasta(){
		$model = SubastaRepository::getInstance()-> chequear_subasta();
		if($model){
			self::getInstance()->listar_propiedades();
		}
		else{
			self::getInstance()-> formulario_subastar_propiedad();
		}
	}

	public function eliminar_subasta(){
		$model = SubastaRepository::getInstance()-> eliminar_subasta();
		self::getInstance()-> listar_subastas();
	}

	public function cancelar_subasta(){
		$model = SubastaRepository::getInstance()-> cancelar_subasta();
		self::getInstance()-> listar_subastas();
	}

	public function finalizar_subasta(){
		$model = SubastaRepository::getInstance()->finalizar_subasta();
		self::getInstance()-> listar_subastas();
	}

	public function detalle_subasta(){
		$subasta = SubastaRepository::getInstance()-> detalle_subasta();
		$mejor_oferta = PujadorRepository::getInstance()->listar_ofertas_by_subasta($subasta->getId());

		$propiedad = PropiedadesRepository::getInstance()->buscar_propiedad_by_id($subasta->getIdPropiedad());
		$view = new Detalle_Subasta();
		if(!empty($mejor_oferta)){
			if($_SESSION['rol'] == 2){
				$ok=1;
				$view -> show($subasta, $mejor_oferta[0]->getMonto(),$ok);
				return true;
			}
			$view -> show($subasta, $mejor_oferta[0]->getMonto(),$_SESSION['usuario']);
		}else{
			if($_SESSION['rol'] == 2){
				$ok=1;
				$view -> show($subasta, $subasta->getMontoBase(),$ok);
				return true;
			}
			$view -> show($subasta, $subasta->getMontoBase(),$_SESSION['usuario']);
		}
	}


	public function agregar_oferta(){
		$model = PujadorRepository::getInstance()-> agregar_oferta();
		self::getInstance()-> listar_subastas();
	}

	//	$model_subasta = SubastaRespository::getInstance()->buscar_mejor_postor($model_propiedad);
	//	$costo_actual = $model['monto'];




			//////////////////////////Usuarios////////////////////////

			public function listar_usuarios(){
				$model = UsuarioRepository::getInstance()->listar_usuarios();
				$view = new Listar_usuarios();
				$view -> show($model);
			}

			public function formulario_agregar_usuario(){
				$view = new Agregar_usuario();
				$view -> show();
			}

			public function chequear_agregar_usuario(){
				$model = UsuarioRepository::getInstance()->agregar_usuario();
				if($model){
					if($_SESSION['rol'] = 2){
						self::getInstance()->home();
					}
					else{
						self::getInstance()-> listar_propiedades();
					}
				}
				else{
					if($_SESSION['rol'] = 2){
						self::getInstance()->home();
					}
					else{
						self::getInstance()-> formulario_agregar_usuario();
					}
				}
			}

			public function modificar_usuario(){
				$model = UsuarioRepository::getInstance()->buscar_usuario();
				$view = new Modificar_datos_usuario();
				$view -> show($model);
			}

			public function modificar_mis_datos(){
				$model = UsuarioRepository::getInstance()->buscar_usuario();
				$view = new Modificar_mis_datos();
				$view -> show($model);
			}

			public function chequear_ingreso_usuario(){
				$model = UsuarioRepository::getInstance()-> chequear_inicio();
				if($model){
					$_SESSION['rol'] = 1;
					self::getInstance()->mostrar_pagina_principal();
				}
				else{
					self::getInstance()->home();
				}
			}

			public function logout(){
	        try{
	            $model= UsuarioRepository::getInstance()->logout_user();
							self::getInstance()-> home();
	        }
					catch (PDOException $e){
	            $error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
	            $view = new Error_display();
	            $view->show($error);
	        }
				}

			public function check_modificar_usuario(){
				$model = UsuarioRepository::getInstance()->modificar_datos_usuario();
				self::getInstance()-> listar_usuarios();
			}

			public function check_modificar_mis_datos(){
				$model = UsuarioRepository::getInstance()->modificar_datos_usuario();
				self::getInstance()-> mostrar_perfil();
			}

			public function mostrar_perfil(){
				$model = UsuarioRepository::getInstance()->buscar_usuario();
				$view = new Mostrar_perfil();
				$view -> show($model);
			}

			public function alquilar_propiedad(){

			}
			public function agregar_tarjeta(){
			$view = new agregar_tarjeta();
			if($_SESSION['rol'] == 2){
				$ok=1;
				$view -> show($subasta, $mejor_oferta[0]->getMonto(),$ok);
				return true;
			}
			$view -> show($_SESSION['usuario']);
		}

		public function agregar_tarjeta_check(){
				try{
						$model = TarjetaRepository :: getInstance() -> agregar_tarjeta();
						if(!$model){
							$view = new agregar_tarjeta();
							$view -> show();
						}
						else {
							self::getInstance()->mostrar_perfil();
						}
				}
				catch(Exception $e){
						$mensaje = "No se pudo agregar la tarjeta. Intentalo nuevamente más tarde.";
				}
		}

		public function listar_tarjetas(){
		try{
			$tarjetas = TarjetaRepository :: getInstance() -> listar_tarjetas();
			$view = new listar_tarjetas();
			$view -> show($tarjetas,$_SESSION['usuario']);
			}
			catch(PDOException $e){
					$error="Se ha producido un error en la consulta: " . $e->getMessage() . "<br/>";
					$view = new Error_display();
					$view->show($error);
			}
		}

			public function eliminar_tarjeta_check(){
				try{
					$tarjetas = TarjetaRepository :: getInstance() -> listar_tarjetas();
					//if (isset($tarjetas)){
						if (count($tarjetas)>1){
							$tarjetas = TarjetaRepository :: getInstance() -> card_delete($_GET['id']);
							self :: getInstance() -> listar_tarjetas();
						}
						else{
							$mensaje = "No puede eliminar su última tarjeta.";
							self :: getInstance() -> listar_tarjetas();
						}
					//}
				}
					catch(PDOException $e){
						$mensaje = "Se produjo un error y la operación no pudo ser realizada.";
					}
					echo "<script>";
					echo "alert('$mensaje');";
					echo "</script>";
			}

			public function agregar_reserva(){
				$id_propiedad = $_GET['id'];
				$propiedad = PropiedadesRepository::getInstance()->buscar_propiedad_by_id($id_propiedad);
				$view = new Agregar_reserva();
				$view -> show($propiedad);
			}
			public function agregar_deshabilitacion(){
				$id_propiedad = $_GET['id'];
				$propiedad = PropiedadesRepository::getInstance()->buscar_propiedad_by_id($id_propiedad);
				$view = new Agregar_Deshabilitar();
				$view -> show($propiedad);
			}

			public function chequear_deshabilitacion(){
				$model = ReservasRespository::getInstance()->chequear_deshabilitacion();
				if(!$model){
					$mensaje = "Se produjo un error y la operación no pudo ser realizada.";
				echo "<script>";
				echo "alert('$mensaje');";
				echo "</script>";
				self::getInstance()->agregar_deshabilitacion();

				}
				else{
					self::getInstance()->listar_propiedades();
				}
			}

			public function chequear_reserva(){
				$model = ReservasRespository::getInstance()->chequear_reserva();
				if(!$model){
					$mensaje = "Se produjo un error y la operación no pudo ser realizada.";
				echo "<script>";
				echo "alert('$mensaje');";
				echo "</script>";
				self::getInstance()->agregar_reserva();
				}
				else{
					self::getInstance()->listar_propiedades();
				}
			}

			// HOT SALEE!!//
			public function listar_hotsale(){
				$model = PropiedadesRepository::getInstance()->listar_hotsale();
				$view = new Listar_hotSales();
				if($_SESSION['rol'] == 2){
					$ok=1;
					$view -> show($model, $ok);
					return true;
				}
				$usuario= UsuarioRepository::getInstance()-> buscarUsuarioPorId($_SESSION['usuario']->getId());

				$view -> show($model, $usuario);
				}

				public function detalle_hot_sale(){
					$model = Hot_saleRepository::getInstance()->detalle_hot_sale();

					$view = new Detalle_hotSale();
					if($_SESSION['rol'] == 2){
						$ok=1;
						$view -> show($model, $ok);
						return true;
					}

					$usuario= UsuarioRepository::getInstance()-> buscarUsuarioPorId($_SESSION['usuario']->getId());
						$view -> show($model, $usuario);
				}

				public function eliminar_hot_sale(){
					$model = Hot_saleRepository::getInstance()-> eliminar_hot_sale();
					if($model){
						$mensaje = "Se elimino exitosamente el hot sale";
					echo "<script>";
					echo "alert('$mensaje');";
					echo "</script>";
					self::getInstance()->listar_hotsale();
					}
					else{
						$mensaje = "Se produjo un error y la operación no pudo ser realizada.";
					echo "<script>";
					echo "alert('$mensaje');";
					echo "</script>";
					self::getInstance()->detalle_hot_sale();
					}
				}

				public function listar_semanas_deshabilitadas(){
					$model_deshabilitadas = ReservasRespository::getInstance()->listar_semanas_deshabilitadas();
					$view = new listar_semanas_deshabilitadas();
					if($_SESSION['rol'] == 2){
						$ok=1;
						$view -> show($model_deshabilitadas,$ok);
						return true;
					}
					$usuario= UsuarioRepository::getInstance()-> buscarUsuarioPorId($_SESSION['usuario']->getId());

					$view -> show($model_subastas, $usuario);
				}

				public function eliminar_reserva(){
					$model = ReservasRespository::getInstance()-> eliminar_reserva();
					self::getInstance()-> listar_propiedades();
				}

				public function adjudicar_hot_sale(){
					$model = Hot_saleRepository::getInstance()-> adjudicar_hot_sale();
					if(!$model){

							self::getInstance()-> listar_hotsale();
					}
					self::getInstance()->Mostrar_pagina_principal();
				}
		}


?>
