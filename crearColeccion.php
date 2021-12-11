<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--favicon-->
	<link rel="shortcut icon" href="img/favicon4.ico" type="image/x-icon">
	<!--icon-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
	<!--estilo-->
	<link rel="stylesheet" href="css/logueadoStyle.css">
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<title>Crear coleccion</title>
</head>
<body>
	<?php 
		session_start();
		//antes de nada comprobar si el usuario esta registrado
		if(!isset($_SESSION['id'])) {
			?>
			<script>
				Swal.fire({
				  icon:"error",
				  title: 'No has iniciado sesión',
				  
				  showDenyButton: false,
				  showCancelButton: false,
				  confirmButtonText: 'Volver al index',
				  denyButtonText: `Don't save`,
				}).then((result) => {
				  /* Read more about isConfirmed, isDenied below */
				  if (result.isConfirmed) {
				    window.location.href = "./index.php";
				 }
				})
			</script>
			<?php
		}
		//importamos el archivo con las funciones y la clase paquetizada
		require_once "./objetos/Database.php";
		require_once "./objetos/Usuario.php";

		//boton de log out
		if(isset($_GET['borrar'])) {
			session_destroy();
			header("Location: ./index.php");
		}

		//recogemos los datos del formulario
		if(isset($_GET['nombre'])) {
			$nombreCol=$_GET['nombre'];
			$idCol=$_SESSION['id'];//como por ahora el cliente solo puede crear una coleccion el id de la coleccion sera el id del cliente
			$date=getdate();
			$fecha=$date["year"] . "-" . $date["mon"] ."-" . $date["mon"];
			

			//INSERCION TABLA COLECCION
			//PDO
			//conexion basica
			$pdo=Database::getInstancia();

			//operacion (insert) tabla coleccion
			
			$pdo->insercion("coleccion",$idCol,$nombreCol,26,$fecha); //DESCOMENTAR

			//aleatorio
			if(isset($_GET['aleatorio'])) {
				//cuento los cuadros que hay en la bd
				$resultadoCuadros=$pdo->leer("cuadro","idCuadro");
				$contadorCuadros=0;
				$cuadrosDis=[];

				foreach($resultadoCuadros as $item) {
					$cuadrosDis[$contadorCuadros]=$item["idCuadro"];
					$contadorCuadros++;
				}
				$cuadrosAle=[];
				//var_dump($cuadrosDis);

				for($i=0;$i<3;$i++) {
					$repetido=false;
					do {
						$repetido=false;
						$cuadrosAle[$i]=rand(1,$contadorCuadros-1);
						for($j=0;$j<$i;$j++) {
							if($cuadrosAle[$i]==$cuadrosAle[$j]) {
								$repetido=true;
							}
						}
				 	} while($repetido==true);
				}
				
				for($j=0;$j<3;$j++) {
					echo $cuadrosDis[$cuadrosAle[$j]] . "-";
				}
			
			//INSERCION TABLA cuadro_has_coleccion
			for($i=0;$i<sizeof($cuadrosAle);$i++) {
				$pdo->insercion("cuadro_has_coleccion",$cuadrosDis[$cuadrosAle[$i]],$idCol);

			}

			//INSERCION TABLA usuario_has_cuadro
			for($i=0;$i<sizeof($cuadrosAle);$i++) {
				$pdo->insercion("usuario_has_cuadro",$_SESSION['id'],$cuadrosDis[$cuadrosAle[$i]]);
				?>
				<script>  window.location.href = "./verColeccion.php";</script>
				<?php
			}
		} else {
				?>
				<script>  window.location.href = "./verColeccion.php";</script>
				<?php
		}
			//cerramos conexion
			Database::cerrarConexion();
		}
	?>
	<section id="containerPrincipal2">
		<!--nav-->
		<div id="nav">
			<ul id="oculto">
				<li id="containerActive"><i id="active" class="bi bi-list"></i></li>
				<div id="navNormal">
					<a href="./index.php" id="semiLogo">My picture</a>
					<div id="enlaces">
						<form action="./crearColeccion.php" method="get">
							<input type="hidden" name="borrar">
							<button id="signUp"><i class="bi bi-person-dash-fill"></i>&nbsp;LOG OUT</button>
						</form>
					</div>
				</div>
			</ul>
		</div>
		<!--cuerpo-->
		<div id="cuerpo2">
			<div id="contenido">
				<form action="./crearColeccion.php" method="get" id="crearForm">
					<h1>Crear coleccion</h1>
					<input type="text" name="nombre" placeholder="nombre de la coleccion" required> 
					<h4>Añadir cuadros</h4>
					<p>A partir de ahora puedes mirar los cuadros de la pagina principal y añadirlos a <br>tu coleccion,también puedes escoger cuadros aleatoriamente.</p>
					<div id="check">
						Aleatorio (3 imagenes):<input type="checkbox" name="aleatorio" value="true">
					</div>
					
					<button>Crear coleccion</button>
				</form>
			</div>
			
		</div>
	</section>
	<script src="js/principal.js"></script>
</body>
</html>