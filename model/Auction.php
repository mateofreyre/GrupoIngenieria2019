<?php

//**Description of Auction**//

Class Auction {

	private $id;
	private $fecha_desde;
	private $fecha_hasta;
	private $id_propiedad;

	/**Constructor**/

	public function __construct($id, $fecha_desde, $fecha_hasta, $id_propiedad) {
		$this->id = $id;
		$this->fecha_desde = $fecha_desde;
		$this->fecha_hasta = $fecha_hasta;
		$this->id_propiedad = $id_propiedad;
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
}

?>