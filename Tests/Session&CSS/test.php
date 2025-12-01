<?php

//Conditionnement du démarrage de session (Session déjà active?) pour éviter les doublons (et Notices)
if(session_status() !== PHP_SESSION_ACTIVE){
session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    	<link rel="stylesheet" href="test.css" />
    <title>Document</title>
</head>
<body>
         <div class="nomdeClasse <?php
         if(!isset($_SESSION['user'])){
            echo "sessionClosed";
         }else{
            echo "sessionOpened";}?>">

                <p>Ceci est un test</p>
            </div>
    </div>
</body>
</html>