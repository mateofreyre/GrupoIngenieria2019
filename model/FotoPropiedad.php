<?php


Class FotoPropiedad {

  private $id;
	private $id_propiedad;
  private $imagen;

  /**Constructor**/

public function __construct($id, $id_propiedad, $imagen){
  $this->id = $id;
  $this->id_propiedad = $id_propiedad;
  $this->imagen = $imagen;

}

public function getId() {
    return $this->id;
}

public function getIdPropiedad() {
    return $this->id_propiedad;
}


public function getImagen() {
    return $this->imagen;
}




}

?>
