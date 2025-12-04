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

?>