<?php

//**Description of Propiedades**//

Class Propiedades {

	private $id;
	private $nombre;
	private $lugar;
	private $monto_normal
	private $hot_sale;
	private $monto_base

	/**Constructor**/

	public function __construct($id, $nombre, $lugar, $monto_normal, $hot_sale, $monto_base) {
		$this->id = $id;
		$this->nombre = $nombre;
		$this->lugar = $lugar;
		$this->monto_normal = $monto_normal;
		$this->hot_sale = $hot_sale;
		$this->monto_base = $monto_base;
	}

	/**Getters & Setters**/

	public function getId() {
		return $this->id;
	}

	public function getNombre() {
		return $this->nombre;
	}

	public function getLugar() {
		return $this->lugar;
	}

	public function getMontoNormal() {
		return $this->monto_normal;
	}

	public function getHotSale() {
		return $this->hot_sale;
	}


	public function getMontoBase() {
		return $this->monto_base;
	}

}

?>
