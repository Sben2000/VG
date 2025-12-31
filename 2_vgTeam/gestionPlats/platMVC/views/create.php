<?php
$title = 'Ajouter un plat';


ob_start();//début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
 <!--enctype="multipart/form-data" important si l'on souhaite que notre fichier soit uplodadé: enctype="multipart/form-data" -->
<form action="index.php?action=store" method="post" enctype="multipart/form-data"><!--Les données seront envoyées dans store.php (action = store.php)-->
    <div class="form">
        <label for="image"><strong>Image du plat (facultatif):</strong></label>
        <input type="file"  name="image" class="withRequirement">
        <span class="requirement">requis: extensions autor.: [ <strong>jpeg, jpg, png, gif</strong> ], Taille max autor.: [ <strong>900ko</strong> ]</span>
        <label for="dishTitle"><strong>Libellé du plat: </strong></label>
        <input type="text"  name="dishTitle" class="withRequirement">
        <span class="requirement">requis: caract.: : [ <strong>alphanumériques</strong> ] - max: [ <strong>15 car.</strong> ]- min: [ <strong>3 car.</strong> ]</span>
    </div>
    <div >
        <!--au clic, soumettra le form à action=update pour l'id et le libellé concerné-->
        <button class="addButton" name="addButton">Ajouter</button>
        <!--retour à la list-->
        <button class="backToListButton"><a href="index.php?action=list" >Revenir à la liste</a></button>
    </div> 
    
             <?php
            //retour du resultat $response affiché à l'utilisateur
                //si le resultat de la function est success
            if(@$response == "success"){
                ?>
                    <p class="success" style='color:green'>L' enregistrement a été réalisé avec succès!</p>
                    <p class="success" style='color:darkblue'>⮕ Ajoutez de nouveau ou revenez à la liste</p>
                <?php
            }else{
                ?><!--sinon retourner le résultat de la sous function qui a soulevé une erreur dans registerUser()-->
                    <p class="error" style ='color:darkred'><?=@$response?></p>
                <?php
            }
        ?>
     
</form>

<?php $content = ob_get_clean(); //fin de la récupération ci dessus et assignement à $content défini dans views/layout?>
<?php include_once 'views/layout.php';?>
