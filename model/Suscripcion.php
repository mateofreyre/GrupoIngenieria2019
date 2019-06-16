<?php

//**Description of Suscripcion**//

Class Suscripcion {

	private $id;
	private $monto_normal;
	private $monto_premium;

	/**Constructor**/

	public function __construct($monto_normal, $monto_premium) {
		$this->monto_normal = $monto_normal;
		$this->monto_premium = $monto_premium;
	}

	/**Getters & Setters**/

	public function getId() {
		return $this->id;
	}

	public function getMonto_normal() {
		return $this->monto_normal;
	}

  public function getMonto_premium() {
		return $this->monto_premium;
	}
}

?>
