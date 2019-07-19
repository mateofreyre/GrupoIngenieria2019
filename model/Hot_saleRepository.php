<?php

Class Hot_saleRepository extends PDORepository {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {

	}

	public function detalle_hot_sale(){
		$id_hot_sale = $_GET['id'];

		$query = self::getInstance()->queryAll("SELECT * FROM hot_sale WHERE id = '{$id_hot_sale}'");
		foreach ($query as $row) {
			  	$hot_sale = new Hot_sale($row['id'], $row['id_propiedad'],$row['fecha_desde']);
			}
			return $hot_sale;
	}
	public function eliminar_hot_sale(){
		$id_hot_sale = $_GET['id'];

		self::getInstance()->queryAll("DELETE FROM hot_sale WHERE id = '{$id_hot_sale}'");

		$mensaje = "El hot sale ha sido eliminado";
		echo "<script>";
		echo "alert('$mensaje');";
		echo "</script>";
		return true;

	}

	public function adjudicar_hot_sale(){
		//	$model_propiedad = PropiedadesRepository::getInstance()->buscar_propiedad();
				$id_hot_sale = $_GET['id'];
				$hot_sale = self::getInstance()->queryAll("SELECT * FROM hot_sale WHERE id = '{$id_hot_sale}'");
				foreach ($hot_sale as $row ) {
					$fecha_ingresada = $row['fecha_desde'];
					$id_propiedad = $row['id_propiedad'];

				}
				$fecha_lunes = SubastaRepository::getInstance()->llevar_fecha_a_lunes($fecha_ingresada);
				$segundoViaje = ReservasRespository::getInstance()-> chequear_fecha_duplicada($_SESSION['id'],$fecha_lunes);
				if($segundoViaje){
					$mensaje = "No se pudo realizar la reserva por ya tener otra reserva para esa semana";
					echo "<script>";
					echo "alert('$mensaje');";
					echo "</script>";
					return false;
				}
				$model_reservas = ReservasRespository::getInstance()->chequear_superposicion_fechas($fecha_lunes);
				$model_subastas = SubastaRepository::getInstance() -> chequear_superposicion_fechas($fecha_lunes);
				if($model_reservas AND $model_subastas){

					ReservasRespository::getInstance()->agregar_hot_sale($fecha_lunes, $id_propiedad);
					$nuevafecha = strtotime ( '+6 day' , strtotime ($fecha_lunes ) ) ;
					$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
					$fecha_hasta = $nuevafecha;
					$mensaje = "Reserva agregada exitosamente desde la fecha:".$fecha_lunes."Hasta la fecha:".$fecha_hasta;
					echo "<script>";
					echo "alert('$mensaje');";
					echo "</script>";
					self::getInstance()->eliminar_hot_sale();

					return true;
				}
				else{
					return false;
				}
		}


		public function crear_hot_sale($fecha_desde, $id_propiedad){
			self::getInstance()-> queryAll("INSERT INTO hot_sale(id_propiedad,fecha_desde) VALUES('{$id_propiedad}', '{$fecha_desde}')");
			$mensaje = "Hot sale creado correctamente";
			echo "<script>";
			echo "alert('$mensaje');";
			echo "</script>";
		}

}
?>
