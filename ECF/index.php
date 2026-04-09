
<!--Redirection automatique vers l'indexLocal présent dans le dossier 1_allUsers-->
<?php header("location: ./1_allUsers/indexLocal.php")?>


<!--Si ne redirige pas vers l'indexLocal => affichage d'une page similaire permettant de réaliser les mêmes actions en mode desktop-->
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
			rel="stylesheet"
		/>
		<link
			href="https://fonts.googleapis.com/css2?family=Lobster&display=swap"
			rel="stylesheet"
		/>

		<!--link css de la page-->
		<link rel="stylesheet" href="./1_allUsers/CSS/Home.css" />
        <!--link css de la navBar header-->
        <link rel="stylesheet" href="./1_allUsers/CSS/styleHeader.css" />
        <!--link css footer-->
		<link rel="stylesheet" href="./1_allUsers/CSS/footer.css" />
		<!--link css disconnect (modal)-->
		<link rel="stylesheet" href="./1_allUsers/CSS/disconnectMod.css" />


		<title>Accueil</title>

	</head>
	<body>
<?php require_once "./includes/header.php"?>
 <?php require_once "./1_allUsers/home.php"?>
<?php require_once "./includes/footer.php"?>



</body>
</html>

 
