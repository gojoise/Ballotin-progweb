<?php

$profile =$_GET["profile"];
$scr =$_GET["Scrutin"];
$option =$_GET["opt"];
class A{

}
class B{
}

function putVote($obj,$one,$two){
	$jsonstring=file_get_contents("results.json");
	$json=json_decode($jsonstring,true);
	
	$toIncr=null;
	
	$nbOpt=count($obj["options"]);
	$numOpt=array_search($two,$obj["options"]);
	//On regarde si le resultat existe déjà
	foreach ($json as $key => $obj) {
		if($obj["name"]==$one){
			$toIncr=$obj;//On le récup
		}
	}
	//Si il existe on le modifie
	if($toIncr!=null){
		$toDel=array_search($json,$toIncr);
		unset($json[$toDel]);
		$json=array_values($json);
		
		foreach ($toIncr["res"] as $index => $OBJopt) {
			foreach ($OBJopt as $value) {
				if(key($OBJopt) == $two){
					$toplus=array_search($value,$toIncr["res"][$numOpt]);
				}
			}
		}
		$toIncr["res"][$numOpt][$toplus]++;
		array_push($json,$toIncr);
	//Sinon on créé le résultat pour l'ajouter dans le tableau
	}else{
		$resPut = new A();
		$resPut->name = $one;
		$resPut->res = [];
		for ($i=0; $i <$nbOpt ; $i++) { 
			$op = new B();
			if($i==$numOpt){
				$optName = $obj["options"][$i];
				$op->$optName=1;
				array_push($resPut->res,$op);
			}else{
				$optName = $obj["options"][$i];
				$op->$optName=0;
				array_push($resPut->res,$op);
			}
		}
		array_push($json,$resPut);
	}
	$strNew = json_encode($json);
	file_put_contents("results.json", $strNew);

}

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
	putVote($toPut,$scr,$option);
	
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