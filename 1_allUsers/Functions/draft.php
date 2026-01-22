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
    

$ref4 = gmdate("Y/m/d");
echo "\n".$ref4;

$ref5 = str_replace("/", "-", $ref4);
echo "\n".$ref5;


echo(substr($ref4, 0, 4));

echo "\n";
echo "\n";
echo "\n";

$wishedDate = "29/01/2026";
//Préparation pour mise des dates au formats DATE SQL (YYYY-MM-dd)

//date de prestation souhaitée ( au format dd/MM/YYYY)
$DDwishedDate = substr($wishedDate, 0,2);//dd
$MMwishedDate = substr($wishedDate, 3,2);//MM
$YYwishedDate = substr($wishedDate, 6,4);//YYYY
$wishedDate = "{$YYwishedDate}-{$MMwishedDate}-{$DDwishedDate}";//YYYY-MM-dd
echo $wishedDate;

//Récupération de la date format SQL (YYYY-MM-dd) et mise au format dd/MM/YYYY

strtotime("2026-01-29");