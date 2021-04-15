<?php

$name = $_GET["name"];

$jsonstring = file_get_contents("listepredef.json");
$json = json_decode($jsonstring);

if($name == ""){
	echo "";
}else{
	foreach($json as $key=>$obj){
    foreach ($obj as $arr) {
        if(key($obj)==$name) echo json_encode($arr); //Donne l'array des votants de la liste des votants à ajax
    }
}
}




?>
