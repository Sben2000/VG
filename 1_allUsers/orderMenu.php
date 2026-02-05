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
require_once("./Functions/fctUserProfil.php");
/*si session user active => réccupérer ses données de profil */
if (isset($_SESSION["user"])) {
	/*Récupérer le résultat de la function données de profil user*/
	$response = userProfilDatas($_SESSION["user"]);
	//si l'utilisateur a préalablement renseigné son compte Profil (non nul) =>assigner à $userProfil
	if ($response != NULL) {
		$userProfil = $response;
	}

	//execution de la function createUserOrder lors du submit "Je confirme"
	//Note: variables traitées/nettoyées dans la function, $feedback=retour du traitement
	if (isset($_POST['confirmOrder'])) {
		//Attribution d'une valeur par défaut à $recordDeliveryDatas si la checkbox si n'existe pas (décochée par l'utilisateur)
		if (empty($_POST['recordDeliveryDatas'])) {
			$recordDeliveryDatas = "notchecked";
		} else {
			$recordDeliveryDatas = $_POST['recordDeliveryDatas'];
		}
		//function createUserOrder($userID, $name, $firstname, $email, $phoneNumber, $adress, $cityName, $postalCode,  $wishedDate, $wishedTime,  $selectedMenu, $peopleNbrSpec, $priceMenu, $reductionRate, $deliveryPrice, $totalPrice, $recordDeliveryDatas){
		$feedback = createUserOrder($_POST['userID'], $_POST['nomCheckedJS'], $_POST['prenomCheckedJS'], $_POST['email'], $_POST['telCheckedJS'], $_POST['adressCheckedJS'], $_POST['villeCheckedJS'], $_POST['codePostalCheckedJS'], $_POST['datePrestaCheckedJS'],  $_POST['heurePrestaCheckedJS'], $_POST['menuCheckedJS'], $_POST['nbrPersCheckedJS'], $_POST['priceMenuCheckedJS'], $_POST['reductionRateCheckedJS'], $_POST['deliveryPriceCheckedJS'], $_POST['totalPriceCheckedJS'], $recordDeliveryDatas);
	}
}




?>

<!DOCTYPE html>
<html lang="fr">

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
	<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->


	<!--Modal de confirmation affiché par le JS si la validation commande est ok-->

	<div class="modal" id="modalOrder">
		<div class="modalContainer" id="modalContainerOrder">
			<div id="orderConfTop">
				<img src="./includes/default_pictures/buttonClose.png" alt="imgCloseModal" id="imgCloseModalOrder">
				<h2 id="h2Order">Résumé de commande</h2>
			</div>

			<form action="" method="POST" id="formToConfirmOrder">

				<div id="SectionContentOrderConf">

					<h3>Personne à joindre</h3>
					<hr>
					<div class="detailedInput fetch">
						<label for="nomCheckedJS">Nom </label>
						<div><br>
							<input readonly type="text" id="nameCheckedJS" name="nomCheckedJS" value="<?= @$userProfil->nom ?>" placeholder="Nom de famille"
								autocomplete="off" required>
							<!--Si changement en JS, version hidden pour comparaison avec données originales DB pour proposition ou pas de conserver les données modifiées dans le compte utilisateur-->
							<input type="hidden" id="nameHidden" name="nom" value="<?= @$userProfil->nom ?>">
							<!--id du user en type hidden pour pour cibler le compte utilisateur-->
							<input type="hidden" id="nameHidden" name="userID" value="<?= @$userProfil->utilisateur_id ?>">
						</div>
					</div>
					<div class="detailedInput fetch">
						<label for="prenomCheckedJS">Prénom </label>
						<div><br>
							<input readonly type="text" id='firstnameCheckedJS' name="prenomCheckedJS" value="<?= @$userProfil->prenom ?>" placeholder="Prénom"
								autocomplete="off" required>
							<!--Si changement en JS, version hidden pour comparaison avec données originales DB pour proposition ou pas de conserver les données modifiées dans le compte utilisateur-->
							<input type="hidden" id='firstnameHidden' name="prenomHidden" value="<?= @$userProfil->prenom ?>">
						</div>
					</div>
					<div class="detailedInput fetch">
						<label for="email">Email du compte</label>
						<div><br>
							<input readonly type="email" id='emailCheckedJS' name="email" value="<?= @$userProfil->email ?>" placeholder="Email" autocomplete="off" required>
						</div>
					</div>
					<div class="detailedInput fetch">
						<label for="telCheckedJS">Numéro de téléphone </label>
						<div><br>
							<!--mis en format text dans le JS pour présentation idem autres éléments-->
							<input readonly type="text" id='phoneNumberCheckedJS' name="telCheckedJS" value="<?= @$userProfil->telephone ?>" placeholder="0123456789" autocomplete="off" required>
							<!--Si changement en JS, version hidden pour comparaison avec données originales DB pour proposition ou pas de conserver les données modifiées dans le compte utilisateur-->
							<input type="hidden" inputmode="numeric" id='phoneNumberHidden' name="telHidden" value="<?= @$userProfil->telephone ?>">
						</div>
					</div>

					<div class="orderFormDelivery">
						<h3>Adresse de livraison</h3>
						<hr>
						<div class="detailedInput fetch">
							<label for="adressCheckedJS">Adresse </label>
							<div><br>
								<input readonly type="text" id="adressCheckedJS" name="adressCheckedJS" value="<?= @$userProfil->adresse_postale ?>" placeholder="rue/Allée/Av/Bvd..."
									autocomplete="off">
								<!--Si changement en JS, version hidden pour comparaison avec données originales DB pour proposition ou pas de conserver les données modifiées dans le compte utilisateur-->
								<input type="hidden" id="adressHidden" name="adressHidden" value="<?= @$userProfil->adresse_postale ?>">
							</div>
						</div>
						<div class="detailedInput fetch">
							<label for="ville">Ville </label>
							<div><br>
								<input readonly type="text" id="cityNameCheckedJS" name="villeCheckedJS" value="<?= @$userProfil->ville ?>" placeholder="Ville" autocomplete="off">
								<!--Si changement en JS, version hidden pour comparaison avec données originales DB pour proposition ou pas de conserver les données modifiées dans le compte utilisateur-->
								<input type="hidden" id="cityNameHidden" name="villeHidden" value="<?= @$userProfil->ville ?>">
							</div>
						</div>
						<div class="detailedInput fetch">
							<label for="codePostalCheckedJS">Code Postal </label>
							<div><br>
								<input readonly type="text" id='postalCodeCheckedJS' name="codePostalCheckedJS" value="<?= @$userProfil->code_postal ?>" placeholder="33XXX"
									autocomplete="off">
								<!--Si changement en JS, version hidden pour comparaison avec données originales DB pour proposition ou pas de conserver les données modifiées dans le compte utilisateur-->
								<input type="hidden" id='postalCodeHidden' name="codePostalHidden" value="<?= @$userProfil->code_postal ?>">
							</div>
						</div>
						<div class="detailedInput fetch">
							<label for="datePrestaCheckedJS">Date souhaitée</label>
							<div><br>
								<!--mis en format text dans le JS pour présentation idem autres éléments-->
								<input readonly type="text" id="wishedDateCheckedJS" name="datePrestaCheckedJS" value="" min="<?= $tomorrow ?>" max="<?= $twoWeeks ?>" placeholder="YYYY-MM-DD" autocomplete="off" required>
							</div>
						</div>
						<div class="detailedInput fetch">
							<label for="heurePrestaCheckedJS">plage horaire souhaitée </label>
							<div><br>
								<!--mis en format text dans le JS pour présentation idem autres éléments-->
								<input readonly type="text" id="wishedTimeCheckedJS" name="heurePrestaCheckedJS" value="" placeholder="XX:00 - YY:00" autocomplete="off" required>
							</div>
						</div>
					</div>
					<div class="orderFormQuantity">
						<h3>Menu et quantités</h3>
						<hr>
						<div class="detailedInput fetch">
							<label for="menuCheckedJS">Menu sélectionné </label>
							<!--titre du plat ne peut être modifié-->
							<div><br>
								<input type="text" id="menuTitleCheckedJS" name="menuCheckedJS" value="<?= $menu->titre ?>" placeholder="réf.Menu..." readonly autocomplete="off">
							</div>
						</div>
						<div class="detailedInput peopleNbrSpec fetch">
							<label for="nbrPersCheckedJS">Nombre de personnes </label>
							<!--Dans le placeholder et la valeur min, est intégré directement la valeur min définie dans le menu. La valeur max correspond à la quantité restante-->
							<div><br>
								<!--mis en format text dans le JS pour présentation idem autres éléments-->
								<input readonly type="text" id="peopleNbrSpecCheckedJS" name="nbrPersCheckedJS" value="" placeholder="<?= $menu->nombre_personne_minimum  ?>" autocomplete="off" min="<?= $menu->nombre_personne_minimum   ?>" max="<?= $menu->quantite_restante ?>">
							</div>
						</div>
						<h3>Tarif détaillé</h3>
						<hr>
						<div class="detailedInput fetch">
							<label for="priceMenuCheckedJS">Prix du menu (&#x20AC TTC/pers): </label>
							<div class="symbol">
								<!--prix du plat ne peut être modifié-->
								<input type="text" id="priceMenuDispCheckedJS" name="priceMenuCheckedJS" value="<?= @$menu->prix_par_personne ?>" readonly required><span>&#x20AC</span>
							</div>
						</div>
						<div class="detailedInput fetch">
							<label for="reductionRateCheckedJS">Réduction (%): </label>
							<div class="symbol">
								<input type="text" id="reductionRateCheckedJS" name="reductionRateCheckedJS" value="" readonly required><span>%</span>
							</div>
						</div>
						<div class="detailedInput fetch">
							<label for="deliveryPriceCheckedJS">Prix de la livraison (&#x20AC): </label>
							<div class="symbol">
								<input type="text" id="deliveryPriceCheckedJS" name="deliveryPriceCheckedJS" value="" readonly required><span>&#x20AC</span>
							</div>
						</div>
						<div class="detailedInput fetch">
							<label for="totalPriceCheckedJS">Prix total (&#x20AC TTC): </label>
							<div class="symbol">
								<strong><input type="text" id="totalPriceCheckedJS" name="totalPriceCheckedJS" value="" readonly required style="text-align: center;"></strong><span>&#x20AC</span>
							</div>
						</div>
						<div class="recordDeliveryDatas" id="recordDeliveryDatas">
							<p class="note">Enregistrer sur mon espace les coordonnées pour une prochaine livraison?</p>
							<div class="recordDatasCheckBox">
								<input type="checkbox" checked name="recordDeliveryDatas" id="recordDatasCheckBox" value="checked">
								<label for="recordDeliveryDatas" class="note">oui</label>
							</div>
						</div>
					</div>
					<div class="modalInputs" id="confirmOrderButtons">
						<input type="submit" name="backToOrder" value="Annuler" id="backToOrder">
						<input type="submit" name="confirmOrder" value="Je confirme" id="confirmOrder">
					</div>

				</div>

			</form>
		</div>
	</div>




	<!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
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
					<?php
					//Récupération du contenu de cette section pour l'afficher plus bas lors de la vue téléphone
					$contentJoinUs = '
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
				 '; ?>
				</section>

				<!--Affichage du contenu-->
				<?= $contentJoinUs  ?>
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
									
									</br>

										<?php
										if ($associatedDishes == NULL) { ?>
											<p class="note"><em>&#x2794; cf.description ci dessus ou nous contacter pour le détail</em></p>
											<?php
										} else {
											foreach ($associatedDishes as $associatedDish): ?>
												<div class="associatedDishesDetails">
													<p><?= $associatedDish->titre_plat ?></p>
													<!--origine du code ci dessous :https://openclassrooms.com/forum/sujet/telecharger-une-image-blob-sur-dans-un-fichier et https://stackoverflow.com/questions/54638875/using-php-pdo-to-show-image-blob-from-mysql-database-in-html-image-tag-->
													<img src="data:image/png;base64,<?= base64_encode($associatedDish->photo) ?>" width="120px" height="120px" />
													<!--affichage des éventuels allergènes de chaque plat-->
													<?php $allergs = getAllergenes($associatedDish->plat_id);
                    								if ($allergs!=NULL){
														?><p class="allergene"><u>Allerg. potentiels:</u></p><?php
													foreach ($allergs as $allerg):?>
													<div class="allergeneElements">
														<span><em><?= $allerg->libelle ?></em></span>
													</div>
													<?php endforeach;}?>
												</div>
											<?php endforeach; 
											}?>
									</div>

									<div class="regimetheme">
										<div>
											<h5>&nbsp;<span id="ThemeMenu">Thème: </span></h5>
											<!--thème menu-->
											<p>&nbsp;&nbsp;&nbsp;<span><em><span><?= $menu->theme ?></span></em></span></p>
										</div>
										<div>
											<h5><span id="RegimeMenu">Régime: </span></h5>
											<!--régime menu-->
											<p>&nbsp;&nbsp;&nbsp;<em><span><?= $menu->regime ?></span></em></p>
										</div>
										<div>
											<h5><span>Nbre pers.min: </span></h5>
											<!--Nbre pers.min-->
											<p>&nbsp;&nbsp;&nbsp;<em><span id="peopleNbrReq"><?= $menu->nombre_personne_minimum ?></span></em></p>
										</div>
										<div>
											<h5><span>Qté restante(s): </span></h5>
											<!--Qté restante(s)-->
											<p>&nbsp;&nbsp;&nbsp;<em><span id="RemainingQty"><?= $menu->quantite_restante ?></span></em></p>
										</div>
										<!--prix menu-->
										<h5>Prix TTC:</h5>
										<p class="price" id="priceMenu"><span><?= $menu->prix_par_personne ?></span>&euro;/pers.</p>
									</div>
								</div>
							</div>
							<hr class="menuSeparation">

						</div>
					</div>
				</section>
				<?php //si l'utilisateur n'est pas connecté, lui sont alors détaillés les différentes façon de commander
				if (!isset($_SESSION["user"])) {	?>
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
				} else { ?>
					<section class="Section">
						<div class="SectionContent Criterias">
							<div class="menuDetailedButtons">
								<input type="submit" name="previousPage" value="&#x2B9C; Fermer la page" id="closePage" />
								<input type="submit" name="orderButton" value="Commander &#x2B9F;" id="orderButton" />
							</div>
							<div class="feedback">
								<?php
								//retour du resultat $feedback affiché à l'utilisateur
								//si le resultat de la function est success
								if (@$feedback == "success") {
								?>
									<!--afficher : -->
									<p class="success" style='color:green'><strong>La commande a bien été enregistrée !</strong></p>
									<p class="success" style='color:green'>Un récapitulatif de celle ci vous sera envoyé par mail.</p>
									<p class="success" style='color:green'>Nous revenons vers vous au plus vite pour vous confirmer sa validation.</p>
								<?php
								 }else {
								?><!--sinon retourner le résultat de la sous function qui a soulevé une erreur -->
									<p class="error" style='color:darkred'><?= @$feedback ?></p>
								<?php
								}
								?>
							</div>
						</div>
					</section>

					<section class="Section" id="orderSectionForm" class="orderSectionForm">
						<div class="SectionContent">
							<h2>Je précise ma commande et mes infos de livraison :</h2>

							<form id="orderForm" method="POST" enctype="multipart/form-data" action="#modalOrder">
								<div class="orderFormInfo">
									<div class="orderFormAdress">
										<h3>Personne à joindre</h3>
										<hr>
										<div class="detailedInput">
											<label for="nom">Nom </label>
											<input type="text" id="name" name="nom" value="<?= @$userProfil->nom ?>" placeholder="Nom de famille"
												autocomplete="off" required>
											<p id="feedBackNameError" style="color: darkred;"></p>
										</div>
										<div class="detailedInput">
											<label for="prenom">Prénom </label>
											<input type="text" id='firstname' name="prenom" value="<?= @$userProfil->prenom ?>" placeholder="Prénom"
												autocomplete="off" required>
											<p id="feedBackFirstnameError" style="color: darkred;"></p>
										</div>
										<div class="detailedInput fetch">
											<label for="email">Email du compte</label>
											<input type="email" id='email' name="email" value="<?= @$userProfil->email ?>" placeholder="Email" autocomplete="off" required readonly>
										</div>
										<div class="detailedInput">
											<label for="tel">Numéro de téléphone </label>
											<input type="tel" inputmode="numeric" id='phoneNumber' name="tel" value="<?= @$userProfil->telephone ?>" placeholder="0123456789" autocomplete="off" required>
											<p id="feedBackPhoneError" style="color: darkred;"></p>
										</div>
									</div>
									<div class="orderFormDelivery">
										<h3>Adresse de livraison</h3>
										<hr>
										<div class="detailedInput">
											<label for="adresse">Adresse </label>
											<input type="text" id="adress" name="adresse" value="<?= @$userProfil->adresse_postale ?>" placeholder="rue/Allée/Av/Bvd..."
												autocomplete="off">
											<p id="feedBackAdressError" style="color: darkred;"></p>
										</div>
										<div class="detailedInput">
											<label for="ville">Ville </label>
											<input type="text" id="cityName" name="ville" value="<?= @$userProfil->ville ?>" placeholder="Ville" autocomplete="off">
											<p id="feedBackCityNameError" style="color: darkred;"></p>
										</div>
										<div class="detailedInput">
											<label for="codePostal">Code Postal </label>
											<input type="text" id='postalCode' inputmode="numeric" name="codePostal" value="<?= @$userProfil->code_postal ?>" placeholder="33XXX"
												autocomplete="off">
											<p id="feedBackPostalCodeSuccess" style="color: darkgreen;"></p>
											<p id="feedBackPostalCodeError" style="color: darkred;"></p>
											<p class="note" id="postalCodeInfo"><em>Pas de livraison hors agglomération.<br>Offerte à Bordeaux, 5&#x20AC/agglo</em></p>

										</div>
										<div class="detailedInput wished">
											<label for="datePresta" style="text-align:center;">Date souhaitée</label>
											<!--$tomorrow et $twoWeeks calculés en php-->
											<input type="date" id="wishedDate" name="datePresta" value="" min="<?= $tomorrow ?>" max="<?= $twoWeeks ?>" placeholder="YYYY-MM-DD" autocomplete="off" required>
											<p id="feedBackWishedDateSuccess" style="color: darkgreen;"></p>
											<p id="feedBackWishedDateError" style="color: darkred;"></p>
											<p class="note" id="datePrestaInfo"><em><br>réservation possible à partir <br>du prochain jour ouvré <br> (sur 2 semaines, hors dimanche) </em></p>
										</div>


										<!--<input type="time"  name="heurePresta" value="" autocomplete="off" required>-->
										<div class="rollingMenuCriterias detailedInput">
											<label for="heurePresta">plage horaire souhaitée </label>
											<div><label>
													<select name="selectFilter" id="wishedTime" class="filter wished">
														<!--<option class="none" value="" disabled selected>Sélectionner</option>-->
														<!--la première option de la liste déroulante avec l'invitation à sélectionner-->
														<option class="none" value="none" disabled selected>Selectionner &#x23F2;|</option>
														<optgroup label="Service du Déjeuner ">
															<option value="11h00-12h00">&#x2B1D; 11:00 - 12:00 </option>
															<option value="12h00-13h00">&#x2B1D; 12:00 - 13:00 </option>
															<option value="13h00-14h00">&#x2B1D; 13:00 - 14:00 </option>
														<optgroup label="Service du Diner ">
															<option value="18h-19h00">&#x2B1D; 18:00 - 19:00 </option>
															<option value="19h00-20h00">&#x2B1D; 19:00 - 20:00 </option>
															<option value="20h00-21h00">&#x2B1D; 20:00 - 21:00 </option>
															<option value="21h00-22h00">&#x2B1D; 21:00 - 22:00 </option>
														</optgroup>
													</select>
												</label></div>
										</div>
										<p id="feedBackWishedTimeSuccess" style="color: darkgreen;"></p>
										<p id="feedBackWishedTimeError" style="color: darkred;"></p>

									</div>
									<div class="orderFormQuantity">
										<h3>Menu et quantités</h3>
										<hr>
										<div class="detailedInput fetch">
											<label for="menu">Menu sélectionné </label>
											<!--titre du plat ne peut être modifié-->
											<input type="text" id="menuTitle" name="menu" value="<?= $menu->titre ?>" placeholder="réf.Menu..." readonly autocomplete="off">
										</div>
										<div class="detailedInput peopleNbrSpec">
											<label for="nbrPers">Nombre de personnes </label>
											<!--Dans le placeholder et la valeur min, est intégré directement la valeur min définie dans le menu. La valeur max correspond à la quantité restante-->
											<input type="number" id="peopleNbrSpec" name="nbrPers" value="" placeholder="<?= $menu->nombre_personne_minimum  ?>" autocomplete="off" min="<?= $menu->nombre_personne_minimum   ?>" max="<?= $menu->quantite_restante ?>">
											<p id="feedBackPeopleSuccess" style="color: darkgreen;"></p>
											<p id="feedBackPeopleError" style="color: darkred;"></p>
											<p id="feedBackPeopleOtherInfo" style="color: darkblue;"></p>
											<p class="note" id="nbrPersInfo"><em><span id="messageMinReq">nbre en fct du mini si requis. <br></span><span id="discount">10% de réduction dès 5 pers.</span></em></p>
										</div>
										<h3>Tarif détaillé</h3>
										<hr>
										<div class="detailedInput fetch">
											<label for="priceMenu">Prix du menu (&#x20AC TTC/pers): </label>
											<div class="symbol">
												<!--prix du plat ne peut être modifié-->
												<input type="text" id="priceMenuDisp" name="priceMenu" value="<?= @$menu->prix_par_personne ?>" readonly required><span>&#x20AC</span>
											</div>
										</div>
										<div class="detailedInput fetch">
											<label for="reductionRate">Réduction (%): </label>
											<div class="symbol">
												<input type="text" id="reductionRate" name="reductionRate" value="" readonly required><span>%</span>
											</div>
										</div>
										<div class="detailedInput fetch">
											<label for="deliveryPrice">Prix de la livraison (&#x20AC): </label>
											<div class="symbol">
												<input type="text" id="deliveryPrice" name="deliveryPrice" value="" readonly required><span>&#x20AC</span>
											</div>
										</div>
										<div class="detailedInput fetch">
											<label for="totalPrice">Prix total (&#x20AC TTC): </label>
											<div class="symbol">
												<input type="text" id="totalPrice" name="totalPrice" value="" readonly required style="text-align: center;"><span>&#x20AC</span>
											</div>
										</div>
									</div>
								</div>
								<div class="menuDetailedButtons">
									<input type="submit" name="cancelOrderProcess" value="Annuler" id="cancelOrderProcess" />
									<input type="submit" name="submitOrder" value="Valider la commande" id="submitOrder" />
								</div>
								<div class="submitMessages">
									<p id="successMessage" style="color: darkgreen;"></p>
									<p id="errorMessage" style="color: darkred;"></p>
								</div>
							</form>
						</div>
						<!--		<div class="modalGroup">
							<div class="modal" id="modal">
								<div class="modalContainer">
									<img src="./includes/default_pictures/buttonClose.png" alt="imgCloseModal" id="imgCloseModal">
									<h2>Je confirme la deconnexion</h2>
									<form action="" method="POST">
										<div class="modalInputs">
											<input type="submit" name="disconnect" value="Me déconnecter">
										</div>
									</form>
								</div>
							</div>


							<div class="modalGroup">
								<div class="modal" id="modalDel">
									<div class="modalContainer">
										<img src="./includes/default_pictures/buttonClose.png" alt="imgCloseModal" id="imgCloseModalDel">
										<h2 id="h2Del">Confirmez vous la <br> suppression du compte?</h2>
										<form action="" method="POST">
											<div class="modalInputs">
												<input type="submit" name="deleteAccountConf" value="Je confirme la suppression">
											</div>
										</form>
									</div>
								</div>
													-->


					</section>
				<?php } ?>
				<section class="sectionContent" id="joinUsPhoneView">
					<?= $contentJoinUs ?>
				</section>
			</div>
		</div>
	</div>


	<?php require_once "includes/footer.php" ?>
	<script type="module" src="./JS/orderMenu.js"></script>
</body>

</html>