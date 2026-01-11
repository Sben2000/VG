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