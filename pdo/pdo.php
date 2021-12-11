<?php 
	function crearConexion() {
		try {
			$pdo=new PDO("mysql:host=localhost;dbname=mypicture","root","");
			return $pdo;
		} catch(PDOException $excep) {
			echo "**Error: ".$excep->getMessage();
		}
	}
	

	function cerrarConexion() {
		$pdo=null;
	}

	function leer($param,$seleccion="*",$clausulaWhere="1") {
		$pdo=crearConexion();

		$sql=$pdo->quote("SELECT $seleccion FROM $param WHERE $clausulaWhere");

		$resultado=$pdo->query("SELECT $seleccion FROM $param WHERE $clausulaWhere;");

		return $resultado;
	}
	function leerColumnas($nombre) {
		$pdo=crearConexion();

		$sql=$pdo->quote("SHOW COLUMNS FROM $nombre;");

		$resultado=$pdo->query("SHOW COLUMNS FROM $nombre;");
		return $resultado;

	}
	function insercion($nombre_tabla,...$values) {
			$valores="";
			$leerColumnas=leerColumnas($nombre_tabla);
			$arrayColumnas=[];
			$contadorColumnas=0;
			$columnas="";
			
			
			
			foreach($leerColumnas as $item) {
				$arrayColumnas[$contadorColumnas]=$item["Field"];
				$contadorColumnas++;
			}

			

			$pdo=crearConexion();

			//echo "Columnas: ".$columnas. "<br>";
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
			$sql=$pdo->prepare("$insercion");
		
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

function eliminacion($tabla,$campo1,$campo2=1,$cambio1,$cambio2=1) {
	$pdo=crearConexion();
	$sql=$pdo->prepare("DELETE FROM $tabla WHERE $campo1=:condicion1 AND $campo2=:condicion2");
	$sql->bindValue(":condicion1",$cambio1,PDO::PARAM_STR);
	$sql->bindValue(":condicion2",$cambio2,PDO::PARAM_STR);
	$sql->execute();
	
}

function modificacion($prepare,...$condiciones) {//$condiciones=1.set,2.where1....
	$pdo=crearConexion();
	
		$sql=$pdo->prepare("$prepare");
		for($i=0;$i<sizeof($condiciones);$i++) {
			$sql->bindValue(":condicion$i",$condiciones[$i],gettype($condiciones[$i])=="integer" ?PDO::PARAM_INT : PDO::PARAM_STR);
		}
		//$resultado = $condicion ? 'verdadero' : 'falso';
		
				
		$sql->execute();
		//cerramos cursor
		$sql->closeCursor();
		var_dump($sql);
		/*	
		echo $set ."<br>";
		$aux=explode(":",$set);*/
		
}
?>