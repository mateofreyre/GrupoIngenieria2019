<?php

Class AdminRepository extends PDORepository {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {

	}

	public function chequear_codigo($codigo){
  		$query = self::queryAll("SELECT * FROM administrador WHERE codigo = '{$codigo}'");
    	$res = $query->fetch(PDO::FETCH_ASSOC);
    	if(empty($res)){
    		$query = null;
      	$mensaje = "Codigo incorrecto, intentelo otra vez.";
      	echo "<script>";
      	echo "alert('$mensaje');";
      	echo "</script>";
      	return false;
    	}
    	$query = null;
    	return true;
  }
}

?>
