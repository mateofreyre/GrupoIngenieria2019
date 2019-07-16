<?php

Class FotosPropiedadesRepository extends PDORepository {

	private static $instance;

	public static function getInstance() {
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	private function __construct() {

	}

	public function fotos_propiedad($id_propiedad){

			$fotos = [];
			$query = FotosPropiedadesRepository::getInstance()->queryAll("SELECT * FROM foto_propiedad WHERE id_propiedad = '{$id_propiedad}' ");
			foreach ($query as $row) {
				$foto = new FotoPropiedad($row['id'], $row['id_propiedad'], $row['destino']);
				$fotos[]=$foto;
			}
			$query = null;
			return $fotos;

	}
}



?>
