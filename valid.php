<?php 
$profile=$_GET["profile"];
$name = $_GET["name"]; 
$question = $_GET["question"]; 
$arrOpt = $_GET["options"];


/*Inspiré de 
https://scoutapm.com/blog/php-json_encode-serialize-php-objects-to-json
*/
class scrutin {

}

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
    
?>