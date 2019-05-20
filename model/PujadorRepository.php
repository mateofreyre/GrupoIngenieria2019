<?php

Class PujadorRepository extends PDORepository {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {

	}

    //**AGREGAR OFERTA**//

    public function agregar_oferta(){
        $monto = $_POST['monto'];
        $id_subasta = $_POST['id_subasta'];
        $id_usuario = $_POST['id_usuario'];


        try{
          	$query = self::getInstance()->queryAll("INSERT INTO usuario_subasta (monto, id_subasta, id_usuario) VALUES ('{$monto}', '{$id_subasta}', '{$id_usuario}')");
						$mensaje = "Se agrego una oferta";
						echo "<script>";
						echo "alert('$mensaje');";
						echo "</script>";
						return false;
						return true;
        }
        catch(PDO $e){
          $mensaje = "Se produjo un error y no se pudo agregar la oferta";
          echo "<script>";
          echo "alert('$mensaje');";
          echo "</script>";
          return false;
        }
    }

    //**LISTAR OFERTAS**//

    public function listar_ofertas_by_propiedad($id_propiedad){
      try {
        $ofertas = [];
        $query = PujadorRepository::getInstance()->queryAll("SELECT * FROM usuario_subasta WHERE id_propiedad = '{$id_propiedad}' ORDER BY monto DESC");
        foreach ($query as $row) {
          $oferta = new Pujador($row['id'], $row['monto'], $row['id_propiedad'], $row['id_usuario']);
          $ofertas[]=$oferta;
        }
        $query = null;
        return $ofertas;
      }
      catch (PDOException $e) {
         print "¡Error!: " . $e->getMessage() . "<br/>";
         die();
      }
    }

    //**ELIMINAR OFERTAS**//

    public function eliminar_ofertas_by_propiedad($id_propiedad){
      try {
        $ofertas = [];
        $query = PujadorRepository::getInstance()->queryAll("DELETE FROM usuario_subasta WHERE id_propiedad = '{$id_propiedad}'");
        return true;
      }
      catch (PDOException $e) {
         print "¡Error!: " . $e->getMessage() . "<br/>";
         die();
      }
    }

  }

?>
