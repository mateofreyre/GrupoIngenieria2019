<?php

Class TarjetaRepository extends PDORepository {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {

	}
	public function chequear_nombre($nombre){


          if(!preg_match("|^[a-zA-Z]+(\s*[a-zA-Z]*)*[a-zA-Z]+$|",$nombre) && strlen($nombre) <= 50){
            $mensaje = "Nombre incorrecto.";
            echo "<script>";
            echo "alert('$mensaje');";
            echo "</script>";
            return false;
          }
          return true;
        }

    public function agregar_tarjeta(){
        $numero_tarjeta = $_POST['numero_tarjeta'];
        $mes_vencimiento = $_POST['mes_vencimiento'];
        $year_vencimiento = $_POST['year_vencimiento'];
        //$id_titular = $_POST['id_titular'];


      //  $nombre_titular = ucfirst($nombre_titular);

        if(strlen($numero_tarjeta) != 16){
          $mensaje = "¡Tu tarjeta debe tener 16 dígitos!";
          echo "<script>";
          echo "alert('$mensaje');";
          echo "</script>";
          return false;
        }



        if(($year_vencimiento == date("y")) && ($mes_vencimiento < date("m"))) {
          $mensaje = "¡Tu tarjeta está vencida!";
          echo "<script>";
          echo "alert('$mensaje');";
          echo "</script>";
          return false;
        }
          $id_titular = $_SESSION['id'];

          self::queryAll("INSERT INTO tarjeta (numero, id_usuario, mes_vencimiento, year_vencimiento) VALUES ( '{$numero_tarjeta}',  '{$id_titular}', '{$mes_vencimiento}', '{$year_vencimiento}')");
          $mensaje = "Tarjeta agregada exitosamente";
          echo "<script>";
          echo "alert('$mensaje');";
          echo "</script>";
          return true;
    }


    public function card_delete($id) {

      try{
        self::queryAll("DELETE FROM tarjeta WHERE id = '{$id}'");
        $mensaje = "Tarjeta eliminada exitosamente";
      }
      catch (PDOException $e){
        $mensaje = "Ocurrió un error y la acción no pudo ejecutarse.";
      }
      echo "<script>";
      echo "alert('$mensaje');";
      echo "</script>";
    }

    public function listar_tarjetas(){
      try {
          $tarjetas = [];
          $query = TarjetaRepository::getInstance()->queryAll("SELECT * FROM tarjeta WHERE id_usuario = '{$_SESSION['id']}'");
          foreach ($query as $row) {
              $tarjeta = new Tarjeta($row['id'],  $row['numero'], $row['mes_vencimiento'], $row['year_vencimiento'],  $row['id_usuario'] );
              $tarjetas[]=$tarjeta;
          }
          $query = null;
          return $tarjetas;
      }
      catch (PDOException $e) {
         print "¡Error!: " . $e->getMessage() . "<br/>";
         die();
      }
    }

    // Retorna una tarjeta buscada por su ID
    public function buscar_tarjeta($id_card){
      try {
          $tarjeta=null;
          $query = TarjetaRepository::getInstance()->queryAll("SELECT * FROM tarjeta WHERE id = '{$id_card}'");
          foreach ($query as $row) {
              $tarjeta = new Tarjeta($row['id'],  $row['nombre_titular'], $row['numero_tarjeta'], $row['codigo'], $row['id_usuario'], $row['mes_vencimiento'], $row['year_vencimiento'] );
          }
          $query = null;
          return $tarjeta;
      }
      catch (PDOException $e) {
         print "¡Error!: " . $e->getMessage() . "<br/>";
         die();
      }
    }

    // Chequea si una tarjeta es válida. Debe recibi la fecha en formato date Y-m-d H:i:s
    public function check_invalid_card($id_card, $date){
      $card=self::getInstance()->buscar_tarjeta($id_card);
      if (is_null($card)){
        $mensaje="La tarjeta seleccionada no existe";
        echo "<script>";
        echo "alert('$mensaje');";
        echo "</script>";
        return true;
      }else{
        //Genera una fecha que es el primer día del mes de vencimiento
        $año = 2000+$card->getYearVencimiento();
        $mes = $card->getMesVencimiento();
        $fecha=date("Y-m-d H:i:s",mktime(0,0,0,$mes,1,$año));
        if (strtotime($date)>strtotime($fecha)){
        $mensaje="La tarjeta seleccionada tiene fecha de vencimiento anterior al viaje. Expira: ".(string)$fecha;
          echo "<script>";
          echo "alert('$mensaje');";
          echo "</script>";
          return true;
        }
      }
      return false;
    }

  }

?>
