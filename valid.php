<?php 
$name = $_GET["name"]; 
$question = $_GET["question"]; 

echo($name);
echo($question);


//t'occupes pas de ça c'est juste pour que j'ai un exmple d'array de coté :)
$arrOpt = $_GET["options"]// l'idée c'est de recup ça comme ça ^^ pas besoin si $_GET[options] est ok !

$data=json_encode($name);
file_put_contents("scrutins.json",$data,FILE_APPEND);
    
?>