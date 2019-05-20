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
