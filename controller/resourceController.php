<?php


class ResourceController {

	private static $instance;
	public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

		public function home(){
        $view = new Home();
        $view->show();
    }

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
			self::getInstance-> home();
		}

			}

?>
