<?php

//**Description of Admin**//

Class Admin {
	private $codigo;

	/**Constructor**/

	public function __construct($codigo){
		$this->codigo = $codigo;
	}

	/**Getters & Setters**/

    public function getCodigo() {
    	return $this->codigo;
    }
}

?>
