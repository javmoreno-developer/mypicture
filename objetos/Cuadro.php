<?php 

	require_once "Database.php" ;

	class Cuadro {
		private $idCuadro;
		private $nombreCuadro;
		private $urlCuadro;
		private $fechaCuadro;
		private $idArtista;

		public function __construct($id,$no,$ur,$fe,$ar) {
			$this->idCuadro=$id;
			$this->nombreCuadro=$no;
			$this->urlCuadro=$ur;
			$this->fechaCuadro=$fe;
			$this->idArtista=$ar;
		}
		public function __get($key) {
			if (property_exists("Cuadro", $key)) return $this->$key ;
			throw new Exception ;
		}
		
	}
?>