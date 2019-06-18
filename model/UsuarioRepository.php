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

	public function agregar_usuario(){
			$email = $_POST['email'];
			$chequear_email_repetido = self::getInstance()-> email_repetido($email);
			if($chequear_email_repetido){
				$mensaje = "Se produjo un error y no se pudo agregar el usuario. Ya existe un usuario para ese email";
				echo "<script>";
				echo "alert('$mensaje');";
				echo "</script>";
				return false;
			}
			$nombre = $_POST['nombre'];
			$apellido = $_POST['apellido'];
			$password = $_POST['password'];
			$hoy = date("Y-m-d H:i:s");

			try{
					self::getInstance() -> queryAll("INSERT INTO usuario (nombre, apellido, password, email, creditos, premium, fecha_registro) VALUES ('{$nombre}', '{$apellido}','{$password}','{$email}',1,0,'{$hoy}')");
					$mensaje = "Usuario agregado exitosamente";
					echo "<script>";
					echo "alert('$mensaje');";
					echo "</script>";
					return true;
			}
			catch(PDO $e){
				$mensaje = "Se produjo un error y no se pudo agregar el usuario";
				echo "<script>";
				echo "alert('$mensaje');";
				echo "</script>";
				return false;
			}
	}

	public function cambiar_suscripcion(){
		$id = $_GET['id'];
		$consulta = self::getInstance()->queryAll("SELECT * FROM usuario WHERE id = '{$id}'");
		foreach ($consulta as $row) {
				$usuario = new Usuario($row['id'], $row['nombre'], $row['apellido'], $row['email'], $row['password'], $row['creditos'], $row['premium'], $row['fecha_registro']);
		}
		$consulta = null;
		$usuario->cambiar_estado();
		$estado_nuevo = $usuario->getPremium();
		self::getInstance()->queryAll("UPDATE usuario SET premium='{$estado_nuevo}' WHERE id = '{$id}'");
	}

	public function email_repetido($email){
		$consulta = self::getInstance()-> queryAll("SELECT * FROM usuario WHERE email = '{$email}'");
		return ($consulta->rowCount()) > 0;
	}

	public function listar_usuarios(){
		try {
			$usuarios = [];
			$query = UsuarioRepository::getInstance()->queryAll("SELECT * FROM usuario u ORDER BY fecha_registro DESC");
			foreach ($query as $row) {
				$usuario = new Usuario($row['id'], $row['nombre'], $row['apellido'], $row['email'], $row['password'], $row['creditos'], $row['premium'], $row['fecha_registro']);
				$usuarios[]=$usuario;
			}
			$query = null;
			return $usuarios;
		}
		catch (PDOException $e) {
			 print "¡Error!: " . $e->getMessage() . "<br/>";
			 die();
		}
	}

	public function buscar_usuario(){
		if (isset($_GET['id'])) {
			$id = $_GET['id'];
		}
		else{
			$id = ($_SESSION['id']);
		}
		$consulta = self::getInstance()->queryAll("SELECT * FROM usuario WHERE id = '{$id}'");
		foreach ($consulta as $row) {
				$usuario = new Usuario($row['id'], $row['nombre'], $row['apellido'], $row['email'], $row['password'], $row['creditos'], $row['premium'], $row['fecha_registro']);
				$_SESSION['email'] = $row['email'];
		}
		$consulta = null;
		return $usuario;
	}

	public function buscarUsuarioPorId($id){
		$consulta = self::getInstance()->queryAll("SELECT * FROM usuario WHERE id = '{$id}'");
		foreach ($consulta as $row) {
				$usuario = new Usuario($row['id'], $row['nombre'], $row['apellido'], $row['email'], $row['password'], $row['creditos'], $row['premium'], $row['fecha_registro']);
				$_SESSION['email'] = $row['email'];
		}
		$consulta = null;
		return $usuario;
	}


  public function obtener_usuario_by_id($id_usuario){
    try {
      $usuarios = [];
      $query = PujadorRepository::getInstance()->queryAll("SELECT * FROM usuario WHERE id = '{$id_usuario}'");
      foreach ($query as $row) {
        $usuario = new Usuario($row['id'], $row['nombre'], $row['apellido'], $row['email'], $row['password'], $row['creditos'], $row['premium'], $row['fecha_registro']);
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


	//Modifica todos los datos de un usuario//
	public function modificar_datos_usuario(){
				$id= $_GET['id'];
				$nombre= $_POST['nombre'];
				$apellido= $_POST['apellido'];
				$password= $_POST['password'];
				$email = $_POST['email'];
				$chequear_email_repetido = self::getInstance()-> email_repetido($email);
				if($chequear_email_repetido){
					$mensaje = "Se produjo un error y no se pudo agregar el usuario. Ya existe un usuario para ese email";
					echo "<script>";
					echo "alert('$mensaje');";
					echo "</script>";
					return false;
				}
				if ( $_SESSION['email'] = $email){
					self::getInstance()->queryAll("UPDATE usuario SET nombre='{$nombre}', apellido='{$apellido}', email='{$email}', password='{$password}' WHERE id = '{$id}'");
					$mensaje = "La operacion ha sido realizada con exito.";
					echo "<script>";
					echo "alert('$mensaje');";
					echo "</script>";
					return true;
				}
				else {
					$chequear_email_repetido = self::getInstance()-> email_repetido($email);
					if($chequear_email_repetido){
						$mensaje = "Se produjo un error y no se pudo modificar sus datos. El email elegido ya esta en uso";
						echo "<script>";
						echo "alert('$mensaje');";
						echo "</script>";
						return false;
					}
				}
	}

	public function chequear_inicio(){
		$password= $_POST['password'];
		$email = $_POST['email'];
		$users = self::getInstance()->queryAll("SELECT * FROM usuario WHERE email = '{$email}' AND password = '{$password}'");
		if(($users->rowCount()) > 0){
			$_SESSION['rol'] = 1;
			foreach ($users as $row) {
				$_SESSION['id']=$row['id'];
        $usuario = new Usuario($row['id'], $row['nombre'], $row['apellido'], $row['email'], $row['password'], 0, $row['creditos'], $row['premium']);
      }
			$_SESSION['usuario'] = $usuario;
			return true;
			}
			else{
				$mensaje = "Se produjo un error y no se pudo iniciar sesion. El email o la contraseña es incorrecto";
				echo "<script>";
				echo "alert('$mensaje');";
				echo "</script>";
				return false;
			}
	}
	public function logout_user(){
        session_destroy();
        session_start();
        $_SESSION['rol']=2;
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


?>
