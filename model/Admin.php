<?php

//**Description of Admin**//

Class Admin {
	private $nombre;
	private $apellido;
	private $email;
	private $password;
	private $fecha_nacimiento;
	private $codigo;

	/**Constructor**/

	public function __construct($nombre, $apellido, $email, $password, $fecha_nacimiento, $codigo){
		$this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->email = $email;
		$this->password = $password;
		$this->fecha_nacimiento = $fecha_nacimiento;
		$this->codigo = $codigo;
	}

	/**Getters & Setters**/

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

    public function getCodigo() {
    	return $this->codigo;
    }
}

?>