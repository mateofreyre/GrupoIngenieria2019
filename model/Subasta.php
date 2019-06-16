<?php

//**Description of Subasta**//

Class Subasta {

	private $id;
	private $fecha_desde;
	private $fecha_hasta;
	private $id_propiedad;
	private $monto_base;
	private $lugar;

	/**Constructor**/

	/*public function __construct($id, $fecha_desde, $fecha_hasta, $id_propiedad, $monto_base) {
		$this->id = $id;
		$this->fecha_desde = $fecha_desde;
		$this->fecha_hasta = $fecha_hasta;
		$this->id_propiedad = $id_propiedad;
		$this->monto_base = $monto_base;
	}*/

	public function __construct($id, $fecha_desde, $fecha_hasta, $id_propiedad, $monto_base, $lugar) {
		$this->id = $id;
		$this->fecha_desde = $fecha_desde;
		$this->fecha_hasta = $fecha_hasta;
		$this->id_propiedad = $id_propiedad;
		$this->monto_base = $monto_base;
		$this->lugar= $lugar;
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

	public function getLugar(){
		return $this->lugar;
	}

	public function seRealizaDentroDe($fecha_desde, $fecha_hasta){
		return ($this->seEncuentraDentro($fecha_desde,$fecha_hasta) OR ($this->desfazadoHaciaIzquierda($fecha_desde,$fecha_hasta)) OR ($this->desfazadoHaciaDerecha($fecha_desde,$fecha_hasta)));
	}

	public function seEncuentraDentro($fecha_desde,$fecha_hasta){
		return ($this->yoMeEncuentroDentro($fecha_desde,$fecha_hasta) OR ($this->elSeEncuentraDentro($fecha_desde,$fecha_hasta)));
	}

	public function yoMeEncuentroDentro($fecha_desde,$fecha_hasta){
		return ($this->getFechaHasta() > $fecha_desde) AND ($this->getFechaHasta() < $fecha_hasta);
	}

	public function elSeEncuentraDentro($fecha_desde,$fecha_hasta){
		return ($this->getFechaDesde() < $fecha_desde) AND ($this->getFechaHasta() > $fecha_hasta);
	}

	public function desfazadoHaciaIzquierda($fecha_desde, $fecha_hasta){
		return ($this->getFechaDesde() > $fecha_desde) AND ($this->getFechaHasta() < $fecha_hasta);
	}

	public function desfazadoHaciaDerecha($fecha_desde, $fecha_hasta){
		return ($this->getFechaDesde() < $fecha_desde) AND ($this->getFechaHasta() > $fecha_hasta);
	}
}

?>
