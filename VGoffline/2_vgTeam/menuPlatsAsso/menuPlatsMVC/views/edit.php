<?php
//La modification est plus ou moins ressamblant à la création, on duplique ainsi la page create que l'on réadapte en ajoutant les value

$title = "Modifier le plat d'un menu";


ob_start(); //début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>

<form action="index.php?action=update" method="post" enctype="multipart/form-data"><!--Les données seront envoyées dans update.php (action = update.php) pour être modifié-->
    <table class="access">
        <thead>
            <tr>
                <th></th>
                <th>Menu & Plat concernés</th>
            </tr>
        </thead>
        <div class="form">
            <tbody>
                <tr>
                    <th class="firstC">Id du menu</th>
                    <td class="idPlat"><?= $propose->menu_id ?></td>
                    <input type="hidden" name="menuID" value="<?php echo $propose->menu_id ?>">
                <tr>
                    <th class="firstC">nom_du_menu</th>
                    <!--menu associé au plat dans la table contient -->
                    <td class="idMenu"><strong><?= $propose->titre ?></strong></td>
                </tr>
                <tr>
                    <th class="firstC">Plat à modifier</th><!--Ajouté afin de dissocier ou modifier une ligne/un plat du menu affiché -->
                    <!--input hidden récupérant l'id du plat à modifier dans la DB-->
                    <input type="hidden" name="platIDtoReplace" value="<?php echo $propose->plat_id ?>">
                    <td>
                        <div class="linkedplats">
                            <p class="toReplace"><u>réf.Id: <?php echo $propose->plat_id ?> / Titre du Plat: <?php echo $propose->titre_plat ?></u></p>
                            <?php
                            if ($propose->photo != NULL) {
                                //origine du code ci dessous :https://openclassrooms.com/forum/sujet/telecharger-une-image-blob-sur-dans-un-fichier et https://stackoverflow.com/questions/54638875/using-php-pdo-to-show-image-blob-from-mysql-database-in-html-image-tag
                                echo '<p>' .
                                    '<img src = "data:image/png;base64,' . base64_encode($propose->photo) . '" width = "120px" height = "120px"/>'
                                    . '</p>';
                            } else {
                                echo
                                '<img src = "data:image/png;base64,'  . '" width = "50px" height = "50px"/>'
                                    . '<p class="requirement"> Pas de photo de plat associée à ce jour' . '</p>';
                            }
                            ?>
                        </div>
                    </td>
                </tr>
                <tr>
                       <span  id="selectorMenus" ></span> <!--selectorMenus, ajouté mais non utilisé car requis par le module JS (appelant les deux fichiers)"-->

                        <th class="firstC">Plat de subsititution</th><!--Ajouté afin de dissocier ou modifier une ligne/un plat -->
                    <td>
                        <label for="plats" class="label">
                            <p><em>Sélectionner le nouveau Plat</em></p>
                        </label>
                        <select name="plats" id="selectorPlats"> <!--onclick="getPlatsJS(this.value)"-->
                            <option class="none" disabled selected>Plat</option><!--la première option de la liste déroulante avec l'invitation à sélectionner-->
                            <optgroup label="Sélectionner">
                                <!--Les plats de la liste sont fetch de la DB en utilisant la function du model getPlats()-->
                                <?php
                                //on récupère chaque donnée de la DB via la variable qui a récupéré les éléments de la liste (dans la partie controller)
                                foreach ($plats as $plat) {
                                ?>
                                    <!--on attribue à value l'id selectionné et on affiche le titre_plat  dans l'option, on récupère également au clic la value (contenant l'ID) que l'on traite au travers de la function JS mentionné précédemment -->
                                    <option id="optionDBplat" class="database" value=<?php echo $plat['plat_id'] ?>><?= $plat['titre_plat'] ?></option>
                                <?php
                                }
                                ?>
                            </optgroup>
                        </select>
                        <!-- Affichera l'option Sélectionnée dans la div ci dessous après Fetch JS. -->
                        <div class="selectedPlat">

                        </div>
                        <p class="requirement"><strong>Note: Pour ajouter un plat à la liste</strong> <br> → Veuillez vous rendre sur l'onglet:<br> &nbsp;&nbsp; "Gestion"> "Plats" depuis la page d'accueil</p>
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