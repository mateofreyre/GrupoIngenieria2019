<?php

//**Description of Usuario**//

Class User {

    private $id;
	private $nombre;
	private $apellido;
	private $email;
	private $password;
	private $fecha_nacimiento;
	private $creditos;
	private $premium;

    /**Constructor**/

	public function __construct($id,$nombre, $apellido, $email, $password, $fecha_nacimiento, $creditos, $premium){
		$this->id = $id;
        $this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->email = $email;
		$this->password = $password;
		$this->fecha_nacimiento = $fecha_nacimiento;
		$this->creditos = $creditos;
		$this->premium = $premium;
	}

    /**Getters & Setters**/

    public function getId() {
        return $this->id;
    }

    public function getNombre() {
        return $this->nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }

	public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getFechaNacimiento() {
        return $this->fecha_nacimiento;
    }

    public function getCreditos() {
    	return $this->creditos;
    }

    public function getPremium() {
    	return $this->premium;
    }

}

?>