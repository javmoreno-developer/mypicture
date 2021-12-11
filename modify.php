<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--favicon-->
	<link rel="shortcut icon" href="img/favicon4.ico" type="image/x-icon">
	<!--style-->
	<link rel="stylesheet" href="css/modifyStyle.css">
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
	<title>Modificar/aniadir</title>
</head>
<body>
	<?php 
		//enumerar cuadros disponibles

		//llamar a fichero de funcion
		session_start();
		require_once "./objetos/Database.php";
		require_once "./objetos/Usuario.php";

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
		
		$id=$_SESSION['id'];
		//paginacion de movil
		$NumeroPaginas=0;

		if(!isset($_GET['p'])) {
			echo "<script>console.log('pagina no definida');</script>";
			$pagina=0;	

		} else {
			$pagina=$_GET['p'];
			echo "<script>console.log('Antes: $pagina');</script>";
			if(isset($_POST['nuevaPagina'])) {
				echo "<script>console.log('$pagina');</script>";
				$pagina=($pagina<=$NumeroPaginas)?$pagina+1:$pagina;
				echo "<script>console.log('$pagina');</script>";
			}
			if(isset($_POST['anteriorPagina'])) {
				echo "<script>console.log('$pagina');</script>";
				$pagina=($pagina>0)?$pagina-1:$pagina;
				echo "<script>console.log('$pagina');</script>";
			}
		}


		
		$pag=8*$pagina;
		//pdo select*
		//conexion principal
		$pdo=Database::getInstancia();

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
		//echo "aaaaa".ceil(($contador/4));
		
		//paginacion buena
		
		

		if(isset($_SESSION['NumeroPaginas'])) {
			$NumeroPaginas=$_SESSION['NumeroPaginas'];
			
		} else {
			$_SESSION['NumeroPaginas']=ceil(($contador+1)/8);
			$NumeroPaginas=$_SESSION['NumeroPaginas'];
		}

		//comprobacion de error al meter un numero mayor en la url
		$pagina=$_GET['p']??0;
		echo "<script>console.log('error2');</script>";

		 if($pagina>$NumeroPaginas){
			echo "<script>console.log('$pagina');</script>";
			header("Location: ./verColeccion.php?p=0");
		}

		if(isset($_GET['aniadir'])) {
			$aniadir=$_GET['aniadir'];
			echo "<script>console.log('$aniadir');</script>";
			$_SESSION['add']=true;
		} 

		
		if(isset($_GET['idCu'])) {
			$_SESSION['imagenCambiar']=$_GET['idCu'];	
		}
		
		
		
		
		$contador=0;
		$contadorAux=0;
		$resultado=$pdo->leer("cuadro","COUNT('idCuadro')");

		foreach($resultado as $item) {
			$contador= intval($item[0]);
		}

		//antes de nada calculamos el numero de filas (para el height)
		$filasHeight=0;
		$filasHeight=ceil($contador/4);
		

		$resultado=$pdo->leer("cuadro");
		$array=[];
		foreach($resultado as $item) {
			array_push($array,$item['idCuadro']);
		}
		/*echo $contador;
		echo "<br>";
		echo "Numero de filas: ".ceil($contador/4);*/

		$contAux=0;
	?>
	

	<section id="containerPrincipal3">
		<div id="cuerpo3">
			 <form action="modify.php" method="get">
				<?php 
					//filas
					for($i=0;$i<ceil($contador/4);$i++) {
						//echo "<script>console.log('recorriendo $i');</script>";
						if($i%2==0) {
							//comprobar cuantos aqui style="height: <?=(($tam)*40)vh;"
							$tam=0;
							
							for($z=0;($contAux<=$contador-1 && $z<4);$z++) {
								$tam++;
								$contAux+=2;
								echo "<script>console.log('$contAux')</script>";
							}
							
							echo $tam . "-";
							echo $contador . "-";
							echo $contAux. "-";

							if(8-$contAux<0) {
								$tam2=abs(8-$contAux-1);

							} else {

								$tam2=$contAux;
							}
							echo $tam2;//tam*50
							if($tam!=1) {
								$tam2=$tam*2;
							} else {
								$tam2=1;
							}
							?>
							<div id="instanciaSlider" class="<?=$i?>" style="height: <?= $tam2*40?>vh;">

							<?php
						}

							?>
							<div class="fila2">
									<?php
							//columnas
							for($j=0;($contadorAux<=$contador-1 && $j<4);$j++) {
								//operacion (select) tabla cuadro
								
								$resultado=$pdo->leer("cuadro","*","idCuadro=$array[$contadorAux]");
								$url="";
								$idCuadro="";
								$nombreCuadro="";
								$fechaCuadro="";
								$idArtista="";

								foreach($resultado as $item) {
									$url=$item['urlCuadro'];
									$idCuadro=$item['idCuadro'];
									$nombreCuadro=$item['nombreCuadro'];
									$fechaCuadro=$item['fechaCuadro'];
									$idArtista=$item['idArtista'];
								}
							
								?>
								<div class="card">
								   <div class="card-image waves-effect waves-block waves-light">
								     <img class="activator" src="<?=$url?>">
								   </div>
								   <div class="card-content">
								     <span class="card-title activator grey-text text-darken-4"><?=$nombreCuadro?><i class="material-icons right">more_vert</i></span>
								     <p><a href="#">This is a link</a></p>
								   </div>
								   <div class="card-reveal">
								     <span class="card-title grey-text text-darken-4"><?=$nombreCuadro?><i class="material-icons right">close</i></span>
								    
								     <p>fecha de creacion: <?=$fechaCuadro?></p>
								      <a href="#">Artista: <?=$idArtista?></a><br>
								      <a href="<?=$url?>">descarga</a>
								      <p>ID:<?=$idCuadro?></p>

								   </div>
								   <input name="group1" type="radio" name="opcion" checked value="aa"/>
								   <p>
     								<label>
							        	<input name="opcion" value="<?=$idCuadro?>" type="radio"  checked />
							        	<?php
							        	if(isset($_SESSION['add'])) {
							        	?>
							        	<span>Añadir esta</span>
							        	
							        	<?php
							        	} else {
							        	?>
							        	<span>Sustituir por esta</span>

							        	<?php
							        	
							        	}
							        	?>
							      	</label>
							   		 </p>
								</div>
								
								<?php
								$contadorAux++;
								
							}
							?>
							</div>
							<?php 
							if($i==ceil($contador/4)-1) {
								?>

								<div id="btnSubmit">
									<button>Aceptar</button>
									<a href="verColeccion.php">Cancelar</a>
								</div>

								<?php
							}
							if($i%2==1) {
								

							
								?>
								<!--fin instancia slider-->
								</div>
					<?php } 
						
					}
				?>

				
				
			</form> 
			
			
		</div>
	</section>
	
	<!--ADICION-->
	
	<?php 
	if(isset($_SESSION['add']) && $_SESSION['add']==true) {
		
		$pdo=Database::getInstancia();
	
		if(isset($_GET['opcion'])) {
				$cuadro=$_GET['opcion'];
				$idUs=$_SESSION['id'];
				//operacion (insert) tabla usuario_has_cuadro
				echo "<script>console.log('$cuadro');</script>";
				try {
					$pdo->insercion("usuario_has_cuadro",$_SESSION['id'],$cuadro);
				} catch(Exception $e) {
					echo "esa imagen ya esta insertada";
				}
				//operacion (insert) tabla cuadro_has_coleccion
				try {
					$pdo->insercion("cuadro_has_coleccion",$cuadro,$_SESSION['id']);
					unset($_SESSION['NumeroPaginas']);
					
					unset($_SESSION['add']);

					echo "<script>window.location.href='./verColeccion.php'</script>";
				} catch(Exception $e) {
					echo "";
				}
		}
	} else {
		//modificacion

		if(isset($_GET['opcion'])) {
			$pdo=Database::getInstancia();
			$eleccion=$_GET['opcion'];
			echo "<script>console.log('mal');</script>";
			$imagenCambiar=$_SESSION['imagenCambiar'];
			//operacion (update) tabla usuario_has_cuadro
			$prepare="UPDATE usuario_has_cuadro SET idCuadro=:condicion0 WHERE idCuadro=:condicion1 AND idUsuario=:condicion2";

			if($eleccion==$imagenCambiar) {
				echo "esa imagen ya esta insertada";
			} else {
				try {
					$pdo->modificacion($prepare,$eleccion,$imagenCambiar,$_SESSION['id']);
					echo "correcto";
				} catch(Exception $e) {
					echo "";
				}
				//operacion (update) tabla cuadro_has_coleccion
				$prepare="UPDATE cuadro_has_coleccion SET idCuadro=:condicion0 WHERE idCuadro=:condicion1 AND idColeccion=:condicion2";
				try {
					$pdo->modificacion($prepare,$eleccion,$imagenCambiar,$_SESSION['id']);
					unset($_SESSION['imagenCambiar']);
					?>
						<script>  window.location.href = "./verColeccion.php";</script>
					<?php
					
				} catch(Exception $e) {
					echo "esa imagen ya esta insertada";
				}
			}
		}

	}
	?>
	<!--FIN MODIFICACION-->
	
	
	<!--FIN ADICION-->
</body>
<!--SWEET ALERT-->
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</html>