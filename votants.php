<?php 
$arrVot = $_GET["electeurs"];
$arrProc = $_GET["procurations"];
$res = array();

/*Inspiré de 
https://scoutapm.com/blog/php-json_encode-serialize-php-objects-to-json
*/
$json_string = file_get_contents("scrutins.json");
$json = json_decode($json_string, true);
class vot{

}
for($i=0;$i< count($arrVot);$i=$i+1){
    $vo = new vot();
    $vo->name=$arrVot[$i];
    $vo->nbVotes = $arrProc[$i];
    array_push($json["votants"], $vo);
}




$strNew = json_encode($json);
file_put_contents("scrutins.json", $strNew);

?>