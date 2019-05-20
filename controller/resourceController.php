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
        $view->show();
    }

    //ADMINISTRADOR

    public function chequear_administrador(){
    	$codigo = $_POST['codigo'];
    	$model = AdminRepository::getInstance()-> chequear_codigo($codigo);
    	if($model){
    		self::getInstance()->listar_propiedades();
    	}
    	else{
    		self::getInstance()-> home();
    	}
    }



		//PROPIEDADES ABM Y LISTAR
		public function listar_propiedades(){
			$model = PropiedadesRepository::getInstance()->listar_propiedades();
			$view = new Listar_propiedades();
			$view -> show($model);
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
			self::getInstance()-> listar_propiedades();
		}

		public function cambiar_estado_hotSale(){
			$model = PropiedadesRepository::getInstance()-> cambiar_estado_hotSale();
			self::getInstance()->listar_propiedades();
		}


		public function modificar_propiedad(){
			$model = PropiedadesRepository::getInstance()->buscar_propiedad();
			$view = new Modificar_datos_propiedad();
			$view -> show($model);
		}

		public function check_modificar_propiedad(){
			$model = PropiedadesRepository::getInstance()->modificar_datos_propiedad();
			self::getInstance()-> listar_propiedades();
		}



		//SUBASTAS

		public function listar_subastas(){
			$model = SubastaRepository::getInstance()->listar_subastas();
			$view = new Listar_subastas();
			$view -> show($model);
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
			$mejor_oferta = PujadorRepository::getInstance()->listar_ofertas_by_propiedad($subasta->getIdPropiedad());
			$view = new Detalle_Subasta();
			if(!empty($mejor_oferta)){
				$view -> show($subasta, $mejor_oferta[0]->getMonto());
			}else{
				$view -> show($subasta, 0);
			}
		}

		

		public function agregar_oferta(){
			$model = PujadorRepository::getInstance()-> agregar_oferta();
			self::getInstance()-> listar_subastas();
		}

	//	$model_subasta = SubastaRespository::getInstance()->buscar_mejor_postor($model_propiedad);
	//	$costo_actual = $model['monto'];

			}

?>
