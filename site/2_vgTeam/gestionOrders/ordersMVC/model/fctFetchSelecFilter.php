<?php
//requête de la DB
include_once "../routes/rootPath.php";
include_once ACCESSROOT."/DB/db.php";


//function qui récupère l'ensemble des menus (ou les qtés sont > 0) de la DB intégrant les themes et regimes associés 
function getAllStatus(){

    //récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }
    //récupère les menus avec qté >0 et les tri de façon aléatoire (RAND())
    $sql = "
    SELECT * FROM commande
    INNER JOIN utilisateur ON commande.utilisateur_id = utilisateur.utilisateur_id
    INNER JOIN menu ON commande.menu_id = menu.menu_id
    ORDER BY commande.date_prestation ASC;
    " ;
    $query = $conn->prepare($sql);
    $query ->execute();
    $result = $query->fetchAll(PDO::FETCH_OBJ);
    //var_dump($result);
    return $result;
}


//function qui récupère sur la sélection unique du filtre 
function getStatusSelectedOnly($selectedFilter){
    
        //récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }
  
    //récupère les menus avec le thème choisi et la qté >0  et les tri du plus récent menu au plus ancien
    $sql = "
    SELECT * FROM commande 
    INNER JOIN utilisateur ON commande.utilisateur_id = utilisateur.utilisateur_id
    INNER JOIN menu ON commande.menu_id = menu.menu_id
    WHERE commande.statut = :selectedFilter
    ORDER BY commande.date_prestation ASC;
    
    " ;
    $query = $conn->prepare($sql);
    $query->bindParam(":selectedFilter", $selectedFilter, PDO::PARAM_STR);
    $query ->execute();
    $result = $query->fetchAll(PDO::FETCH_OBJ);
   return $result;

}


//Vérification/écoute d'un éventuel POST possédant la clé "selectedFilter" (via une url)

if(isset($_POST['selectedFilter'])){

    //Récupèration de la valeur séléctionnée et transmise
    $selectedFilter = $_POST['selectedFilter'];
    //vérification de cette valeur
    //si la valeur est égale à "all"
    if($selectedFilter ==="all"){
        //on affiche toute les valeurs via la fonction dévellopée dans fctMenus.php
        $status = getAllStatus();
    }else{
        //sinon affichage uniquement le status selectionné en passant celui ci dans la function getStatusSelectedOnly
        $status = getStatusSelectedOnly($selectedFilter);

       }
    //on renvoi le résultat au JS au format json

    echo json_encode($status);

}

