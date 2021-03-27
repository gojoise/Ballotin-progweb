<?php
	$email = htmlspecialchars($_POST["email"])
	$passwd = htmlspecialchars($_POST["passwd"])
$dataJson = file_get_contents(filename.json);
$donne = json_encode($dataJson, true);

	$donne[$mail.' '.$passwd] = array (

		'email' => $email,




	)





?>