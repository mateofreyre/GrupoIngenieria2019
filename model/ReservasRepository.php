<?php

Class ReservasRespository extends PDORepository {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {

	}

	public function chequear_superposicion_fechas(){
    //recuperar datos de la fecha ingersada y id de propiedad
    $id_propiedad = $_GET['id'];
    $fecha_desde = $_POST['fecha'];
    //Se le agregan 7 dias a la fecha ingresada
    $nuevafecha = strtotime ( '+7 day' , strtotime ($fecha_desde ) ) ;
    $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
    $fecha_hasta = $nuevafecha;


    $query = self::getInstance()->queryAll("SELECT * FROM alquiler WHERE id_propiedad = '{$id_propiedad}'");
    if(!empty($query)){
        $alquileres= [];
        foreach ($query as $row) {
          $alquiler = new Reservas($row['monto'], $row['fecha_desde'], $row['fecha_hasta'], $row['id_propiedad'],  $row['id_usuario']);
          $alquileres[] = $alquiler;

        }
				if(!empty($alquiler)){
		      foreach ($alquileres as $alquier) {
						if($alquiler->seRealizaDentroDe($fecha_desde, $fecha_hasta)){
		          return false;
		        }
        	}
				}
        return true;

    }
    else{
      return true;
    }
  }



}
?>
