<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--favicon-->
	<link rel="shortcut icon" href="img/favicon4.ico" type="image/x-icon">
	<!--style-->
	<link rel="stylesheet" href="css/style.css">

	<!--icon-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
	<!--Materialize-->
	  <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <!-- Compiled and minified JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <!--iconos materialize-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    

	<title>Pagina principal</title>
</head>
<body>
	<!--LOADER-->
	<section id="contenedor_carga">
		<div class="mosaic-loader">
	    <div class="cell d-0"></div>
	    <div class="cell d-1"></div>
	    <div class="cell d-2"></div>
	    <div class="cell d-3"></div>
	    <div class="cell d-1"></div>
	    <div class="cell d-2"></div>
	    <div class="cell d-3"></div>
	    <div class="cell d-4"></div>
	    <div class="cell d-2"></div>
	    <div class="cell d-3"></div>
	    <div class="cell d-4"></div>
	    <div class="cell d-5"></div>
	    <div class="cell d-3"></div>
	    <div class="cell d-4"></div>
	    <div class="cell d-5"></div>
	    <div class="cell d-6"></div>
	</div>
	</section>
	
	<!--FIN LOADER-->
	<?php 
		session_start();
		require_once "./objetos/Database.php";
		require_once "./objetos/Usuario.php";
		
		//paginacion
		
		$pagina=$_GET['p']??0;
		

		if($pagina>=4){
			
			header("Location: ./index.php");
		} else if($pagina<0) {
			header("Location: ./index.php");
		}

		if(!isset($_GET['p'])) {
			echo "<script>console.log('pagina no definida');</script>";
			$pagina=0;
		} else {
			//retroceder
			$pagina=$_GET['p'];
			echo "<script>console.log('Antes: $pagina');</script>";

			if(isset($_POST['anteriorPagina'])) {
				echo "<script>console.log('$pagina');</script>";
				$pagina=($pagina>0)?$pagina-1:$pagina;
				$_GET['p']=$pagina;
				header("Location: ./index.php?p=$pagina");
				echo "<script>console.log('$pagina');</script>";
			} else if(isset($_POST['nuevaPagina'])) {
				echo "<script>console.log('$pagina');</script>";
				$pagina=($pagina<2)?$pagina+1:$pagina;
				echo "<script>console.log('Pagina actual: $pagina');</script>";
				$aaa=$_SESSION['NumeroPaginas'];
				$_GET['p']=$pagina;
				header("Location: ./index.php?p=$pagina");
				echo "<script>console.log('NumeroPaginas: $aaa');</script>";
			}
		}


	?>
	<section id="containerPrincipal">
		<!--nav-->
		<div id="nav">
			<ul id="oculto">
				<li id="containerActive"><i id="active" class="bi bi-list" ></i></li>
				<div id="navNormal">
					<a href="#" id="semiLogo">My picture</a>
					<div id="enlaces">
						<?php 
							//generamos vistas

							if(!isset($_SESSION['id'])) {//no se ha registrado	
						?>
							<a id="signUp" href="./login.php"><i class="bi bi-person-fill"></i>&nbsp;SIGN UP</a>
							<a id="signIn" href="./login.php"><i class="bi bi-person-plus-fill"></i>&nbsp;SIGN IN</a>
						<?php 
						 } else {//se ha registrado
						?>
							<a id="signIn" href="./logueado.php"><i class="bi bi-person-fill"></i>&nbsp;Acceder</a>
						<?php 
						}
						?>
					</div>
				</div>
			</ul>
		</div>
		<!--header-->
		<header id="header">
			<div id="headerContenido">
				<h1 id="realise">Realise your creatives ideas</h1>
				<h4>We build epic,realtime interactive experiencies to blow people's minds</h4>
				<div id="botones">
					<a id="signIn" href="#imagenes"><i class="bi bi-search"></i>&nbsp;COLECCION</a>
				</div>
				
			</div>
		</header>
		<!--imagenes-->
		<section id="imagenes">
			<div id="tituloImagenes">
				<h4></h4>
			</div>
			<!--CUADROS-->
			<div id="cuadros">
				<?php 
					if(isset($_GET['p'])) {
						$contador=106+($_GET['p']*20);
					} else {

						$contador=106;//id de la primera foto
					}
					for($j=1;$j<=4;$j++) {//establecemos el numero de filas de cuadros
				?>
				<div class="fila">
					<?php 
						for($i=1;$i<=4;$i++) {//establecemos el numero de columnas de cuadros

							$excepciones=[147,148,149,150,138,139];
							for($z=0;$z<sizeof($excepciones);$z++) {
								if($contador==$excepciones[$z]) {
									$contador++;
								}
							}
							
					?>

					<!--card-->
					<div class="card">
					    <div class="card-image waves-effect waves-block waves-light">
					    	<img class="activator" src="https://picsum.photos/id/<?php echo $contador++;?>/400/400">

					    </div>
					    <?php 
						    //llamada a la API
					  	
						    $titulo= file_get_contents('https://picsum.photos/id/'.$contador++.'/info');//devuelve string
						    
						
						    echo "<script>console.log('el contador es: $contador');</script>";
						    $prueba= explode(",", $titulo);
						    $array = explode(",", $titulo);//el string lo convertimos en un array
						    $autor=substr($array[1], 9);
						    $id=substr($array[0], 7,3);
						    $url=substr($array[4],7);
						    $url=substr($url,0,-1);
					    ?>
					    <div class="card-content">
					      <span class="card-title activator grey-text text-darken-4">Mas detalles<i class="material-icons right">more_vert</i></span>
					    </div>
					    <!--card-reveal=lo que se muestra al dar click en la imagen-->
					    <div class="card-reveal">
					      <span class="card-title grey-text text-darken-4">Imagen de id <strong><?php echo $id; ?></strong><i class="material-icons right">close</i></span>
					      <p>URL imagen original: <strong><?php echo $url; ?></strong></p>
					      <p>Autor: <br><strong><?php echo $autor ?></strong></p>
					       
					      	<!--generamos la vista para los botones de aniadir cuadros a coleccion-->
					      	<?php if(isset($_SESSION['id'])) {?>
					       <form action="./index.php">
						       	<input type="hidden" name="idCuadroAniadir" value="<?=$id?>">
						       	<button>aniadir a coleccion</button>
					       </form>
					       <form action="./index.php">
					       	<?php $idImagenMod=$id-1; ?>
					       		<input type="hidden" name="imagenModificada" value="<?php echo $idImagenMod;?>">
								<button id="buttonModFoto">Cambiar foto</button>
							</form>
					   <?php } ?>

					    </div>
					</div>
					<!-- fin card-->
					<?php 
						}
					?>
				</div>
				<?php 
						}
					?>
				<div id="paginacion">
					<form action="./index.php?p=<?=$pagina?>" method="POST">
						<input type="hidden" name="anteriorPagina" value="a">
						<button><i class="bi bi-caret-left-fill"></i></button>
					</form>
					<?php 
						for($i=0;$i<=3;$i++) {
							if(isset($_GET['p'])) {
								if($_GET['p']==$i) {
									?>
							<div id="selected">
								<a href="./index.php?p=<?=$i?>"><?=$i?></a>
								<hr>	
							</div>
							
							<?php
								} else {
									?>

							<a href="./index.php?p=<?=$i?>"><?=$i?></a>
							<?php
								}
							} else {
								?>

							<a href="./index.php?p=<?=$i?>"><?=$i?></a>
							<?php
							}
						}
					 ?>
					<form action="./index.php?p=<?=$pagina?>" method="POST">
						<input type="hidden" name="nuevaPagina" value="a">
						<button><i class="bi bi-caret-right-fill"></i></button>
					</form>
				</div>
			</div>
			
			<!--FIN CUADROS-->
		</section>
		<!--FIN IMAGENES-->
		
		<!--FOOTER-->
		<div id="footer">
			<div id="contenidoFooter">
				<div id="descripcion">
					<h4>My picture</h4>
					<p>
						La app en cuestión llevará la gestión de colecciones privadas de cuadros que estarán previamente disponibles en la página principal.El usuario podrá escoger desde la página principal las imagenes y crear a partir de estas sus propias colecciones.
					</p>
					
				</div>
				
				<div id="follow">
					<h4>Redes</h4>
					<div id="iconos">
						<div id="follow-first"><i class="bi bi-discord"></i></div>
						<div id="follow-second"><i class="bi bi-google"></i></div>
						<div id="follow-third"><i class="bi bi-facebook"></i></div>
					</div>
				</div>
				<div id="logo">
					<h4 id="semiLogo">My picture</h4>
					<div id="foto"></div>
				</div>
			</div>
		</footer>
	</section>
	
	<!--Recojo datos del formulario de aniadir a coleccion linea 105 aprox-->
	<?php 
	if(isset($_GET["idCuadroAniadir"])) {
		//tenemos que hacer 3 inserciones->cuadro,cuadro_has_coleccion,usuario_has_cuadro
		//esto es porque los cuadros expuestos no existen en la bd

		//operacion (insert) tabla cuadro
		  //llamada a la API
		$titulo= file_get_contents('https://picsum.photos/id/'.$_GET["idCuadroAniadir"].'/info');//devuelve string
		$array = explode(",", $titulo);//el string lo convertimos en un array
		$autor=substr($array[1], 9);
		$id=intval(substr($array[0], 7,3));
		$p=$id-1;
		$url2="https://picsum.photos/id/$p/400/500";
		$date=getdate();
		$fecha23=$date["year"] . "-" . $date["mon"] ."-" . $date["mon"];
		$bo=8;
		$nombre="cuadro$id";
		

		$pdo=Database::getInstancia();

		try {
			$pdo->insercion("cuadro",$id,$nombre,$url2,$fecha23,1);
		} catch(Exception $e) {
			echo "<script>console.log(".$e->getMessage().")</script>";
		}

		//operacion (insert) tabla usuario_has_cuadro
		
		$idUsu=$_SESSION['id'];
		try {
			$pdo->insercion("usuario_has_cuadro",$idUsu,$id);
		} catch(Exception $e) {
			echo "<script>console.log(".$e->getMessage().")</script>";
		}
		//echo "<script>console.log(".$_SESSION['id'].")</script>";

		//operacion (insert) tabla cuadro_has_coleccion
		
		$idUsu=$_SESSION['id'];
		try {
			$pdo->insercion("cuadro_has_coleccion",$id,$idUsu);
		} catch(Exception $e) {
			echo "<script>console.log(".$e->getMessage().")</script>";
		}
		//echo "<script>console.log(".$_SESSION['id'].")</script>";
		?>
		
		<?php
	}
	 ?>
	<!--Formulario de cambiar foto-->
	
	<?php 
	if(isset($_GET['imagenModificada'])) {
		$pdo=Database::getInstancia();
		$auxiliar=$_GET['imagenModificada'];
		$auxiliar;
		echo "<script>console.log('$auxiliar');</script>";
		//operacion (update) tabla usuario
		$prepare="UPDATE usuario SET imagenUsuario=:condicion0 WHERE idUsuario=:condicion1";

		$pdo->modificacion($prepare,$auxiliar,$_SESSION['id']);

		//echo ("<script> window.location.href = './index.php';</script>");
	}

	?>
	<!--Carga de imagenes-->
	<!--PRELOADERS-->
	<img src="https://picsum.photos/id/27/3000/2000" style="display: none">
	<img src="https://picsum.photos/id/184/3000/2000?grayscale&blur=2" style="display: none">
	<img src="https://picsum.photos/id/190/3000/2000" style="display: none">
	<img src="https://picsum.photos/id/400/3000/2000" style="display: none">
	<img src="https://picsum.photos/id/171/3000/2000" style="display: none">

		
		<script src="js/principal.js"></script>

</body>
</html>