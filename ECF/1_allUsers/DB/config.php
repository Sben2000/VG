<?php
// commence la session chaque fois que le connexion est lancée
session_start(); 

// DB credentials.
define('DB_HOST','127.0.0.1');/*adresse localhost, à reconfig si besoin*/
define('DB_USER','root');/*par défaut nom d'utilisateur=>à configurer si besoin*/
define('DB_NAME','vgo');/*Nom de la BDD*/
define('DB_PASS','');/*par défaut pas de MDP pour la démo=>à configurer si besoin*/

//Path
define('__ROOT__', __DIR__);

