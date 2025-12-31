<?php

//require les fichiers Model
require_once "model/menuPlatsModel.php";
require_once "model/modFetchSelectMenu.php";
require_once "model/modFetchSelectPlat.php";

/*******************************Affiche la liste des plats à jour dans index.php*************************************************** */
function indexAction(){
    $menus = latests_menus();//on assigne à $menus l'objet fetch par la function latests_plats
    require_once 'views/liste_menuPlats.php';
}

/*****************************************Crée et enregistre dans la dB*************************************************** */

function createAction()//fait apparaitre la vue create.php pour ajouter les données
{
//on récupère les plats via la function du model pour les afficher dans la liste déroulante
$plats = getPlats();
//on récupère les allergènes via la function du model pour les afficher dans la liste déroulante
$menus = getMenus();
require_once './views/create.php';
}

function storeAction()//insère les données ajoutées dans le create.php vers la base de données
{

$response =null;//avant de soumettre le fichier et d'avoir le retour de la function , la variable n'affiche rien à l'écran (sinon cf <p class= success ou <pc class = error)
//si le bouton de soumission d'ajout est activé 
if(isset($_POST["addButton"])){
    //on récupère les id du plat et de l'allergène à associer et FETCH par les JS respectifs
        $platID = $_POST['platChoosenID'];
        $menuID = $_POST['menuChoosenID'];
 //on execute la function 
        $response = createAssoc($platID, $menuID);
}
//on renvoit vers la page de resultat avec l'actualisation du message de succès ou d'échec récupéré par $response
require_once './views/result.php';
//puis au bout de quelques secondes, si pas d'action, on renvoit à la liste
header('Refresh:5; url=index.php?action=list');

}   
/**************************************Afficher les valeurs à modifier et éditer les modifications*********************************************************************************** */
function editAction(){
/*Récupère les id de la ligne à modifier*/
$idMenu= $_GET['idMenu'];
$idPlat= $_GET['idPlat'];
//on récupère les plats via la function du model pour les afficher dans la liste déroulante
$plats = getPlats();
$propose = view($idMenu, $idPlat);//function du Model qui affiche les éléments de la combinaison d'id sélectionnée 

require_once './views/edit.php';//appel à la page /views/edit.php (pour afficher l'élément selectionné)
}

function updateAction(){//ressemble plus ou moins à la function createAction(){}

//si le bouton de soumission d'ajout est activé 
if(isset($_POST["modifyButton"])){
    //on récupère la valeur ID assignée au menu concerné 
        $menuID = $_POST['menuID'];
    //on récupère la valeur ID assignée au plat à modifier 
        $platIDtoReplace = $_POST['platIDtoReplace'];    
    //on récupère la valeur du FETCH JS , l'id du nouveau plat substituant l'ancien
        $platNewID = $_POST['platChoosenID'];
    //Vérification récupération des ID concernés en décommentant ci dessous
    //echo ($menuID . " " . $platIDtoReplace  ." " .$platNewID );
    
    //La function de mise à jour est jouée avec les arguments récupérés et la réponse fournie avec le résultat 
    $response = editPlatAssoc($menuID, $platIDtoReplace, $platNewID);
    }
    

//on renvoit vers la page de resultat avec l'actualisation du message de succès ou d'échec récupéré par $response
require_once './views/result.php';
//puis au bout de quelques secondes, si pas d'action, on renvoit à la liste
header('Refresh:5; url=index.php?action=list');

} 

/**************************************************************Delete***************************************************** */

function deleteAction(){ //appelle la vue qui delete  
/*Récupère les id de la ligne à dissocier */
$idMenu= $_GET['idMenu'];
$idPlat= $_GET['idPlat'];
//on récupère les infos des entités à dissocier que l'on affiche dans la demande de confirmation
$propose = view($idMenu, $idPlat);
require_once './views/delete.php';/* appel de la page /views/delete.php  pour confirmation ou non suppression  */
}

function destroyAction()/*function qui réalise la suppression lors lors de la confirmation de suppression dans la view delete.php*/  
{
/*Récupère les id de la ligne à dissocier */
$idMenu= $_GET['idMenu'];
$idPlat= $_GET['idPlat'];
$response = destroy($idMenu, $idPlat); 

/*Option de base (non activée)
on renvoit vers la page de  deleteResult avec l'actualisation du message de succès ou d'échec récupéré par $response
require_once './views/delete.php';
*/
//Option choisit pour renvoi message de succès ou échec après activation suppression
//on renvoit vers la page de résultat  avec l'actualisation du message de succès ou d'échec récupéré par $response
require_once './views/result.php';
//puis au bout de quelques secondes, si pas d'action, on renvoit à la liste
header('Refresh:5; url=index.php?action=list');

}   


?>