<?php

Class SubastaRepository extends PDORepository {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {

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
		self::getInstance()->queryAll("INSERT INTO subasta(id_propiedad,fecha_desde,fecha_hasta) VALUES ('{$id_propiedad}','{$fecha_desde}','{$fecha_hasta}')");
	  return true;
	}

	public function detalle_subasta(){
		//recuperar datos de la fecha ingresada y id de propiedad
		$id_subasta = $_GET['id'];
		$query = self::getInstance()->queryAll("SELECT * FROM subasta WHERE id = '{$id_subasta}'");
		if(!empty($query)){
			$subastas = [];
			foreach ($query as $row) {
			  	$subasta = new Subasta($row['id'], $row['fecha_desde'], $row['fecha_hasta'], $row['id_propiedad']);
			  	$subastas[] = $subasta;
			}
			return $subastas[0];
		}else{
		  return false;
		}
	}
		// foreach ($query as $row) {
		// 	return new Subasta($row['id'], $row['fecha_desde'], $row['fecha_hasta'], $row['id_propiedad']);
		// }
	  	// return $subasta;

 	public function listar_subastas(){
		try {
			$subastas = [];
			$query = SubastaRepository::getInstance()->queryAll("SELECT * FROM subasta");
			foreach ($query as $row) {
				$subasta = new Subasta($row['id'], $row['fecha_desde'], $row['fecha_hasta'], $row['id_propiedad']);
				$subastas[]=$subasta;
			}
			$query = null;
			return $subastas;
		}
		catch (PDOException $e) {
			 print "¡Error!: " . $e->getMessage() . "<br/>";
			 die();
		}
	}

	public function eliminar_subasta(){
		$id = $_GET['id'];
		self::getInstance()->queryAll("DELETE FROM subasta WHERE id = '{$id}'");
		/* me fijo si el atributo del monto pujado para esa subasta es distinto de 0 y devuelvo en "var".
		hago un if("var"){
			si es verdadero significa que hay un pujador,le informo de que gano la subasta y se la adjudico
		cuando sale del if cierro la subasta ya que si no hay pujador la voy a tener que eliminar igual.
		} */
		$mensaje = "La subasta ha sido eliminada";
		echo "<script>";
		echo "alert('$mensaje');";
		echo "</script>";
		return true;
	}

	public function cancelar_subasta() {
		$id = $_GET['id'];
		self::getInstance()->queryAll("DELETE FROM subasta WHERE id = '{$id}'");
		$mensaje = "La subasta ha sido cancelada";
		echo "<script>";
		echo "alert('$mensaje');";
		echo "</script>";
		return true;
	}

	public function finalizar_subasta() {
		$subasta = self::getInstance()->detalle_subasta();
		$id_propiedad = $subasta->getIdPropiedad();
		$id_subasta = $subasta->getId();
		$ofertas = PujadorRepository::getInstance()->listar_ofertas_by_subasta($id_subasta);
		$id_usuario = $ofertas[0]->getIdUsuario();
		$usuario = UsuarioRepository::getInstance()->obtener_usuario_by_id($id_usuario);
		$mensaje = "La subasta ha finalizado, el ganador es el usuario {$usuario->getNombre()} {$usuario->getApellido()}";
		ReservasRespository::getInstance()->agregar_reserva($subasta->getFechaDesde(), $subasta->getFechaHasta(), $ofertas[0]->getMonto(), $id_usuario, $id_propiedad);
		PujadorRepository::getInstance()->eliminar_ofertas_by_subasta($id_subasta);
		self::getInstance()->queryAll("DELETE FROM subasta WHERE id = '{$subasta->getId()}'");
		echo "<script>";
		echo "alert('$mensaje');";
		echo "</script>";
		return true;
	}

}
?>
