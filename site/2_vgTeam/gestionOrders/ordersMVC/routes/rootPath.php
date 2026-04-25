<?php
define('ROUTESFILE', basename(__FILE__));//renvoi nom du fichier=> rootPath.php
define('ROUTESFOLDER',dirname(__FILE__));//renvoi chemin du fichier => C:\xampp\htdocs\libelle\nomDossier\routes
define('ACCESSROOT',dirname(dirname(ROUTESFOLDER)));//renvoi chemin du dossier de gestion ACCESS
define('__ROOT__',dirname(ACCESSROOT));//renvoi à la racine =>C:\xampp\htdocs
define('ROOTER',dirname(__ROOT__));

?>