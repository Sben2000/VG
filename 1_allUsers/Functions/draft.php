<?php
//accès aux constantes permettant l'accès à la dB
require_once "DB/config.php";
//accès à la DB via la function listée
require_once "DB/db.php";

    $conn = DBconnection();
    if(!$conn){
        return false;
    }
//La réf se compose de : l'user_id +l'id commande+date du jour (AAMMJour) avec l'année sur 2 chiffres

//partie ref2 =>//id de la dernière commande connue dans la DB +1 (+1 correspond à l'actuel commande en constructiion) 
$sql ="SELECT MAX(commande_id) FROM commande " ;
$query = $conn->prepare($sql);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);
$ref2 =  $result["MAX(commande_id)"] +1;
echo $ref2;
//partie ref3 => //date du jour au format GMT (« Greenwich Mean Time » ) avec  AnMoisJour (année sur 2 chiffres)
$ref3= gmdate("ymd");
    echo $ref3; 
echo "\n";
echo $ref2."-".$ref3;
    