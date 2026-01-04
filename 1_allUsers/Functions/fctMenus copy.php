<?php
//accès aux constantes permettant l'accès à la dB (mis en dur ci dessous  et non réf au fichier car bug avec le JS (ajax))
require_once "./DB/config.php";

//accès à la DB via la function listée (mis en dur ci dessous  et non réf au fichier car bug lors de requête ajax via  le JS (ajax))
require_once "./DB/db.php";


//function qui récupère les thèmes de menus présent dans la DB
function themesList(){

    //récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }

    //récupération de la liste des themes enregistrés dans la DB
    $sql = "SELECT * FROM theme" ;
    $query = $conn->prepare($sql);
    $query ->execute();
    $result = $query->fetchAll(PDO::FETCH_OBJ);
    //var_dump($result);
    return $result;
}

//function qui récupère les régimes de menus présent dans la DB
function regimesList(){

    //récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }

    //récupération de la liste des themes enregistrés dans la DB
    $sql = "SELECT * FROM regime" ;
    $query = $conn->prepare($sql);
    $query ->execute();
    $result = $query->fetchAll(PDO::FETCH_OBJ);
    //var_dump($result);
    return $result;
}

//function qui récupère l'ensemble des menus (ou les qtés sont > 0) de la DB intégrant les themes et regimes associés 
function getAllMenus(){

    //récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }
    //récupère les menus avec qté >0 et les tri de façon aléatoire (RAND())
    $sql = "
    SELECT menu.menu_id, menu.regime_id, menu.theme_id, menu.titre, menu.nombre_personne_minimum, menu.prix_par_personne, menu.description, menu.photo_menu, menu.quantite_restante,
     theme.theme_id,theme.libelle as theme,
    regime.regime_id, regime.libelle as regime
      FROM menu
    JOIN theme ON menu.theme_id = theme.theme_id
    JOIN regime ON menu.regime_id = regime.regime_id
    WHERE quantite_restante > 0
    ORDER BY RAND();
    " ;
    $query = $conn->prepare($sql);
    $query ->execute();
    $result = $query->fetchAll(PDO::FETCH_OBJ);
    //var_dump($result);
    return $result;
}


//function qui récupère sur la sélection unique du filtre Theme
function getMenusByThemeOnly($selectedTheme){
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
    WHERE quantite_restante > 0 AND menu.theme_id =:selectedTheme
    ORDER BY menu_id DESC;
    " ;
    $query = $conn->prepare($sql);
    $query->bindParam(":selectedTheme",$selectedTheme, PDO::PARAM_INT);
    $query ->execute();
    $result = $query->fetchAll(PDO::FETCH_OBJ);
    //var_dump($result);
    return $result;
}


//function qui récupère sur la sélection unique du filtre Regime
function getMenusByRegimeOnly($selectedRegime){
        //récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }
    //récupère les menus avec le régime choisi et la qté >0  et les tri du plus récent menu au plus ancien
    $sql = "
    SELECT menu.menu_id, menu.regime_id, menu.theme_id, menu.titre, menu.nombre_personne_minimum, menu.prix_par_personne, menu.description, menu.photo_menu, menu.quantite_restante,
     theme.theme_id,theme.libelle as theme,
    regime.regime_id, regime.libelle as regime
      FROM menu
    JOIN theme ON menu.theme_id = theme.theme_id
    JOIN regime ON menu.regime_id = regime.regime_id
    WHERE quantite_restante > 0 AND menu.regime_id =:selectedRegime
    ORDER BY menu_id DESC;
    " ;
    $query = $conn->prepare($sql);
    $query->bindParam(":selectedRegime",$selectedRegime, PDO::PARAM_INT);
    $query ->execute();
    $result = $query->fetchAll(PDO::FETCH_OBJ);
    //var_dump($result);
    return $result;
}