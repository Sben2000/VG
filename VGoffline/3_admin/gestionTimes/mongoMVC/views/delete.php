<?php
$title="Supprimer"; 


ob_start();
?>
    <p>Voulez vous vraiment supprimer l'horaire?</p>
    <div class="deleteConfirmation">
    <!--On se dirige vers la page destroy.php en cas de confirmation-->
    <button class="deleteButton"><a  href="index.php?action=destroy&id=<?php echo $id ?>">Valider la suppression</a></button>
    </div>
    <!--On revient sur l'index en cas d'annulation-->
    <div>
    <button class="cancelButton"><a  href="index.php?action=list" >Annuler la suppression</a></button>
    </div>
    </div>
                 <?php
            //retour du resultat $response affiché à l'utilisateur
            if(@$response == "success"){
                ?>
                    <p class="success" style='color:green'>L'accès a bien été supprimé</p>

                <?php
            }else{
                ?>
                    <p class="error" style ='color:darkred'><?=@$response?></p>
                <?php
            }
        ?>
<?php
$content = ob_get_clean();
include_once 'views/layout.php'; 