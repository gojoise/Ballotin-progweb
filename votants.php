<?php 
$name = $_GET["name"];
$arrVot = $_GET["electeurs"];
$arrProc = $_GET["procurations"];
$res = array();
$toPut;

/*Inspiré de 
https://scoutapm.com/blog/php-json_encode-serialize-php-objects-to-json
*/
$json_string = file_get_contents("scrutins.json");
$json = json_decode($json_string, true);

foreach ($json as $index => $obj) {
    if($obj["name"] == $name){
        $toPut=$obj;
    }
}

$toReasign=array_search($toPut,$json);

class vot{

}
for($i=0;$i< count($arrVot);$i=$i+1){
    $vo = new vot();
    $vo->name=$arrVot[$i];
    $vo->nbVotes = $arrProc[$i];
    array_push($toPut["votants"], $vo);
}

unset($json[$toReasign]);
$json=array_values($json);
array_push($json,$toPut);


$strNew = json_encode($json);
file_put_contents("scrutins.json", $strNew);

?>