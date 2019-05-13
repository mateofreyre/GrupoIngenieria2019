<?php


class ResourceController {

	private static $instance;
	public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

		public function formulario_agregar_propiedad(){
			$view = new Agregar_propiedad();
			$view -> show();
		}

		public function check_agregar_propiedad(){
			$model = PropertieRepository::getInstance()->agregar_propiedad();
			self::getInstance-> home();
		}

			}

?>
