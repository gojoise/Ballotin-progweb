<?php

$profile =$_GET["profile"];
$scr =$_GET["Scrutin"];
$option =$_GET["opt"];
class A{

}
class B{
}

function putVote($sous,$scrutin,$optionglobal){
	$jsonstring=file_get_contents("results.json");
	$json=json_decode($jsonstring,true);
	
	$resToIncr=null;
	$nbOpt=count($sous["options"]);
	$numOpt=array_search($optionglobal,$sous["options"]);
	//On regarde si le resultat existe déjà
	foreach ($json as $key => $obj) {
		if($obj["name"]==$scrutin){
			$resToIncr=$obj;//On le récup
			$resToIncrIndex=$key; //ainsi que l'index
		}
	}
	//Si il existe on le modifie
	if($resToIncr!=null){
		
		/*resToIncr = Array ( [name] => second [res] => 
							Array ( [0] => Array ( [D] => 0 ) 
									[1] => Array ( [E] => 1 ) 
									[2] => Array ( [F] => 0 ) 
								) 
						)
		resofToIncr = Array ( [0] => Array ( [D] => 0 ) 
							[1] => Array ( [E] => 1 ) 
							[2] => Array ( [F] => 0 ) 
						)
		*/
		$resofToIncr=$resToIncr["res"];
		foreach ($resofToIncr as $index => $value) {
			if(key($value)==$optionglobal){
				$save = $value;
				unset($resofToIncr[$index]);
				$resofToIncr=array_values($resofToIncr);

				$save[$optionglobal]++;
				array_push($resofToIncr,$save);
			}		
		}
		$toDel=array_search($resToIncr,$json);
		$resToIncr["res"]=$resofToIncr;
		unset($json[$toDel]);
		$json=array_values($json);
		array_push($json,$resToIncr);
	//Sinon on créé le résultat pour l'ajouter dans le tableau
	}else{
		$resPut = new A();
		$resPut->name = $scrutin;
		$resPut->res = [];
		for ($i=0; $i <$nbOpt ; $i++) { 
			$op = new B();
			if($i==$numOpt){
				$optName = $sous["options"][$i];
				$op->$optName=1;
				array_push($resPut->res,$op);
			}else{
				$optName = $sous["options"][$i];
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