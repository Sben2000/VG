<?php

//accès aux constantes permettant l'accès à la dB
require_once "./DB/config.php";
//accès à la DB via la function listée
require_once "./DB/db.php";
//accès à la fonction sendMail pour messages automatiques
require_once './PHP_Mailer/SendMailFunction.php'; 
use PHPMailer\PHPMailer\PHPMailer; //classe PHPMailer pour instancier notre mail ;
use PHPMailer\PHPMailer\Exception;// Exception du dossier PHP Mailer pour gérer les erreurs d'envoi




//function qui récupère les détails menu/thème/régime du menu sélectionné (via le menuID envoyé via l'url encodé depuis menu.php)
function getSelectedMenu($selectedMenuID){
        //récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }
    //récupère les menus avec le thème choisi et la qté >0  et les tri du plus récent menu au plus ancien
    $sql = "
    SELECT menu.menu_id, menu.regime_id, menu.theme_id, menu.titre, menu.nombre_personne_minimum, menu.prix_par_personne, menu.description, menu.photo_menu, menu.quantite_restante,
     theme.theme_id,theme.libelle as theme,
    regime.regime_id, regime.libelle as regime
      FROM menu
    JOIN theme ON menu.theme_id = theme.theme_id
    JOIN regime ON menu.regime_id = regime.regime_id
    WHERE quantite_restante > 0 AND menu.menu_id =:selectedMenuID
    " ;
    $query = $conn->prepare($sql);
    $query->bindParam(":selectedMenuID",$selectedMenuID, PDO::PARAM_INT);
    $query ->execute();
    //fetch (sans ALL) car un seul menu sélectionné via l'url dans menu.php
    $result = $query->fetch(PDO::FETCH_OBJ);
    //var_dump($result);
    return $result;
}

//function élaborée pour récupérer les plats associés au menu en passant par la table Propose et menu_id 

function getProposePlatByMenuID($menuID){

    //récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }

    //récupération des détails des plats associés pour un menu_id identifié via les jointures sur la table propose 
    $sql = "
    SELECT propose.menu_id, menu.menu_id,
    plat.titre_plat, plat.plat_id, plat.photo
    FROM propose
    JOIN menu ON propose.menu_id = menu.menu_id
    JOIN plat ON propose.plat_id = plat.plat_id
    WHERE propose.menu_id =:menuID
    " ;
    $query = $conn->prepare($sql);
    $query->bindParam(":menuID", $menuID, PDO::PARAM_INT);
    $query ->execute();
    //fetch all car potentiellement plats 
    $result = $query->fetchAll(PDO::FETCH_OBJ);
    //var_dump($result);
    return $result;
}


/****Ajout de journée(s) à la date du jour (cours studi)***/

//date du jour au format html (Année-Mois-Jour)
$today = date('Y-m-d');

//lendemain au format html (Année-Mois-Jour)
$tomorrow = date('Y-m-d', strtotime($today. ' + 1 days'));

//Quinzaine au format html (Année-Mois-Jour)
$twoWeeks = date('Y-m-d', strtotime($today. ' + 14 days'));


//Function qui met en forme et enregistre les données de la commande dans la DB (et maj le compte user éventuellement si ok )
function createUserOrder($userID, $name, $firstname, $email, $phoneNumber, $adress, $cityName, $postalCode,  $wishedDate, $wishedTime,  $selectedMenu, $peopleNbrSpec, $priceMenu, $reductionRate, $deliveryPrice, $totalPrice, $recordDeliveryDatas){
        
//récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }
//Récupèration de l'ensemble des arguments placés dans la fonction dans $args (qui devient un tableau contenant les entrées utilisateurs passés en argument)
$args=func_get_args();

    //assignation de function permettant de nettoyer les données des caractères spéciaux
    $sanitize_value = function($value){
        return htmlspecialchars($value);
    };

    //application de la fonction de rappel nettoyage sur tous les arguments récupérés et assignation à $args.
    array_map($sanitize_value, $args);

//mise en forme des datas (lettres capitales, majuscule, minuscules, ...)
$name = strtoupper($name);
$firstname = strtolower($firstname);//met l'ensemble du prénom en minsucule avant de capitaliser la 1ère lettre.
$firstname = ucfirst($firstname);
$adress = strtolower($adress);
$cityName = strtoupper($cityName);
//Par défaut, toutes les commandes acceptés sont en france
$country = "FRANCE";

//Si la checkbox contient la valeur "checked", les données sont enregistrés dans le compte user, (sinon pas d'update des données profil user)
if($recordDeliveryDatas == "checked"){
    $sql = "UPDATE utilisateur SET nom =:nameUser, prenom =:firstname, telephone =:phoneNumber, ville =:cityName, pays=:country, adresse_postale =:adress, code_postal =:postalCode WHERE utilisateur_id =:userID" ;
    $query=$conn->prepare($sql);
    $query->bindParam(":userID", $userID, PDO::PARAM_STR);
    $query->bindParam(":nameUser", $name, PDO::PARAM_STR);
    $query->bindParam(":firstname", $firstname, PDO::PARAM_STR);
    $query->bindParam(":phoneNumber", $phoneNumber, PDO::PARAM_STR);
    $query->bindParam(":cityName", $cityName, PDO::PARAM_STR);
    $query->bindParam(":country", $country, PDO::PARAM_STR);
    $query->bindParam(":adress", $adress, PDO::PARAM_STR);
    $query->bindParam(":postalCode", $postalCode, PDO::PARAM_STR);
    $query->execute();
    //on vérifie qu'une ligne a bien été affectée (confirmant l'enregistrement dans la dB) 
         $count=$query->rowCount();
    //si il n' y a pas un  $count >0 , l'enregistrement la modification n'a pas réussi, veuillez recommencer
        if (!$count > 0){
        return "l'enregistrement de vos données n'a pas réussi, veuillez recommencer";
        }
}


//echo($userID . "," . $name .",". $firstname ."," . $phoneNumber ."," . $cityName."," . $country."," . $adress."," . $postalCode . "," . $wishedDate . "," . $wishedTime . "," . $peopleNbrSpec . "," . $deliveryPrice . "," . $totalPrice . "," . $selectedMenu . "," . $recordDeliveryDatas);
if ($recordDeliveryDatas=="checked"){
    echo ($userID . "," . $name .",". $firstname ."," . $phoneNumber ."," . $cityName."," . $country."," . $adress."," . $postalCode . "," . $wishedDate . "," . $wishedTime . "," . $peopleNbrSpec . "," . $deliveryPrice . "," . $totalPrice . "," . $selectedMenu . "," . $recordDeliveryDatas);
}else{
    echo("not checked");
}
//Référecement de la commande: ind+1 de dernièreCommande_nom_prénom_dateDuJour

    //récupération de l'indice de dernière commande et ajout+1 pour intégration dans la réf de commande



}

