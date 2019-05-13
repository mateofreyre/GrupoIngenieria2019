<?php

//**Description of Pujador**//

Class Pujador {

	private $id;
	private $monto;
	private $id_subasta;
	private $id_usuario;

	/**Constructor**/

	public function __construct($id, $monto, $id_subasta, $id_usuario) {
		$this->id = $id;
		$this->monto = $monto;
		$this->id_subasta = $id_subasta;
		$this->id_usuario = $id_usuario;
	}

	/**Getters & Setters**/

	public function getId() {
		return $this->id;
	}

	public function getMonto() {
		return $this->monto;
	}

	public function getMonto() {
		return $this->monto;
	}

	public function getIdSubasta() {
		return $this->id_subasta;
	}

	public function getIdUsuario() {
		return $this->id_usuario;
	}

}

?>
