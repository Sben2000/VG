<?php
//La modification est plus ou moins ressamblant à la création, on duplique ainsi la page create que l'on réadapte en ajoutant les value

$title = "Modifier l'allergène d'un plat";


ob_start(); //début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>

<form action="index.php?action=update" method="post" enctype="multipart/form-data"><!--Les données seront envoyées dans update.php (action = update.php) pour être modifié-->
    <table class="access">
        <thead>
            <tr>
                <th></th>
                <th>Plat & Allergène concernés</th>
            </tr>
        </thead>
        <div class="form">
            <tbody>
                <tr>
                    <th class="firstC">Id du plat</th>
                    <td class="idPlat" ><?= $contient->plat_id ?></td>
                     <!--input hidden récupérant l'id de l'allergène à modifier dans la DB-->
                    <input type="hidden" name="dishID"  value="<?php echo $contient->plat_id ?>" >
                <tr>
                    <th class="firstC">nom_du_plat</th>
                    <!--plat associé à l'allergene dans la table contient -->
                    <td class="idPlat"><strong><?= $contient->titre_plat ?></strong></td>
                </tr>
                <tr>
                    <th class="firstC">Photo du plat</th>

                    <?php
                    if ($contient->photo != NULL) {
                        //origine du code ci dessous :https://openclassrooms.com/forum/sujet/telecharger-une-image-blob-sur-dans-un-fichier et https://stackoverflow.com/questions/54638875/using-php-pdo-to-show-image-blob-from-mysql-database-in-html-image-tag
                        echo '<td class="idPlat">' .
                            '<img src = "data:image/png;base64,' . base64_encode($contient->photo) . '" width = "120px" height = "120px"/>'
                            . '</td>';
                    } else {
                        echo '<td class="idPlat"></td>';
                    }
                    ?>
                </tr>
                <tr>
                    <th class="firstC">Allergène à modifier</th><!--Ajouté afin de dissocier ou modifier une ligne/un allergène -->
                    <!--input hidden récupérant l'id de l'allergène à modifier dans la DB-->
                    <input type="hidden" name="allergIDtoReplace"  value="<?php echo $contient->allergene_id ?>" >
                    <td>
                        <p class="toReplace">réf.Id: <?php echo $contient->allergene_id ?> / Libellé: <?php echo $contient->libelle ?></p>
                    </td>
                </tr>
                <tr>
                    <th class="firstC">Allergène de subsititution</th><!--Ajouté afin de dissocier ou modifier une ligne/un allergène -->
                    <td>
                        <label for="allergenes" class="label">
                            <p><em>Sélectionner le nouvel allergène</em></p>
                        </label>
                        <span  id="selectorPlats" ></span> <!--selectorPlat, ajouté mais non utilisé car requis par le module JS (appelant les deux fichiers)"-->
                        <!-- au click, on fait appel à la function JS(cf.fichier JS) pour afficher dans un input la catégorie sélectionnée ainsi que son id-->
                        <select name="allergenes" id="selectorAllergenes"> <!--onclick="getAllergenesJS(this.value)"-->
                            <option class="none" disabled selected>Allergène</option><!--la première option de la liste déroulante avec l'invitation à sélectionner-->
                            <optgroup label="Sélectionner">
                                <!--Les régimes de la liste sont fetch de la DB en utilisant la function du model getAllergenes()-->
                                <?php
                                //on récupère chaque donnée de la DB via la variable qui a récupéré les éléments de la liste (dans la partie controller)
                                foreach ($allergenes as $allergene) {
                                ?>
                                    <!--on attribue à value l'id selectionné et on affiche le libellé  dans l'option, on récupère également au clic la value (contenant l'ID) que l'on traite au travers de la function JS mentionné précédemment -->
                                    <option id="optionDBallergene" class="database" value=<?php echo $allergene['allergene_id'] ?>><?= $allergene['libelle'] ?></option>
                                <?php
                                }
                                ?>
                            </optgroup>
                        </select>
                        <!-- Affichera l'option Sélectionnée dans la div ci dessous après Fetch JS. -->
                        <div class="selectedAllergene">

                        </div>
                        <p class="requirement"><strong>Note: Pour ajouter un allergène à la liste</strong> <br> → Veuillez vous rendre sur l'onglet:&nbsp;&nbsp; "Gestion"> "Libelles">"Allergènes" </p>
                        </div>
                    </td>
                </tr>
        </div>
        </tbody>
    </table>


    <div>
        <!--au clic, soumettra le form à action=update pour l'id et le libellé concerné-->
        <button class="modifyButton" name="modifyButton">Modifier</button>
        <!--retour à la list-->
        <button class="backToListButton"><a href="index.php?action=list">Revenir à la liste</a></button>
    </div>

</form>

<?php $content = ob_get_clean(); //fin de la récupération ci dessus et assignement à $content défini dans views/layout
?>
<?php include_once 'views/layout.php'; ?>