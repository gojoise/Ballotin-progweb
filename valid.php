<?php 
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
$scr->question = $question;
$scr->options = $arrOpt;
$scr->votants = [];


$jsonData = json_encode($scr);
file_put_contents("scrutins.json",$jsonData,FILE_APPEND);
    
?>