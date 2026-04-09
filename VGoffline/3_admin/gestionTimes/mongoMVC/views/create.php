<?php
$title = 'Ajouter une horaire';

ob_start(); //début de la récupération/lecture de tout ce qu il y a en aval(ci dessous)
?>
<div class="feedback">
    <?php
    //retour du resultat $response affiché à l'utilisateur
    //si le resultat de la function  est success
    if (@$response == "success") {
    ?>
        <p class="success" style='color:green'>L'horaire a bien été enregistrée</p>
    <?php
    } else {
    ?><!--sinon retourner le résultat de la sous function qui a soulevé une erreur -->
        <p class="error" style='color:darkred'><?= @$notcreated ."<br>". @$response ?></p>
    <?php
    }

    if (@$imgResponse == "success") {
    ?>
        <p class="success" style='color:green'>L'image a bien été chargée</p>
    <?php
    } else {
    ?><!--sinon retourner le résultat de la sous function qui a soulevé une erreur dans registerUser()-->
        <p class="error" style='color:darkred'><?= "<br>". @$imgResponse ?></p>
    <?php
    }
    ?>
</div>

<!--redirigé préalablement vers store.php mais désormais vers action=store suite au routage via index.php-->
<form action="index.php?action=store" method="post" enctype="multipart/form-data" id="myForm"><!--Les données seront envoyées dans store.php (action = store.php)-->
    <div class="form">
        <!-- Text input-->
        <div>
            <label for="title"><strong>Titre:</strong></label><br>
            <input type="text" id="title" name="title" class="withRequirement" placeholder="" minlength="3" maxlength="30">
            <p class="requirement">requis: caract.: alphanum_- ,max:30 - min: 3</p>
        </div>
        <!-- Text Area-->
        <div>
            <label for="description"><strong>Description: </strong></label><br>
            <textarea id="description" name="description" placeholder="" rows="6" minlength="10" maxlength="700"></textarea>
            <br><br>
            <p class="requirement">requis: caract.: alphanum_- ,max: 700 - min: 10</p>
        </div>
        <!-- Text input-->
        <div><br><br>
            <label for="contract"><strong>Type de contrat:</strong></label>
            <select name="selectContract" id="selectContract" class="filter">
                <option class="none" value="none" disabled selected>Selectionner un contrat</option>
                <optgroup label="Types de contrat">
                    <option value="CDI">CDI</option>
                    <option value="CDD">CDD</option>
                    <option value="Stage">Stage</option>
                    <option value="Autre">Autre</option>
                </optgroup>
            </select>            
            <br>
            <input type="text" id="contract" name="contract" class="withRequirement" placeholder="">
        </div>
        <!-- Text input-->
        <div>
            <label for="city"><strong>Ville:</strong></label>
            <select name="selectCity" id="selectCity" class="filter">
                <option class="none" value="none" disabled selected>Selectionner une ville</option>
                <optgroup label="Ville">
                    <option value="Paris">Paris</option>
                    <option value="Lyon">Lyon</option>
                    <option value="Marseille">Marseille</option>
                    <option value="Bordeaux">Bordeaux</option>
                    <option value="Lille">Lille</option>
                    <option value="Autre">Autre</option>
                </optgroup>
            </select>  
            <br>
            <input type="text" id="city" name="city" class="withRequirement"  readonly>
        </div>
        <!-- Text input-->
        <div>
            <label for="author"><strong>Auteur:</strong></label><br>
            <input type="text" id="author" name="author" class="withRequirement" >
        </div>
        <!-- File input-->
        <div>
            <label for="file">Selectionner une Image <span style="color: darkred;">(requis)</span></label>
            <input id="file" name="file" type="file">
            <p class="requirement">requis img: taille max: 2Mb _ ext: jpeg, jpg, png, gif</p>
        </div>
        <!-- Text input-->
        <div class="detailedInput">
            <label for="statut"><strong>Statut:</strong></label>
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
        <!-- Hidden horaire id -->
        <input type="hidden" name="aid" id="aid">
    </div>
    <br><br>
    <div>
        <!--au clic, soumettra le form à action=update pour l'id et le libellé concerné-->
        <button class="addButton" name="addButton" id="submit">Ajouter</button>
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