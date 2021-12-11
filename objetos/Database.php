<?php 
	//conexion de bd y patron singleton
	class Database {
		private static ?Database $instancia=null;
		private $pdo ;

		private function __clone() { }

		private function __construct() {
			try {
				$this->pdo=new PDO("mysql:host=localhost;dbname=mypicture","root","");
			} catch(PDOException $excep) {
				echo "**Error: ".$excep->getMessage();
			}
		}
		public static function getInstancia() {
			if(self::$instancia==null) self::$instancia=new Database;
			return self::$instancia;
		}
		public static function cerrarConexion() {
			self::$instancia==null;
		}
		public function escapar($sentencia) {
			return $this->pdo->quote($sentencia);

		}
		public function lecturaColumnas($nombre) {
			$resultado=$this->escapar("SHOW COLUMNS FROM $nombre;");
			$resultado=$this->pdo->query("SHOW COLUMNS FROM $nombre;");
			return $resultado;
		}
		public function leer(string $param,string $seleccion="*",string $clausulaWhere="1") {
			$sql=$this->escapar("SELECT $seleccion FROM $param WHERE $clausulaWhere;");
			$resultado=$this->pdo->query("SELECT $seleccion FROM $param WHERE $clausulaWhere;");
			return $resultado;
		}
		public function insercion($nombre_tabla,...$values) {
			$valores="";
			$leerColumnas=$this->lecturaColumnas($nombre_tabla);
			$arrayColumnas=[];
			$contadorColumnas=0;
			$columnas="";
			
			foreach($leerColumnas as $item) {
				$arrayColumnas[$contadorColumnas]=$item["Field"];
				$contadorColumnas++;
			}

			$palabra="";
			for($j=0;$j<sizeof($arrayColumnas);$j++) {
				if($j==sizeof($arrayColumnas)-1) {
					 $palabra .= "" . "?";
				} else {
				    $palabra .= "" . "?" . ",";
				}
			}
			//echo $palabra;
			echo "<br>";
			$insercion="INSERT INTO $nombre_tabla VALUES($palabra);";
			$sql=$this->pdo->prepare("$insercion");
		
			//bindValue
			for($i=0;$i<sizeof($arrayColumnas);$i++) {
				if(gettype($values[$i])=="integer") {
					$sql->bindValue($i+1,$values[$i],PDO::PARAM_INT);		
				} else {
					$sql->bindValue($i+1,$values[$i],PDO::PARAM_STR);
				}
			}

			$sql->execute();

			//cerramos cursor
			$sql->closeCursor();

		}
		public function eliminacion($tabla,$campo1,$campo2=1,$cambio1,$cambio2=1) {
			$sql=$this->pdo->prepare("DELETE FROM $tabla WHERE $campo1=:condicion1 AND $campo2=:condicion2");
			$sql->bindValue(":condicion1",$cambio1,PDO::PARAM_STR);
			$sql->bindValue(":condicion2",$cambio2,PDO::PARAM_STR);
			$sql->execute();
			
		}
		public function modificacion($prepare,...$condiciones) {//$condiciones=1.set,2.where1....
			
			
			$sql=$this->pdo->prepare("$prepare");
			for($i=0;$i<sizeof($condiciones);$i++) {
				$sql->bindValue(":condicion$i",$condiciones[$i],gettype($condiciones[$i])=="integer" ?PDO::PARAM_INT : PDO::PARAM_STR);
			}
			
			$sql->execute();
			//cerramos cursor
			$sql->closeCursor();
		}
	}
?>