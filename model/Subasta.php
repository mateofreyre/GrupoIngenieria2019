<?php

//**Description of Subasta**//

Class Subasta {

	private $id;
	private $fecha_desde;
	private $fecha_hasta;
	private $id_propiedad;
	private $monto_base;

	/**Constructor**/

	public function __construct($id, $fecha_desde, $fecha_hasta, $id_propiedad, $monto_base) {
		$this->id = $id;
		$this->fecha_desde = $fecha_desde;
		$this->fecha_hasta = $fecha_hasta;
		$this->id_propiedad = $id_propiedad;
		$this->monto_base = $monto_base;
	}

	/**Getters & Setters**/

	public function getId() {
		return $this->id;
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

	public function getMontoBase(){
		return $this->monto_base;
	}
}

?>
