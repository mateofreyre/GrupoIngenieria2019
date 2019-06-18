<?php

//**Description of Reservas**//

Class Reservas {

	private $id;
	private $monto;
	private $fecha_desde;
	private $fecha_hasta;
	private $id_propiedad;
	private $id_usuario;

	/**Constructor**/

	public function __construct($monto, $fecha_desde, $fecha_hasta, $id_propiedad, $id_usuario) {
		$this->monto = $monto;
		$this->fecha_desde = $fecha_desde;
		$this->fecha_hasta = $fecha_hasta;
		$this->id_propiedad = $id_propiedad;
		$this->id_usuario = $id_usuario;
	}

	/**Getters & Setters**/

	public function getId() {
		return $this->id;
	}

	public function getMonto() {
		return $this->monto;
	}

	public function getFechaDesde() {
		return $this->fecha_desde;
	}

	public function getFechaHasta() {
		return $this->fecha_hasta;
	}

	public function getIdPropiedad() {
		return $this->id_propiedad;
	}

	public function getIdUsuario() {
		return $this->id_usuario;
	}

	public function seRealizaDentroDe($fecha_desde){
		return ($this->getFechaDesde()) == $fecha_desde;
	}

}

?>
