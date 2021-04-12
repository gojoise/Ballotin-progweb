<?php 
$name = $_GET["name"];
$profile =$_GET["profile"];
$action = $_GET["action"];


$jsonstring = file_get_contents("scrutins.json");
$json = json_decode($jsonstring);
$res = array();

switch ($action) {
    case 'all':
        //Tout les scrutins sans conditions
        echo $jsonstring;

        break;
    case 'owner':
        //Tout les scrutins qui vérifient orga = $profile
        foreach($json as $key=>$obj){
            if ($obj["organisateur"]=$profile){
                array_push($res,$obj);
            }
        }
        echo json_encode($res);
        break;
    case 'votable':
        //Tout les scrutins  qui vérifient array_exist($profile)
        foreach($json as $key=>$obj){
            $vots=$obj["votans"];
            if(in_array($profile,$res)){
                array_push($res,$obj);
            }  
        }
        echo json_encode($res);
        break;
        
}

?>