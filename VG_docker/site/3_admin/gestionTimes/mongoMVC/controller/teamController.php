<?php
require_once "routes/rootPath.php";
require_once ACCESSROOT . "/mongoMVC/model/teamModel.php";


/*******************************Affiche la liste des horaires à jour dans index.php*************************************************** */
function indexAction()
{
    $horaires = latests_horaires();
    require_once 'views/liste_horaires.php';
}

/*****************************************Crée et enregistre dans la dB*************************************************** */

function createAction() //fait apparaitre la vue create.php pour ajouter les données
{
    require_once './views/create.php';
}

function storeAction() //insère les données ajoutées dans le create.php pour intégration collection
{
    $title = $_POST['title'];
    $timeDetails = $_POST['timeDetails'];
    $author = $_POST['author'];
    $statut = $_POST['statut'];
    $createdOn = new MongoDB\BSON\UTCDateTime; //date du jour

    //function create issue du model
    $response = create($title, $timeDetails, $author, $statut, $createdOn); //fait appel à la fonction du Model pour créer les données ajoutées dans la collection 
    $notcreated = "L'horaire n' pas été enregistrée :";
    //on renvoit ensuite à la vue actuelle avec l'actualisation du message de succès ou d'échec
    require_once './views/create.php';

    //on renvoit vers la page de resultat(create) avec l'actualisation du message de succès ou d'échec récupéré par $response
    //require_once './views/createResult.php';

    //puis au bout de quelques secondes, si pas d'action, on renvoit à la liste
    //header('Refresh:5; url=index.php?action=list');

}
/**************************************Afficher les valeurs à modifier et éditer les modifications*********************************************************************************** */
function editAction()
{
    //On Récupère la valeur de l'id (passé dans l'uri) , mis au format ObjectId Mongo avec la clé pour interroger la BDD Mongo */
    $id = ['_id' => new MongoDB\BSON\ObjectId($_GET['id'])];
    //var_dump($id); //on récupère bien une asso clé /valeur objet Id 

    //function du Model qui récupère les données de l'id seul sélectionné
    $horaire = view($id);
    //var_dump($horaire); //voir les éléments de l'id récupéré
    require_once './views/edit.php'; // afficher  les datas mis en forme de l'élément selectionné)

}

function updateAction()
{ //ressemble plus ou moins à la function storeAction(){}
    $title = $_POST['title'];
    $timeDetails = $_POST['timeDetails'];
    $author = $_POST['author'];
    $statut = $_POST['statut'];
    $createdOn = new MongoDB\BSON\UTCDateTime; //date du jour édité au format MongoDB
    $id = ['_id' => new MongoDB\BSON\ObjectId($_POST['id'])]; //id hidden dans le formulaire edit mis au format ObjectId Mongo
    //passage de la variable dans la function edit du Model
    $response = edit($id, $title, $timeDetails, $author, $statut, $createdOn);

    //on renvoit vers la page de resultat(edit) avec l'actualisation du message de succès ou d'échec récupéré par $response
    require_once './views/editResult.php';

    //puis au bout de quelques secondes, si pas d'action, on renvoit à la liste
    header('Refresh:5; url=index.php?action=list');
}

/**************************************************************Delete***************************************************** */
//appelle la vue  delete.php  
function deleteAction()
{
    //On Récupère la valeur de l'id (passé dans l'uri) , mis au format ObjectId Mongo avec la clé pour interroger la BDD Mongo */
    $id = $_GET['id'];
    //var_dump($id);/*vérification de récupération de l'id de l'item selectionné*/
    require_once './views/delete.php';/*une fois l'id récupéré est assigné à $id, appel de la page /views/delete.php  pour confirmation ou non suppression $id */
}

/*function réalisant la suppression après confirmation*/
function destroyAction()
{
    //valeur de l'id (passé dans l'uri) et mis au format ObjectId Mongo avec la clé pour interroger la BDD Mongo     
    $id = ['_id' => new MongoDB\BSON\ObjectId($_GET['id'])];
    //var_dump($id);
    /*function issue du model qui supprime l'id passé en clé */
    $response = destroy($id);

    //renvoit vers la page de résultat deleteResult 
    require_once './views/deleteResult.php';
    //puis au bout de quelques secondes, si pas d'action, renvoit à la liste
    header('Refresh:5; url=index.php?action=list');
}
