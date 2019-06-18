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

	public function chequear_superposicion_fechas($fecha_desde){
    //recuperar datos de la fecha ingersada y id de propiedad
    $id_propiedad = $_GET['id'];
    //Se le agregan 7 dias a la fecha ingresada
    $nuevafecha = strtotime ( '+6 day' , strtotime ($fecha_desde ) ) ;
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
						if($alquiler->seRealizaDentroDe($fecha_desde)){
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
public function agregar($fecha_desde){
	//recuperar datos de la fecha ingresada y id de propiedad
	$id_propiedad = $_GET['id'];
	//Se le agregan 7 dias a la fecha ingresada
	$nuevafecha = strtotime ( '+6 day' , strtotime ($fecha_desde ) ) ;
	$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
	$fecha_hasta = $nuevafecha;
	self::getInstance()-> agregar_reserva($fecha_desde,$fecha_hasta,0,$_SESSION['id'],$id_propiedad);
	return true;
}

public function chequear_reserva(){
//	$model_propiedad = PropiedadesRepository::getInstance()->buscar_propiedad();
	$fecha_ingresada = $_POST['fecha'];
	$fecha_lunes = SubastaRepository::getInstance()->llevar_fecha_a_lunes($fecha_ingresada);
	$model_reservas = ReservasRespository::getInstance()->chequear_superposicion_fechas($fecha_lunes);
	$model_subastas = self::getInstance() -> chequear_superposicion_fechas($fecha_lunes);
	if($model_reservas AND $model_subastas){
		self::getInstance()->agregar($fecha_lunes);
		$nuevafecha = strtotime ( '+6 day' , strtotime ($fecha_lunes ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		$fecha_hasta = $nuevafecha;
		$mensaje = "Reserva agregada exitosamente desde la fecha:".$fecha_lunes."Hasta la fecha:".$fecha_hasta;
		echo "<script>";
		echo "alert('$mensaje');";
		echo "</script>";

		return true;
	}
	else{
		return false;
	}
}

public function llevar_fecha_a_lunes($fecha){
		$dia = self::getInstance()->saber_dia($fecha);
		switch ($dia) {
			case 'Martes':
				$nueva = strtotime ( '-1 day' , strtotime ($fecha ) ) ;
				return date ( 'Y-m-d' , $nueva );
				break;
			case 'Miercoles':
				$nueva = strtotime ( '-2 day' , strtotime ($fecha ) ) ;
				return date ( 'Y-m-d' , $nueva );
				break;
			case 'Jueves':
				$nueva = strtotime ( '-3 day' , strtotime ($fecha ) ) ;
				return date ( 'Y-m-d' , $nueva );
				break;
			case 'Viernes':
				$nueva = strtotime ( '-4 day' , strtotime ($fecha ) ) ;
				return date ( 'Y-m-d' , $nueva );
				break;
			case 'Sabado':
				$nueva = strtotime ( '-5 day' , strtotime ($fecha ) ) ;
				return date ( 'Y-m-d' , $nueva );
				break;
			case 'Domingo':
				$nueva = strtotime ( '-6 day' , strtotime ($fecha ) ) ;
				return date ( 'Y-m-d' , $nueva );
				break;
		}
		return $fecha;
}

function saber_dia($nombredia) {
	$dias = array('Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado');
	$fecha = $dias[date('N', strtotime($nombredia))];
	return $fecha;
}




}
?>
