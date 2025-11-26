<?php
define('ROUTESFILE', basename(__FILE__));//renvoi nom du fichier=> rootPath.php
define('ROUTESFOLDER',dirname(__FILE__));//renvoi chemin du fichier => C:\xampp\htdocs\VG\_allUsers\routes
define('__ROOT__',dirname(dirname(ROUTESFOLDER)));//renvoi à la racine =>C:\xampp\htdocs\VG

echo ROUTESFOLDER;
?>

