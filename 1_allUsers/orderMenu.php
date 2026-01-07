<?php
//fichier de function traitant les détails affichés dans cette page
require_once "./Functions/fctOrderMenu.php";

/*Si une réquête (en provenance de l'url encodé (clé menuID) de menu.php) est complétée avec une valeur de menuID :*/
if (isset($_GET['menuID'])) {
	/*la valeur décodé est alors récupéré est assigné à $menuID*/
	$menuID = urldecode($_GET['menuID']);
	//le menuID est passé en argument de la function qui récupère les détails de celui ci 
	//seul le menu sélectionné est  affiché dans la suite via les data objets récupérés $menu->XXX
	$menu =  getSelectedMenu($menuID);
	//les plats associés sont récupérés via la function getProposePlatByMenuID($menuID) en y passant l'ID menu sélectionné
	$associatedDishes = getProposePlatByMenuID($menuID);
}

//chemin du dossier photo menus
$photoMenuPath = "../2_vgTeam/gestionMenus/uploads/";

//récupération des données du Profil utilisateur à remplir dans le formulaire de commande
	require_once ("./Functions/fctUserProfil.php");
	/*si session user active => réccupérer ses données de profil */
		if(isset($_SESSION["user"])){
			/*Récupérer le résultat de la function données de profil user*/
			$response = userProfilDatas($_SESSION["user"]);
			//si l'utilisateur a préalablement renseigné son compte Profil (non nul) =>assigner à $userProfil
		    if($response != NULL){
		      $userProfil = $response;
    	}
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

	<title>Détails menu & commande</title>
</head>

<body>
	<?php include_once "includes/header.php" ?>
	<div class="main">
		<div class="separator">
			<h1 class="sectionTitle">Détails menu & commande</h1>
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
				<section class="Section" id="absolute">
					<div class="SectionContent">
						<div>
							<h2 id="reachUsPanelTitle"><u>Nous joindre : </u></h2>
							<div class="reachUsPanel">
								<div class="reachUsPanelDetails">
									<h3>&#x25AA; Nous trouver:</h3>
									<div class="findUsContent">
										<div class="mapResponsive">
											<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2829.6317741257817!2d-0.5671845234627645!3d44.829065775590735!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd5527b530b3ead3%3A0xdabebb8f9b125ed3!2sCr%20de%20la%20Marne%2C%2033800%20Bordeaux!5e0!3m2!1sfr!2sfr!4v1762846904803!5m2!1sfr!2sfr" width="200" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
										</div>
										<p>#Cr de la Marne, 33800 Bordeaux#</p>
									</div>

								</div>
								<div class="reachUsPanelDetails">
									
										<h3>&#x25AA; Nos horaires:</h3>
									
									<li type ="circle">Restauration sur place:</li>
									<p>Mardi au Samedi <br> de 12h-14h/19h-22h </p>
									<div class="orderType">
										<li>Commandes du restaurant:</li>
										<p>Mardi au Samedi <br> de 9h-11h30/14h-18h</p>
										<li>Commandes personnalisées:</li>
										<p>Lundi au Vendredi <br> de 8h-11h30/15h-19h</p>
									</div>
								</div>
								<div class="reachUsPanelDetails" id="ourContact">
									
										<h3>&#x25AA; Nous contacter:</h3>
									
									<li>Services du jour:</li>
									<p>&#x260E;: XX/XX/XX/XX/XX </p>
									<li>Commandes personnalisées:</li>

										<p>&#x260E;: <span> XX/XX/XX/XX/XX</span></p>
										<p>&#x40; : <span> XX@vit&go.fr</span></p>
									<div class="orderTypeContact" id="orderTypeContact" >
										<p>&#x2709; formulaire: <a href="contact.php">Contact</a></p>
									</div>
								</div>
							</div>

						</div>
					</div>
				</section>
			</div>
			<div class="multiSectionsRight">
				<section class="Section">
					<div class="SectionContent">
						<h2><u>Menu sélectionné </u>: <em><span id="heading"><?= $menu->titre ?></span></em></h2>
						<div id="menuContainer">
							<hr class="menuSeparation">

							<div class="menu">
								<div class="menuLeft">
									<!--cheminPhotoMenu&NomdePhoto-->
									<img src="<?php echo ($photoMenuPath . $menu->photo_menu) ?>" alt="" width="200px">
								</div>
								<div class="menuRight">
									<h3 class="choosenMenuTitle">
										<!--titre menu-->
										<p><u><?= $menu->titre ?></u></p>
									</h3>
									<!--description menu-->
									<p class="description">
										<?= $menu->description ?></p>
										
									<!--liste des plats associés-->
									<div class="associatedDishes">
									<h4>&nbsp;<span>Plat(s):&nbsp;</span></h4>
											<?php 
											if ($associatedDishes == NULL){?>
												<p class= "note"><em>&#x2794; cf.description ci dessus ou nous contacter pour le détail</em></p>
											<?php
											}else{
											foreach ($associatedDishes as $associatedDish): ?>
										<div class="associatedDishesDetails">

												<p><?= $associatedDish->titre_plat ?></p>
												<!--origine du code ci dessous :https://openclassrooms.com/forum/sujet/telecharger-une-image-blob-sur-dans-un-fichier et https://stackoverflow.com/questions/54638875/using-php-pdo-to-show-image-blob-from-mysql-database-in-html-image-tag-->
													<img src="data:image/png;base64,<?=base64_encode($associatedDish->photo)?>" width="120px" height="120px" />
										</div>
										<?php endforeach;} ?>
									</div>

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

						</div>
					</div>
				</section>
				<?php //si l'utilisateur n'est pas connecté, lui sont alors détaillés les différentes façon de commander
					if(!isset($_SESSION["user"])){	?>
				<section class="Section">
					<div class="SectionContent Criterias">
						<h2>Commander le menu ?</h2>

						<div class="orderLinksExplanation">
							<h3>&#x27A5; Depuis le site internet : </h3>
							<div class="howToOrder">
								<p>&#x2B2A; Connecter vous à votre compte en cliquant sur <a href="login.php">ce lien</a> et sélectionner le menu</p>
								<p>&#x2B2A; Pas encore de compte? <a href="signUP.php">S'inscrire ici</a></p>
							</div>
						</div>
						<div class="orderLinksExplanation">
							<h3>&#x27A5; En nous contactant : </h3>
							<div class="howToOrder">
								<p>&#x2B2A; Via nos coordonnées affichées dans la section "Nous joindre"</a> ou <a href="indexLocal.php#reachUsRight">en page d'accueil</a></p>
								<p>&#x2B2A; Via notre <a href="contact.php">formulaire de contact</a></p>
							</div>
						</div>

						<div class="menuDetailedButtons">
							<input type="submit" name="previousPage" value="<< Fermer la page" id="closePage" />
						</div>
					</div>
				</section>
				<?php 
						//sinon si l utilisateur est connecté, on lui affiche la possibilité de commander 
				}else{ ?>
				<section class="Section">
					<div class="SectionContent Criterias">
						<div class="menuDetailedButtons">
							<input type="submit" name="previousPage" value="&#x2B9C; Fermer la page" id="closePage" />
							<input type="submit" name="orderButton" value="Commander &#x2B9F;" id="orderButton" onclick="location.reload()" />
						</div>
					</div>
				</section>
				<section class="Section" id="orderSectionForm" class="orderSectionForm">
					<div class="SectionContent">
						<h2>Je précise ma commande</h2>

						<form id="orderForm">
							<div class="orderFormInfo">
								<div class="orderFormAdress">
									<h3>Mes coordonnées</h3>
									<hr>
									<div class="detailedInput">
										<label for="nom">Nom </label>
										<input type="text" name="nom" value="<?= @$userProfil->nom ?>" placeholder="Nom de famille"
											autocomplete="off" required>
									</div>
									<div class="detailedInput">
										<label for="prenom">Prénom </label>
										<input type="text" name="prenom" value="<?= @$userProfil->prenom ?>" placeholder="Prénom"
											autocomplete="off" required>
									</div>
									<div class="detailedInput">
										<label for="email">Email </label>
										<input type="email" name="email" value="<?= @$userProfil->mail ?>" placeholder="Email" autocomplete="off" required>
									</div>
									<div class="detailedInput">
										<label for="tel">Numéro de téléphone </label>
										<input type="tel" name="tel" value="<?= @$userProfil->telephone ?>" placeholder="../../../../.." autocomplete="off" required>
									</div>
								</div>
								<div class="orderFormDelivery">
									<h3>Mes infos de Livraison</h3>
									<hr>
									<div class="detailedInput">
										<label for="adresse">Adresse </label>
										<input type="text" name="adresse" value="<?= @$userProfil->adresse_postale ?>" placeholder="rue/Allée/Av/Bvd..."
											autocomplete="off">
									</div>
									<div class="detailedInput">
										<label for="ville">Ville </label>
										<input type="text" name="ville" value="<?= @$userProfil->ville ?>" placeholder="Ville" autocomplete="off">
									</div>
									<div class="detailedInput">
										<label for="codePostal">Code Postal </label>
										<input type="text" name="codePostal" value="<?= @$userProfil->code_postal ?>" placeholder="Code Postal"
											autocomplete="off">
										<p class="note"><em>Pas de livraison hors agglomération</em></p>
										<p class="note"><em>Offerte à Bordeaux, 5&#x20AC/agglo</em></p>
									</div>
									<div class="detailedInput">
										<label for="datePresta">Date souhaitée </label>
										<input type="date" name="datePresta" value="" autocomplete="off" required>
									</div>
									<div class="detailedInput">
										<label for="heurePresta">heure souhaitée </label>
										<input type="time" name="heurePresta" value="" autocomplete="off" required>
									</div>
								</div>
								<div class="orderFormQuantity">
									<h3>Menu et quantités</h3>
									<hr>
									<div class="detailedInput fetch">
										<label for="menu">Menu sélectionné </label>
										<!--titre du plat ne peut être modifié-->
										<input type="text" name="adresse" value="<?= $menu->titre ?>" placeholder="réf.Menu..." readonly autocomplete="off">
									</div>
									<div class="detailedInput">
										<label for="nbrPers">Nombre de personnes </label>
										<input type="number" name="nbrPers" value="" placeholder="2" autocomplete="off" min="1" max="50">
										<p class="note"><em>nbre en fct du mini si requis</em></p>
										<p class="note"><em>10% de réduction dès 5 pers.</em></p>
									</div>
									<h3>Tarif détaillé</h3>
									<hr>
									<div class="detailedInput fetch">
										<label for="priceMenu">Prix du menu (&#x20AC TTC/pers): </label>
										<!--prix du plat ne peut être modifié-->
										<input type="text" name="priceMenu" value="<?=@$menu->prix_par_personne ?>" readonly required>
									</div>
									<div class="detailedInput fetch">
										<label for="deliveryPrice">Prix de la livraison (&#x20AC): </label>
										<input type="text" name="deliveryPrice" value="" readonly required>
									</div>
									<div class="detailedInput fetch">
										<label for="totalPrice">Prix total (&#x20AC TTC): </label>
										<input type="text" name="totalPrice" value="" readonly required>
									</div>
								</div>
							</div>
							<div class="menuDetailedButtons">
								<input type="submit" name="cancelOrderProcess" value="Annuler" id="cancelOrderProcess" />
								<input type="submit" name="submitOrder" value="Valider la commande" id="submitOrder" />
							</div>
						</form>
					</div>
				</section>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php require_once "includes/footer.php" ?>
	<script type="module" src="./JS/orderMenu.js"></script>
</body>

</html>