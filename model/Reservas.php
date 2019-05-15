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

	public function __construct($id, $monto, $fecha_desde, $fecha_hasta, $id_propiedad, $id_usuario) {
		$this->id = $id;
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
		return (self->seEncuentraDentro($fecha_desde,$fecha_hasta) OR (self->desfazadoHaciaIzquierda($fecha_desde,$fecha_hasta)) OR (self->desfazadoHaciaDerecha($fecha_desde,$fecha_hasta)));
	}

	public function seEncuentraDentro($fecha_desde,$fecha_hasta){
		return (self->yoMeEncuentroDentro($fecha_desde,$fecha_hasta) OR (self->seEncuentraDentro($fecha_desde,$fecha_hasta)));
	}

	public function yoMeEncuentroDentro($fecha_desde,$fecha_hasta){
		return (self->getFechaDesde > $fecha_desde) AND (self->getFechaHasta < $fecha_hasta);
	}

	public function seEncuentraDentro($fecha_desde,$fecha_hasta){
		return (self->getFechaDesde < $fecha_desde) AND (self->getFechaHasta > $fecha_hasta);
	}

	public function desfazadoHaciaIzquierda($fecha_desde, $fecha_hasta){
		return (self-> getFechaDesde > $fecha_desde) AND (self-> getFechaHasta < $fecha_hasta);
	}

	public function desfazadoHaciaDerecha($fecha_Desde, $fecha_hasta){
		return (self-> getFechaDesde < $fecha_desde) AND (self-> getFechaHasta > $fecha_hasta);
	}

}

?>
