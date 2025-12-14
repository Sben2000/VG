<?php

$title = 'Liste des libelles de la table "Allergène"';

//var_dump($allergenes);/*voir les valeurs récupérées de la dB */
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
            <?php foreach ($allergenes as $allergene): ?>
                <tr>
                    <td><?= $allergene->allergene_id ?></td><!--Dans colonne ID-->
                    <td><?= $allergene->libelle ?></td><!--Dans colonne libelle-->
                    <div class="actionButtons">
                        <!--Dans colonne Actions => 2 boutons avec liens pour modifier (redirection vers edit&la valeur de l'id) ou supprimer (redirection vers delete&la valeur de l'id à supprimer)-->
                        <!--?id :  $_GET l'id que l'on souhaite edit et le rediriger vers la page edit.php-->
                        <!--redirigé préalablement vers edit.php?id.php mais désormais vers index.php qui fait le routage-->
                        <div>
                            <td><button class="modifyButton"><a href="index.php?action=edit&id=<?php echo $allergene->allergene_id ?>">Modifier</a></button><!--Ajouté afin de modifier une ligne/un libelle, apparaitra autant de fois qu'il y a de libelles (car dans la boucle for each)-->
                        </div>
                        <!--?id : $_GET l'id que l'on souhaite delete et le rediriger vers la page delete.php-->
                        <!--redirigé préalablement vers delete.php?id.php mais désormais vers index.php qui fait le routage-->
                        <div>
                            <td><button class="deleteButton"><a href="index.php?action=delete&id=<?php echo $allergene->allergene_id ?>">Supprimer</a></button><!--Ajouté afin de supprimer une ligne/un libelle, apparaitra autant de fois qu'il y a de libelles (car dans la boucle for each)-->
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