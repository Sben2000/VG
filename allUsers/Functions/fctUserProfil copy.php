<?php

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
    $result = $query->fetch(PDO::FETCH_OBJ);
    $userID= $result->utilisateur_id;
    


    //récupération des commandes passées par le user

    $sql = "SELECT * FROM commande WHERE utilisateur_id = :user_id";
    $query = $conn->prepare($sql);
    $query->bindParam(":user_id", $userID, PDO::PARAM_INT);
    $query ->execute();
    //potentiellement +eurs commandes (fetchAll)
    $result = $query->fetchAll(PDO::FETCH_OBJ);
    return $result;


}
?>