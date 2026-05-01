<?php

require_once './Functions/vendor/autoload.php';
//Méthodes de connexion avec user et Mdp selon: https://www.php.net/manual/en/mongodb.tutorial.library.php
/*Méth 1:
	use MongoDB\Client as Mongo;
	$user = "user1";
	$pwd = 'studi...';
	$mongo = new Mongo("mongodb://".$user.":".$pwd."@127.0.0.1:27017");
	//var_dump($mongo);
*/
//Méth 2: 
/*
	$user = "user1";
	$pwd = 'studi...';
	// connection string 
	$uri = "mongodb://$user:$pwd@localhost";

	// attempt connection to database with $uri 
	$client = new MongoDB\Client("$uri");
	if (!isset($client)) {
	echo ('error: la connexion a échoué');
	}
*/
    // Etablir la connection avec la BDD MongoDB.
    try{
		$user = "user1";
		$pwd = 'studi...';
		$uri = "mongodb://$user:$pwd@localhost";
		//$uri = "mongodb://user1:studi...@mongo:27017/";
		$uri="mongodb://user1:studi...@mongo:27017/?authSource=admin";
		$client = new MongoDB\Client("$uri");
    }
    catch(MongoDB\Driver\Exception $e){ 
        $errorMessage = "Erreur de connexion:" .$e->getMessage() ;
		echo $errorMessage;
        return false;

    }

	//Ajouter la database à prendre en compte par le client
	$database = $client->selectDatabase('vgo');

	//Ajouter/créer une collection de la précédente database mentionnée
	$collection = $database->selectCollection('times');

?>