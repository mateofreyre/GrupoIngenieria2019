<?php

Class PropiedadesRepository extends PDORepository {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {

	}

    //**AGREGAR PROPIEDAD**//

    public function agregar_propiedad(){
        $nombre = $_POST['nombre'];
				$chequear_nombre_repetido = self::getInstance()-> nombre_repetido($nombre);
				if($chequear_nombre_repetido){
					$mensaje = "Se produjo un error y no se pudo agregar la propiedad. El nombre elegido ya esta en uso";
          echo "<script>";
          echo "alert('$mensaje');";
          echo "</script>";
          return false;
				}

				$tieneFoto = 0;
				if(!empty($_FILES["imagen"]["name"])){
            $archivo = $_FILES['imagen']['tmp_name'];
            $destino = "img_propiedades/". $_FILES['imagen']['name'];
            move_uploaded_file($archivo,$destino);
						$tieneFoto = 1;
          }
        $lugar = $_POST['lugar'];
        //$monto_normal = $_POST['monto_normal'];
        //$monto_base = $_POST['monto_base'];

        try{
          	self::getInstance() -> queryAll("INSERT INTO propiedad (nombre, lugar, monto_normal, monto_base, hotsale) VALUES ('{$nombre}', '{$lugar}', 0, 0, false)");
          	$mensaje = "Propiedad agregada exitosamente";
						echo "<script>";
          	echo "alert('$mensaje');";
          	echo "</script>";

						if($tieneFoto == 1){
							$consulta = self::getInstance() -> queryAll("SELECT * FROM propiedad ORDER BY id ASC");
							foreach ($consulta as $row) {
								$id_propiedad = $row['id'];
							}

							self::getInstance() -> queryAll("INSERT INTO foto_propiedad (id_propiedad,destino) VALUES ('{$id_propiedad}', '{$destino}')");
							$mensaje = "Foto agregada exitosamente";
						}
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

		//CHEQUEA SI EL NOMBRE ELEGIDO ESTA DENTRO DE LA BASE DE DATOS.  CORREGIR!!!!!!
		public function nombre_repetido($nombre){
			$consulta = self::getInstance()-> queryAll("SELECT * FROM propiedad WHERE nombre = '{$nombre}'");
			return ($consulta->rowCount()) > 0;
		}

    //**LISTAR PROPIEDADES**//

    public function listar_propiedades(){
      try {
        $propiedades = [];
        $query = PropiedadesRepository::getInstance()->queryAll("SELECT * FROM propiedad ");
        foreach ($query as $row) {
          $propiedad = new Propiedades($row['id'], $row['nombre'], $row['lugar'], $row['monto_normal'], $row['hotsale'], $row['monto_base']);
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

		public function listar_hotsale(){
			try {
				$hot_sales = [];
				$query = PropiedadesRepository::getInstance()->queryAll("SELECT * FROM propiedad, hot_sale WHERE hot_sale.id_propiedad = propiedad.id");
				foreach ($query as $row) {
					$hot_sale = new Hot_sale ($row['id'], $row['id_propiedad'], $row['fecha_desde']);
					$hot_sales[]=$hot_sale;
				}
				$query = null;
				return $hot_sales;
			}
			catch (PDOException $e) {
				 print "¡Error!: " . $e->getMessage() . "<br/>";
				 die();
			}

		}



    public function listar_propiedades_by_location(){
      try {
        $location = $_POST['property_search'];
        $date = $_POST['property_date'];
        $propiedades = [];
        $query = PropiedadesRepository::getInstance()->queryAll("SELECT p.id, p.nombre, p.lugar, p.monto_normal, p.hotsale, p.monto_base
                                                                 FROM propiedad as p LEFT JOIN alquiler as a ON p.id = a.id_propiedad
                                                                 WHERE p.lugar LIKE '%$location%'
                                                                 AND '$date' NOT BETWEEN IFNULL(a.fecha_desde, '2000-01-01') AND IFNULL(a.fecha_hasta, '2000-01-01')");
        foreach ($query as $row) {
          $propiedad = new Propiedades($row['id'], $row['nombre'], $row['lugar'], $row['monto_normal'], $row['hotsale'], $row['monto_base']);
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

		public function mostrar_galeria(){

		}


    //** BUSCAR PROPIEDAD **//

    public function buscar_propiedad(){
      $id = $_GET['id'];
      $propiedad;
      $consulta = self::getInstance()->queryAll("SELECT * FROM propiedad WHERE id = '{$id}'");
      foreach ($consulta as $row) {
          $propiedad = new Propiedades($row['id'], $row['nombre'], $row['lugar'], $row['monto_normal'], $row['hotsale'], $row['monto_base']);
      }
      $consulta = null;
      return $propiedad;

    }

    public function buscar_propiedad_by_id($id){
      $propiedad;
      $consulta = self::getInstance()->queryAll("SELECT * FROM propiedad WHERE id = '{$id}'");
      foreach ($consulta as $row) {
          $propiedad = new Propiedades($row['id'], $row['nombre'], $row['lugar'], $row['monto_normal'], $row['hotsale'], $row['monto_base']);
      }
      $consulta = null;
      return $propiedad;

    }

    //** ELIMINAR PROPIEDAD **//

    public function eliminar_propiedad(){
  //    $propiedad = self::getInstance()->buscar_propiedad($nombre)[0];
			$id_propiedad = $_GET['id'];

			$hoy = date("y-m-d");
			$reservas = self::getInstance()-> queryAll("SELECT * FROM alquiler WHERE id_propiedad = '{$id_propiedad}' AND fecha_desde > '{$hoy}' ");


			ReservasRespository::getInstance()->informarBajaDeReservas($reservas);

			$subastas = self::getInstance()-> queryAll("SELECT * FROM subasta, usuario_subasta WHERE id_propiedad = '{$id_propiedad}' AND subasta.id = usuario_subasta.id_subasta ");
			SubastaRepository::getInstance()-> informarBajaDeSubastas($subastas);

      self::getInstance()->queryAll("DELETE FROM propiedad WHERE id = '{$id_propiedad}'");
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
					$propiedad = new Propiedades($row['id'], $row['nombre'], $row['lugar'], $row['monto_normal'], $row['hotsale'], $row['monto_base']);
			}
			$consulta = null;
			$propiedad->cambiar_estado();
			$estado_nuevo = $propiedad->getHotSale();
			self::getInstance()->queryAll("UPDATE propiedad SET hotsale='{$estado_nuevo}' WHERE id = '{$id}'");
		}

		//Modifica todos los datos de una propiedad
		public function modificar_datos_propiedad(){
          $nombre= $_POST['nombre'];
					$lugar= $_POST['lugar'];
          $monto_normal = 0;
					$id= $_GET['id'];
					$chequear_nombre_repetido = false;
					$propiedad_actual = self::getInstance()-> buscar_propiedad_by_id($id);
					$nombre_propiedad_actual = $propiedad_actual->getNombre();
					if(!($nombre_propiedad_actual == $nombre)){
						$chequear_nombre_repetido = self::getInstance()-> nombre_repetido($nombre);
					}
					if($chequear_nombre_repetido){
						$mensaje = "Se produjo un error y no se pudo agregar la propiedad. El nombre elegido ya esta en uso";
	          echo "<script>";
	          echo "alert('$mensaje');";
	          echo "</script>";
	          return false;
					}
					$tieneFoto = 0;
					if(!empty($_FILES["imagen"]["name"])){
	            $archivo = $_FILES['imagen']['tmp_name'];
	            $destino = "img_propiedades/". $_FILES['imagen']['name'];
	            move_uploaded_file($archivo,$destino);
							$tieneFoto = 1;
	          }
						if($tieneFoto == 1){
								self::getInstance() -> queryAll("INSERT INTO foto_propiedad (id_propiedad,destino) VALUES ('{$id}', '{$destino}')");
								$mensaje = "Foto agregada exitosamente";
							}


          self::getInstance()->queryAll("UPDATE propiedad SET nombre='{$nombre}', monto_normal='{$monto_normal}', lugar='{$lugar}' WHERE id = '{$id}'");
          $mensaje = "La operacion ha sido realizada con exito.";
              echo "<script>";
              echo "alert('$mensaje');";
              echo "</script>";

    }

	}
?>
