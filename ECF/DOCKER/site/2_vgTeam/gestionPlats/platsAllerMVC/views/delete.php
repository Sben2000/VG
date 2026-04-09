<?php
$title="Dissocier"; //on définit la variable $title qui apparait dans le layout.php requis ci dessous


//on doit également définir le contenu de la variable $content que l'on dévellope ci dessous via ob_start() et ob_get_clean()
ob_start();
?>
    <p>Voulez vous vraiment dissocier l'allergène <strong><?=$contient->libelle?></strong>  du plat <strong><?=$contient->titre_plat?></strong> ?</p>
    <div class="deleteConfirmation">
    <!--On se dirige vers la page destroy.php avec les id concernés en cas de confirmation-->
    <div>
    <button class="deleteButton"><a  href="index.php?action=destroy&idAllergene=<?php echo $contient->allergene_id ?>&idPlat=<?php echo $contient->plat_id ?>">Valider la dissociation</a></button>
    </div>
    <!--On revient sur l'index en cas d'annulation-->
    <div>
    <button class="cancelButton"><a  href="index.php?action=list" >Annuler la dissociation</a></button>
    </div>
    </div>
                 <?php
            //retour du resultat $response affiché à l'utilisateur
                //si le resultat de la function est success
            if(@$response == "success"){
                ?>
                    <p class="success" style='color:green'>La dissociation a bien été réalisée</p>

                <?php
            }else{
                ?><!--sinon retourner le résultat de la sous function qui a soulevé une erreur -->
                    <p class="error" style ='color:darkred'><?=@$response?></p>
                <?php
            }
        ?>
<?php
$content = ob_get_clean();
include_once 'views/layout.php'; //on requiert la vue layout (qui sera mis à jour)