<?php

include_once "routes/rootPath.php";
//include_once ACCESSROOT."/DB/db.php";
//include_once "DBprov/db.php";


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

            $error= "Aucun nouveau statut n'a été sélectionné, <br> le dernier statut est donc conservé par défaut";
            
        }
        //si la variable $error n a pas pu rester vide, elle est retourné pour être traitée
        if (!empty($error)) 
        //on affiche le message d'erreur
        return $error;

        }
}


/****************************************ENSEMBLE DES FONCTIONS DE BASE DU MVC*********************************************** */
//détail de la fonction firsts_orders
function firsts_orders(){
    $pdo = DBconnection();
    if(!$pdo){
            return false;
        }
    //récupération de l'ensemble des id du tableau  menu en affichant les derniers enregistrés en prmier (query-> prepare et execute en même temps)
    $orders = $pdo->query(
" SELECT * FROM commande
  JOIN menu ON commande.menu_id = menu.menu_id
  JOIN utilisateur ON commande.utilisateur_id = utilisateur.utilisateur_id
ORDER BY date_prestation")->fetchAll(PDO::FETCH_OBJ);

return $orders ; // return menus au Controller qui sera utilisé par la views (for each $access as $acces)
    
}

function create()//function non utilisée pour le moment 
{
    
    
}

/****************************************************Afficher et modifier le libellé selectionné******************************************************************/
//on récupère l'id de la commande à modifier (sélectionné dans la page d'acceuil)
function view($id){
    $pdo = DBconnection();
    if(!$pdo){
        return false;
    }
    $sql="SELECT * FROM commande 
  JOIN menu ON commande.menu_id = menu.menu_id
  JOIN utilisateur ON commande.utilisateur_id = utilisateur.utilisateur_id
  WHERE commande_id=:id";
    $query=$pdo->prepare($sql);
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    $query->execute();
    //on affiche l'unique  clé  sélectionnée (donc pas de fetchAll ) =>function récupéré dans editAction partie controller
    return $query->fetch(PDO::FETCH_OBJ);
}
//Met à jour le nouveau statut via la fonction updateAction() du fichier controller qui a récupéré  les valeurs $_POST
function edit($id, $newStatus){ 
   
    
    $pdo = DBconnection();
    if(!$pdo){
        return false;
    }
    //Nettoyage des valeurs de variables récupérées (même si aucune valeur entrée)
    $args = func_get_args();//récupère l'ensemble des arguments placés dans la fonction dans $args 

    foreach ($args as $arg){
    //Application de la function de nettoyage et vérification à la valeur intégrée (htmlchars, trim et valeur non vide) à $libelle
    cleanAndCheckValue($arg);
        //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(cleanAndCheckValue($arg))){
        return cleanAndCheckValue($arg);
    }
}

        //Récupération des données actuelles de la Table pour agir sur les valeurs modifiées
        $sql="SELECT * FROM commande WHERE commande_id=:id";
        $query=$pdo->prepare($sql);
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();
        //on affiche l'unique  clé sélectionnée (donc pas de fetchAll ) =>function récupéré dans editAction partie controller
        $currentDatas = $query->fetch(PDO::FETCH_OBJ);



    //si le statut sélectionné est identique à l'existant
    if($newStatus == $currentDatas->statut){
                return "Statut identique au dernier enregistré,<br> aucune modification n'a été détectée";
    }

    //on update les valeurs sauf l'id qui ne se modifie pas 
    $query=$pdo->prepare("UPDATE commande 
                            SET  statut=:newStatus 
                            WHERE commande_id =:id");
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    $query->bindParam(":newStatus", $newStatus, PDO::PARAM_STR);
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
//Function non utilisé à ce stade => un statut "annulé" permet de remplacer et garder une trace
function destroy($id) /*function qui supprime l'id get ($id = $_GET['id']) en argument suite à appui sur bouton supprimer dans le fichier views/delete.php (href="index.php?action=destroy&?id=<?php echo $id ?>">Valider la suppression</a>)*/
{
/*     
    $id=htmlspecialchars($id);//Nettoyage la valeur de la variable récupérée

    $pdo = DBconnection();
    if(!$pdo){
        return false;
    }
    $sql="DELETE FROM commande WHERE commande_id=:id";
    $query=$pdo->prepare($sql);
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    $query->execute();
    //si il y a une ligne affectée , la suppression a été réalisée avec succès, sinon la suppression n'a pas réussi
        if ($query->rowCount()>0){
        return "success";
        }else{
        return "la suppression n'a pas réussi, veuillez recommencer";
        }
*/    
}


