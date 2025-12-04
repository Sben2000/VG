<?php

require_once ("./Functions/fctAccount.php");
//sécurisation de la page afin que seul l'utilisateur identifié ait accès à sa page
/*si session non active, redirection de l'utilisateur automatiquement  vers la page de login.php */
	    if(!isset($_SESSION["user"])){
        header("location: login.php");
        exit;
    }

	require_once ("./Functions/fctUserProfil.php");
	/*si session user active => réccupérer ses données de profil */
		if(isset($_SESSION["user"])){
			/*Récupérer le résultat de la function données de profil user*/
			$response = userProfilDatas($_SESSION["user"]);
			//si non nul =>assigner à $userProfil
		    if($response != NULL){
		      $userProfil = $response;
    	}else{
         $errorDatas = "echec de chargement de vos données personelles";
    		}
	
			/*Récupérer ses commandes passées si il clique sur "Afficher mes commandes" */
			if (isset($_POST['showMyOrders'])){
			$responseOrders= fetchUserOrders($_SESSION["user"]);
			//si non nul =>assigner à $userProfil
		    if($responseOrders != NULL){
		      $userOrders = $responseOrders;
    		}else{
				$emptyOrders ="Nous n'avons pas trouvé de commandes";
			}
			
			}
			
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
	<!--link css deleteAccount (modal)-->
	<link rel="stylesheet" href="CSS/delAccountMod.css" />	
</head>

<body>
	<?php require_once "deleteAccount.php"?>
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
						<form id="accountForm" action="">
							<div class="detailedInput fetch">
								<label for="username">Nom d'utilisateur: </label>
								<input type="text" id="username" name="username" value="<?= @$userProfil->nom_utilisateur ?>" autocomplete="off"
									readonly required />
							</div>
							<div class="detailedInput fetch">
								<label for="email">Email: </label>
								<input type="email" name="email" value="<?= @$userProfil->email ?>" readonly autocomplete="off" />
							</div>
							<span class="note"><em>*Par sécurité, seul le nom d'utilisateur est modifiable,<br> → Nous contacter pour modifier l'email</em></span>
								<!-- Submit boutton  -->
								<div class="formBottom">
									<form action="./userContact.php">
									<input type="submit" name="modifierGeneral" value="Modifier" formaction="./userContact.php"/>
									</form>
								</div>
						</form>
						<p class="error" style="color: darkred"><?= @$errorDatas ?></p>
				</section>


			</div>
			<div class="multiSectionsRight">
				<section class="Section">
					<div class="SectionContent">
						<h2>Mes coordonnées</h2>

						<form id="userContactForm">

							<div class="detailedInput fetch">
								<label for="nom">Nom: </label>
								<input type="text" name="nom" value="<?= @$userProfil->nom ?>" readonly autocomplete="off" required>
							</div>
							<div class="detailedInput fetch">
								<label for="prenom">Prénom: </label>
								<input type="text" name="prenom" value="<?= @$userProfil->prenom ?>" readonly required>
							</div>
							<div class="detailedInput fetch">
								<label for="tel">Numéro de téléphone: </label>
								<input type="text" name="tel" value="<?= @$userProfil->telephone ?>" readonly>

							</div>
							<div class="detailedInput fetch">
								<label for="adresse">Adresse: </label>
								<input type="text" name="adresse" value="<?= @$userProfil->adresse_postale ?>" readonly>
							</div>
							<div class="detailedInput fetch">
								<label for="ville">Ville: </label>
								<input type="text" name="ville" value="<?= @$userProfil->ville ?>" readonly>
							</div>
							<div class="detailedInput fetch">
								<label for="codePostal">Code Postal: </label>
								<input type="text" name="codePostal" value="<?= @$userProfil->code_postal ?>" readonly>
							</div>
							<div class="detailedInput fetch">
								<label for="pays">Pays: </label>
								<input type="text" name="pays" value="<?= @$userProfil->pays ?>" readonly>
							</div>
							<div class="formBottom">
								<input type="submit" name="modifierDetails" value="Modifier" formaction="./userContact.php"/>
							</div>
						</form>
				<!--dans le cas d'erreur, message de retour-->
				<p class="error" style="color: darkred"><?= @$errorDatas ?></p>
					</div>
				</section>
			</div>
		</div>
		<div class="multiSectionsBottom">
			<section class="Section">
				<div class="SectionContent">
					<h2>Voir mes commandes</h2>
					<div class="formBottom">
						<form action="#" method="post">
						<input type="submit" name="showMyOrders" value="Afficher mes Commandes ↓ " id="showMyOrders" />
						<input type="submit" name="hideMyOrders" value="Masquer mes Commandes ↑" id="hideMyOrders" />
						</form>
					</div>
					<!--Si aucune commande trouvée-->
					<p class="error"><?= @$emptyOrders ?></p>
				</div>
			</section>
			<section class="Section myOrders" id="myOrders">
				<!--raccourci foreach(): + endforeach-->
				<?php if (!empty($userOrders)){foreach ($userOrders as $k=>$v): ?>
				<div class="SectionContent">
					<h2>Commande N° <?= @$v["numero_commande"]?></h2>
					<div class="tables">
						<table class="myOrderTable">
							<thead>
								<tr>
									<th scope="col">date_cde</th>
									<th scope="col">statut</th>
									<th scope="col">Total en &#x20AC(TTC)</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><?= @$v["date_commande"]?></td>
									<td><?= @$v["statut"]?></td>
									<td><?= @$v["prix_TTC"]?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="orderDetailsButtons">
						<input type="submit" name="showDetails" value="Voir détails ↓" id="showDetails" class="showDetails"/>
						<input type="submit" name="hideDetails" value="Masquer détails ↑" id="hideDetails" class="hideDetails" />

					</div>
					<div class="orderDetails">
						<table>
							<tr>
								<th scope="row">titre menu</th>
								<td><?= @$v["titre"]?></td>
							</tr>

							<tr>
								<th scope="row">prix du menu (TTC)</th>
								<td><?= @$userOrder->prix_TTC ?></td>
							</tr>

							<tr>
								<th scope="row">nbre_pers</th>
								<td><?= @$userOrder->nbr_pers ?></td>
							</tr>


							<tr>
								<th scope="row">date_presta</th>
								<td><?= @$userOrder->date_prestation ?></td>
							</tr>
							<tr>
								<th scope="row">heure_livraison</th>
								<td><?= @$userOrder->heure_livraison ?></td>
							</tr>
							<tr>
								<th scope="row">prêt_matériel</th>
								<td><?= @$userOrder->pret_materiel ?></td>
							</tr>
							<tr>
								<th scope="row">restitution</th>
								<td><?= @$userOrder->restitution_materiel ?></td>
							</tr>
						<?php endforeach;}?>
						</table>
					</div>
			</section>
			<section class="Section" id="accessManagement">
				<div class="SectionContent">
					<h2>Gérer mes accès</h2>
					<div class="accessManagement">
						
							<input class="DeleteAccount" type="submit" name="delete" value="Supprimer" id="deleteAccount" />


							<input class="disconnectAccount" type="submit" name="disconnect" value="Me déconnecter" id="disconnect" />

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