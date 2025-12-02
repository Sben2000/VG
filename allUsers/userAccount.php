<?php

require ("./Functions/fctAccount.php");
//sécurisation de la page afin que seul l'utilisateur identifié ait accès à sa page
/*si session non active, redirection de l'utilisateur automatiquement  vers la page de login.php */
	    if(!isset($_SESSION["user"])){
        header("location: login.php");
        //puis on sort de cette page
        exit;
    }
/*
//si l'utilisateur clique sur deconnexion dans la navBar => appele la clé logout(href="?logout") via le lien du formulaire ci dessous =>clé/variable récupérant($GET_["logout"])), 
//on appelle la function logout qui détruit la session et redirige vers la page login.php

if (isset($_GET["logout"])){
    logoutUser();
}
*/
//3) cas ou l'utilisateur confirme  la suppression du compte défini en fin de page

if(isset($_GET["confirm-account-deletion"])){
    /*on apelle alors la function deleteAccount() qui supprimera celui ci définitivement et 
    renverra vers la page de confirmation de compte supprimé (delete-message.php) qui contient également
    un lien pour recréer un compte sur la page index.php*/
    deleteAccount();
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!--import des fonts  lobster et montserrat depuis googlefonts-->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
		rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet" />

	<!--link css-->
	<link rel="stylesheet" href="CSS/connexion.css" />
	<!--link css de la navBar header-->
	<link rel="stylesheet" href="CSS/styleHeader.css" />
	<!--link css footer-->
	<link rel="stylesheet" href="CSS/footer.css" />
	<!--link css disconnect (modal)-->
	<link rel="stylesheet" href="CSS/disconnectMod.css" />
</head>

<body>
	<?php include_once "includes/header.php" ?>
	<div class="main">
		<div class="separator">
			<h1 class="sectionTitle">Mon compte</h1>
		</div>
		<div class="multiSectionsTop">
			<div class="multiSectionsLeft">
				<section class="Section">
					<div class="SectionContent">
						<h2>Mes informations Vite&Go</h2>
						<form id="accountForm" method="post" action="">
							<div class="detailedInput fetch">
								<label for="username">Nom d'utilisateur: </label>
								<input type="text" id="username" name="username" value="" autocomplete="off"
									readonly required />
							</div>
							<div class="detailedInput fetch">
								<label for="email">Email: </label>
								<input type="email" name="email" value="" readonly autocomplete="off" />
							</div>
							<span class="note"><em>*Par sécurité, seul le nom d'utilisateur est modifiable,<br> → Nous contacter pour modifier l'email</em></span>
								<!-- Submit boutton  -->
								<div class="formBottom">
									<form action="./userContact.php">
									<input type="submit" name="modifierGeneral" value="Modifier" formaction="./userContact.php"/>
									</form>
								</div>
						</form>
					
				</section>


			</div>
			<div class="multiSectionsRight">
				<section class="Section">
					<div class="SectionContent">
						<h2>Mes coordonnées</h2>

						<form id="userContactForm">

							<div class="detailedInput fetch">
								<label for="nom">Nom: </label>
								<input type="text" name="nom" value="" readonly autocomplete="off" required>
							</div>
							<div class="detailedInput fetch">
								<label for="prenom">Prénom: </label>
								<input type="text" name="prenom" value="" readonly required>
							</div>
							<div class="detailedInput fetch">
								<label for="tel">Numéro de téléphone: </label>
								<input type="text" name="tel" value="" readonly>

							</div>
							<div class="detailedInput fetch">
								<label for="adresse">Adresse: </label>
								<input type="text" name="adresse" value="" readonly>
							</div>
							<div class="detailedInput fetch">
								<label for="ville">Ville: </label>
								<input type="text" name="ville" value="" readonly>
							</div>
							<div class="detailedInput fetch">
								<label for="codePostal">Code Postal: </label>
								<input type="text" name="codePostal" value="" readonly>
							</div>
							<div class="detailedInput fetch">
								<label for="pays">Pays: </label>
								<input type="text" name="pays" value="" readonly>
							</div>
							<div class="formBottom">
								<input type="submit" name="modifierDetails" value="Modifier" formaction="./userContact.php"/>
							</div>
						</form>
					</div>
				</section>
			</div>
		</div>
		<div class="multiSectionsBottom">
			<section class="Section">
				<div class="SectionContent">
					<h2>Voir mes commandes</h2>
					<div class="formBottom">
						<input type="submit" name="myOrder" value="Afficher mes Commandes ↓ " id="showMyOrders" />
						<input type="submit" name="myOrder" value="Masquer mes Commandes ↑" id="hideMyOrders" />

					</div>
				</div>
			</section>
			<section class="Section myOrders" id="myOrders">

				<div class="SectionContent">
					<h2>Commande N° xxxxx</h2>
					<div class="tables">
						<table class="myOrderTable">
							<thead>
								<tr>
									<th scope="col">date_cde</th>
									<th scope="col">statut</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>xxxxxx</td>
									<td>xxxxxx</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="orderDetailsButtons">
						<input type="submit" name="showDetails" value="Voir détails ↓" id="showDetails" />
						<input type="submit" name="HideDetails" value="Masquer détails ↑" id="hideDetails" />
					</div>
					<div class="orderDetails">
						<table>

							<tr>
								<th scope="row">prix_menu</th>
								<td>xxxxxx</td>
							</tr>

							<tr>
								<th scope="row">nbre_pers</th>
								<td>xxxxxx</td>
							</tr>


							<tr>
								<th scope="row">date_presta</th>
								<td>xxxxxx</td>
							</tr>
							<tr>
								<th scope="row">heure_livraison</th>
								<td>xxxxxx</td>
							</tr>
							<tr>
								<th scope="row">prêt_matériel</th>
								<td>xxxxxx</td>
							</tr>
							<tr>
								<th scope="row">restitution</th>
								<td>xxxxxx</td>
							</tr>

						</table>
					</div>
			</section>
			<section class="Section" id="accessManagement">
				<div class="SectionContent">
					<h2>Gérer mes accès</h2>
					<div class="accessManagement">
						<form action="./deleteMessage.php">
							<input type="submit" name="delete" value="Supprimer" id="deleteAccount" />
						</form>
						<form action="./indexLocal.php">
							<input type="submit" name="disconnect" value="Me déconnecter" id="disconnect" />
						</form>
					</div>
				</div>
		</div>

		</section>

	</div>

	</div>
	<?php require_once "includes/footer.php" ?>
	<script type="module" src="./JS/userAccount.js"></script>
</body>

</html>