<?php
define('ROUTESFILE', basename(__FILE__));//renvoi nom du fichier=> rootPath.php
define('ROUTESFOLDER',dirname(__FILE__));//renvoi chemin du fichier => C:\xampp\htdocs\VG\routes
define('__ROOT__',dirname(__DIR__));//renvoi à la racine =>C:\xampp\htdocs\VG
define('ROOT',$_SERVER['DOCUMENT_ROOT']);
define("scriptROOT", $_SERVER['SCRIPT_FILENAME']);


?>