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
        $query = PropertieRepository::getInstance()->queryAll("SELECT * FROM propiedad ");
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
          $query = PropertieRepository::getInstance()->queryAll("SELECT * FROM propiedad WHERE nombre = '{$nombre_propiedad}'");
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

    public function eliminar_propiedad(){
  //    $propiedad = self::getInstance()->buscar_propiedad($nombre)[0];
				$id = $_GET['id'];
        self::getInstance()->queryAll("DELETE FROM propiedad WHERE id = '{$id}'");
        $mensaje = "La propiedad ha sido eliminada";
      echo "<script>";
      echo "alert('$mensaje');";
      echo "</script>";

      return true;
		}


		//* PONER O SACAR UNA PROPIEDAD EN HOT SALE *//
		public function cambiar_estado_hotSale(){
			$id = $_GET['id'];
			$consulta = self::getInstance()->queryAll("SELECT * FROM propiedad WHERE id = '{$id}'");
			foreach ($consulta as $row) {
					$propiedad = new Propertie($row['id'], $row['nombre'], $row['lugar'], $row['monto_normal'], $row['hot_sale'], $row['monto_base']);
			}
			$consulta = null;
			$propiedad->cambiar_estado();
			$estado_nuevo = $propiedad->getEstado();
			self::getInstance()->queryAll("UPDATE propiedad SET hot_sale='{$estado_nuevo}' WHERE id = '{$id}'");
		}

//TERMINAR!!!!
		public function modificar_datos_propiedad(){
          $nombre= $_POST['nombre'];
          $monto_normal = $_POST['monto_normal'];
					$monto_base = $_POST['monto_base'];
          self::getInstance()->queryAll("UPDATE usuario SET mail='{$email}', nombre='{$nombre}', apellido='{$apellido}', fecha_nacimiento='{fecha_nacimiento}' WHERE id = '{$id}'");
          else{
              if (!$mail_correcto) {
              $mensaje = "La operacion ha sido rechazada por mail duplicado.";
              echo "<script>";
              echo "alert('$mensaje');";
              echo "</script>";
              }
              if(!$fecha_correcta){
                  $mensaje = "La operacion ha sido rechazada por fecha incorrecta.";
                  echo "<script>";
                  echo "alert('$mensaje');";
                  echo "</script>";
              }

          $mensaje = "La operacion ha sido realizada con exito.";
              echo "<script>";
              echo "alert('$mensaje');";
              echo "</script>";
          }
    }

}
?>