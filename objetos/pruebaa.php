<?php 
require_once "Cuadro.php";
require_once "Database.php";
require_once "Usuario.php";
require_once "Artista.php";
require_once "Coleccion.php";

$pdo=Database::getInstancia() ;

$cuadro1=new Cuadro(1,"cuadro1","https://picsum.photos/id/237/400/500","2021-11-04","1");

/*$res=$pdo->lecturaColumnas("cuadro");
foreach($res as $item) {
	echo $item[0] . ",";
}*/
/*$res=$pdo->leer("cuadro");
foreach($res as $item) {
	var_dump($item[0]) . ",";
}*/

//$a=$pdo->insercion("borrar",3,"prueba","39");
//$pdo->eliminacion("borrar","id","1","3","1");
/*$prepare="UPDATE borrar SET id=:condicion0 WHERE id=:condicion1 AND nombre=:condicion2";
$pdo->modificacion($prepare,4,5,"Moreno");*/

$usuario=new Usuario(1,"javier","javi1234","https://picsum.photos/id/108/300/300");
$res=Usuario::buscarUsuario("javier","javi1234");
var_dump($res);

if($res->rowCount()==0) {
	echo "ewee";
} else {
	foreach($res as $item) {
		echo $item['idUsuario'];
	}
}


/*$res=Artista::artistaRelCuadro($cuadro1);

foreach($res as $item) {
	var_dump($item[0]) . ",";
}*/
/*
$a=new Usuario(3,'prueba','prueba','https://picsum.photos/id/237/300/300');

$a->changePhoto(3,"https://picsum.photos/id/237/300/300");*/

/*$a=new Coleccion(1,"a",9,"a");

echo $a->getNumero();*/
?>