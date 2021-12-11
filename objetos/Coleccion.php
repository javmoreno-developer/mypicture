<?php 
	class Coleccion {
		private $idColeccion;
		private $nombreColeccion;
		private static int $numeroColeccion=16;
		private $fechaColeccion;

		public function __construct($id,$no,$nu=16,$fe) {
			$this->idColeccion=$id;
			$this->nombreColeccion=$no;
			self::$numeroColeccion=$nu;
			$this->fechaColeccion=$fe;
		}
		public function getNumero() {
			return self::$numeroColeccion;

		}
		public function __get($key) {
			if(property_exists("Coleccion",$key)) {
				return $this->$key;
			} else {
				throw new Exception ;
			}
		}

	}
?>