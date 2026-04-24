
<?php
//accès aux constantes permettant l'accès à la dB 
require_once "./DB/config.php";

//accès à la DB via la function listée 
require_once "./DB/db.php";

//accès à la DB Mongo
require_once "./DB/dbMongo.php";



function timesList(){

//on récupère la variable $collection définie à l'extérieur
global $collection;
//on ne prend en compte que les offres au statut = "Publier"
$statut = ["statut"=>"Publier"];
//Récupérer tous les datas de collection
$times = $collection->find($statut);
return $times;
}