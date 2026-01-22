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


// instanciatiant une date avec la class DateTime et mise au format souhaitée.
$dateInput = "2026-01-01";


$dateTime = new DateTime($dateInput);

$dateTime->format("d/m/YYY");// le mois avec un 0 en initial, le jour avec un 0 en initial, l’année sur 4 digit.

// instanciatiant une date avec la class DateTime et mise au format souhaitée PHP .
function dateTime($SQLdate){
    $dateTime = new DateTime($SQLdate);
    $datePHP = $dateTime->format("d/m/Y");// le mois avec un 0 en initial, le jour avec un 0 en initial, l’année sur 4 digit.
    return $datePHP;

}

echo dateTime($dateInput);