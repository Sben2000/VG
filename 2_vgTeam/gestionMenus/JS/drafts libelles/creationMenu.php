<?php

//Sélection ou création d'un Thème
    require "./Functions/modelTheme.php";

//chargement de l'image prévalidée et confirmé
require_once "./Functions/confirmPicture.php";

//
$response = confirmPicture();

?>


<!--HTML CODE -->

<html>

<head>
	<title>Menu Creation</title>
	<!--Lien fichier css-->
	<link rel="stylesheet" href="./4_style.css" />
	<!--Lien pour la font google-->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link
		href="https://fonts.googleapis.com/css2?family=Lobster&display=swap"
		rel="stylesheet" />
		<!--link css de la page-->
		<link rel="stylesheet" href="./CSS/gestMenus.css" />
</head>

<body id=frame>
	<div class="upperBlock">
		<div class="upperBlock-left">
			<h1 class="sectionTitle">Construction du Menu</h1>
			<!--Formulaire qui sera envoyé,  enctype à multipart/form-data car les données seront coupées en plusieurs parties, une pour chaque fichier (ex: fichier image) plus une pour les données dans le corps du formulaire.-->
			<form action="" method="POST" enctype="multipart/form-data" id="myForm">
			<!--le formulaire sera envoyé en tant que message MIME en plusieurs parties-->
				<div class="form-content">
				<!--Liste Déroulante Thème -->
				<label for="themes" class="label"><li>Sélectionner ou Créer un thème</li></label>
				<!-- au click, on fait appel à la function JS getThemeJS pour afficher dans un input la catégorie sélectionnée ainsi que son id-->
				<select name="themes" id="selectorThemes" onclick="getThemeJS(this.value)">	
				 <option class="none" value="disabled" disabled selected >Thème</option><!--la première option de la liste déroulante avec l'invitation à sélectionner-->
           			 <optgroup label="Créer">
                <option id ='creaTheme' class="Create" value="Créertheme">Créer Thème</option>
					</optgroup>
					<optgroup label="Sélectionner">
						<!--Les thèmes de la liste sont fetch de la DB en utilisant la function du model getThemes()-->
						<?php
						//on récupère chaque donnée de la DB à travers la function php getCategories
					$categories = getThemes();
						foreach($themes as $theme){
							?>
							<!--on attribue à value l'id du thème selectionné et on affiche le libellé du theme dans l'option, on affiche le nom de la catégorie et on récupère également au clic la value (contenant l'ID) que l'on traite au travers de la function JS getCategoryJS -->
							<option id="optionDBthe" class="database" value=<?php echo $theme['theme_id'] ?>><?= $theme['libelle'] ?></option>
						<?php
						} 
						?>
						</optgroup>
				<optgroup label="Draft-non rattaché">
                <option value="none">Aucun</option>
					</select>
					<!--Cas d'une création de thème ->Gestion Javascript -->
					
        <div class="newTheme">
            <label for="TheNewName">A créer:</label><br>
            <input type="text" name="TheNewName" placeholder="Nouveau thème" autocomplete ="off" value="<?= @$_POST['CatNewName']; ?>"  /><!--ne pas mettre de required sinon l'input crée par le JS ne sera pas envoyé "not focusable"-->
        </div>
        <!-- Selected from javascript file in here. -->
        <div class="selectedTheme">
   
        </div>
        <input type="submit" id="createThemeButton" name="createTheme" value="Créer le thème" >
        <!--réponse renvoyée suite à erreur ou succès de soumission des datas-->
    <?php
            //retour du resultat $response affiché à l'utilisateur
            if(@$themeResponse == "success"){
                ?>
                <!--afficher : inscription réussi-->
                <p class="success" style='color:green'>Le thème a bien été ajouté, veuillez le selectionner .</p>
                <?php
            }else{
                ?><!--sinon retourner le résultat de la sous function qui a soulevé une erreur dans resetPassword()-->
                    <p class="error" style ='color:darkred'><?=@$themeResponse?></p>
                <?php
            }
        ?>



					<!--Input invitant au téléchargement de l'image-->
					<label for="imageSelected" class="label">
						<li>Image à charger</li>
					</label>
					<!-- Limite le fichier à télécharger en taille  -->
					<input type="hidden" name="MAX_FILE_SIZE" value="2500000">
					<input
						type="file"
						id="imageSelected"
						accept="image/jpg, image/jpeg, image/png"
						name="imageSelected" />
					<!--affiche les caractéritiques du fichier récupéré pour controle des conditions par le user-->

					<ul class="fileInfo">
						<li>Nom de l'image : <span id="fileName"></span></li>
						<span id="acceptedFile">requis : 20 caract.max (nom+extension) </span>
						<li>Taille:<span id="fileSize"></span></li>
						<span id="acceptedFile">requis :Taille< 2Mb</span>
								<li>Type:<span id="fileType"></span></li>
								<span id="acceptedFile">requis : .jpeg/.jpg/.png</span>
					</ul>


					<label for="menuTitle" class="label">
						<li>Titre du Menu</li>
					</label>
					<input
						id="menuTitle"
						type="text"
						name="menuTitle"
						minlength="5"
						maxlength="30"
						placeholder="Menu...(5 à 30 caract.)"
						autocomplete="off" />
					<label for="textInput" class="label">
						<li>Description du Menu</li>
					</label>
					<!--Limit min 10 caractères et 500 max via les attributs required min/maxlength-->
					<textarea
						id="textInput"
						type="text"
						name="textInput"
						minlength="10"
						maxlength="500"
						placeholder="Description/composition...(10 à 500 caract.)"
						autocomplete="off"></textarea>
					<div class="minPeople">
						<label for="minPeople" class="label">
							<li>Nbre pers_mini : </li>
						</label>
						<input
							id="minPeople"
							type="number"
							name="menuPrice"
							minlength="1"
							maxlength="8"
							min="0"
							max="500"
							step="1"
							placeholder="00"
							autocomplete="off" />
					</div>
					<div class="remainQty">
						<label for="remainQty" class="label">
							<li>Quantité restante : </li>
						</label>
						<input
							id="remainQty"
							type="number"
							name="menuPrice"
							minlength="1"
							maxlength="8"
							min="0"
							max="500"
							step="1"
							placeholder="00"
							autocomplete="off" />
					</div>
					<div class="menuPrice">
						<label for="menuPrice" class="label">
							<li>Prix TTC/pers en &#x20AC : </li>
						</label>
						<input
							id="menuPrice"
							type="number"
							name="menuPrice"
							minlength="1"
							maxlength="8"
							min="0"
							max="500"
							step="0.01"
							placeholder="00.00"
							autocomplete="off" />
					</div>
					<input type="submit" value="Créer le menu" id="sendData" name="submit">

				</div>
			</form>
			<p id="errorMessage"></p>
			<!--Visible uniquement lorsque le menu est enregistré: Input demandant le chargement de l'image (et rend inacessible toute sélection d'autre image)-->
			<div class="Upload">

				<form action="" method="POST" enctype="multipart/form-data" id="Uploadform" >
					<p id ="successFetch" style="color: darkblue"></p>
						<input type="hidden" name="MAX_FILE_SIZE" value="2500000" >
						<input
							type="file"
							id="imageUpload"
							accept="image/jpg, image/jpeg, image/png"
							name="imageUpload"
							disabled
							>
							
						<input type="submit" value="Charger l'image" id="uploadButton" name="uploadButton" disabled>
			</div>
			<!--Gestion du retour sur le téléchargement de l'image géré uniquement en PHP (fichier upload.php) suivant les prescriptions du JS-->
			<?php
			//si le retour de la function imageValidation (via $response) suite au submit est success:
			if ($response == "success") {
				// on affiche le message de succès 
			?>
				<p class="success" style="color: darkgreen">L'image a été téléchargée avec succès, le menu est finalisé</p>
			<?php
			} else {
			?>
				<!--sinon, on retourne l'une des autres sorties de la function imageValidation retourné avant d'atteindre "success"-->
				<p class="errorUpload"><?=@$response ?></p>
			<?php
			}
			?>
		</div>
		<div class="upperBlock-right">
			<!--Données non envoyées mais uniquement visible-->
			<h1 class="sectionTitle">Prévisualisation</h1>
			<!--L'image ne sera visible dans le preview que si elle est acceptée (cf JS)-->
			<div class="Preview">
				<!--Image de prévisualisation-->
				<img id="previewImage" alt=">>Preview image<<" name="previewImage" />
				<h2 id="inputTitleContent"></h2>

				<!--en readonly-->
				<textarea id="inputContent" readonly></textarea>
				<!--inputs ajoutés lors de l'écriture-->
				<div class="copiedInputs" >
				<p class="inputPeople peopleText"><span class="inputPeople peopleNumber"></span> pers.minimum</p>
				<p class="inputQty qtyText"><span class="inputQty qtyNumber"></span> menu(s) restant(s)</p>
				<p class="inputPrice priceText"><span class="inputPrice priceNumber"></span>€ TTC/pers</p>
				</div>
			</div>
		</div>
	</div>

	<div class="lowerBlock">
		<div class="lowerBlock-left">

			<p>//////</p>


			</form>
		</div>
		<!----------------------------------------------------------------------------------------------------------------------------->
		<div class="lowerBlock-right">
			<p>//////</p>
		</div>
	</div>

	<!--Le script est de type module et importe des functions d'autres fichiers-->
	<script type="module" src="./JS/creationMenu.js"></script>
</body>

</html>