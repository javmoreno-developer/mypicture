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
	<title>Logueado</title>
</head>
<body style="background: white;">
	<?php 
		session_start();
		//importamos el archivo con las funciones y la clase paquetizada
		require_once "./objetos/Database.php";
		require_once "./objetos/Usuario.php";

		//boton de log out
		if(isset($_GET['borrar'])) {
			
			session_destroy();
			header("Location: ./index.php");
			
		}
		//si no esta logueado te lleva al login
		if(!isset($_SESSION['id'])) {
			header("Location: ./login.php");
		} else {//comprobar si el usuario tiene cuadros o no
			$id=$_SESSION['id'];
			//PDO
			//conexion
			$pdo=Database::getInstancia();
			
			//hacemos query (para select)
			//hay coleccion
			//$resultado=leer("coleccion","COUNT(idColeccion)","idColeccion=$id");
			$resultado=$pdo->leer("coleccion","COUNT(idColeccion)","idColeccion=$id");
			//hay cuadros asociados
			//$sql = "SELECT COUNT(idCuadro) FROM usuario_has_cuadro WHERE idUsuario=$id ";
			
			if ($resultado34 = $pdo->leer("usuario_has_cuadro","COUNT(idCuadro)","idUsuario=$id")) {
				$poseeCuadros=true;
			  if ($resultado34->fetchColumn() > 0) {
			  	$poseeCuadros=true;
			  } else {
			  	$poseeCuadros=false;
			  }

			}

			$contador = $resultado->fetchColumn();

			$poseeColeccion=false;

			if($contador>0) {
				$poseeColeccion=true;//el usuario no tiene coleccion
			}

			//cerramos el cursor
			$resultado->closeCursor();
			if($poseeColeccion==true) {
				//hacemos query (para select)
				$resultado=$pdo->leer("usuario","nombreUsuario","idUsuario=$id");

				//cogemos el nombre del usuario
				$nombre = $resultado->fetchColumn();

			}

			
			//cerramos la clase
			$pdo=null;
		}
		
	?>
	<section id="containerPrincipal">
		<!--nav-->
		<div id="nav">
			<ul id="oculto">
				<li id="containerActive"><i id="active" class="bi bi-list"></i></li>
				<div id="navNormal">
					<a id="semiLogo" href="./index.php">My picture</a>
					<div id="enlaces">
						<form action="./logueado.php" method="get">
							<input type="hidden" name="borrar">
							<button id="signUp"><i class="bi bi-person-dash-fill"></i>&nbsp;LOG OUT</button>
						</form>
						
					</div>
				</div>
			</ul>
		</div>
		<!--Cuerpo-->
		<?php 
				$pdo=Database::getInstancia();
				$resultado=$pdo->leer("usuario","imagenUsuario","idUsuario=$id");

				//cogemos el nombre del usuario
				$imagen = $resultado->fetchColumn();
				if($imagen[0]!="h") { 

				
		?>
		<div id="cuerpo" style="background-image:url(https://picsum.photos/id/<?=$imagen?>/1700/700);">
			<?php 
				} else {
					?>
					<div id="cuerpo" style="background-image:url('<?=$imagen?>')">
					<?php
				}
			 ?>
			<div id="contenido">
				<!--Vista sin colecciones-->
				
					
				
				<?php 
					if($poseeColeccion==false && $poseeCuadros==false) {

				?>
				<div id="c">
					<h1>Bienvenido usuario</h1>
					<p>
						Te voy a explicar que puedes hacer a partir de ahora con tu cuenta. <br>

	                     1.Ver toda la colección de cuadros disponible en la aplicación 
	                     (sin estar logueado no podrías ver todos los cuadros).   <br>

	                     2.Seleccionar imágenes tanto para  meterlas en una colección 
	                     privada como para descargarlas. <br>

	                     3.Creación de colecciones privadas. <br>

	                     4.Compartir las imágenes por redes sociales. <br>
					</p>
					<a href="./crearColeccion.php">Crear coleccion</a>	
				</div>
				
			<?php } else if($poseeCuadros==true && $poseeColeccion==true) { ?>
				
						<!--Vista con colecciones-->
						<h1>Bienvenido <?php echo $nombre; ?></h1>
						<div id="coleccion">
							<a href="./verColeccion.php">Acceder a coleccion</a>
						</div>
					

			<?php } else {
				?>
				
					<a href="https://imgur.com/a/UXsrjyE" id="tutorial">Tutorial</a>
				
				<p>con tu coleccion ya creada podras seleccionar los cuadros de la pagina principal</p>
				<div id="coleccion">
					<a href="./index.php">Pagina principal</a>
				</div>
				<?php
			} ?>

			</div>
		</div>
	</section>
	
</body>

<script src="js/principal.js"></script>
</html>