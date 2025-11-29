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
		<link rel="stylesheet" href="./allUsers/CSS/Home.css" />
        <!--link css de la navBar header-->
        <link rel="stylesheet" href="./allUsers/CSS/styleHeader.css" />
        <!--link css footer-->
		<link rel="stylesheet" href="./allUsers/CSS/footer.css" />
		<!--link css disconnect (modal)-->
		<link rel="stylesheet" href="./allUsers/CSS/disconnectMod.css" />


		<title>Acceuil</title>
	</head>
	<body>
<?php require_once "./includes/header.php"?>
 <?php require_once "./allUsers/home.php"?>
<?php require_once "./includes/footer.php"?>

<script type="module"  src="./allUsers/JS/Home.js"></script>
</body>
</html>

 
