<?php

Class SuscripcionRepository extends PDORepository {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {

	}

  public function chequear_precios(){
    $monto_normal = $_POST['monto_normal'];
    $monto_premium = $_POST['monto_premium'];
    self::getInstance()->queryAll("UPDATE suscripcion SET monto_normal='{$monto_normal}', monto_premium='{$monto_premium}'");
    $mensaje = "La operacion ha sido realizada con exito.";
    echo "<script>";
    echo "alert('$mensaje');";
    echo "</script>";
    return true;
  }

  public function devolver_precio(){
    $query=self::getInstance()->queryAll("SELECT * FROM suscripcion WHERE id = 1");
    foreach ($query as $row) {
			  	$suscripcion = new Suscripcion($row['monto_normal'], $row['monto_premium']);
			  	$suscripciones[] = $suscripcion;
			}
			return $suscripciones[0];
  }
}

?>
