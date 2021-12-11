<?php 	
	require_once "Database.php" ;
	require_once "Cuadro.php" ;

	class Artista {
		private $idArtista;
		private $nombreArtista;

		public function __construct($i,$n) {
			$this->idArtista=$i;
			$this->nombreArtista=$n;
		}
		public static function artistaRelCuadro(Cuadro $a) {
			$idParam=$a->idCuadro;
			$db=Database::getInstancia();
			$resultado=$db->leer("cuadro","idArtista","idCuadro=$idParam");
			return $resultado;
		}
	}
?>