<?php
//La modification est plus ou moins ressamblant à la création, on duplique ainsi la page create que l'on réadapte en ajoutant les value

$title = 'Modifier la présentation d\'un plat';


ob_start();//début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
<!--enctype="multipart/form-data" important si l'on souhaite que notre fichier image soit uplodadé: enctype="multipart/form-data" -->
<form action="index.php?action=update" method="post" enctype="multipart/form-data"><!--Les données seront envoyées dans update.php (action = update.php) pour être modifié-->
    <div class="form">
    
            <!--on récupère l'id mais ne l'affiche pas (type="hidden) pour qu il ne soit pas modifié mais uniquement récupéré-->
        <input type="hidden" name="id" value=<?=$plat->plat_id?>>
        <!--Partie image -->
        <label for="image"><strong>Image du plat(facultatif):</strong></label>
        <!--on affiche l'image du plat connue dans la BDD si elle existe -->
        <?php 
            if ($plat->contentType!=NULL){
                //origine du code ci dessous :https://openclassrooms.com/forum/sujet/telecharger-une-image-blob-sur-dans-un-fichier et https://stackoverflow.com/questions/54638875/using-php-pdo-to-show-image-blob-from-mysql-database-in-html-image-tag
                echo '<td>' .
                '<img src = "data:image/png;base64,' . base64_encode($plat->photo) . '" width = "120px" height = "120px"/>'
                        . '</td>';
                }
        ?>        
        <!--on propose l'ajout ou le chargement potentiel d'une nouvelle image -->
        <input type="file"  name="image" class="withRequirement">
        <p class="requirement">requis: extensions autor.: [ <strong>jpeg, jpg, png, gif</strong> ], Taille max autor.: [ <strong>900ko</strong> ]</p>
        <label for="dishTitle"><strong>Libellé du plat: </strong></label>
            <!--on ajoute la value dans laquelle on affiche la valeur récupérée de l'id si le user souhaite le modifier-->
            <!--cf function dans le controller editAction() qui récupère = view($id);-->
        <input type="text"  name="dishTitle" class="withRequirement"
        value=<?php 
        /*Gestion du cas ou l'utilisateur efface la donnée et tente de la soumettre -> n'affiche pas les tags générés dans l'input par la BDD  (type <br)*/
        if(empty($plat->titre_plat)){
            echo "";
            }else{
                echo $plat->titre_plat;
                } ?>>
            <p class="requirement">requis: caract.: : [ <strong>alphanumériques</strong> ] - max: [ <strong>15 car.</strong> ]- min: [ <strong>3 car.</strong> ]</p>
    </div>
    <div >
    <!--au clic, soumettra le form à action=update pour l'id et le libellé concerné-->
    <button class="modifyButton" name="modifyButton" >Modifier</button>
    <!--retour à la list-->
    <button class="backToListButton"><a href="index.php?action=list" >Revenir à la liste</a></button>
    </div>   
</form>

<?php $content = ob_get_clean(); //fin de la récupération ci dessus et assignement à $content défini dans views/layout?>
<?php include_once 'views/layout.php';?>
