<?php

//**Description of Cards**//

Class Card {

    private $id;
	private $numero;
	private $fecha_vencimiento;
	private $codigo;
	private $id_titular;

    /**Constructor**/

	public function __construct($id, $numero, $fecha_vencimiento, $codigo, $id_titular) {
        $this->id = $id;
        $this->numero = $numero;
        $this->fecha_vencimiento = $fecha_vencimiento;
        $this->codigo = $codigo;
        $this->id_titular = $id_titular;
    }

    /**Getters & Setters**/

    public function getId() {
        return $this->id;
    }
    
    public function getNumero() {
    	return $this->numero;
    }

    public function getFechaVencimiento() {
    	return $this->fecha_vencimiento;
    }

    public function getCodigo() {
    	return $this->codigo;
    }

    public function getIdTitular() {
    	return $this->id_titular;
    }

}

?>