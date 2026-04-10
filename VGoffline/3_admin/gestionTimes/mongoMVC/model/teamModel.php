<?php

include_once "routes/rootPath.php";
//include_once ACCESSROOT . "/mongoMVC/DB/dbMongo.php";
include_once __ROOT__."/3_admin/DB/dbMongo.php";
require_once __ROOT__ . '/3_admin/gestionTimes/vendor/autoload.php';

/*******************************************Function cleanAndCheckValue appliquée à tous les champs ajoutés ou modifiés********************************************************************************/


function cleanAndCheckValue($value)
{
    //Vérification et Nettoyage la valeur de la variable récupérée 
    $value = htmlspecialchars($value);

    $args = func_get_args(); //récupère l'ensemble des arguments placés dans la fonction dans $args 

    //function : enlever les espaces avant et après des valeurs récupérées dans le tableau $args
    $trim_value = function ($value) {
        return trim($value);
    };

    //array_map($callback, $array) =>applique la fonction de rappel sur tous les éléments d’un tableau, sans modifier le tableau d’origine.
    $args = array_map($trim_value, $args); // $trim_value appliqué sur les valeurs du tableau $args pour leur enlever les espaces

    //Parcourir l'ensemble des valeurs et si une est vide , retourner le message "tous les champs sont requis"
    foreach ($args as $arg) {
        if (empty($arg)) {

            $error = "Tous les champs doivent être complétés";
        }
        //si la variable $error n a pas pu rester vide, elle est retourné pour être traitée
        if (!empty($error))
            //on affiche le message d'erreur
            return $error;
    }
}

/****************************************ENSEMBLE DES FONCTIONS DE BASE DU MVC*********************************************** */

/*La connection à la BDD NOSQL est réalisée via " ACCESSROOT."/mongoMVC/DB_NOSQL/dbMongo.php"
la liaison avec celle ci est réalisée à travers la variable global $collection introduite dans les fonctions*/


/*recupérer les horaires du plus récent au plus ancien*/
function latests_horaires()
{
    //on récupère la variable $collection définie à l'extérieur
    global $collection;
    //Récupérer tous les datas de collection 
    $horaires = $collection->find();
    // return horaires au Controller qui sera utilisé par la views (for each $access as $acces)
    return $horaires;
}

function create($title, $timeDetails, $author, $statut, $createdOn) //function qui ajoute des libelles en récupérant les champs remplis
{

    //on récupère la variable $collection définie à l'extérieur
    global $collection;
    //function qui s'applique uniquement aux datas alphanumériques (excluant le fichier file)
    function checkDatas($title, $timeDetails, $author, $statut, $createdOn)
    {
        //récupère l'ensemble des arguments placés dans la fonction dans $args 
        $args = func_get_args();
        foreach ($args as $arg) {
            //Application de la function de nettoyage et vérification à la valeur intégrée (htmlchars, trim et valeur non vide)
            cleanAndCheckValue($arg);
            //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
            if (!empty(cleanAndCheckValue($arg))) {
                return cleanAndCheckValue($arg);
            }
        }
    }
    //Associer les valeurs postées avec les clés de la collection pour créer un document
    $data = [
        'title' => $title,
        'timeDetails' => $timeDetails,
        'author' => $author,
        'statut' => $statut,
        //classe MongoDB pour créer la date du jour UTC
        'createdOn' => $createdOn
    ];


    //Message de succès si la colletion a été enregistée dans la DB
    //n'est inséré qu'une collection $data à la fois
    $result = $collection->insertOne($data);
    //si le count du nombre inséré >0
    if ($result->getInsertedCount() > 0) {
        return "success";
    } else {
        return "Echec de création d'horaire";
    }
}

/****************************************************Afficher et modifier le l'horaire selectionné******************************************************************/
function view($id)
{ //on récupère l'id du theme à modifier (sélectionné dans la page d'acceuil)

    //on récupère la variable $collection définie à l'extérieur (dans le fichier dbMongo)
    global $collection;
    //Récupérer l'unique ID concerné 
    $horaire = $collection->findOne($id);
    // return horaires au Controller qui sera utilisé par la views (for each $access as $acces)
    return $horaire;
}

function edit($id, $title, $timeDetails, $author,  $statut, $createdOn)
{ //edite les valeurs extraites de la fonction updateAction() du fichier controller qui a récupéré  les valeurs $_POST 
    //Nettoyage des valeurs de variables récupérées 
    //on récupère la variable $collection définie à l'extérieur
    global $collection;
    //function qui s'applique uniquement aux datas alphanumériques 
    function checkDatas($title, $timeDetails, $author, $statut, $createdOn)
    {
        //récupère l'ensemble des arguments placés dans la fonction dans $args 
        $args = func_get_args();
        foreach ($args as $arg) {
            //Application de la function de nettoyage et vérification à la valeur intégrée (htmlchars, trim et valeur non vide)
            cleanAndCheckValue($arg);
            //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
            if (!empty(cleanAndCheckValue($arg))) {
                return cleanAndCheckValue($arg);
            }
        }
    }
    //Associer les valeurs postées avec les clés de la collection pour créer un document
    $data = [
        'title' => $title,
        'timeDetails' => $timeDetails,
        'author' => $author,
        'statut' => $statut,
        'createdOn' => $createdOn
    ];


    //n'est updaté qu'une collection $data à la fois dans l'objet id cité
    $result = $collection->updateOne($id, ['$set' => $data]); //$data inclue un set de clé/valeur sous forme []
    //si le count du nombre modifié >0
    if ($result->getModifiedCount() > 0) {
        return "success";
    } else {
        return "Echec de la mise à jour";
    }
}

/******************************************************************************************************************************************/
function destroy($id) /*function qui supprime l'id get ($id = $_GET['id']) en argument suite à appui sur bouton supprimer dans le fichier views/delete.php (href="index.php?action=destroy&?id=<?php echo $id ?>">Valider la suppression</a>)*/
{

    //$id = htmlspecialchars($id); //Nettoyage la valeur de la variable récupérée
    //récupération de la variable pointant vers la BDD NOSQL et définie dans le fichier dbMongo
    global $collection;
    //On essai de trouver l'id dans la DB (Un seul id normalement)
    $horaireToDelete = $collection->findOne($id);

    //Si l'id n'est pas trouvé , renvoyer un msg d'erreur
    if (!$horaireToDelete) {
        return "Horaire non trouvée.";
    };

    //Supprimer la collection complète lié à 'id 
    $result = $collection->deleteOne($id);
    //si le count du nombre supprimé >0
    if ($result->getDeletedCount() > 0) {
        return "success";
    } else {
        return "Echec de suppression de l'horaire";
    }
}
