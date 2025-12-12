<?php
$title="Supprimer"; //on définit la variable $title qui apparait dans le layout.php requis ci dessous
//var_dump($id); on peut récupérer l'id dans cette page grâce à la function deleteAction parent de cette page (incluant cette page)
                //on peut ainsi réattribuer cet id en variable ?id dans le lien destroy.php ci dessous

//on doit également définir le contenu de la variable $content que l'on dévellope ci dessous via ob_start() et ob_get_clean()
ob_start();
?>
    <p>Voulez vous vraiment supprimer le libelle?</p>
    <!--On se dirige vers la page destroy.php en cas de confirmation-->
    <!--redirigé préalablement vers destroy.php mais désormais vers index.php?action=destroy&id=... (&id= car redirigé également derrière un ? préalablement donc 2 fois ?? =>?...&...) -->
    <a class ="btn btn-danger" href="index.php?action=destroy&id=<?php echo $id ?>">Valider la suppression</a>
 
    <!--On revient sur l'index en cas d'annulation-->
    <!--redirigé préalablement vers index.php mais désormais vers index.php?action=list qui fait le routage-->
    <a class ="btn btn-warning" href="index.php?action=list" >Annuler la suppression</a>

<?php
$content = ob_get_clean();
include_once 'views/layout.php'; //on requiert la vue layout (qui sera mis à jour)