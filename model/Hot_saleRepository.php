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

		$mensaje = "La subasta ha sido eliminada";
		echo "<script>";
		echo "alert('$mensaje');";
		echo "</script>";
		return true;

	}

}
?>
