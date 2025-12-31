<?php

$title = 'Liste des "Plats"';

//var_dump($plats);/*voir les valeurs récupérées de la dB */
ob_start(); //début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
<div>
    <div>
        <!--lien vers create pour ajouter des plats -->
        <button class=addButton><a href="index.php?action=create">Ajouter</a></button>
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
                    <th class="firstC">Id</th>
                    <td class="idPlat"><?= $plat->plat_id ?></td>
                </tr>
                <tr>
                    <th class="firstC">nom_du_plat</th>
                    <td><?= $plat->titre_plat ?></td>
                </tr>
                <tr >
                    <th class="firstC">Type d'image</th>
                    <td><?= $plat->contentType ?></td>
                </tr>
                <tr>
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
                    <th class="firstC">Actions</th><!--Ajouté afin de supprimer ou modifier une ligne/un accès plat-->
                    <div class="actionButtons">
                        <!--Dans colonne Actions => 2 boutons avec liens pour modifier (redirection vers edit&la valeur de l'id) ou supprimer (redirection vers delete&la valeur de l'id à supprimer)-->
                        <td>
                            <button class="modifyButton"><a href="index.php?action=edit&id=<?php echo $plat->plat_id ?>">Modifier</a></button>

                            <button class="deleteButton"><a href="index.php?action=delete&id=<?php echo $plat->plat_id ?>">Supprimer</a></button>
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