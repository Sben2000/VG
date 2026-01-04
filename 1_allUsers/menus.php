<?php

require_once "./Functions/fctMenus.php";
//récupération de la liste des thèmes et leur id de la DB
$themes = themesList();
//récupération de la liste des régimes et leur id de la DB
$regimes = regimesList();
//récupération de la liste des menus avec leurs themes et régimes associés
$menus = getAllMenus();
//chemin du dossier photo menus
$photoMenuPath = "../2_vgTeam/gestionMenus/uploads/";
//traitement du thème séléctionné dans le panneau de gauche hors AJAX (traitement AJAX pour les filtres)
if (isset($_GET['themePanelID'])){
	/*si une valeur d'index est identifié lors du clic sur un lien du panneau de gauche, on decode la valeur que l on assigne à une variable $themeID*/
		$themeID = urldecode($_GET['themePanelID']); 
	//puis introduction dans la function ci dessous et assignation du resultat à $menus
		$menus = getMenusByThemeOnly($themeID);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!--Meta tags ajouté, aide pour le référencement SEO-->
	<meta name="description"
		content="Nous avons un large choix de menus pour tout les moments de la journée et tous les goûts" />
	<meta name="keywords" content="Gouter,Burgers, café, thé, menu végan, gourmand, brunch,menus à thèmes" />
	<!--import des fonts  lobster et montserrat depuis googlefonts-->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
		rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet" />
	<!--link css-->
	<link rel="stylesheet" href="CSS/menus.css" />
	<!--link css de la navBar header-->
	<link rel="stylesheet" href="CSS/styleHeader.css" />
	<!--link css footer-->
	<link rel="stylesheet" href="CSS/footer.css" />
	<!--link css disconnect (modal)-->
	<link rel="stylesheet" href="CSS/disconnectMod.css" />

	<title>Nos menus</title>
</head>

<body>
	<?php include_once "includes/header.php" ?>
	<div class="main">
		<div class="separator">
			<h1 class="sectionTitle">Nos menus&formules</h1>
		</div>

		<section class="Section">
			<div class="SectionContent Top">
				<h2>Découvrez nos différents menus et formules</h2>
				<p class="subtitle">
					Een beitel in de vorm van een schuurtje op een beekplaat. Het dak wordt
					ondersteund door een frame dat rust op vier grote houten pilaren. Daar,
					in de omgeving van het schuurtje, onderweg stijgt en daalt een heel
					eenvoudig mechanisme tegen dit zaagje een stuk hout.
				</p>
			</div>
		</section>

		<div class="multiSectionsCentral">
			<div class="multiSectionsLeft">
				<section class="Section">
					<div class="SectionContent">
						<div class="filterTheme">
							<h2 id="themeCriteriaPanel">Thèmes</h2>
									<select multiple name="selectThemesPanel" id="selectThemesPanel" class="filter">
										<!--la première option de la liste déroulante avec l'invitation à sélectionner-->
										<optgroup label=" Tous">
											<option value="all" default>Tout les menus</option>
										</optgroup>
										<optgroup label=" Par thème">
											<?php
											//récupère les themes de la db (les id en valeurs et libelles en écriture)
											foreach ($themes as $theme): ?>
												<option value="<?= $theme->theme_id ?>"><?= $theme->libelle ?></option>
											<?php endforeach; ?>
										</optgroup>
									</select>
						</div>
					</div>
				</section>
			</div>
			<div class="multiSectionsRight">
				<section class="Section">
					<div class="SectionContent Criterias">
						<h2>Recherche d'un menu spécifique ?</h2>
						<div class="rollingMenuCriterias" id="filterSelection">
						<h3>1. Veuillez sélectionner un choix ou un filtre: </h3>
								<div><label>
									<h6 id="filterCriteria">Filtres Menus</h6>
									<select name="selectFilter" id="selectFilter" class="filter">
										<!--<option class="none" value="" disabled selected>Filtres menus</option>-->
										<!--la première option de la liste déroulante avec l'invitation à sélectionner-->
										<option class="none" value="none" disabled selected>Afficher</option>
										<optgroup label="Tous">
										<option value="all" default>. Tout les menus</option>
										<optgroup label="Filtres menus">
											<option value="theme">. Par thèmes</option>
											<option value="priceRange">. Par plages de prix</option>
											<option value="maxPrice">. Par prix max</option>
											<option value="regimeType">. Par type de régime</option>
										</optgroup>
									</select>
								</label></div>
						</div>
						<div class="rollingMenuCriterias" id="filterGroup">
							<h3 id="chooseFilter">2. Veuillez préciser un critère de filtre: </h3>
							<div class="tempChoosenFilter">
							<!--Pour représentation temporaire uniquement tant qu un filtre n'est pas choisi-->
								<label>
									<h6>Critères du Filtre</h6>
									<select class="filter" disabled>
										<option class="none" value="" disabled selected>Critères</option>
									</select>
								</label></div>
							<div id="themeFilter" ><label>
									<h6 id="themeCriteria">Thèmes</h6>
									<select name="selectThemes" id="selectThemes" class="filter">
										<option class="none" value="" disabled selected>Thèmes</option>
										<!--la première option de la liste déroulante avec l'invitation à sélectionner-->
										<optgroup label="Tous">
											<option value="all" default>Tous</option>
										</optgroup>
										<optgroup label=" Par thème">
											<?php
											//récupère les themes de la db (les id en valeurs et libelles en écriture)
											foreach ($themes as $theme): ?>
												<option value="<?= $theme->theme_id ?>"><?= $theme->libelle ?></option>
											<?php endforeach; ?>
										</optgroup>
									</select>
								</label></div>
							<div id="priceRangeFilter"><label>
									<h6 id="priceRangeCriteria">Plages de prix</h6>
									<select name="priceRange" id="selectPriceRange" class="filter">
										<option class="none" value="" disabled selected>Fourchette</option>
										<optgroup label="Tous">
											<option value="all" default>Tous</option>
										</optgroup>
										<optgroup label="Par plages de prix">
											<option value="0">0-15 €</option>
											<option value="15">15-30 €</option>
											<option value="30">30-45 €</option>
											<option value="45">> 45 €</option>
										</optgroup>
									</select>
								</label></div>
							<div id="maxPriceFilter" ><label>
									<h6 id="maxPriceCriteria"> Prix max</h6>
									<select name="maxPrice" id="selectMaxPrice" class="filter">
										<option class="none" value="" disabled selected>Prix max</option>
										<optgroup label="Tous">
											<option value="all" default>Tous</option>
										</optgroup>
										<optgroup label="Par prix max">
											<option value="20">20 €</option>
											<option value="35">35 €</option>
											<option value="50">50 €</option>
											<option value="10000">> 50 €</option>
										</optgroup>
									</select>
								</label></div>

							<div id="typeRegimeFilter"><label>
									<h6 id="typeRegimeCriteria">Type de régime</h6>
									<select name="regime" id="selectRegime" class="filter">
										<option class="none" value="" disabled selected>Régime</option>
										<optgroup label="Tous">
											<option value="all" default>Tous</option>
										</optgroup>
										<optgroup label="Par régime">
											<?php
											//récupère les régimes de la db (les id en valeurs et libelles en écriture)
											foreach ($regimes as $regime): ?>
												<option value="<?= $regime->regime_id ?>"><?= $regime->libelle ?></option>
											<?php endforeach; ?>
										</optgroup>
									</select>
								</label></div>
						</div>
						<input type="submit" name="resetFilters" value="Reinitialiser les filtres" id="resetFilters" onclick="location.reload()" />
					</div>
				</section>
				<section class="Section">
					<div class="SectionContent" >
						<h2><u>Menus </u>: <em><span id="heading">Tout les menus</span></em></h2>
						<p class="requirement" id="notePlat">* Cliquer sur un menu pour voir le détail des plats le composant</p>
				<div id="menuContainer">
				<hr class="menuSeparation">
						<?php
						//récupère les menus de la db ( ainsi que leur thèmes et leur régime associés)
						foreach ($menus as $menu):
						?>
							<div class="menu">
								<div class="menuLeft">
									<!--cheminPhotoMenu&NomdePhoto-->
									<img src="<?php echo ($photoMenuPath . $menu->photo_menu) ?>" alt="" width="200px">
								</div>
								<div class="menuRight">
									<h3 class="title">
										<!--titre menu-->
										<a href=""><?= $menu->titre ?></a>
									</h3>
									<!--description menu-->
									<p class="description">
										<?= $menu->description ?>

									</p>
									<div class="regimetheme">
										<div>
											<h5>&nbsp;<span>Thème: </span></h5>
											<!--thème menu-->
											<p>&nbsp;&nbsp;&nbsp;<span><em><?= $menu->theme ?></em></span></p>
										</div>
										<div>
											<h5><span>Régime: </span></h5>
											<!--régime menu-->
											<p>&nbsp;&nbsp;&nbsp;<em><?= $menu->regime ?></em></p>
										</div>
										<div>
											<h5><span>Nbre pers.min: </span></h5>
											<!--Nbre pers.min-->
											<p>&nbsp;&nbsp;&nbsp;<em><?= $menu->nombre_personne_minimum ?></em></p>
										</div>
										<div>
											<h5><span>Qté restante(s): </span></h5>
											<!--Qté restante(s)-->
											<p>&nbsp;&nbsp;&nbsp;<em><?= $menu->quantite_restante ?></em></p>
										</div>
										<!--prix menu-->
										<h5>Prix TTC:</h5>
										<p class="price"><?= $menu->prix_par_personne ?>&euro;/pers.</p>
									</div>
								</div>
							</div>
							<hr class="menuSeparation">
						<?php endforeach; ?>
					</div>	
					</div>
				</section>
			</div>
		</div>
	</div>
	<?php require_once "includes/footer.php" ?>
	<script type="module" src="./JS/menus.js"></script>
</body>

</html>