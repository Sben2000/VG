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
	<link rel="stylesheet" href="CSS/onProgress.css" />
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
			<h1 class="sectionTitle">Page en Travaux</h1>
		</div>
		<div class=onProgress>
			<p ><strong>Désolé, page en travaux , merci de revenir plus tard</strong></p>
			<img src="./includes/default_pictures/NicePng_under-construction-png_9724676.png"  alt="New Content Coming Soon - Website Under Construction Banner@nicepng.com">
			<span>Credit-picture : NicePng - NicePng_under-construction-png_9724676.png - libre de droit</span>
		</div>

	</div>
	<?php require_once "includes/footer.php" ?>
	<script type="module" src="./JS/login.js"></script>
</body>

</html>