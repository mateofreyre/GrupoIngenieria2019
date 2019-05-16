<?php

Class SubastaRepository extends PDORepository {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct {

	}

	public function chequear_subasta(){
	//	$model_propiedad = PropiedadesRepository::getInstance()->buscar_propiedad();
		$model_reservas = ReservasRespository::getInstance()->chequear_superposicion_fechas();
		if($model_reservas){
			self::getInstance()->agregar_subasta();
			return true;
		}
		else{
			return false;
		}
	}

	public function agregar_subasta(){
		//recuperar datos de la fecha ingresada y id de propiedad
		$id_propiedad = $_GET['id'];
		$fecha_desde = $_POST['fecha'];
		//Se le agregan 7 dias a la fecha ingresada
		$nuevafecha = strtotime ( '+7 day' , strtotime ($fecha_desde ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		$fecha_hasta = $nuevafecha;
		self::getInstance()->queryAll("INSERT INTO subasta(id_propiedad,fecha_desde,fecha_hasta) VALUES ($id_propiedad,$fecha_desde,$fecha_hasta)");
	  return true;
	}



}
?>
