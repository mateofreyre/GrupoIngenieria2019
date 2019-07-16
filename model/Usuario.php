<?php

//**Description of Usuario**//

Class Usuario {

  private $id;
	private $nombre;
	private $apellido;
	private $email;
	private $password;
	private $creditos;
	private $premium;
  private $fecha_registro;
//  private $foto;



    /**Constructor**/

	public function __construct($id,$nombre, $apellido, $email, $password, $creditos, $premium, $fecha_registro){
		$this->id = $id;
    $this->nombre = $nombre;
		$this->apellido = $apellido;
		$this->email = $email;
		$this->password = $password;
		$this->creditos = $creditos;
		$this->premium = $premium;
    $this->fecha_registro = $fecha_registro;
//    $this->foto = $foto;

	}

    /**Getters & Setters**/

    public function getId() {
        return $this->id;
    }

  /*  public function getFoto() {
        return $this->foto;
    }*/

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

    public function getFechaRegistro() {
        return $this->fecha_registro;
    }

    public function getCreditos() {
    	return $this->creditos;
    }

    public function getPremium() {
    	return $this->premium;
    }

    public function setPremium($boolean){
      	$this-> premium = $boolean;
    }
    public function cambiar_estado(){
  		$this->setPremium(!($this->getPremium()));
  	}

}

?>
