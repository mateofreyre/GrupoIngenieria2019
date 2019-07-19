<?php

//**Description of Reservas**//

Class Reservas {

	private $id;
	private $monto;
	private $fecha_desde;
	private $fecha_hasta;
	private $id_propiedad;
	private $id_usuario;
	private $deshabilitado;
	private $nombre_propiedad;

	/**Constructor**/

	public function __construct($id, $fecha_desde, $fecha_hasta, $id_propiedad, $id_usuario, $deshabilitado, $nombre_propiedad) {
		$this->id = $id;
		$this->fecha_desde = $fecha_desde;
		$this->fecha_hasta = $fecha_hasta;
		$this->id_propiedad = $id_propiedad;
		$this->id_usuario = $id_usuario;
		$this->deshabilitado = $deshabilitado;
		$this->nombre_propiedad = $nombre_propiedad;

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

	public function getDeshabilitado(){
		return $this->deshabilitado;
	}
	public function getNombre_propiedad(){
			return $this->nombre_propiedad;
}
}

?>
