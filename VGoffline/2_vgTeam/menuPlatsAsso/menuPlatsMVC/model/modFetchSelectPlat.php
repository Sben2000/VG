<?php


//Ce fichier dévellopant les functions FETCH plat est ensuite inclus dans le fichier Principal du Model : platsAllerModel;

//Function récupérant l'ensemble de la DB pour les afficher en options de la liste déroulante
function getPlats(){


    $pdo=DBconnection();
    if(!$pdo){
        // si la connection n'est pas établi, on s'arrête ici 
        return false;
    }    
    //Récupération de l'ensemble des éléments de la table regroupé (GROUP BY) pour éviter l'affichage des doublons si il y en a
    $sql = ("SELECT * FROM plat GROUP BY titre_plat");
    $query =  $pdo->prepare($sql);
    $query->execute();
     //Récupération des éléments dans un tableau ASSO
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

    //Préparation d'un tableau pour storer les éléments récupérés
    $data=[];

    //Boucler les lignes récupérées si non nulles et  les push dans le tableau
    if($query->rowCount()>0){
        foreach ($results as $result){
            array_push($data, $result);
        }
    }
    //Retourner le tableau
    return $data;
    
}




/********Ecoute de l'ID de l'option sélectionnée et récupération de ces datas pour mise en forme via le fetchJS************ */


//Ecoute potentielle  de la valeur clé ID requêtée via un GET provenant du fetch JS
if(isset($_GET["ID"])){
    //Si requête il y 'a, => appel à la function getData (devellopée plus bas) qui va interroger la DB avec l'argument ID
     echo getDataPlat($_GET["ID"]);

     //note:  echo (afficher) du résultat de la function car il s'agit de la réponse server (encodé en json) récupéré par la méthode fetch dans le fichier JS 
}
// function getData incluant l'argument représentant l'id requêté 
function getDataPlat($id){
//on fait appel à la DB mis dans le dossier MVC en local(car non liée directement via la liaison fetch JS contrairement à liaison des fichiers model PHP_PHP dont l'une fait appel à la DB Root)
include_once  "../DB/db.php";
    $pdo=DBconnection();
    if(!$pdo){
        // si la connection n'est pas établi, on s'arrête ici 
        return false;
    } 

    //on nettoie la valeur de la variable récupéré dans le GET ()
    $id=htmlspecialchars($id);

    //Récupération de la  DB de l'id et du titre_plat ou la colonne plat_id match l'ID' requêtée via GET
    $sql = ('SELECT plat_id, titre_plat FROM plat WHERE plat_id =:ID');
    $query =$pdo->prepare($sql);
    $query->bindParam("ID",$id);
    $query->execute();
    //FETCH_OBJ pour les objets seuls sinon FETCH_ASSOC
    $results = $query->fetchAll(PDO::FETCH_ASSOC);
    return (json_encode($results));    

}



?>