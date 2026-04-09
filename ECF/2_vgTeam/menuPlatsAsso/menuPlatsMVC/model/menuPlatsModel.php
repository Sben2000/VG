<?php

include_once "routes/rootPath.php";
include_once ACCESSROOT."/DB/db.php";

include_once "modFetchSelectMenu.php";
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

//appliquée à l'association plat_id et menu_id dans la table contient

function alreadyExistsAssoc($platID, $menuID,$pdo){
    $sql = "SELECT plat_id, menu_id FROM propose where plat_id =:platID and menu_id =:menuID";
    $query =$pdo->prepare($sql);
    $query->bindParam(":platID",$platID);
    $query->bindParam(":menuID",$menuID);
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
/*recupérer les menus du plus récent au plus ancien*/
function latests_menus(){
    $pdo = DBconnection();
    if(!$pdo){
            return false;
        }
    //récupération de l'ensemble des id du tableau  menu en affichant les derniers enregistrés en prmier (query-> prepare et execute en même temps)
    $menus = $pdo->query(
" SELECT menu.menu_id, menu.titre, menu.theme_id, menu.regime_id, theme.libelle as themeLibelle, regime.libelle as regimeLibelle FROM menu
  JOIN theme ON menu.theme_id = theme.theme_id
  JOIN regime ON menu.regime_id = regime.regime_id
ORDER BY menu_id DESC")->fetchAll(PDO::FETCH_OBJ);

    return $menus; // return menus au Controller qui sera utilisé par la views (for each $access as $acces)
    
}


//function qui récupère dans le tableau contient les libelles et l'id des plats associés (à l'id menu)
function display($menu_id){
    $pdo = DBconnection();
    if(!$pdo){
            return false;
        }
$sql =     "SELECT propose.menu_id, propose.plat_id,  menu.titre, menu.menu_id,  plat.titre_plat, plat.plat_id, plat.photo FROM propose 
JOIN menu ON propose.menu_id = menu.menu_id
JOIN plat ON propose.plat_id = plat.plat_id
WHERE propose.menu_id = :menu_id";
$query = $pdo->prepare($sql);
$query->bindParam(":menu_id", $menu_id, PDO::PARAM_INT);
$query->execute();
$result=$query->fetchAll(PDO::FETCH_OBJ);
//var_dump($result);
return $result;



}



//function de creation d'association
function createAssoc($platID, $menuID)
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
    if (!empty(alreadyExistsAssoc($platID, $menuID,$pdo))){
        return alreadyExistsAssoc($platID, $menuID,$pdo);
    }
     
 
 
    //on prépare la requête comme il s'agit de données récupérés de champs  via create.php 
    $sql = "INSERT INTO propose (plat_id, menu_id) VALUES (:platID, :menuID)";
    $query=$pdo->prepare($sql);
    $query->bindParam(":platID",$platID);
    $query->bindParam(":menuID",$menuID);
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
function view($idMenu, $idPlat){//on récupère l'association d'id à modifier (sélectionné dans la page d'acceuil)
    $pdo = DBconnection();
    if(!$pdo){
        return false;
    }
// echo ($idMenu ."" . $idPlat);
  
    $sql = "SELECT propose.menu_id, propose.plat_id,  menu.titre,  plat.titre_plat, plat.photo FROM propose 
    JOIN menu ON propose.menu_id = menu.menu_id
    JOIN plat ON propose.plat_id = plat.plat_id
    WHERE propose.menu_id= :idMenu AND propose.plat_id= :idPlat";
$query = $pdo->prepare($sql);
$query->bindParam(":idMenu", $idMenu, PDO::PARAM_INT);
$query->bindParam(":idPlat", $idPlat, PDO::PARAM_INT);
$query->execute();
//on affiche l'unique  clé  sélectionnée (donc pas de fetchAll ) =>function récupérée dans editAction partie controller
$result=$query->fetch(PDO::FETCH_OBJ);
//vardump($result);
return $result;

}

//function de substitution d'ID plat au menu concerné
function editPlatAssoc($menuID, $platIDtoReplace, $platNewID){

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

     //si le même id a été sélectionné , pas de mise à jour de la BDD
    if($platIDtoReplace == $platNewID){
        return "Le même choix a été sélectionné => pas de changement réalisé";
    }
    //Application de la function alreadyExists pour vérifier que l'association n'existe pas déjà
      //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
      //menu concerné avec nouveau Plat de substition 
    if (!empty(alreadyExistsAssoc($menuID, $platNewID ,$pdo))){
        return alreadyExistsAssoc($menuID, $platNewID ,$pdo);
    }
     


    //on met à jour la ligne modifiée et on prépare la requête avec les valeurs des arguments récupérés (en ciblant la ligne concernée avec les 2 PK=>WHERE)

    $sql = "UPDATE propose  SET menu_id =:menuID, plat_id =:platNewID WHERE plat_id=:platIDtoReplace and menu_id =:menuID";
    $query=$pdo->prepare($sql);
    $query->bindParam(":menuID", $menuID, PDO::PARAM_INT);
    $query->bindParam(":platNewID", $platNewID, PDO::PARAM_INT);
    $query->bindParam(":platIDtoReplace", $platIDtoReplace, PDO::PARAM_INT);
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
function destroy($idMenu, $idPlat) /*function qui supprime du tableau la ligne concerné par le ou les arguments passés dans la function*/
{

    $idAllergene=htmlspecialchars($idMenu);//Appliqué par défaut comme pour toute les entrées
    $idPlat=htmlspecialchars($idPlat);
    
    $pdo = DBconnection();
    if(!$pdo){
        return false;
    }
    $sql="DELETE FROM propose WHERE menu_id=:idMenu AND plat_id =:idPlat ";
    $query=$pdo->prepare($sql);
    $query->bindParam(":idMenu", $idMenu, PDO::PARAM_INT);
    $query->bindParam(":idPlat", $idPlat, PDO::PARAM_INT);
    $query->execute();
    //si il y a une ligne affectée , la dissociation a été réalisée avec succès, sinon la dissociation n'a pas réussi
        if ($query->rowCount()>0){
        return "successDelete";
        }else{
        return "la dissociation n'a pas réussi, veuillez recommencer";
        }
    
}


