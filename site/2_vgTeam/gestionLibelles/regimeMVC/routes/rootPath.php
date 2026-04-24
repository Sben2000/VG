<?php
define('ROUTESFILE', basename(__FILE__));//renvoi nom du fichier=> rootPath.php
define('ROUTESFOLDER',dirname(__FILE__));//renvoi chemin du fichier => C:\xampp\htdocs\libelle\regimeMVC\routes
define('LIBELLESROOT',dirname(dirname(ROUTESFOLDER)));//renvoi chemin du dossier de gestion libelles =>C:\xampp\htdocs\libelle
define('__ROOT__',dirname(LIBELLESROOT));//renvoi à la racine =>C:\xampp\htdocs


?>