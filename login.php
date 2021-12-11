<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--icons-->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
	<!--scroll reveal-->
	<script src="https://unpkg.com/scrollreveal"></script>
	<!--style-->
	<link rel="stylesheet" href="./css/loginStyle.css">
	<!--favicon-->
	<link rel="shortcut icon" href="img/favicon4.ico" type="image/x-icon">
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<title>LOGIN</title>
</head>
<body>
	<?php 
		session_start();
		require_once "./objetos/Database.php";
		require_once "./objetos/Usuario.php";

		//extraemos los datos del formulario y comparamos con los de la bd
		if(isset($_GET['usuario'])) {
			$usuario=$_GET['usuario'];
			$password=$_GET['contrasena'];
			
			//PDO
			
			$db=Database::getInstancia();

			//hacemos query (para select)
			$resultado=Usuario::buscarUsuario($usuario,$password);
			if($resultado->rowCount()==0) {
				echo "<script>console.log('usuario mal');</script>";
			} else {
				foreach($resultado as $item) {
					$_SESSION['id']=$item['idUsuario'];
				}
				header("Location: ./logueado.php");
			}
			//cerramos el cursor
			$resultado->closeCursor();
			//cerramos la clase
			Database::cerrarConexion();

		}//fin if
	?>
	<!--LOGIN-->
	<section id="containerLogin">
		<div id="card1">
			<div id="elementosLogin">
				<h1>Sign in</h1>
				<div class="iconos">
					<div class="icono1"><i class="bi bi-instagram"></i></div>
					<div class="icono2"><i class="bi bi-google"></i></div>
					<div class="icono3"><i class="bi bi-shield-shaded"></i></div>
				</div>
				
				<form action="login.php">
					<p class="grey">or use your account</p>
					<input type="text" placeholder="usuario" name="usuario" pattern="([A-Za-z0-9_]{1,15})">
					<input type="password" placeholder="contrasena" name="contrasena" ><!--pattern="([A-Za-z0-9_]{1,15}\d{1,4})"-->
					<button type="submit">SIGN IN</button>
				</form>
			</div>
		</div>
		<div id="card2">
			<div id="overlay">
				<h1 id="tituloOverlay">Hello, Friend!</h1>
				<p id="parrafoOverlay">Enter your personal details and start journey with us</p>
				<button type="button" id="up">SIGN UP</button>
			</div>
			<div id="signUp">
				<h1>Create Account</h1>
				<div class="iconos">
					<div class="icono1"><i class="bi bi-instagram"></i></div>
					<div class="icono2"><i class="bi bi-google"></i></div>
					<div class="icono3"><i class="bi bi-shield-shaded"></i></div>
				</div>

				<form action="login.php">
					<p class="grey">or use your email for registration</p>
					
					<input type="text" placeholder="usuario" name="usuarioNuevo">
					<input type="password" placeholder="contrasena" name="contrasenaNueva">
					<button type="submit">SIGN UP</button>
				</form> 
			</div>
		</div>
	</section>
	<!--SIGN UP-->
	<?php 
		if(isset($_GET['usuarioNuevo'])) {
			$usuarioNuevo=$_GET['usuarioNuevo'];
			$contrasenaNueva=$_GET['contrasenaNueva'];
			$pdo=Database::getInstancia();

			//comprobar si existe			
			$e=Usuario::buscarUsuario($usuarioNuevo,$contrasenaNueva);
			
			if($e->rowCount()==0) {
				//operacion (select) tabla usuario (esto para obtener el ultimo id y asignar a este nuevo id+1)
				$resultado=$pdo->leer("usuario");
				$contador=0;
				foreach($resultado as $item) {
					$contador++;
				}
				$idNuevo=++$contador;
				$pdo->insercion("usuario",$idNuevo,$usuarioNuevo,$contrasenaNueva,"https://picsum.photos/1700/700");
				$_SESSION['id']=$idNuevo;
				?>
				<script>window.location.href = "./logueado.php";</script>
				<?php
			} else {
				?>
				<script>
				Swal.fire({
				  icon:"info",
				  title: 'Usuario existente',
				  showDenyButton: false,
				  showCancelButton: false,
				  confirmButtonText: 'Aceptar',
				}).then((result) => {
				  
				  if (result.isConfirmed) {
				    window.location.href = "./login.php";
				 }
				})
			</script>
				<?php
			}
		}
	 ?>
	<script src="js/login.js"></script>
</body>
</html>