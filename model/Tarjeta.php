<?php

//**Description of Tarjeta**//

Class Tarjeta {

  private $id;
	private $numero;
	private $mes_vencimiento;
  private $year_vencimiento;
	private $id_titular;

    /**Constructor**/

	public function __construct($id, $numero, $mes_vencimiento, $year_vencimiento, $id_titular) {
        $this->id = $id;
        $this->numero = $numero;
        $this->mes_vencimiento = $mes_vencimiento;
        $this->year_vencimiento = $year_vencimiento;
        $this->id_titular = $id_titular;
    }

    /**Getters & Setters**/

    public function getId() {
        return $this->id;
    }

    public function getNumero() {
    	return $this->numero;
    }

    public function getMesVencimiento() {
    	return $this->mes_vencimiento;
    }


    public function getYearVencimiento() {
    	return $this->year_vencimiento;
    }

  

    public function getIdTitular() {
    	return $this->id_titular;
    }

}

?>
