<?php

$title = 'Liste des libelles de la table "Régime"';

//var_dump($regimes);/*voir les valeurs récupérées de la dB */
ob_start(); //début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
<div>
    <div>
        <!--lien vers create pour ajouter des libelles -->
        <button class=addButton><a href="index.php?action=create">Ajouter</a></button>
        <!--liste des libelles de la table -->
    </div>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>libelle</th>
                <th colspan="2">Actions</th><!--Ajouté afin de supprimer ou modifier une ligne/un libelle-->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($regimes as $regime): ?>
                <tr>
                    <td><?= $regime->regime_id ?></td><!--Dans colonne ID-->
                    <td><?= $regime->libelle ?></td><!--Dans colonne libelle-->
                    <div class="actionButtons">
                        <div>
                            <td><button class="modifyButton"><a href="index.php?action=edit&id=<?php echo $regime->regime_id ?>">Modifier</a></button><!--Ajouté afin de modifier une ligne/un libelle, apparaitra autant de fois qu'il y a de libelles (car dans la boucle for each)-->
                        </div>
                        <div>
                            <td><button class="deleteButton"><a href="index.php?action=delete&id=<?php echo $regime->regime_id ?>">Supprimer</a></button><!--Ajouté afin de supprimer une ligne/un libelle, apparaitra autant de fois qu'il y a de libelles (car dans la boucle for each)-->
                        </div>
                    </div>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
    <?php $content = ob_get_clean(); //fin de la récupération ci dessus et assignement à $content défini dans views/layout
    ?>
    <?php include_once 'views/layout.php'; ?>
</div>