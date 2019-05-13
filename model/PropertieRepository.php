<?php

Class PropiedadesRepository extends PDORepository {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct {

	}

    //**AGREGAR PROPIEDAD**//

    public function agregar_propiedad(){
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $lugar = $_POST['lugar'];
        $monto_normal = $_POST['monto_normal'];
        $hot_sale = $_POST['hot_sale'];
        $monto_base = $_POST['monto_base'];
        try{
          PropertieRepository::getInstance() -> queryAll("INSERT INTO propiedad (id, nombre, lugar, monto_normal, hotsale, monto_base) VALUES ('$id', $nombre', '$lugar', '$monto_normal', '$hot_sale', '$monto_base')");
          $mensaje = "Propiedad agregada exitosamente";
          echo "<script>";
          echo "alert('$mensaje');";
          echo "</script>";
          return true;
        }
        catch(PDO $e){
          $mensaje = "Se produjo un error y no se pudo agregar la propiedad";
          echo "<script>";
          echo "alert('$mensaje');";
          echo "</script>";
          return false;
        }
    }

    //**LISTAR PROPIEDADES**//

    public function listar_propiedades(){
      try {
        $propiedades = [];
        $query = PropertieRepository::getInstance()->queryAll("SELECT * FROM Propiedad ");
        foreach ($query as $row) {
          $propiedad = new Propertie($row['id'], $row['nombre'], $row['lugar'], $row['monto_normal'], $row['hot_sale'], $row['monto_base']);
          $propiedades[]=$propiedad;
        }
        $query = null;
        return $propiedades;
      }
      catch (PDOException $e) {
         print "¡Error!: " . $e->getMessage() . "<br/>";
         die();
      }
    }

    //** BUSCAR PROPIEDAD **//

    public function buscar_propiedad($nombre_propiedad){
      try {
          $query = PropertieRepository::getInstance()->queryAll("SELECT * FROM viaje WHERE nombre = '{$nombre_propiedad}'");
          foreach ($query as $row) {
              $propiedad = new Propertie($row['id'], $row['nombre'], $row['lugar'], $row['monto_normal'], $row['hot_sale'], $row['monto_base']);
          }
          $query = null;
          return $propiedad;
      }
      catch (PDOException $e) {
         print "¡Error!: " . $e->getMessage() . "<br/>";
         die();
      }
    }

    //** ELIMINAR PROPIEDAD **//

    public function eliminar_propiedad($nombre){
      $propiedad = self::getInstance()->buscar_propiedad($nombre)[0];
        self::getInstance()->queryAll("DELETE FROM propiedades WHERE nombre = '{$nombre}'");
        $mensaje = "La propiedad ha sido eliminada";
      }
      echo "<script>";
      echo "alert('$mensaje');";
      echo "</script>";

      return true;
}
?>
