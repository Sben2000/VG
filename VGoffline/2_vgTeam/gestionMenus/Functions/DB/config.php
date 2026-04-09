<?php
// commence la session chaque fois que le connexion est lancée
session_start(); 


// DB credentials. old méthode avant fichier .env

    // define('DB_HOST', 'localhost');/*adresse docker IP4: 192.168.1.68 ou host.docker.internal*/
    // define('DB_USER','root');/*par défaut nom d'utilisateur=>à configurer si besoin*/
    //define('DB_NAME','vgo');/*Nom de la BDD*/
    // define('DB_PASS','');/**/

//Path
define('__ROOT__', dirname(dirname(__DIR__))); //renvoi à la racine site=> ...\1_allUsers
//On remonte d'un cran uniquement ici car ce dossier DB est à l'intérieur du dossier Functions pour combler la pb du fichier JS API FETCH à récupérer les mêmes chemins
define('__ROOTER__', dirname(dirname(__ROOT__))); //renvoi à la racine site=> ...\site
//echo __ROOTER__;
//Requérir le fichier autoload de dotenv
require_once realpath(__ROOTER__."/vendor/autoload.php");//=>check via  echo  __ROOT__."/vendor/autoload.php";

//Utilisation de la Bibliothèque Dotenv
use Dotenv\Dotenv;
//appel de la méthode createImmutable pour charger le fichier .env là ou il se trouve (crée à la racine )
$dotenv = Dotenv::createImmutable(__ROOTER__);
//appel de la méthode load sur l'objet renvoyé pour charger les valeurs de fichier dans l'environnement
$dotenv->load();

//Test de recupération
//var_dump($dotenv->load());

//Les valeurs sont chargées via la superglobale $_ENV() ou via getenv() dans le fichier db.php 

?>