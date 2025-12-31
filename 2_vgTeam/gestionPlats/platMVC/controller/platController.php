<?php
/*
    require_once "routes/rootPath.php";
    require_once ACCESSROOT."/platMVC/model/platModel.php";

*/
require_once "model/platModel.php";

/*******************************Affiche la liste des themes à jour dans index.php*************************************************** */
function indexAction(){
    $plats = latests_plats();//on assigne à $themes l'objet fetch par la function latests_plats
    require_once 'views/liste_plats.php';//fait appel à la view pour afficher la page dans laquelle $themes est appelé (for each $themes as $theme)
}

/*****************************************Crée et enregistre dans la dB*************************************************** */

function createAction()//fait apparaitre la vue create.php pour ajouter les données
{
require_once './views/create.php';
}

function storeAction()//insère les données ajoutées dans le create.php vers la base de données
{

$response =null;//avant de soumettre le fichier et d'avoir le retour de la function , la variable n'affiche rien à l'écran (sinon cf <p class= success ou <pc class = error)
//si le bouton de soumission d'ajout est activé 
if(isset($_POST["addButton"])){
    //on récupère la valeur assignée à dishTitle
        $dishTitle = $_POST['dishTitle'];
        //si un fichier chargée est détecté (détection nom de fichier)) , on execute la function createDishImage en récupérant dishTitle et les caractéristique de l'image
        if (!empty($_FILES['image']['name'])){
        $response = createDishImage($dishTitle, $_FILES['image']['name'], $_FILES['image']['size'], $_FILES['image']['tmp_name'], $_FILES['image']['type'] );
                                    //$_FILES['image']['name'] : on requiert le nom de l'input image
                                    //$_FILES['image']['size'] : on requiert la taille de l'input image
                                    //$_FILES['image']['tmp_name'] : on requiert le fichier temporaire dans lequel sera placé placé l'image
                                    //$_FILES['image']['type'] : on requiert le type de fichier uploadé (text, image,doc,..)
        }else{
        //sinon on execute la function createDish (n'incluant pas les caractéristique image)
        $response = createDish($dishTitle);
        }
    
}

require_once './views/create.php';

}   
/**************************************Afficher les valeurs à modifier et éditer les modifications*********************************************************************************** */
function editAction(){
/*Récupère l'id de l'élément à modifier (lors du clic sur modifier de liste_plats.php  =>action=edit&id =<?php echo $plat->plat_id ?>)*/
$id = $_GET['id'];
$plat = view($id);//function du Model qui affiche l'id seul sélectionné 
//var_dump($plat); //voir les éléments de l'id récupéré
require_once './views/edit.php';//une fois l'id récupéré ,  appel à la page /views/edit.php dans laquelle la variable $id est passé (pour afficher l'élément selectionné)
}

function updateAction(){//ressemble plus ou moins à la function createAction(){}

//si le bouton de soumission d'ajout est activé 
if(isset($_POST["modifyButton"])){
    //on récupère la valeur assignée à dishTitle
        $dishTitle = $_POST['dishTitle'];
    //on récupère la valeur de l'id
        $id = $_POST['id'];
        //si un fichier chargée est détecté (détection nom de fichier)) , on execute la function editDishImage en récupérant dishTitle et les caractéristique de l'image
        if (!empty($_FILES['image']['name'])){
        $response = editDishImage($id, $dishTitle, $_FILES['image']['name'], $_FILES['image']['size'], $_FILES['image']['tmp_name'], $_FILES['image']['type'] );
                                    //$_FILES['image']['name'] : on requiert le nom de l'input image
                                    //$_FILES['image']['size'] : on requiert la taille de l'input image
                                    //$_FILES['image']['tmp_name'] : on requiert le fichier temporaire dans lequel sera placé placé l'image
                                    //$_FILES['image']['type'] : on requiert le type de fichier uploadé (text, image,doc,..)
        }else{
        //sinon on execute la function editDish (n'incluant pas les caractéristiques image)
        $response = editDish($id, $dishTitle);

        }
    
}


//on renvoit vers la page de resultat(edit) avec l'actualisation du message de succès ou d'échec récupéré par $response
require_once './views/editResult.php';
//require_once './views/edit.php';
//puis au bout de quelques secondes, si pas d'action, on renvoit à la liste
header('Refresh:5; url=index.php?action=list');

} 

/**************************************************************Delete***************************************************** */

function deleteAction(){ //appelle la vue qui delete  
$id = $_GET['id'];//les GET ou POST dans un modèle MVC sont récupérés dans le controller, récupère la valeur de l'id de la page edit.php (id=$theme->theme_id). 
//var_dump($id);/*vérification de récupération de l'id de l'item selectionné*/
require_once './views/delete.php';/*une fois l'id récupéré est assigné à $id, appel de la page /views/delete.php  pour confirmation ou non suppression $id */
}

function destroyAction()/*function qui réalise la suppression lors lors de la confirmation de suppression dans la view delete.php*/  
{
$id = $_GET['id'];/*argument $id qui représente l'id récupéré via le $_GET['id'] précédent (cf deleteAction) et passé en clé lors de la confirmation de suppression*/
//var_dump($id);
$response = destroy($id); /*function issue du model qui supprime l'id passé en clé lorsque le bouton suivant est cliqué dans delete.php href="index.php?action=destroy&?id=<?php echo $id ?>">Valider la suppression</a>*/

/*Option de base (non activée)
on renvoit vers la page de  deleteResult avec l'actualisation du message de succès ou d'échec récupéré par $response
require_once './views/delete.php';
*/
//Option choisit pour renvoi message de succès ou échec après activation suppression
//on renvoit vers la page de résultat deleteResult avec l'actualisation du message de succès ou d'échec récupéré par $response
require_once './views/deleteResult.php';
//puis au bout de quelques secondes, si pas d'action, on renvoit à la liste
header('Refresh:5; url=index.php?action=list');

}   


?>