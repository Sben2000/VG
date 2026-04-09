<?php

$title = 'Liste des Associations:<br>&nbsp;&nbsp;&nbsp; "Menus - Plats"';


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
                <th><strong>Associations: Menus-Plats </strong></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menus as $menu): ?>
                <tr>
                    <th class="firstC">Id du menu</th>
                    <td class="idMenu"><strong><?= $menu->menu_id ?></strong></td>
                <tr>
                    <th class="firstC">nom_du_menu</th>
                    <td class="idMenu"><strong><?= $menu->titre ?></strong></td>
                </tr>
                <tr>
                    <th class="firstC">Thème menu</th>
                    <td><?= $menu->themeLibelle ?></td>
                </tr>
                <tr>
                    <th class="firstC">Régime menu</th>
                    <td><?= $menu->regimeLibelle ?></td>
                </tr>
                <tr>
                    <th class="firstC">Plat(s) associé(s)</th><!--Ajouté afin de dissocier ou modifier une ligne/un allergène -->
                        <td>
                    <div class ="linkedplats">
                    <?php 
                    $disps = display($menu->menu_id);
                    if ($disps!=NULL){
                    foreach ($disps as $disp): 
                    ?>
                        <!--Dans colonne Actions => 2 boutons avec liens pour modifier (redirection vers edit&les valeurs des id concernés (allergene_id & plat_id)) ou supprimer (redirection vers delete&la valeur de l'id à supprimer)-->
                            <p><u>réf.Id: <?php echo $disp->plat_id ?> / Titre du Plat:  <?php echo $disp->titre_plat ?></u></p>
                                                <?php 
                    if ($disp->photo!=NULL){
                    //origine du code ci dessous :https://openclassrooms.com/forum/sujet/telecharger-une-image-blob-sur-dans-un-fichier et https://stackoverflow.com/questions/54638875/using-php-pdo-to-show-image-blob-from-mysql-database-in-html-image-tag
                    echo '<p>' .
                        '<img src = "data:image/png;base64,' . base64_encode($disp->photo) . '" width = "120px" height = "120px"/>'
                        . '</p>';
                        }else{
                            echo 
                        '<img src = "data:image/png;base64,'  . '" width = "50px" height = "50px"/>'
                        . '<p class="requirement"> Pas de photo de plat associée à ce jour' .'</p>';
                        }
                        ?>
                            <div class="actionButtons">
                            <button class="modifyButton"><a href="index.php?action=edit&idMenu=<?php echo $disp->menu_id ?>&idPlat=<?php echo $disp->plat_id ?>">Modifier</a></button>

                            <button class="deleteButton"><a href="index.php?action=delete&idMenu=<?php echo $disp->menu_id ?>&idPlat=<?php echo $disp->plat_id ?>">Dissocier</a></button>
                        <?php endforeach; 
                        }else{?>
                        <p class="requirement" style="color: darkred;"><em>Pas de plat(s) associé(s) à ce jour<em></p>
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