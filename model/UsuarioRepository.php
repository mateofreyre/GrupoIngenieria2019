<?php

Class UsuarioRepository extends PDORepository {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {

	}

  //**OBTENER USUARIOS**//

  public function obtener_usuario_by_id($id_usuario){
    try {
      $usuarios = [];
      $query = PujadorRepository::getInstance()->queryAll("SELECT * FROM usuario WHERE id = '{$id_usuario}'");
      foreach ($query as $row) {
        $usuario = new Usuario($row['id'], $row['nombre'], $row['apellido'], $row['email'], $row['password'], 0, $row['creditos'], $row['premium']);
        $usuarios[]=$usuario;
      }
      return $usuarios[0];
    }
    catch (PDOException $e) {
        print "¡Error!: " . $e->getMessage() . "<br/>";
        die();
    }
  }

	public function chequear_cantidad_creditos(){
		$id_usuario = $_POST['id_usuario'];

		$creditos = self::getInstance() -> queryAll("SELECT * FROM usuario WHERE id = '{$id_usuario}'");
		foreach ($creditos as $row ) {
			$cant_creditos = $row['creditos'];
		}
		if($cant_creditos > 0){
			return true;
		}
		else{
			$mensaje = "Se produjo un error y no se pudo agregar la oferta. No posee creditos para realizarla";
			echo "<script>";
			echo "alert('$mensaje');";
			echo "</script>";
			return false;
		}
	}

//     //** BUSCAR PROPIEDAD **//

//     public function buscar_propiedad(){
// 			$id = $_GET['id'];
//       $propiedad;
//       $consulta = self::getInstance()->queryAll("SELECT * FROM propiedad WHERE id = '{$id}'");
//       foreach ($consulta as $row) {
//           $propiedad = new Propiedades($row['id'], $row['nombre'], $row['lugar'], $row['monto_normal'], $row['hotsale'], $row['monto_base']);
//       }
//       $consulta = null;
//       return $propiedad;

//     }

//     public function buscar_propiedad_by_id($id){
//       $propiedad;
//       $consulta = self::getInstance()->queryAll("SELECT * FROM propiedad WHERE id = '{$id}'");
//       foreach ($consulta as $row) {
//           $propiedad = new Propiedades($row['id'], $row['nombre'], $row['lugar'], $row['monto_normal'], $row['hotsale'], $row['monto_base']);
//       }
//       $consulta = null;
//       return $propiedad;

//     }

//     //** ELIMINAR PROPIEDAD **//

//     public function eliminar_propiedad(){
//   //    $propiedad = self::getInstance()->buscar_propiedad($nombre)[0];
// 			$id = $_GET['id'];
//       self::getInstance()->queryAll("DELETE FROM propiedad WHERE id = '{$id}'");
//       $mensaje = "La propiedad ha sido eliminada";
//       echo "<script>";
//       echo "alert('$mensaje');";
//       echo "</script>";

//       return true;
// 		}


// 		//* PONER O SACAR UNA PROPIEDAD EN HOT SALE *//
// 		public function cambiar_estado_hotSale(){
// 			$id = $_GET['id'];
// 			$consulta = self::getInstance()->queryAll("SELECT * FROM propiedad WHERE id = '{$id}'");
// 			foreach ($consulta as $row) {
// 					$propiedad = new Propiedades($row['id'], $row['nombre'], $row['lugar'], $row['monto_normal'], $row['hotsale'], $row['monto_base']);
// 			}
// 			$consulta = null;
// 			$propiedad->cambiar_estado();
// 			$estado_nuevo = $propiedad->getHotSale();
// 			self::getInstance()->queryAll("UPDATE propiedad SET hotsale='{$estado_nuevo}' WHERE id = '{$id}'");
// 		}

// 		//Modifica todos los datos de una propiedad
// 		public function modificar_datos_propiedad(){
//           $nombre= $_POST['nombre'];
// 					$lugar= $_POST['lugar'];
//           $monto_normal = $_POST['monto_normal'];
// 					$monto_base = $_POST['monto_base'];
// 					$id= $_GET['id'];
//           self::getInstance()->queryAll("UPDATE propiedad SET nombre='{$nombre}', monto_normal='{$monto_normal}', monto_base='{$monto_base}', lugar='{$lugar}' WHERE id = '{$id}'");
//           $mensaje = "La operacion ha sido realizada con exito.";
//               echo "<script>";
//               echo "alert('$mensaje');";
//               echo "</script>";
//           }
    }


?>
