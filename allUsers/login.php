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
	<link rel="stylesheet" href="CSS/connexion.css" />
	<!--link css de la navBar header-->
	<link rel="stylesheet" href="CSS/styleHeader.css" />
	<!--link css footer-->
	<link rel="stylesheet" href="CSS/footer.css" />
	
</head>

<body>
	<?php include_once "includes/header.php" ?>
	<div class="main">
		<div class="separator">
			<h1 class="sectionTitle">Se connecter</h1>
		</div>
		<!-- Container pour le login form -->
		<section class="Section">
			<div class="SectionContent">
				<h2>Login</h2>
				<!-- Login form avec champs pour username and password -->
				<form id="loginForm">
					<div class="detailedInput">
						<label for="username">Nom d'utilisateur *</label>
						<input
							type="text"
							id="username"
							name="username"
							placeholder="Mon nom d'utilisateur V&Go"
							value=""
							autocomplete="off"
							required />
					</div>
					<div class="detailedInput">
						<label for="password">Mot de passe *</label>
						<input
							type="password"
							id="pass1"
							name="password"
							value=""
							placeholder="Mon choix de mot de passe"
							autocomplete="off"
							required />
						<div class="note" id="showPass">
							<label for="checkbox">Montrer le mot de passe</label>
							<input type="checkbox" name="checkbox" id="passCheckbox" />
						</div>
						<span class="note"><em>*Champs requis</em></span>
					</div>
					<!-- Submit boutton  -->
					<div class="formBottom">
						<input type="submit" name="login" value="Se connecter" />
					</div>
				</form>
				<p>
					<span>Pas encore de compte?</span>
					<a href="./signUP.php">S'inscrire ici</a>
				</p>

				<p>
					<a href="forgotPassword.php">Mot de passe oublié?</a>
				</p>
				<!--dans le cas d'erreur de login, celle ci sera postée dans le paragraphe ci dessous-->
				<p class="error" style="color: darkred"><?= @$response ?></p>
			</div>
		</section>
	</div>
	<?php require_once "includes/footer.php" ?>
	<script type="module" src="./JS/login.js"></script>
</body>
</html>