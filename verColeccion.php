<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--favicon-->
	<link rel="shortcut icon" href="img/favicon4.ico" type="image/x-icon">
	<!--style-->
	<link rel="stylesheet" href="css/verColeccionStyle.css">
	<!--icon-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
	<!--Materialize-->
	  <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <!--iconos materialize-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<title>Ver coleccion</title>
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
		//importamos el fichero con las funciones y la clase paquetizada
		require_once "./objetos/Database.php";
		require_once "./objetos/Usuario.php";

		//conexion principal
		$pdo=Database::getInstancia();
		$id=$_SESSION['id'];

		//creamos vista para coleccion creada y sin cuadros
		//hay cuadros asociados
			if ($resultado34 = $pdo->leer("cuadro_has_coleccion","COUNT(idCuadro)","idColeccion=$id")) {
				$poseeCuadros=true;
			  if ($resultado34->fetchColumn() > 0) {
			  	$poseeCuadros=true;
			  } else {
			  	$poseeCuadros=false;
			  }

			}

		if($poseeCuadros==false) {
			?>
				<script>  window.location.href = "./index.php";</script>
			<?php
		} else {
			//boton de log out
			if(isset($_GET['borrar'])) {
				session_destroy();
				header("Location: ./index.php");
			}

			//destruimos la session de aniadir (por si existe)
			if (isset($_SESSION['add'])) {
				unset($_SESSION['add']);
			}
			//paginacion

			//calculamos el numero de paginas
			
			//recojo datos numero de paginas
			
			$NumeroPaginas=0;

			if(!isset($_GET['p'])) {
				echo "<script>console.log('pagina no definida');</script>";
				$pagina=0;	

			} else {
				$pagina=$_GET['p'];
				echo "<script>console.log('Antes: $pagina');</script>";
				if(isset($_POST['nuevaPagina'])) {
					echo "<script>console.log('$pagina');</script>";
					$pagina=($pagina<$_SESSION['NumeroPaginas'])?$pagina+1:$pagina;
					echo "<script>console.log('Pagina actual: $pagina');</script>";
					$aaa=$_SESSION['NumeroPaginas'];
					$_GET['p']=$pagina;
					header("Location: ./verColeccion.php?p=$pagina");
					echo "<script>console.log('NumeroPaginas: $aaa');</script>";
				} else if(isset($_POST['anteriorPagina'])) {
					echo "<script>console.log('$pagina');</script>";
					$pagina=($pagina>0)?$pagina-1:$pagina;
					$_GET['p']=$pagina;
					header("Location: ./verColeccion.php?p=$pagina");
					echo "<script>console.log('$pagina');</script>";
				}
			}


			
			$pag=8*$pagina;
			//pdo select*
			

			//escapar consulta
			//esta consulta sirve para contar los cuadros 
			/*$sql=$pdo->quote("SELECT * FROM usuario_has_cuadro WHERE idUsuario=$id");
			$resultado=$pdo->query("SELECT * FROM usuario_has_cuadro WHERE idUsuario=$id");*/
			//operacion (select) tabla usuario_has_cuadro
			if($pag<0) {
				header("Location: ./verColeccion.php?p=0");
			}
			$resultado=$pdo->leer("usuario_has_cuadro","*","idUsuario=$id LIMIT $pag,8");

			$contador=0;
			$array=[];
			foreach($resultado as $item) {
				$array[$contador]=$item;
				$contador++;
				

			}
			$resultado2=$pdo->leer("usuario_has_cuadro","*","idUsuario=$id");

			$contador2=0;
			foreach($resultado2 as $item) {
				$contador2++;
				

			}
			//echo "aaaaa".ceil(($contador/4));
			
			//paginacion buena
			
			

			if(isset($_SESSION['NumeroPaginas'])) {
				$NumeroPaginas=ceil(($contador2)/8);
					echo "<script>console.log('numero paginas derivado: $NumeroPaginas');</script>";
					echo "<script>console.log('numero paginas derivado: ".ceil(($contador2)/8)."');</script>";
					
			} else {
				$_SESSION['NumeroPaginas']=ceil(($contador2)/8);
				$NumeroPaginas=$_SESSION['NumeroPaginas'];
				echo "<script>console.log('numero paginas : $NumeroPaginas');</script>";
			}

			
			//comprobacion de error al meter un numero mayor en la url
			$pagina=$_GET['p']??0;
		

			 if($pagina>=$NumeroPaginas){
				echo "<script>console.log('$pagina');</script>";
				header("Location: ./verColeccion.php?p=0");
			}

			//cerramos el cursor
			$resultado->closeCursor();
			
		}
	?>
	<section id="containerPrincipal">
		<!--nav-->
		<div id="nav">
			<ul id="oculto">
				<li id="containerActive"><i id="active" class="bi bi-list"></i></li>
				<div id="navNormal">
					<?php 
							//esta consulta sirve para obtener el titulo de la coleccion
							//escapar consulta
							$idCol=$_SESSION['id'];

							/*$sql=$pdo->quote("SELECT * FROM coleccion WHERE idColeccion=$idCol");
							$resultado=$pdo->query("SELECT * FROM coleccion WHERE idColeccion=$idCol");*/
							//operacion (select) tabla coleccion
							$resultado=$pdo->leer("coleccion","*","idColeccion=$idCol");

							foreach($resultado as $item) {
								$idCol=$item["nombreColeccion"];

							}
					?>
				
					<a id="semiLogo" href="./index.php">My picture:<?= $idCol ?></a>
					<div id="enlaces">
						<form action="./verColeccion.php" method="get">
							<input type="hidden" name="borrar">
							<button id="signUp"><i class="bi bi-person-dash-fill"></i>&nbsp;LOG OUT</button>
						</form>
						<form action="./modify.php" method="get">
							<input type="hidden" name="aniadir" value="a">
							<a id="signUp" href="./modify.php?aniadir=a"><i class="bi bi-bookmark-plus-fill"></i>&nbsp;Agregar</a>
						</form>
						<form action="./verColeccion.php" method="get">
							<input type="hidden" name="borrarTotal" value="1">
							<button id="borrarCol"><i class="bi bi-trash-fill"></i>&nbsp;Borrar Col</button>
						</form>
					</div>
				</div>
			</ul>
		</div>

		<!--cuerpo-->
		<div id="cuerpo">
			
				<?php 
				$contador=0;
				for($i=0;$i<ceil((sizeof($array)/4));$i++) {//numero de filas de cuadros
					?>
					<div class="fila">
						<?php 
							for($j=0;($contador<=sizeof($array)-1 && $j<4);$j++) {//numero de columnas de cuadros
								
								//esta consulta sirve para obtener los datos de los cuadros
								//escapar consulta
								$aux=intval($array[$contador]['idCuadro']);
								
								$contador++;
								$nombre="";
								$fecha="";
								$artista="";
								$url="";
								$idCuadro=0;

								/*$sql=$pdo->quote("SELECT * FROM cuadro WHERE idCuadro=$aux");
								$resultado=$pdo->query("SELECT * FROM cuadro WHERE idCuadro=$aux");*/
								//operacion (select) tabla cuadro
								$resultado=$pdo->leer("cuadro","*","idCuadro=$aux");

								foreach($resultado as $item) {
									$aux=$item["urlCuadro"];
									$nombre=$item["nombreCuadro"];
									$fecha=$item["fechaCuadro"];
									$artista=$item["idArtista"];
									$url=$item["urlCuadro"];
									$idCuadro=$item["idCuadro"];
								}
								?>
								<!--card-->
								 <div class="card">
								    <div class="card-image waves-effect waves-block waves-light">
								      <img class="activator" src="<?=$aux?>">
								    </div>
								    <div class="card-content">
								      <span class="card-title activator grey-text text-darken-4"><?=$nombre?><i class="material-icons right">more_vert</i></span>
								     
								    </div>
								    <div class="card-reveal">
								      <span class="card-title grey-text text-darken-4"><?=$nombre?><i class="material-icons right">close</i></span>
								      <p>fecha de creacion: <?=$fecha?></p>
								      <a href="#">Artista: <?=$artista?></a><br>
								      <a href="<?=$url?>">descargar</a>
								     
								      <form action="./verColeccion.php" method="get">
								      	<input type="hidden" name="idC" value="<?=$idCuadro?>">
								      	<button id="delete">borrar</button>
								      </form>
								      <form action="./modify.php" method="get">
								      	<input type="hidden" name="idCu" value="<?=$idCuadro?>">
								      	<button id="mod" type="submit" >modificar</button>
								      </form>
								       <form action="./verColeccion.php">
								       		<input type="hidden" name="imagenModificada" value="<?php echo $idCuadro;?>">
											<button id="buttonModFoto">Cambiar foto</button>
										</form>
								    </div>
								  </div>
            
								<!-- fin card-->

								<?php

								//cerramos el cursor
								$resultado->closeCursor();
								
							}
						?>
					</div>
					<?php
				}
				if($NumeroPaginas!=1) {

				
				?>
				<div id="paginacion">
					<form action="./verColeccion.php?p=<?=$pagina?>" method="POST">
						<input type="hidden" name="anteriorPagina" value="a">
						<button><i class="bi bi-arrow-left"></i></button>
					</form>
					<?php 

					for($i=0;$i<$NumeroPaginas;$i++) {
						?>
						<a href="./verColeccion.php?p=<?=$i?>"><?=$i?></a>
						
						<?php
					}
					?>
					<form action="./verColeccion.php?p=<?=$pagina?>" method="POST">
						<input type="hidden" name="nuevaPagina" value="a">
						<button><i class="bi bi-arrow-right"></i></button>
					</form>
				</div>
				
				<?php 
					}
				 ?>
		</div>
	</section>
	
	<!--BORRAMOS--->
		<?php 
		//usuario_has_cuadro
			if(isset($_GET['idC'])) {
				$idC=$_GET['idC'];
				$pdo=Database::getInstancia();
				//operacion (delete) tabla usuario_has_cuadro
			    $pdo->eliminacion("usuario_has_cuadro","idCuadro","idUsuario","$idC","$id");
				
				//cuadro_has_coleccion
		
				$idC=$_GET['idC'];

				//operacion (delete) tabla cuadro_has_coleccion
				$pdo-> eliminacion("cuadro_has_coleccion","idCuadro","idColeccion","$idC","$id");
				?>
				<script>  window.location.href = "./verColeccion.php";</script>
				<?php
				//cerramos cursor
				$sql->closeCursor();
			}
		?>
	<!--FIN BORRAR-->
	<!--borrarTotal (borrado de coleccion)-->
	<?php 
		if(isset($_GET['borrarTotal'])) {
			//operacion (delete) tabla coleccion
			echo "<script>console.log('operacion')</script>";
			$idColeccion=$_SESSION['id'];
			$pdo=Database::getInstancia();

			try {
			$pdo->eliminacion("cuadro_has_coleccion","idColeccion","1","$idColeccion","1");
			
			echo "<script>console.log('ok')</script>";
			} catch(Exception $e) {
				echo "<script>console.log('fallo')</script>";
				echo $e->getMessage();
			}
			//operacion (delete) tabla cuadro_has_coleccion
			$pdo->eliminacion("usuario_has_cuadro","idUsuario","1","$idColeccion","1");
			//operacion (delete) tabla usuario_has_cuadro
			$pdo->eliminacion("coleccion","idColeccion","1","$idColeccion","1");
			unset($_SESSION['NumeroPaginas']);
			echo "<script>window.location.href='./index.php';</script>";
		}
	?>
	<!--FIN borrarTotal-->
	<!--Formulario de cambiar foto-->
	<?php 
	if(isset($_GET['imagenModificada'])) {
		$auxiliar=$_GET['imagenModificada'];
		$auxiliar;
		$pdo=Database::getInstancia();
		echo "<script>console.log('formulario: $auxiliar');</script>";
		//cogo la url a traves de la id
		$resultadoMod=$pdo->leer("cuadro","*","idCuadro=$auxiliar");
		$urlMod="";
		foreach($resultadoMod as $item) {
			$urlMod=$item['urlCuadro'];
		}
		echo "<script>console.log('url: $urlMod');</script>";
		$porciones = explode("/", $urlMod);
		
		$urlMod= $porciones[4];
		echo "<script>console.log('url2: $urlMod');</script>";
		//operacion (update) tabla usuario
		$prepare="UPDATE usuario SET imagenUsuario=:condicion0 WHERE idUsuario=:condicion1";

		$pdo->modificacion($prepare,$urlMod,$_SESSION['id']);

		//echo ("<script> window.location.href = './index.php';</script>");
	}

	?>
	<?php 
		//cerramos la conexion
		$pdo=null;
	?>

	
	<script src="js/principal.js"></script>
</body>
</html>