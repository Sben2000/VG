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
							<h2>Thèmes</h2>
							<a href="">Les Spécifiques</a>
							<a href="">Du Jour</a>
							<a href="">Du Week end</a>
							<a href="">Nos Gouters</a>
							<a href="">Nos Pastas</a>
						</div>
					</div>
				</section>
			</div>
			<div class="multiSectionsRight">
				<section class="Section">
					<div class="SectionContent Criterias">
						<h2>Veuillez sélectionner un thème ou un filtre: </h2>
						<div class="rollingMenuCriterias">
							<div><label>
									<h6>Nos thèmes:</h6>
									<select name="selectThemes" id="selectThemes" class="filter">
										<option class="none" value="" disabled selected>Thèmes</option>
										<!--la première option de la liste déroulante avec l'invitation à sélectionner-->
										<optgroup label="Tous">
											<option value="all" default>Tous thèmes</option>
										</optgroup>
										<optgroup label=" Par thème">
											<option value="specifiques">Les spécifiques</option>
											<option value="jour">Du Jour</option>
											<option value="weekend">Du Week End</option>
											<option value="gouter">Nos Gouter</option>
											<option value="pasta">Nos Pastas</option>
										</optgroup>
									</select>
								</label></div>
							<div><label>
									<h6>Plages de prix:</h6>
									<select name="priceRange" id="priceRange" class="filter">
										<option class="none" value="" disabled selected>Fourchette</option>
										<optgroup label="Tous">
											<option value="all" default>Tous</option>
										</optgroup>
										<optgroup label="Par plages de prix">
											<option value="15">0-15 €</option>
											<option value="30">15-30 €</option>
											<option value="45">30-45 €</option>
											<option value="46">> 45 €</option>
										</optgroup>
									</select>
								</label></div>
							<div><label>
									<h6> prix max:</h6>
									<select name="maxPrice" id="maxPrice" class="filter">
										<option class="none" value="" disabled selected>Prix max</option>
										<optgroup label="Tous">
											<option value="all" default>Tous</option>
										</optgroup>
										<optgroup label="Par prix max">
											<option value="20">20 €</option>
											<option value="35">35 €</option>
											<option value="50">50 €</option>
											<option value="1000">> 50 €</option>
										</optgroup>
									</select>
								</label></div>

							<div><label>
									<h6>Type de régime:</h6>
									<select name="regime" id="regime" class="filter">
										<option class="none" value="" disabled selected>Régime</option>
										<optgroup label="Tous">
											<option value="all" default>Tous</option>
										</optgroup>
										<optgroup label="Par régime">
											<option value="vegan">végétarien</option>
											<option value="sansGluten">sans Gluten</option>
											<option value="arachideFree">sans arachide</option>
										</optgroup>
									</select>
								</label></div>
						</div>
						<input type="submit" name="resetFilters" value="Reinitialiser les filtres" id="resetFilters" onclick="location.reload()" />
					</div>
				</section>
				<section class="Section">
					<div class="SectionContent">
						<h2>Menus</h2>
						<div class="product">

							<div class="productLeft">
								<img src="../2_vgTeam/gestionMenus/uploads/gourmand.jpg" alt="" width="150px" >
							</div>

							<div class="productRight">
								<h3 class="title">
									<a href="">Gourmand</a>
								</h3>
								<p class="description">
									Een beitel in de vorm van een schuurtje op een beekplaat. Het dak wordt
									ondersteund door een frame dat rust op vier grote houten pilaren.
								</p>
								<p class="price">
									29.99 &euro;
								</p>

							</div>
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