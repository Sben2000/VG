<?php

require_once 'model/regimeModel.php';

/*******************************Affiche la liste des regimes à jour dans index.php*************************************************** */
function indexAction(){
    $regimes = latests_regimes();//on assigne à $regimes l'objet fetch par la function latests_regimes()
    require_once 'views/liste_libelles.php';//fait appel à la view pour afficher la page dans laquelle $regimes est appelé (for each $regimes as $regime)
}

/*****************************************Crée et enregistre dans la dB*************************************************** */

function createAction()//fait apparaitre la vue create.php pour ajouter les données
{
require_once './views/create.php';
}

function storeAction()//insère les données ajoutées dans le create.php vers la base de données
{
$libelle = strtolower($_POST['libelle']);
$response = create($libelle);//fait appel à la fonction du Model pour créer les données ajoutées dans la DB 
/*header('location: index.php?action=list');*/
//on renvoit à la vue actuelle avec l'actualisation du message de succès ou d'échec
require_once './views/create.php';

//puis au bout de quelques secondes, on renvoit à la liste en option
//header('Refresh:3; url=index.php?action=list');

}   
/**************************************Afficher les valeurs à modifier et éditer les modifications*********************************************************************************** */
function editAction(){
/*Récupère l'id de l'élément à modifier (lors du clic sur modifier de liste_libelles.php dans le lieb => &id=<?php echo $regime->regime_id ?>)*/
$id = $_GET['id'];
$regime = view($id);//function du Model qui affiche l'id seul sélectionné 
require_once './views/edit.php';//une fois l'id récupéré ,  appel à la page /views/edit.php dans laquelle la variable $id est passé (pour affiché l'élément selectionné)
}

function updateAction(){//ressemble plus ou moins à la function createAction(){}
//var_dump($_POST);/*affiche les valeurs récupérées par le fichier './views/edit.php dans lequel on renvoi en action =update.php (situé à la racine) avec une method="post"*/
//assignation de la valeur $_POST['libelle'] du fichier edit.php
$libelle=strtolower($_POST['libelle']);
$id=$_POST['id'];
//passage de la variable dans la function edit du Model
$response = edit($id, $libelle);

//on renvoit à la vue actuelle avec l'actualisation du message de succès ou d'échec
require_once './views/editResult.php';
//require_once './views/edit.php';
//puis au bout de quelques secondes, si pas d'action, on renvoit à la liste
header('Refresh:5; url=index.php?action=list');

} 

/**************************************************************Delete***************************************************** */

function deleteAction(){ //appelle la vue qui delete  
$id = $_GET['id'];//les GET ou POST dans un modèle MVC sont récupérés dans le controller, récupère la valeur de l'id de la page edit.php (id=$regime->regime_id). 
//var_dump($id);/*vérification de récupération de l'id de l'item selectionné*/
require_once './views/delete.php';/*une fois l'id récupéré est assigné à $id, appel de la page /views/delete.php  pour confirmation ou non suppression $id */
}

function destroyAction()/*function qui réalise la suppression lors lors de la confirmation de suppression dans la view delete.php*/  
{
$id = $_GET['id'];/*argument $id qui représente l'id récupéré via le $_GET['id'] précédent (cf deleteAction) et passé en clé lors de la confirmation de suppression*/
//var_dump($id);
$response = destroy($id); /*function issue du model qui supprime l'id passé en clé lorsque le bouton suivant est cliqué dans delete.php href="index.php?action=destroy&?id=<?php echo $id ?>">Valider la suppression</a>*/
/*
//on renvoit à la vue actuelle avec l'actualisation du message de succès ou d'échec récupérée par $response
require_once './views/delete.php';
*/
//on renvoit vers la page de résultat deleteResult avec l'actualisation du message de succès ou d'échec récupéré par $response
require_once './views/deleteResult.php';
//puis au bout de quelques secondes, si pas d'action, on renvoit à la liste
header('Refresh:5; url=index.php?action=list');

} 


?>