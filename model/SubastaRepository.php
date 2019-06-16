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
		$model_subastas = self::getInstance() -> chequear_superposicion_fechas();
		if($model_reservas AND $model_subastas){
			self::getInstance()->agregar_subasta();
			return true;
		}
		else{
			return false;
		}
	}

	public function chequear_superposicion_fechas(){
		//recuperar datos de la fecha ingersada y id de propiedad
		$id_propiedad = $_GET['id'];
		$fecha_desde = $_POST['fecha'];
		//Se le agregan 7 dias a la fecha ingresada
		$nuevafecha = strtotime ( '+7 day' , strtotime ($fecha_desde ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		$fecha_hasta = $nuevafecha;

		$query = self::getInstance()->queryAll("SELECT * FROM subasta WHERE id_propiedad = '{$id_propiedad}'");
		if(!empty($query)){
			$subastas = [];
			foreach ($query as $row) {
			  	$subasta = new Subasta($row['id'], $row['fecha_desde'], $row['fecha_hasta'], $row['id_propiedad'], $row['monto_base'],0);
			  	$subastas[] = $subasta;
			}
				if(!empty($subastas)){
					foreach ($subastas as $subasta) {
						if($subasta->seRealizaDentroDe($fecha_desde, $fecha_hasta)){
							$mensaje = "Ya existe un evento para esa fecha (subasta)";
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




	public function agregar_subasta(){
		//recuperar datos de la fecha ingresada y id de propiedad
		$id_propiedad = $_GET['id'];
		$fecha_desde = $_POST['fecha'];
		$monto = $_POST['monto_base'];
		//Se le agregan 7 dias a la fecha ingresada
		$nuevafecha = strtotime ( '+7 day' , strtotime ($fecha_desde ) ) ;
		$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
		$fecha_hasta = $nuevafecha;
		self::getInstance()->queryAll("INSERT INTO subasta(id_propiedad,fecha_desde,fecha_hasta,monto_base) VALUES ('{$id_propiedad}','{$fecha_desde}','{$fecha_hasta}','{$monto}')");
	  return true;
	}

	public function detalle_subasta(){
		//recuperar datos de la fecha ingresada y id de propiedad
		$id_subasta = $_GET['id'];
		$query = self::getInstance()->queryAll("SELECT * FROM subasta WHERE id = '{$id_subasta}'");
		foreach ($query as $row) {
			  	$subasta = new Subasta($row['id'], $row['fecha_desde'], $row['fecha_hasta'], $row['id_propiedad'], $row['monto_base'],0);
			  	$subastas[] = $subasta;
			}
			return $subastas[0];

	}
		// foreach ($query as $row) {
		// 	return new Subasta($row['id'], $row['fecha_desde'], $row['fecha_hasta'], $row['id_propiedad']);
		// }
	  	// return $subasta;

 	public function listar_subastas(){
		try {
			$subastas = [];
			$query = SubastaRepository::getInstance()->queryAll("SELECT * FROM propiedad, subasta  WHERE subasta.id_propiedad = propiedad.id");
			foreach ($query as $row) {;
				$subasta = new Subasta($row['id'], $row['fecha_desde'], $row['fecha_hasta'], $row['id_propiedad'], $row['monto_base'], $row['nombre']);
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
		PujadorRepository::getInstance()->eliminar_ofertas_by_subasta($id);
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

	public function informarBajaDeSubastas($subastas){
		foreach ($subastas as $row) {
			$id_usuario = $row['id_usuario'];
			$usuario = UsuarioRepository::getInstance()->buscarUsuarioPorId($id_usuario);
			$nombre_usuario = $usuario->getNombre() . $usuario->getApellido();
			$mensaje = "Se le informo al usuario".$nombre_usuario."Que se dio de baja la subasta.";
			echo "<script>";
			echo "alert('$mensaje');";
			echo "</script>";

		}
	}

	public function cancelar_subasta() {
		$id = $_GET['id'];
		PujadorRepository::getInstance()->eliminar_ofertas_by_subasta($id);
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
		if (!empty($ofertas)){
			$id_usuario = $ofertas[0]->getIdUsuario();
			$usuario = UsuarioRepository::getInstance()->obtener_usuario_by_id($id_usuario);
			$mensaje = "La subasta ha finalizado, el ganador es el usuario {$usuario->getNombre()} {$usuario->getApellido()}";
			ReservasRespository::getInstance()->agregar_reserva($subasta->getFechaDesde(), $subasta->getFechaHasta(), $ofertas[0]->getMonto(), $id_usuario, $id_propiedad);
			PujadorRepository::getInstance()->eliminar_ofertas_by_subasta($id_subasta);
			$credito_actualizado = $usuario->getCreditos() - 1;
			UsuarioRepository::getInstance()->queryAll("UPDATE usuario SET creditos='{$credito_actualizado}' WHERE id = '{$id_usuario}'");
			self::getInstance()->queryAll("DELETE FROM subasta WHERE id = '{$subasta->getId()}'");
			echo "<script>";
			echo "alert('$mensaje');";
			echo "</script>";
		}else{
			$mensaje = "La subasta ha finalizado, no hay ganadores";
			echo "<script>";
			echo "alert('$mensaje');";
			echo "</script>";
		}
		return true;
	}

}
?>
