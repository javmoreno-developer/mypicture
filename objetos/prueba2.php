<?php 
	 //llamada a la API
					  	
	$titulo= file_get_contents('https://picsum.photos/v2/list?page=2&limit=18');//devuelve string
 	//echo $titulo;
 	$array=explode("}", $titulo);
 	//var_dump($array);
 	echo $array[0] . "<br>";

 	//id
 	/*for($i=1;$i<=17;$i++) {

	 	$idArray=explode(",",$array[$i]);
	 	//echo $idArray[1] . "<br>";
	 	$auxId=explode(":",$idArray[1]);
	 	//echo gettype($auxId[1]) . "-" .$auxId[1] . "<br>";
	 	$id=$auxId[1];
	 	$id=substr($id,0 ,-1);
	 	$id=substr($id,1 ,strlen($id));
	 	$id=intval($id);
	 	echo gettype($id) . "-" .$id . "<br>";
	 }*/

	 //autor
	 /*for($i=1;$i<=17;$i++) {
		$autorArray=explode(",",$array[$i]);
		//echo $idArray[1] . "<br>";
		$auxAut=explode(":",$autorArray[2]);
		//echo gettype($auxId[1]) . "-" .$auxId[1] . "<br>";
		$autor=$auxAut[1];
		echo gettype($autor) . "-" .$autor . "<br>";
	}*/
	//url
	$urlArray=explode(",",$array[0]);
	//echo $idArray[1] . "<br>";
	$auxUrl=explode("\"",$urlArray[5]);
	//echo gettype($auxId[1]) . "-" .$auxId[1] . "<br>";
	$url=$auxUrl[3];
	echo gettype($url) . "-" .$url . "<br>";
?>