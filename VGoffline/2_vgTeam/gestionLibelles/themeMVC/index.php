<?php
//Contrôle accès session
require_once "../includes/accessVgTeamMng.php";
//require le fichier Controller ou se trouve les functions
require_once 'controller/themeController.php';


//Création d'un routeur
//var_dump($_GET); //nous affiche action =>create 

//si on a une demande $_GET action => , on assigne la valeur récupéré à $action
if(isset($_GET['action'])){
    $action = $_GET['action'];
    //on ajoute un switch qui redirigera vers le chemin $_GET demandé
    switch($action){
        case 'create': 
             createAction();//fonction createAction du controller affiche la page avec les champs à ajouter qui est ensuite traitée dans le model parfunction create() est géré dans le controller par la function storeAction()
            break;
        case 'list'://si on GET la liste (via le lien sur la nav "href="index.php?action=list" ),
            indexAction();
            break;
        case 'destroy'://si on GET la valeur destroy (via la page delete.php , bouton supprimer), on récupère alors les éléments de la page destroy.php 
            destroyAction();
            break;
        case 'edit':
            editAction();
            break;
        case 'store':
            storeAction();
            break;
        case 'update':
            updateAction();
            break;
        case 'delete':
            deleteAction();
            break;
      
    }
    //var_dump($action);
}else{
    indexAction();
}