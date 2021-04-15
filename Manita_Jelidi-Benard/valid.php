<?php 
$profile=$_GET["profile"];
$name = $_GET["name"]; 
$question = $_GET["question"]; 
$arrOpt = $_GET["options"];


/*Inspiré de 
https://scoutapm.com/blog/php-json_encode-serialize-php-objects-to-json
*/


if($name == "" || $question == "" || $arrOpt == null){ 
    // Petite coquille "$arrOpt = null" pendant la soutenance ce qui faisait mettre options à null dans le json
}else{
    
class scrutin {

}
//On créé un objet à la volée pour le mettre dans le JSON
$scr= new scrutin();
$scr->name = $name;
$scr->organisateur = $profile;
$scr->question = $question;
$scr->options = $arrOpt;
$scr->votants = [];
$scr->closed = false;


$json_string = file_get_contents("scrutins.json");
$json = json_decode($json_string, true);

array_push($json, $scr);

$strNew = json_encode($json);
file_put_contents("scrutins.json", $strNew);
    
}


?>