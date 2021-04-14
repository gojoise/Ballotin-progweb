<?php

$profile =$_GET["profile"];
$scr =$_GET["Scrutin"];
$option =$_GET["opt"];








$jsonstring = file_get_contents("scrutins.json");
$json = json_decode($jsonstring,true);
$tomodify = null;
foreach ($json as $obj) {
	if($scr == $obj["name"]){
		foreach ($obj["votants"] as $index => $value) {
			if($value["name"] ==$profile && $value["nbVotes"] > 0){
				$tomodify = $value;
			}
		}
	}
}

if($tomodify != null){
	foreach ($json as $index => $obj) {
		if($obj["name"] == $scr){
			$toPut=$obj;
		}
	}
	$toReasign=array_search($toPut,$json);
	$toReasign2=array_search($tomodify,$toPut["votants"]);
	
	$tomodify["nbVotes"]--;
	
	
	unset($json[$toReasign]["votants"][$toReasign2]);
	$json[$toReasign]["votants"]=array_values($json[$toReasign]["votants"]);
	
	array_push($json[$toReasign]["votants"],$tomodify);
	
	//unset($json[$toReasign]);
	//$json=array_values($json);
	
	$strNew = json_encode($json);
	file_put_contents("scrutins.json", $strNew);
}else {
	echo("Vos votes sont épuisés");
}

?>