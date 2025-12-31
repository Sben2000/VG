<?php

$title = 'Liste des Associations "Plats - Allergènes"';


ob_start(); //début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
<div>
    <div>
        <!--lien vers create pour ajouter des plats -->
        <button class=addButton><a href="index.php?action=create">Associer</a></button>
        <!--liste des plats de la table plat -->
    </div>
    <table class="access">
        <thead>
            <tr>
                <th></th>
                <th>Détails plats</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($plats as $plat): ?>
                <tr>
                    <th class="firstC">Id du plat</th>
                    <td class="idPlat"><?= $plat->plat_id ?></td>
                <tr>
                    <th class="firstC">nom_du_plat</th>
                    <td><strong><?= $plat->titre_plat ?></strong></td>
                </tr>
                <tr>
                    <th class="firstC">Photo</th>

                    <?php 
                    if ($plat->photo!=NULL){
                    //origine du code ci dessous :https://openclassrooms.com/forum/sujet/telecharger-une-image-blob-sur-dans-un-fichier et https://stackoverflow.com/questions/54638875/using-php-pdo-to-show-image-blob-from-mysql-database-in-html-image-tag
                    echo '<td>' .
                        '<img src = "data:image/png;base64,' . base64_encode($plat->photo) . '" width = "120px" height = "120px"/>'
                        . '</td>';
                        }else{
                            echo '<td></td>';
                        }
                        ?>
                </tr>
                <tr>
                    <th class="firstC">Allergene(s)</th><!--Ajouté afin de dissocier ou modifier une ligne/un allergène -->
                        <td>
                    <div class ="linkedAllergenes">
                    <?php 
                    $disps = display($plat->plat_id);
                    if ($disps!=NULL){
                    foreach ($disps as $disp): 
                    ?>
                        <!--Dans colonne Actions => 2 boutons avec liens pour modifier (redirection vers edit&les valeurs des id concernés (allergene_id & plat_id)) ou supprimer (redirection vers delete&la valeur de l'id à supprimer)-->
                            <p>réf.Id: <?php echo $disp->allergene_id ?> / Libellé:  <?php echo $disp->libelle ?></p>
                            <div class="actionButtons">
                            <button class="modifyButton"><a href="index.php?action=edit&idAllergene=<?php echo $disp->allergene_id ?>&idPlat=<?php echo $disp->plat_id ?>">Modifier</a></button>

                            <button class="deleteButton"><a href="index.php?action=delete&idAllergene=<?php echo $disp->allergene_id ?>&idPlat=<?php echo $disp->plat_id ?>">Dissocier</a></button>
                        <?php endforeach; 
                        }else{?>
                        <p class="requirement"><em>Pas d'allergène(s) associé(s) à ce jour<em></p>
                        <?php }?>
                        </div>
                        
                        </td>
                    </div>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
    <?php $content = ob_get_clean(); //fin de la récupération ci dessus et assignement à $content défini dans views/layout
    ?>
    <?php include_once 'views/layout.php'; ?>
</div>