<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<!--import des fonts  lobster et montserrat depuis googlefonts-->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link
		href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
		rel="stylesheet" />
	<link
		href="https://fonts.googleapis.com/css2?family=Lobster&display=swap"
		rel="stylesheet" />

	<!--link css-->
	<link rel="stylesheet" href="./CSS/connexion.css" />
	<!--link css de la navBar header-->
	<link rel="stylesheet" href="CSS/styleHeader.css" />
	<!--link css footer-->
	<link rel="stylesheet" href="CSS/footer.css" />
</head>

<body>
	<?php include_once "includes/header.php" ?>
	<div class="main">
		<div class="separator">
			<h1 class="sectionTitle">Compte supprimé</h1>
		</div>

		<section class="Section">
			<div class="SectionContent">
				<h2>Confirmation de suppression de compte</h2>
				<h3 style="color:darkred; text-align:center;">Nous vous confirmons la suppression du compte</h4><br>

					<p> Nous sommes désolé de vous voir partir :-( ... </p><br>
					<p>Si vous changer d'avis:</p><br>
					<p style="text-align: end;">n'hésitez pas à <a href="login.html">Recréer un compte</a></p>

			</div>
		</section>
	</div>
	<?php require_once "includes/footer.php" ?>
	<script type="module" src="./JS/delete.js"></script>
</body>

</html>