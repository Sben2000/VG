<?php
// commence la session chaque fois que le connexion est lancée
session_start(); 

// DB credentials.
define('DB_HOST','192.168.1.45');/*mettre l'adresse de votre machine obtenue via la cmd prompt : ipconfig*/
define('DB_USER','root');/*par défaut nom d'utilisateur=>à configurer si besoin*/
define('DB_NAME','vgo');/*Nom de la BDD*/
define('DB_PASS','');/*par défaut pas de MDP pour la démo=>à configurer si besoin*/

//Path
define('__ROOT__', __DIR__);

