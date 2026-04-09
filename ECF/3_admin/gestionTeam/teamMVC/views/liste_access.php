<?php

$title = 'Liste des accès "Employés"';

//var_dump($access);/*voir les valeurs récupérées de la dB */
ob_start(); //début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
<div>
    <div>
        <!--lien vers create pour ajouter des employés -->
        <button class=addButton><a href="index.php?action=create">Ajouter</a></button>
        <!--liste des employés de la table utilisateur -->
    </div>
    <table class="access">
        <thead>
            <tr>
                <th></th>
                <th>Détails accès Employés</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($access as $acces): ?>
                <tr>
                    <th class="firstC">Id</th>
                    <td class="idEmployee"><?= $acces->utilisateur_id ?></td>
                </tr>
                <tr>
                    <th class="firstC">nom_utilisateur</th>
                    <td><?= $acces->nom_utilisateur ?></td>
                </tr>
                <tr>
                    <th class="firstC">email</th>
                    <td><?= $acces->email ?></td>
                </tr>
                <tr class="password">
                    <th class="firstC">Mot de passe</th>
                    <td><?= $acces->password ?></td>
                </tr>
                <tr>
                    <th class="firstC">Actions</th><!--Ajouté afin de supprimer ou modifier une ligne/un accès employé-->
                    <div class="actionButtons">
                        <!--Dans colonne Actions => 2 boutons avec liens pour modifier (redirection vers edit&la valeur de l'id) ou supprimer (redirection vers delete&la valeur de l'id à supprimer)-->
                        <td>
                                <button class="modifyButton"><a href="index.php?action=edit&id=<?php echo $acces->utilisateur_id ?>">Modifier</a></button>
                                
                                <button class="deleteButton"><a href="index.php?action=delete&id=<?php echo $acces->utilisateur_id ?>">Supprimer</a></button>
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