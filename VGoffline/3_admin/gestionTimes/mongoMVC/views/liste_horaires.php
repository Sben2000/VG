<?php

$title = 'Liste des horaires ';

ob_start(); //début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
<div>
    <div>
        <!--lien vers create pour ajouter  -->
        <button class=addButton><a href="index.php?action=create">Ajouter</a></button>
        <!--liste -->
    </div>
    <table class="access">
        <thead>
            <tr>
                <th></th>
                <th>Détails des horaires</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($horaires as $key => $horaire): ?>
                <tr>
                    <th class="firstC">Id horaire</th>
                    <td class="id"><?= $horaire['_id'] ?></td>
                </tr>
                <tr>
                    <th class="firstC">titre</th>
                    <td><?= $horaire['title'] ?></td>
                </tr>
                <tr class="firstC">
                    <th class="firstC">Image</th>
                    <td><img src="<?= "upload/" . $horaire['fileName'] ?>" width="180"></td>
                </tr>
                <tr>
                    <th class="firstC">Description</th>
                    <td><textarea id="inputContent" readonly><?= $horaire['description'] ?></textarea></td>
                </tr>
                <tr>
                    <th class="firstC">Type de contrat</th>
                    <td><?= $horaire['contract'] ?></td>
                </tr>
                <tr>
                    <th class="firstC">Ville</th>
                    <td><?= $horaire['city'] ?></td>
                </tr>
                <tr>
                    <th class="firstC">Créée le</th>
                    <td><?php
                        //Mise au format DateTime() PHP de la date stockée dans la base MongoDB (MongoDB\BSON\UTCDateTime)
                        $UTCDateTime     = $horaire['createdOn'];
                        $DateTime = $UTCDateTime->toDateTime();
                        //affichage au format :jour/mois/Année heure:min:sec( avec heure sur 24h )
                        echo $DateTime->format('d/m/Y à H:i:s'); 
                       ?></td>
                </tr>
                <tr>
                    <th class="firstC">Statut</th>
                    <td><?= $horaire['statut'] ?></td>
                </tr>
                <tr>
                    <th class="firstC">Auteur</th>
                    <td><?= $horaire['author'] ?></td>
                </tr>
                <tr>
                    <th class="firstC">Actions</th>
                    <div class="actionButtons">
                        <!--Dans colonne Actions => 2 boutons avec liens pour modifier (redirection vers edit&la valeur de l'id) ou supprimer (redirection vers delete&la valeur de l'id à supprimer)-->
                        <td>
                            <button class="modifyButton"><a href="index.php?action=edit&id=<?php echo $horaire['_id'] ?>">Modifier</a></button>

                            <button class="deleteButton"><a href="index.php?action=delete&id=<?php echo $horaire['_id'] ?>">Supprimer</a></button>
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