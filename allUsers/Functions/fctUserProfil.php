<?php
//accès aux constantes permettant l'accès à la dB
require_once "./DB/config.php";
//accès à la DB via la function listée
require_once "./DB/db.php";


//function qui récupère les coordonnées du user
function userProfilDatas($username){

    //récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }

    //récupération des coordonnées user enregistrés dans la DB
    $sql = "SELECT * FROM utilisateur WHERE nom_utilisateur = :username";
    $query = $conn->prepare($sql);
    $query->bindParam(":username", $username, PDO::PARAM_STR);
    $query ->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    return $result;

}

//function qui récupère les comandes du user
function fetchUserOrders($username){

    //récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }

    //récupération de l'id du user
    $sql = "SELECT utilisateur_id FROM utilisateur WHERE nom_utilisateur = :username";
    $query = $conn->prepare($sql);
    $query->bindParam(":username", $username, PDO::PARAM_STR);
    $query ->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $userID= $result["utilisateur_id"];
    
    //récupération des commandes passées par le user

    $sql = "SELECT * FROM commande WHERE utilisateur_id = :user_id";
    $query = $conn->prepare($sql);
    $query->bindParam(":user_id", $userID, PDO::PARAM_INT);
    $query ->execute();
    //potentiellement +eurs commandes (fetchAll)
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

//Récupération des datas du (table) menu correspondant à chaque commande identifiée
    //initialisation de la Table commune
    $Table=[];
    //Loop à travers chacune des commandes pour en récupérer le menu_id
    for ($i=0; $i<count($results);$i++){
            $orderMenuID = $results[$i]["menu_id"];
            //récupération des datas du menu identifié à chaque loop
            $sql = "SELECT * FROM menu WHERE menu_id = :orderMenuID";
            $query = $conn->prepare($sql);
            $query->bindParam("orderMenuID",$orderMenuID,PDO::PARAM_INT);
            $query ->execute();
            $menuData = $query->fetch(PDO::FETCH_ASSOC);
            //merge des datas de la commande et du menu à chaque Loop
            $mergedResult = array_merge($results[$i], $menuData);
            //Push la table assoc.merged(data cde+menu) de chaque loop  dans La Table initialisée
            array_push($Table, $mergedResult);
        
    }
    //retourne Table recomposée complète (avec ss tables par cde+menu) pour exploitation dans Account.php 
    return $Table;

}



?>

