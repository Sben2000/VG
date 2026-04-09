<?php
define('ROUTESFILE', basename(__FILE__));//renvoi nom du fichier=> rootPath.php
define('ROUTESFOLDER',dirname(__FILE__));//renvoi chemin du fichier 
define('ACCESSROOT',dirname(dirname(ROUTESFOLDER)));//renvoi chemin du dossier de gestion ACCESS
define('__ADMINROOT__',dirname(ACCESSROOT));//renvoi à la racine admin=>C:\xampp\htdocs\myCompanyENV\site\3_admin
define('__ROOT__',dirname(__ADMINROOT__));//renvoi à la racine =>C:\xampp\htdocs\myCompanyENV\site
?>