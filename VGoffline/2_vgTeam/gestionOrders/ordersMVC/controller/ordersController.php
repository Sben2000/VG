<?php

//require les fichiers Model
require_once "model/ordersModel.php";

/*******************************Affiche la liste des commandes à jour dans index.php*************************************************** */
function indexAction(){
    $orders = firsts_orders();//affiche par ordre de priorité
    require_once 'views/liste_orders.php';
}

/*****************************************Crée et enregistre dans la dB*************************************************** */

//A créer si utilisation de la fonction, fonction laissée en prévision
function createAction()
{
//A renseigner si utilisation de la fonction, fonction laissée en prévision

require_once './views/create.php';
}

//Fonction qui enregistre la fonction créée =>non utilisé mais laissé en prévision
function storeAction()
{
//A renseigner si utilisation de la fonction, fonction laissée en prévision

}   
/**************************************Afficher les valeurs à modifier et éditer les modifications*********************************************************************************** */
function editAction(){

/*Récupère l'id de l'élément à modifier (lors du clic sur modifier de liste_access.php  =>action=edit&id =<?php echo $acces->utilisateur_id ?>)*/
$id = $_GET['id'];
$order = view($id);//function du Model qui affiche l'id seul sélectionné 
require_once './views/edit.php';//appel à la page /views/edit.php (pour afficher l'élément selectionné)
}

//met à jour le statut de la commande
function updateAction(){

//si le bouton de soumission d'ajout est activé 
if(isset($_POST["modifyButton"])){
    //on récupère la valeur ID assignée à la commande dont le statut est à modifier 
        $id = $_POST['orderID'];
    //on récupère la nouvelle valeur ID assignée au statut à modifier 
        $newStatus = $_POST['newStatus'];    
  
    //La function de mise à jour est jouée avec les arguments récupérés et la réponse fournie avec le résultat 
    $response = edit($id, $newStatus);

 
     }
  
//require_once '..index.php?action=edit&id='.$id.'.php';
//on renvoit vers la page de resultat avec l'actualisation du message de succès ou d'échec récupéré par $response
require_once './views/result.php';
//puis au bout de quelques secondes, si pas d'action, on renvoit à la liste
header('Refresh:5; url=index.php?action=list');
} 

/**************************************************************Delete***************************************************** */

//Fonctions non utilisées=> pas de suppression de commande, mais statut convertit en annulée

function deleteAction(){ /*Non utilisé =>function qui récupère l'id à supprimer*/  
}

function destroyAction()/*Non utilisé =>function qui réalise la suppression lors lors de la confirmation de suppression dans la view delete.php*/  
{

}   


?>