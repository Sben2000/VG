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

/*******************************************Function imageValidation au champs image********************************************************************************/

//définition de la function imageValidation et des arguments passés
function imageValidation($imageName, $imageSize, $imageTemp)
{
    /***********************************Vérification présence image*****'*****************************************************/
    if (empty($imageName)) {
        return "Veuillez ajouter une image";
    }
    /***********************************Vérification de l'extension*****'*****************************************************/

    //on vérifie que l'image uploadé est bien une image (extensions acceptés et type (même si l'extension est corrigée pour correspondre de façon malicieuse, le type d'origine est détécté)) 
    //on utilise la classe fileinfo =>finfo avec le paramètre(FILEINFO_MIME_TYPE) pour vérifier ces données
    $fileInfo = new finfo(FILEINFO_MIME_TYPE); //A media type (formerly known as a Multipurpose Internet Mail Extensions or MIME type) indicates the nature and format of a document, file, or assortment of bytes. MIME types are defined and standardized in IETF's RFC 6838

    //en objet de la variable $fileInfo on requiert le type de media du fichier uploadé qui est placé dans le dossier temp, on assigne le résultat à la variable $mimeType
    $mimeType = $fileInfo->file($imageTemp);

    //on définit les types d'extensions autorisés dans un tableau
    $allowedImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

    //on vérifie que le mimeType est inclus dans le tableau des extensions autorisés via la function in_array
    if (in_array($mimeType, $allowedImageTypes) === false) {
        //si l'extension du fichier n'est pas inclus dans celles autorisées:
        return "seules les extensions jpeg, jpg, png, and gif files sont autorisées";
    }
    /***********************************Vérification de la taille du fichier*****************************************************/

    //on définit la taille max du fichier autorisée (2MB):
    $uploadedMaxSize = 2 * 1024 * 1024;
    //si la taille de l'image uploadé est supérieur à 2MB, avertissement:
    if ($imageSize > $uploadedMaxSize) {
        return "la taille de l'image doit être inférieur à 2MB";
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

function create($title, $description, $author, $city, $contract, $statut, $createdOn, $file) //function qui ajoute des libelles en récupérant les champs remplis
{

    //on récupère la variable $collection définie à l'extérieur
    global $collection;
    //function qui s'applique uniquement aux datas alphanumériques (excluant le fichier file)
    function checkDatas($title, $description, $author, $city, $contract, $statut, $createdOn)
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
        'description' => $description,
        'author' => $author,
        'city'  => $city,
        'contract' => $contract,
        'statut' => $statut,
        //classe MongoDB pour créer la date du jour UTC
        'createdOn' => $createdOn
    ];

    //Contrôle de la présence d'une image et de ses caractéristiques

    //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(imageValidation($file['name'], $file['size'], $file['tmp_name']))) {
        return imageValidation($file['name'], $file['size'], $file['tmp_name']);
    }

    //si il existe un fichier à uploader
    if ($file) {
        //possibilité de créer des critères: size, extension,....pas fait dans notre cas
        //si le fichier est avec son nom tmp est uploadé vers notre dossier upload avec son nom 
        if (move_uploaded_file($file['tmp_name'], 'upload/' . $_FILES['file']['name'])) {
            //ajouter à la clé $data['filename'] le nom du fichier uploadé;
            $data['fileName'] = $file['name'];
        } else {
            return "Echec du chargement de l'image.";
        }
    }

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

function edit($id, $title, $description, $author, $city, $contract, $statut, $createdOn, $file)
{ //edite les valeurs extraites de la fonction updateAction() du fichier controller qui a récupéré  les valeurs $_POST 
    //Nettoyage des valeurs de variables récupérées 
    //on récupère la variable $collection définie à l'extérieur
    global $collection;
    //function qui s'applique uniquement aux datas alphanumériques (excluant le fichier file)
    function checkDatas($title, $description, $author, $city, $contract, $statut, $createdOn)
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
        'description' => $description,
        'author' => $author,
        'city'  => $city,
        'contract' => $contract,
        'statut' => $statut,
        'createdOn' => $createdOn
    ];

    //Contrôle de la présence d'une image et de ses caractéristiques si modifié


    if (!empty($file['name'])) {
        //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
        if (!empty(imageValidation($file['name'], $file['size'], $file['tmp_name']))) {
            return imageValidation($file['name'], $file['size'], $file['tmp_name']);
        }
        //si le fichier est avec son nom tmp est uploadé vers notre dossier upload avec son nom 
        if (move_uploaded_file($file['tmp_name'], 'upload/' . $_FILES['file']['name'])) {
            //ajouter à la clé $data['filename'] le nom du fichier uploadé;
            $data['fileName'] = $file['name'];
        } else {
            return "Echec du chargement de l'image.";
        }
    }

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
    //Si id , identifier si une image est liée auquel cas la supprimer
    $fileName = 'upload/' . $horaireToDelete['fileName'];
    if (file_exists($fileName)) {
        //en cas d'echec de suppression
        if (!unlink($fileName)) {
            return "Echec de suppression de l'image.";
            exit;
        }
    }

    //Supprimer la collection complète lié à 'id 
    $result = $collection->deleteOne($id);
    //si le count du nombre supprimé >0
    if ($result->getDeletedCount() > 0) {
        return "success";
    } else {
        return "Echec de suppression de l'horaire";
    }
}
