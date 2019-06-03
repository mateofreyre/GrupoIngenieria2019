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
							$mensaje = "Ya existe un evento para esa fecha(reserva)";
							echo "<script>";
							echo "alert('$mensaje');";
							echo "</script>";
		          return false;
		        }
        	}
				}
				$mensaje = "Subasta agregada exitosamente";
				echo "<script>";
				echo "alert('$mensaje');";
				echo "</script>";
        return true;

    }
    else{
      return true;
    }
  }

	public function informarBajaDeReservas($reservas){
		foreach ($reservas as $row) {
			$id_usuario = $row['id_usuario'];
			$usuario = UsuarioRepository::getInstance()->buscarUsuarioPorId($id_usuario);
			$nombre_usuario = $usuario->getNombre() . $usuario->getApellido();
			$mensaje = "Se le informo al usuario".$nombre_usuario."Que se dio de baja la reserva.";
			echo "<script>";
			echo "alert('$mensaje');";
			echo "</script>";

		}
	}

  public function agregar_reserva($fecha_desde, $fecha_hasta, $monto, $id_usuario, $id_propiedad){
    try{
        self::getInstance() -> queryAll("INSERT INTO alquiler(fecha_desde, fecha_hasta, monto, id_usuario, id_propiedad) VALUES ('{$fecha_desde}', '{$fecha_hasta}', '{$monto}', '{$id_usuario}', '{$id_propiedad}')");
        return true;
    }
    catch(PDO $e){
      $mensaje = "Se produjo un error y no se pudo agregar la reserva";
      echo "<script>";
      echo "alert('$mensaje');";
      echo "</script>";
      return false;
    }
}

}
?>
