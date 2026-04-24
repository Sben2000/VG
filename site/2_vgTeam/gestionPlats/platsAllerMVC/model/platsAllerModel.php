<?php

include_once "routes/rootPath.php";
include_once __ROOT__ . "/DB/db.php";
include_once "modFetchSelectAllerg.php";
include_once "modFetchSelectPlat.php";


/*******Function récupérant l'ensembles des données Plats et  allergenes de la DB pour les afficher en options de la liste déroulante et gérant le FETCHJS*****************/

//=>gérés dans les fichiers modelFetchXXXX.php respectifs et inclus en entête du présent document.


/*******************************************Function cleanAndCheckValue appliquée à tous les champs ajoutés ou modifiés********************************************************************************/

function cleanAndCheckValue($value){
    //Vérification et Nettoyage la valeur de la variable récupérée 
    $value=htmlspecialchars($value);
    
    $args = func_get_args();//récupère l'ensemble des arguments placés dans la fonction dans $args 
            
        //function : enlever les espaces avant et après des valeurs récupérées dans le tableau $args
        $trim_value = function ($value){
        return trim($value); 
        };
                
        //array_map($callback, $array) =>applique la fonction de rappel sur tous les éléments d’un tableau, sans modifier le tableau d’origine.
        $args = array_map($trim_value, $args); // $trim_value appliqué sur les valeurs du tableau $args pour leur enlever les espaces

        //Parcourir l'ensemble des valeurs et si une est vide , retourner le message "tous les champs sont requis"
        foreach ($args as $arg) {
            if (empty($arg)){

            $error= "Sélection requise incomplète";
            
        }
        //si la variable $error n a pas pu rester vide, elle est retourné pour être traitée
        if (!empty($error)) 
        //on affiche le message d'erreur
        return $error;

        }
}


/*******************************************Function alreadyExists appliquée à tous les types de champs ajoutés ou modifiés pour éviter les doublons********************************************************************************/

//appliquée à l'association plat_id et allergene_id dans la table contient

function alreadyExistsAssoc($platID, $allergeneID,$pdo){
    $sql = "SELECT plat_id, allergene_id FROM contient where plat_id =:platID and allergene_id =:allergeneID";
    $query =$pdo->prepare($sql);
    $query->bindParam(":platID",$platID);
    $query->bindParam(":allergeneID",$allergeneID);
    $query -> execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    //condition sur le paramètre objet ->  pour vérifier si l'association requétée existe déjà ou non
    if(!empty($result->plat_id )){
        // on affiche le message d'erreur
        $error = "Cette association existe déjà dans la Base de Données";
        //si la variable $error n a pas pu rester vide, elle est retourné pour être traitée
        return $error;
    }

}


/****************************************ENSEMBLE DES FONCTIONS DE BASE DU MVC*********************************************** */
/*recupérer les plat des employés du plus récent au plus ancien*/
function latests_plats(){
    $pdo = DBconnection();
    if(!$pdo){
            return false;
        }
    //récupération de l'ensemble des id du tableau  plat en affichant les derniers enregistrés en prmier (query-> prepare et execute en même temps)
    $plats = $pdo->query("SELECT * FROM plat ORDER BY plat_id DESC")->fetchAll(PDO::FETCH_OBJ);

    return $plats; // return plats au Controller qui sera utilisé par la views (for each $access as $acces)
    
}

//function qui récupère dans le tableau contient les libelles et l'id des allergènes associés
function display($plat_id){
    $pdo = DBconnection();
    if(!$pdo){
            return false;
        }
$sql =     "SELECT contient.allergene_id, contient.plat_id,  allergene.libelle,  plat.titre_plat FROM contient 
JOIN allergene ON contient.allergene_id = allergene.allergene_id
JOIN plat ON contient.plat_id = plat.plat_id
WHERE contient.plat_id = :plat_id";
$query = $pdo->prepare($sql);
$query->bindParam(":plat_id", $plat_id, PDO::PARAM_INT);
$query->execute();
$result=$query->fetchAll(PDO::FETCH_OBJ);

return $result;



}



//function de creation d'association
function createAssoc($platID, $allergeneID)
{
        $pdo = DBconnection();
        if(!$pdo){
            return false;
        }

    $args = func_get_args();//récupère l'ensemble des arguments placés dans la fonction dans $args 

    foreach ($args as $arg){
    //Application de la function de nettoyage et vérification à la valeur intégrée (htmlchars, trim et valeur non vide) 
    cleanAndCheckValue($arg);
        //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(cleanAndCheckValue($arg))){
        return cleanAndCheckValue($arg);
    }
}
    //Application de la function alreadyExists pour éviter les doublons dans la BDD en récupérant la connection ouverte
      //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(alreadyExistsAssoc($platID, $allergeneID,$pdo))){
        return alreadyExistsAssoc($platID, $allergeneID,$pdo);
    }
     
 
 
    //on prépare la requête comme il s'agit de données récupérés de champs  via create.php 
    $sql = "INSERT INTO contient (plat_id, allergene_id) VALUES (:platID, :allergeneID)";
    $query=$pdo->prepare($sql);
    $query->bindParam(":platID",$platID);
    $query->bindParam(":allergeneID",$allergeneID);
    $query -> execute();

    //on vérifie qu'une ligne a bien été affectée (confirmant l'enregistrement dans la dB) 
         $count=$query->rowCount();
    //si il y a un $count >0 , l'enregistrement a été réalisé avec succès, sinon l'enregistrement n'a pas réussi
        if ($count > 0){
        return "successCreate";
        }else{
        return "l'enregistrement n'a pas réussi, veuillez recommencer";
        }    
        

}


/****************************************************Afficher et modifier le libellé selectionné******************************************************************/
function view($idAllergene, $idPlat){//on récupère l'association d'id à modifier (sélectionné dans la page d'acceuil)
    $pdo = DBconnection();
    if(!$pdo){
        return false;
    }
// echo ($idAllergene ."" . $idPlat);
  
    $sql = "SELECT contient.allergene_id, contient.plat_id,  allergene.libelle,  plat.titre_plat, plat.photo FROM contient 
    JOIN allergene ON contient.allergene_id = allergene.allergene_id
    JOIN plat ON contient.plat_id = plat.plat_id
    WHERE contient.allergene_id= :idAllergene AND contient.plat_id= :idPlat";
$query = $pdo->prepare($sql);
$query->bindParam(":idAllergene", $idAllergene, PDO::PARAM_INT);
$query->bindParam(":idPlat", $idPlat, PDO::PARAM_INT);
$query->execute();
//on affiche l'unique  clé  sélectionnée (donc pas de fetchAll ) =>function récupérée dans editAction partie controller
$result=$query->fetch(PDO::FETCH_OBJ);
//vardump($result);
return $result;

}

//function de substitution d'ID Allergene au plat concerné
function editAllergAssoc($platID, $allergIDtoReplace, $allergeneNewID){

        $pdo = DBconnection();
        if(!$pdo){
            return false;
        }

    $args = func_get_args();//récupère l'ensemble des arguments placés dans la fonction dans $args 

    foreach ($args as $arg){
    //Application de la function de nettoyage et vérification à la valeur intégrée (htmlchars, trim et valeur non vide) à $libelle
    cleanAndCheckValue($arg);
        //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(cleanAndCheckValue($arg))){
        return cleanAndCheckValue($arg);
    }
    }

     //si le même id a été sélectionné , pas de mise à jour de la BDD
    if($allergIDtoReplace == $allergeneNewID){
        return "Le même choix a été sélectionné => pas de changement réalisé";
    }
    //Application de la function alreadyExists pour vérifier que l'association n'existe pas déjà
      //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
      //plat concerné avec nouvel Allergene de substition 
    if (!empty(alreadyExistsAssoc($platID, $allergeneNewID ,$pdo))){
        return alreadyExistsAssoc($platID, $allergeneNewID ,$pdo);
    }
     


    //on met à jour la ligne modifiée et on prépare la requête avec les valeurs des arguments récupérés (en ciblant la ligne concernée avec les 2 PK=>WHERE)

    $sql = "UPDATE contient  SET plat_id =:platID, allergene_id =:allergeneNewID WHERE allergene_id=:allergIDtoReplace and plat_id =:platID";
    $query=$pdo->prepare($sql);
    $query->bindParam(":platID", $platID, PDO::PARAM_INT);
    $query->bindParam(":allergeneNewID", $allergeneNewID, PDO::PARAM_INT);
    $query->bindParam(":allergIDtoReplace", $allergIDtoReplace, PDO::PARAM_INT);
    $query->execute();
    
    //on vérifie qu'une ligne a bien été affectée (confirmant l'enregistrement dans la dB) 
         $count=$query->rowCount();
    //si il y a un  $count >0 , l'enregistrement a été réalisé avec succès, sinon l'enregistrement n'a pas réussi
        if ($count > 0){
        return "successEdit";
        }else{
        return "la modification n'a pas réussi, veuillez recommencer";
        }

    }

/******************************************************************************************************************************************/
function destroy($idAllergene, $idPlat) /*function qui supprime du tableau la ligne concerné par le ou les arguments passés dans la function*/
{

    $idAllergene=htmlspecialchars($idAllergene);//Appliqué par défaut comme pour toute les entrées
    $idPlat=htmlspecialchars($idPlat);
    
    $pdo = DBconnection();
    if(!$pdo){
        return false;
    }
    $sql="DELETE FROM contient WHERE allergene_id=:idAllergene AND plat_id =:idPlat ";
    $query=$pdo->prepare($sql);
    $query->bindParam(":idAllergene", $idAllergene, PDO::PARAM_INT);
    $query->bindParam(":idPlat", $idPlat, PDO::PARAM_INT);
    $query->execute();
    //si il y a une ligne affectée , la dissociation a été réalisée avec succès, sinon la dissociation n'a pas réussi
        if ($query->rowCount()>0){
        return "successDelete";
        }else{
        return "la dissociation n'a pas réussi, veuillez recommencer";
        }
    
}


