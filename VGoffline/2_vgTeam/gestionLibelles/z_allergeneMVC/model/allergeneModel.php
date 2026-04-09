<?php

include_once "routes/rootPath.php";
include_once __ROOT__."/DB/db.php";


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

            $error= "champs ne pouvant être vide";
            
        }
        //si la variable $error n a pas pu rester vide, elle est retourné pour être traitée
        if (!empty($error)) 
        //on affiche le message d'erreur
        return $error;

        }
}

/*******************************************Function alreadyExists appliquée à tous les champs ajoutés ou modifiés pour éviter les doublons********************************************************************************/

function alreadyExists($value,$pdo){
    $sql = "SELECT libelle FROM allergene where libelle =:libelle";
    $query =$pdo->prepare($sql);
    $query->bindParam(":libelle",$value);
    $query -> execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    //condition sur le paramètre objet ->  pour vérifier si déjà existant
    if($result->libelle != NULL){
        // on affiche le message d'erreur
        $error = "Cet élément existe déjà dans la Base de Données";
        //si la variable $error n a pas pu rester vide, elle est retourné pour être traitée
        if (!empty($error)) 
        return $error;
    }

}
/****************************************ENSEMBLE DES FONCTIONS DE BASE DU MVC*********************************************** */
function latests_allergenes()
{
    $pdo = DBconnection();
    if(!$pdo){
            return false;
        }
    //récupération de l'ensemble des données du tableau
    $allergenes = $pdo->query("SELECT * FROM allergene ORDER BY allergene_id DESC")->fetchAll(PDO::FETCH_OBJ);
    return $allergenes; // return allergenes au Controller qui sera utilisé par la views (for each $allergenes as $allergene)
    
}

function create($libelle)//function qui ajoute des libelles en récupérant les champs remplis
{
    
        $pdo = DBconnection();
        if(!$pdo){
            return false;
        }
    //Application de la function de nettoyage et vérification à la valeur intégrée (htmlchars, trim et valeur non vide) à $libelle
    cleanAndCheckValue($libelle);
        //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(cleanAndCheckValue($libelle))){
        return cleanAndCheckValue($libelle);
    }
    //Application de la function alreadyExists pour éviter les doublons dans la BDD en récupérant la connection ouverte
     alreadyExists($libelle,$pdo);
             //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(alreadyExists($libelle,$pdo))){
        return alreadyExists($libelle,$pdo);
    }           

    //on prépare la requête comme il s'agit de données récupérés de champs  via create.php
    $sql = "INSERT INTO allergene (allergene_id, libelle) VALUES (null, :libelle)";
    $query=$pdo->prepare($sql);
    $query->bindParam(":libelle", $libelle, PDO::PARAM_STR);
    $query->execute();
    
    //on vérifie que le dernier Id enregistré est supérieur à O (confirmant l'enregistrement dans la dB) ->PDO::lastInsertId() Returns the ID of the last inserted row, or the last value from a sequence object.
            $lastInserted=$pdo->lastInsertId();
    //si il y a un id >0 , l'enregistrement a été réalisé avec succès, sinon l'enregistrement n'a pas réussi
        if ($lastInserted > 0){
        return "success";
        }else{
        return "l'enregistrement n'a pas réussi, veuillez recommencer";
        }
    
}
/****************************************************Afficher et modifier le libellé selectionné******************************************************************/
function view($id){//on récupère l'id du allergene à modifier (sélectionné dans la page d'acceuil)
    $pdo = DBconnection();
    if(!$pdo){
        return false;
    }
    $sql="SELECT * FROM allergene WHERE allergene_id=:id";
    $query=$pdo->prepare($sql);
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    $query->execute();
    //on affiche l'unique libellé dont la clé a été sélectionnée (donc pas de fetchAll ) =>function récupéré dans editAction partie controller
    return $query->fetch(PDO::FETCH_OBJ);
}

function edit($id, $libelle){//edite les valeurs extraites de la fonction updateAction() du fichier controller qui a récupéré  les valeurs $_POST 
    //Nettoyage des valeurs de variables récupérées 
    
    $pdo = DBconnection();
    if(!$pdo){
        return false;
    }
    $id=htmlspecialchars($id);
    //Application de la function de nettoyage et vérification à la valeur intégrée (htmlchars, trim et valeur non vide) à $libelle
    cleanAndCheckValue($libelle);
        //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(cleanAndCheckValue($libelle))){
        return (cleanAndCheckValue($libelle));
    }
    //Application de la function alreadyExists pour éviter les doublons dans la BDD en récupérant la connection ouverte
     alreadyExists($libelle,$pdo);
             //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(alreadyExists($libelle,$pdo))){
        return alreadyExists($libelle,$pdo);
    }        

    //on update les valeurs sauf l'id qui ne se modifie pas( auto incrémenté) 
    $query=$pdo->prepare("UPDATE allergene 
                            SET libelle =:libelle 
                            WHERE allergene_id =:id");
    $query->bindParam(":libelle", $libelle, PDO::PARAM_STR);
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    return $query->execute();// on termine la function en retournant l'execution de la query (possibilité d'afficher un message de succès en option)                        
   
}

/******************************************************************************************************************************************/
function destroy($id) /*function qui supprime l'id get ($id = $_GET['id']) en argument suite à appui sur bouton supprimer dans le fichier views/delete.php (href="index.php?action=destroy&?id=<?php echo $id ?>">Valider la suppression</a>)*/
{
     
    $id=htmlspecialchars($id);//Nettoyage la valeur de la variable récupérée

    $pdo = DBconnection();
    if(!$pdo){
        return false;
    }
    $sql="DELETE FROM allergene WHERE allergene_id=:id";
    $query=$pdo->prepare($sql);
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    $query->execute();
    //si il y a une ligne affectée , la suppression a été réalisée avec succès, sinon la suppression n'a pas réussi
        if ($query->rowCount()>0){
        return "success";
        }else{
        return "la suppression n'a pas réussi, veuillez recommencer";
        }
}


