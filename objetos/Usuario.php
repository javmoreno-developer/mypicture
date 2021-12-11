<?php 

	require_once "Database.php" ;

	class Usuario {
		private $idUsuario;
		private $nombreUsuario;
		private $contrasenaUsuario;
		private $imagenUsuario;

		public function __construct($id,$no,$con,$im) {
			$this->idUsuario=$id;
			$this->nombreUsuario=$no;
			$this->contrasenaUsuario=$con;
			$this->imagenUsuario=$im;
		}	
		public static function buscarUsuario(string $name, string $pass) {			
			$db  = Database::getInstancia() ;
			$total = $db->leer("usuario","*","nombreUsuario='$name' AND contrasenaUsuario='$pass'");
			//$total->closeCursor();
			return $total;
			
		}
		public static function changePhoto(int $id,string $image) {
			$prepare="UPDATE usuario SET imagenUsuario=:condicion0 WHERE idUsuario=:condicion1";
			$db  = Database::getInstancia() ;
			$db->modificacion($prepare,$image,$id);
		}
	}
?>