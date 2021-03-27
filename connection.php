<?php 
$mail = $_GET["mail"];
$passwd = $_GET["password"];
$dataJson = file_get_contents("resources/passwd.json");
$data = json_decode($dataJson, true);


if($data[$mail] == $passwd){
	echo "Ok.";
}else{
	echo "Erreur";
}



?>