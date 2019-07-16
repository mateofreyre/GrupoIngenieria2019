<?php



Class Hot_sale {

  private $id;
	private $fecha_desde;
  private $id_propiedad;



    /**Constructor**/

	public function __construct($id,$id_propiedad,$fecha_desde){
		$this->id = $id;
    $this->id_propiedad = $id_propiedad;
    $this->fecha_desde = $fecha_desde;


	}

    /**Getters & Setters**/

    public function getId() {
        return $this->id;
    }

    public function getFechaDesde(){
      return $this->fecha_desde;
    }

    public function getIdPropiedad(){
      return $this->id_propiedad;
      
    }


}

?>
