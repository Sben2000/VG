<?php
//On remonte d'un cran supplémentaire par rapport au dossier DB situé avant le dossier functions
require_once '../Functions/vendor/autoload.php';;
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
    // Etablir la connection avec la BDD MongoDB en récupérant les variables d'environnement.
    try{
		$user = $_ENV["userMongo"];
		$pwd = $_ENV["pwdMongo"];
		$MONGODB_URI = $_ENV["uriMongo"];
		//Via Xampp dans fichier .env ou development.env
		//MONGODB_URI = "mongodb://$user:$pwd@localhost";
		//Via Docker dans fichier production.env
		//MONGODB_URI="mongodb://$user:$pwd@mongo:27017/?authSource=admin";
		//Via Deployement dans fichier deployment.env
		//MONGODB_URI="mongodb+srv://$user:$pwd@cluster0.nndroc9.mongodb.net/";
		$client = new MongoDB\Client("$MONGODB_URI");
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