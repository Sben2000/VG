<?php
//La modification est plus ou moins ressamblant à la création, on duplique ainsi la page create que l'on réadapte en ajoutant les value

$title = 'Modifier l\'horaire';
//var_dump($libelle); pour voir les valeurs récupérées


ob_start(); //début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
<!--redirigé préalablement vers update.php mais désormais vers action=uptade suite au routage via index.php-->
<form action="index.php?action=update" method="post" enctype="multipart/form-data" class="form" id="myForm"><!--Les données seront envoyées dans update.php (action = update.php) pour être modifié-->
    <div class="form">

        <!--on récupère l'id mais ne l'affiche pas (type="hidden) pour qu il ne soit pas modifié mais uniquement récupéré-->
        <input type="hidden" name="id" value=<?= $horaire['_id'] ?>>
        <!-- Text input-->
        <div>
            <label for="title"><strong>Titre:</strong></label><br>
            <input type="text" id="title" name="title" class="withRequirement" minlength="3" maxlength="50" value="<?= $horaire['title'] ?>">
            <p class="requirement">requis: caract.: alphanum_- ,max:50 - min: 3</p>
        </div>
        <!-- Text input-->
        <div>
            <label for="timeDetails"><strong>Horaire détaillé:</strong></label><br>
            <input type="text" id="timeDetails" name="timeDetails" class="withRequirement" placeholder="" minlength="3" maxlength="50" value="<?= $horaire['timeDetails'] ?>">
            <p class="requirement">requis: caract.: alphanum_- ,max:50 - min: 3</p>
        </div>
        <!-- Text input-->
        <div>
            <label for="author"><strong>Auteur:</strong></label><br>
            <input type="text" id="author" name="author" class="withRequirement" value="<?= $horaire['author'] ?>">
        </div><br>
        <!-- File input-->
        <div>
            <label for="statut"><strong>Statut d'édition:</strong></label>
            <select name="selectStatut" id="selectStatut" class="filter">
                <option class="none" value="none" disabled selected>Selectionner un statut</option>
                <optgroup label="Statut">
                    <option value="Draft">Draft</option>
                    <option value="Publier">Publier</option>
                    <option value="Archiver">Archiver</option>
                    <option value="Annuler">Annuler</option>
                    <option value="Autre">Autre</option>
                </optgroup>
            </select>  
            <br>
            <input type="text" id="statut" name="statut" class="withRequirement" readonly>
        </div>
        <!-- Text input-->
    </div>
    <div>
        <!--au clic, soumettra le form à action=update pour l'id et le libellé concerné-->
        <button class="modifyButton" id="Btn" >Modifier</button>
        <!--retour à la list-->
        <button class="backToListButton"><a href="index.php?action=list">Revenir à la liste</a></button>
    </div>
    <div>
        <p class="errorMessage"></p>
    </div>
</form>

<script  src="../JS/gestionTimes.js"></script>

<?php $content = ob_get_clean(); //fin de la récupération ci dessus et assignement à $content défini dans views/layout
?>
<?php include_once 'views/layout.php'; ?>