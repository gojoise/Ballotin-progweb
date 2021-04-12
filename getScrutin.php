<?php 
$profile =$_GET["profile"];
$action = $_GET["action"];


$jsonstring = file_get_contents("scrutins.json");
$json = json_decode($jsonstring);
$res = array();

$org="organisateur";
$vota="votants";
$name="name";

switch ($action) {
    case 'all':
        //Tout les scrutins sans conditions
        echo $jsonstring;
        break;
    case 'owner':
        //Tout les scrutins qui vérifient orga = $profile
        foreach($json as $index=>$obj){
            if($obj->$org==$profile){
                array_push($res,$obj);
            }
        }
        echo json_encode($res);
        break;
    case 'votable':
        //Tout les scrutins  qui vérifient array_exist($profile)
        foreach($json as $index=>$obj){
            $arrVot=$obj->$vota;
            foreach ($arrVot as $key => $value) {
                if($value->$name == $profile){
                    array_push($res,$obj);
                }
                
            }
        }
        echo json_encode($res);
        break;
        
}

?>