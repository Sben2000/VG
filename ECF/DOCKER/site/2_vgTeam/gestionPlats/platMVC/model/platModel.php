<?php

include_once "routes/rootPath.php";
include_once ACCESSROOT."/DB/db.php";

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

            $error= "le champs requis doit être complété";
            
        }
        //si la variable $error n a pas pu rester vide, elle est retourné pour être traitée
        if (!empty($error)) 
        //on affiche le message d'erreur
        return $error;

        }
}

/*******************************************Function alreadyExists appliquée à tous les types de champs ajoutés ou modifiés pour éviter les doublons********************************************************************************/

//appliquée au titre/libellé

function alreadyExistsDishTitle($dishTitle,$pdo){
    $sql = "SELECT titre_plat FROM plat where titre_plat =:dishTitle";
    $query =$pdo->prepare($sql);
    $query->bindParam(":dishTitle",$dishTitle);
    $query -> execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    //condition sur le paramètre objet ->  pour vérifier si déjà existant
    if(!empty($result->titre_plat )){
        // on affiche le message d'erreur
        $error = "le titre/libellé de ce plat existe déjà dans la Base de Données";
        //si la variable $error n a pas pu rester vide, elle est retourné pour être traitée
        return $error;
    }

}

//appliquée à l'image

function alreadyExistsDishImage($imageTemp,$imageType, $pdo){


//rappel du chemin de stockage temporaire de l'image(car $imageTemp passé en argument ne reprend pas toujours le chemin temporaire complet)
$imageTemp = $_FILES['image']['tmp_name'];

    //application du modèle PHP
    //ouverture du fichier en mode lecture pour le lire en mode binaire (rb = reading binary) 
    $fp = fopen($imageTemp, 'rb');

    $sql = "SELECT photo, contentType FROM plat where photo =:fp AND contentType=:imageType";
    $query =$pdo->prepare($sql);
    $query->bindParam(":fp",$fp, PDO::PARAM_LOB);// LOB : gros objets Binaire (LOB) >4kb
    $query->bindParam(":imageType",$imageType);
    $query -> execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    //var_dump($result);
    //condition sur le paramètre objet ->  pour vérifier si déjà existant
    if(!empty($result->photo)){
        // on affiche le message d'erreur
        $error = "Cette image existe déjà dans la Base de Données";
        //si la variable $error n a pas pu rester vide, elle est retourné pour être traitée
        return $error;
    }

}


 /********Function de vérification et traitement complémentaires*/


//Titre du plat
    function addTreatmentDishTitle($dishTitle){
        if(strlen($dishTitle)>15){
            return "le titre/libellé du plat ne doit pas dépasser 15 caractères";
        }

        if(strlen($dishTitle)<3){
            return "le titre/libellé du plat doit comporter au moins 3 caractères";
        }
        //Vérification des caractères autorisés (alphanumériques (case insensitive) , - et _) uniquement (Upper&Lowercase)
        $masque ="/[^[\w]_\-0-9]/i"; //classe:[], ne contenant pas: ^(interne), les caractères: Toutes lettres(\w) - _ 0à9, minuscule ou majuscule:/i
        preg_match_all($masque, $dishTitle, $resultat);
        if (count($resultat[0])!=0){
        return "le titre/libellé du plat ne doit comporter que des caractères alphanumériques ,sont également admis '-' et '_'";
        }
        }


        //Nom Image

    function addTreatmentImageName($imageName){
        if(strlen($imageName)>20){
            return "le nom de l'image ne doit pas dépasser 20 caractères";
        }

        if(strlen($imageName)<3){
            return "le nom de l'image doit comporter au moins 3 caractères";
        }
        //Vérification des caractères autorisés (alphanumériques (case insensitive) , - et _) uniquement (Upper&Lowercase)
        $masque ="/[^[\w]_\-0-9]/i"; //classe:[], ne contenant pas: ^(interne), les caractères: Toutes lettres(\w) - _ 0à9, minuscule ou majuscule:/i
        preg_match_all($masque, $imageName, $resultat);
        if (count($resultat[0])!=0){
        return "le nom de l'image ne doit comporter que des caractères alphanumériques ,sont également admis '-' et '_'";
        }
        }        
/***************************Validation taille, extensions, présence fichier******************************* */

//définition de la function imageValidation et des arguments passés
function imageValidation($imageName, $imageSize, $imageTemp, $imageType){
    
    /***********************************Vérification présence fichier suite à soumission**********************************************************/
/*
    //on vérifie qu'un fichier est bien sélectionné en récupérant le nom de celui ci
    if(empty($imageName)){
        return "Veuillez selectionner une image";
    }
*/
    /***********************************Vérification des caractéristiques du nom image**********************************************************/

    //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(addTreatmentImageName($imageName))){
        return addTreatmentImageName($imageName);
    }

    /***********************************Vérification de l'extension*****'*****************************************************/

    //on vérifie que l'image uploadé est bien une image (extensions acceptés et type (même si l'extension est corrigée pour correspondre de façon malicieuse, le type d'origine est détécté)) 
    //on utilise la classe fileinfo =>finfo avec le paramètre(FILEINFO_MIME_TYPE) pour vérifier ces données
    $fileInfo = new finfo(FILEINFO_MIME_TYPE);//A media type (formerly known as a Multipurpose Internet Mail Extensions or MIME type) indicates the nature and format of a document, file, or assortment of bytes. MIME types are defined and standardized in IETF's RFC 6838

    //en objet de la variable $fileInfo on requiert le type de media du fichier uploadé qui est placé dans le dossier temp, on assigne le résultat à la variable $mimeType
    $mimeType = $fileInfo->file($imageTemp);

    //on définit les types d'extensions autorisés dans un tableau
    $allowedImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];

    //on vérifie que le mimeType est inclus dans le tableau des extensions autorisés via la function in_array
        if(in_array($mimeType, $allowedImageTypes) === false){
            //si l'extension du fichier n'est pas inclus dans celles autorisées:
        return "Seules les extensions jpeg, jpg, png, and gif files sont autorisées";
    }
    //possible d'utiliser directement $imageType en lieu et place de $mimeType
    /***********************************Vérification de la taille du fichier*****************************************************/
    
  
    //on définit la taille max du fichier autorisée (1MB) afin d'éviter les erreurs à la lecture de fichier trop volumineux:
    $uploadedMaxSize = 900*1024; 
    //si la taille de l'image uploadé est supérieur à 1MB, avertissement:
    if($imageSize > $uploadedMaxSize){
        $error = "L'image ne doit pas être supérieur à 900ko";
        return $error;
    }
    
    /***********************************Renommage du fichier via la function dévellopée pour*****************************************************/

    //on renomme le fichier à l'aide de la function renameImage() dévellopée à la suite (qui vérifie également que le nom n'existe pas dans le dossier uploads)
    //$newName = renameImage($imageName);


}


/****************************************ENSEMBLE DES FONCTIONS DE BASE DU MVC*********************************************** */
/*recupérer les plat des employés du plus récent au plus ancien*/
function latests_plats(){
    $pdo = DBconnection();
    if(!$pdo){
            return false;
        }
    //récupération de l'ensemble des données du tableau  en affichant les derniers enregistrés en prmier (query-> prepare et execute en même temps)
    $plats = $pdo->query("SELECT * FROM plat ORDER BY plat_id DESC")->fetchAll(PDO::FETCH_OBJ);
    return $plats; // return plats au Controller qui sera utilisé par la views (for each $access as $acces)
    
}

/*Function ci dessous non utilisée =>trouvé une alternative (base64_encode) plus simple directement dans le fichier liste_plats et lien :https://openclassrooms.com/forum/sujet/telecharger-une-image-blob-sur-dans-un-fichier et https://stackoverflow.com/questions/54638875/using-php-pdo-to-show-image-blob-from-mysql-database-in-html-image-tag
function displayPicture($id, $photo, $contentType)

{

    $pdo = DBconnection();
    if(!$pdo){
            return false;
        }
    
    //récupération de l'mage selon modèle Doc PHP (https://www.php.net/manual/fr/pdo.lobs.php) et https://blog.crea-troyes.fr/4099/format-blob-comment-stocker-une-image-en-base-de-donnees/
    $sql = "SELECT photo, contentType FROM plat  where plat_id=:id";
    $query = $pdo->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);

    //on execute la requête avec l'id récupéré
    $query->execute();
 
    //On lie la column contentType (type d'extension) positionné en 4 dans la requête  à la variale $imageContentType
    $query->bindParam(2,$contentType, PDO::PARAM_STR, 256);
    //On lie la column photo positionnéE en 3 dans la requête  à la variale $imageLOB, on spécifie le type requêté (PARAM_LOB)
    $query->bindParam(1,$photo, PDO::PARAM_LOB);

    //on récupère (fetch) les données liées (BOUND) aux colonnes au format adéquat pour la lecture
   $query->fetch(PDO::FETCH_BOUND);

    //on envoie au navigateur en utilisant la fonction fpassthru() et en passant le type dans un header.
    header("Content-Type: $contentType");
    return $photo;
    

    
}
    */
//function de creation sans ajout d'image
function createDish($dishTitle)
{
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
    //Application de la function alreadyExists pour éviter les doublons dans la BDD en récupérant la connection ouverte
           //titre_plat
      //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(alreadyExistsDishTitle($dishTitle,$pdo))){
        return alreadyExistsDishTitle($dishTitle,$pdo);
    }
     
    //Application des functions de traitements Complémentaires 
    addTreatmentDishTitle($dishTitle);

 
    //on prépare la requête comme il s'agit de données récupérés de champs  via create.php 
    $sql = "INSERT INTO plat (plat_id, titre_plat) VALUES (null, :dishTitle)";
    $query=$pdo->prepare($sql);
    $query->bindParam(":dishTitle", $dishTitle, PDO::PARAM_STR);
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
//function de creation avec ajout d'image
function createDishImage($dishTitle, $imageName, $imageSize, $imageTemp, $imageType)
{
    
        $pdo = DBconnection();
        if(!$pdo){
            return false;
        }

    //on définit la taille max du fichier autorisée (900kO) afin d'éviter les erreurs à la lecture de fichier trop volumineux causant des pb de max-allowed pour la DB:
    $uploadedMaxSize = 900*1024; 
    //si la taille de l'image uploadé est supérieur à 900ko, avertissement:
    if($imageSize > $uploadedMaxSize){
        $error = "L'image ne doit pas être supérieur à 900ko";
        return $error;
    }

    
    //var_dump($dishTitle, $imageName, $imageSize, $imageTemp, $imageType);
    $args = func_get_args();//récupère l'ensemble des arguments placés dans la fonction dans $args 

    foreach ($args as $arg){
    //Application de la function de nettoyage et vérification à la valeur intégrée (htmlchars, trim et valeur non vide) à $libelle
    cleanAndCheckValue($arg);
        //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(cleanAndCheckValue($arg))){
        return cleanAndCheckValue($arg);
    }
}
    //Application de la function alreadyExists pour éviter les doublons dans la BDD en récupérant la connection ouverte
           //titre_plat
    //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(alreadyExistsDishTitle($dishTitle,$pdo))){
        return alreadyExistsDishTitle($dishTitle,$pdo);
    }
     
    //photo.extension
    //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(alreadyExistsDishImage($imageName, $imageType, $pdo))){
        return alreadyExistsDishImage($imageName, $imageType, $pdo);
    }

    //Application des functions de traitements Complémentaires 
    //titre_plat
    //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    addTreatmentDishTitle($dishTitle);
    if (!empty(addTreatmentDishTitle($dishTitle))){
        return addTreatmentDishTitle($dishTitle);
    }
    //Application des autres traitement pour l'image via function imageValidation
    imageValidation($imageName, $imageSize, $imageTemp, $imageType);
    //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(imageValidation($imageName, $imageSize, $imageTemp, $imageType))){
        return imageValidation($imageName, $imageSize, $imageTemp, $imageType);
    }
    
 
    //on prépare la requête comme il s'agit de données récupérés de champs  via create.php 
    $sql = "INSERT INTO plat (plat_id, titre_plat, photo, contentType) VALUES (null, :dishTitle, :photoContent, :photoType)";
    $query=$pdo->prepare($sql);
    //rappel du chemin de stockage temporaire de l'image (car $imageTemp passé en argument ne reprend pas toujours le chemin temporaire complet)
    $imageTemp = $_FILES['image']['tmp_name'];
    //selon modèle doc PHP on ouvre en mode lecture le fichier image  en lecture binaire (rb) en spécifiant son chemin de stockage temporaire
    $photoContentRB = fopen($imageTemp, 'rb');
    
    //Liaison des paramètres
    $query->bindParam(":dishTitle", $dishTitle, PDO::PARAM_STR);
    $query->bindParam(":photoContent", $photoContentRB, PDO::PARAM_LOB);//code type PDO::PARAM_LOB pour gérer les gros Objet selon doc PHP
    $query->bindParam(":photoType", $imageType, PDO::PARAM_STR);
    
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
function view($id){//on récupère l'id à modifier (sélectionné dans la page d'acceuil)
    $pdo = DBconnection();
    if(!$pdo){
        return false;
    }
    $sql="SELECT * FROM plat WHERE plat_id=:id";
    $query=$pdo->prepare($sql);
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    $query->execute();
    //on affiche l'unique  clé  sélectionnée (donc pas de fetchAll ) =>function récupéré dans editAction partie controller
    return $query->fetch(PDO::FETCH_OBJ);
}

//function de modification sans ajout d'image
function editDish($id, $dishTitle)
{
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

//Récupération des données actuelles de la Table pour agir uniquement sur les valeurs modifiées
        $sql="SELECT * FROM plat WHERE plat_id=:id";
        $query=$pdo->prepare($sql);
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();
        //on affiche l'unique  clé sélectionnée (donc pas de fetchAll ) =>function récupéré dans editAction partie controller
        $currentDatas = $query->fetch(PDO::FETCH_OBJ);

    //Application des functions de vérifications/contrôles utilisées dans create si les données ont été modifiées.
    // Si nom du plat  modifié
        
        if (($dishTitle != $currentDatas->titre_plat)){
        //Application de la function alreadyExists pour éviter les doublons dans la BDD en récupérant la connection ouverte
            //titre_plat
        //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
        if (!empty(alreadyExistsDishTitle($dishTitle,$pdo))){
            return alreadyExistsDishTitle($dishTitle,$pdo);
        }
        
        //Application des functions de traitements Complémentaires 
        addTreatmentDishTitle($dishTitle);

    }

    //si aucun champs n'a été modifié, pas de mise à jour de la BDD
    if($dishTitle == $currentDatas->titre_plat){
        return "Aucune modification n'a été détectée";
    }

    //on met à jour la ligne modifiée et on prépare la requête comme il s'agit de données récupérés de champs  via create.php 
    $sql = "UPDATE plat  SET titre_plat =:dishTitle WHERE plat_id=:id";
    $query=$pdo->prepare($sql);
    $query->bindParam(":dishTitle", $dishTitle, PDO::PARAM_STR);
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    $query->execute();
    
    //on vérifie qu'une ligne a bien été affectée (confirmant l'enregistrement dans la dB) 
         $count=$query->rowCount();
    //si il y a un  $count >0 , l'enregistrement a été réalisé avec succès, sinon l'enregistrement n'a pas réussi
        if ($count > 0){
        return "success";
        }else{
        return "la modification n'a pas réussi, veuillez recommencer";
        }
    
}
//function de modification avec ajout d'image
function editDishImage($id, $dishTitle, $imageName, $imageSize, $imageTemp, $imageType)
{
    
        $pdo = DBconnection();
        if(!$pdo){
            return false;
        }

    //on définit la taille max du fichier autorisée (900kO) afin d'éviter les erreurs à la lecture de fichier trop volumineux causant des pb de max-allowed pour la DB:
    $uploadedMaxSize = 900*1024; 
    //si la taille de l'image uploadé est supérieur à 900ko, avertissement:
    if($imageSize > $uploadedMaxSize){
        $error = "L'image ne doit pas être supérieur à 900ko";
        return $error;
    }

    
    //var_dump($dishTitle, $imageName, $imageSize, $imageTemp, $imageType);
    $args = func_get_args();//récupère l'ensemble des arguments placés dans la fonction dans $args 

    foreach ($args as $arg){
    //Application de la function de nettoyage et vérification à la valeur intégrée (htmlchars, trim et valeur non vide) à $libelle
    cleanAndCheckValue($arg);
        //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(cleanAndCheckValue($arg))){
        return cleanAndCheckValue($arg);
    }
}

//Récupération des données actuelles de la Table pour agir uniquement sur les valeurs modifiées
        $sql="SELECT * FROM plat WHERE plat_id=:id";
        $query=$pdo->prepare($sql);
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();
        //on affiche l'unique  clé sélectionnée (donc pas de fetchAll ) =>function récupéré dans editAction partie controller
        $currentDatas = $query->fetch(PDO::FETCH_OBJ);

    //Application des functions de vérifications/contrôles utilisées dans create si les données ont été modifiées.
    // Si nom du plat  modifié
        
    if (($dishTitle != $currentDatas->titre_plat)){

    //Application de la function alreadyExists pour éviter les doublons dans la BDD en récupérant la connection ouverte
           //titre_plat
    //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(alreadyExistsDishTitle($dishTitle,$pdo))){
        return alreadyExistsDishTitle($dishTitle,$pdo);
    }
     
    //Application des functions de traitements Complémentaires 
    //titre_plat
    //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    addTreatmentDishTitle($dishTitle);
    if (!empty(addTreatmentDishTitle($dishTitle))){
        return addTreatmentDishTitle($dishTitle);
    }
    }

    // Si une image est chargée pour modification de l'actuelle

    // on applique ensuite les fonctions de contrôle

    //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(alreadyExistsDishImage($imageName, $imageType, $pdo))){
        return alreadyExistsDishImage($imageName, $imageType, $pdo);
    }

    //Application des autres traitement pour l'image via function imageValidation
    imageValidation($imageName, $imageSize, $imageTemp, $imageType);
    //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(imageValidation($imageName, $imageSize, $imageTemp, $imageType))){
        return imageValidation($imageName, $imageSize, $imageTemp, $imageType);
    }
    


    //si aucune modification n'a été modifié (au moins du titre si nouvelle image chargée)
    if($imageTemp==NULL){
        if($dishTitle == $currentDatas->titre_plat){
                    return "Aucune modification n'a été détectée";
            }
    }
    //on update les valeurs sauf l'id qui ne se modifie pas( auto incrémenté) 
    $query=$pdo->prepare("UPDATE plat 
                            SET  titre_plat=:dishTitle, photo=:photoContent, contentType=:photoType 
                            WHERE plat_id =:id");
    //rappel du chemin de stockage temporaire de l'image (car $imageTemp passé en argument ne reprend pas toujours le chemin temporaire complet)
    $imageTemp = $_FILES['image']['tmp_name'];
    //selon modèle doc PHP on ouvre en mode lecture le fichier image  en lecture binaire (rb) en spécifiant son chemin de stockage temporaire
    $photoContentRB = fopen($imageTemp, 'rb');
    //Liaison des paramètres    
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    $query->bindParam(":dishTitle", $dishTitle, PDO::PARAM_STR);
    $query->bindParam(":photoContent", $photoContentRB, PDO::PARAM_LOB);//code type PDO::PARAM_LOB pour gérer les gros Objet selon doc PHP
    $query->bindParam(":photoType", $imageType, PDO::PARAM_STR);
    $query->execute();

    //on vérifie qu'une ligne a bien été affectée (confirmant l'enregistrement dans la dB) 
         $count=$query->rowCount();
    //si il y a un $count >0 , l'enregistrement a été réalisé avec succès, sinon l'enregistrement n'a pas réussi
        if ($count > 0){
        return "success";
        }else{
        return "la modification n'a pas réussi, veuillez recommencer";
        }                       
    
}


/******************************************************************************************************************************************/
function destroy($id) /*function qui supprime l'id get ($id = $_GET['id']) en argument suite à appui sur bouton supprimer dans le fichier views/delete.php (href="index.php?action=destroy&?id=<?php echo $id ?>">Valider la suppression</a>)*/
{
     
    $id=htmlspecialchars($id);//Nettoyage la valeur de la variable récupérée

    $pdo = DBconnection();
    if(!$pdo){
        return false;
    }
    $sql="DELETE FROM plat WHERE plat_id=:id";
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


