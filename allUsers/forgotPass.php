<?php

require_once "./Functions/fctAccount.php";
//execution de la function passwordReset lors du reset
	//Note: variables traitées/nettoyées dans la function, $response=retour du traitement

	if(isset($_POST['reset'])){
	$response = passwordReset($_POST['email']);
	
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
	<!--link css disconnect (modal)-->
	<link rel="stylesheet" href="./allUsers/CSS/disconnectMod.css" />
</head>

<body>
	<?php include_once "includes/header.php" ?>
	<div class="main">
		<div class="separator">
			<h1 class="sectionTitle">Réinitialiser mon mot de passe</h1>
		</div>
		<!-- Container pour le login form -->
		<section class="Section">
			<div class="SectionContent">
				<h2>Reinitialisation mot de Passe</h2>
				<!-- Login form avec champs pour email & password -->
				<form id="loginForm" action="" autocomplete="off"><!--response envoyé dans la même page en cas d'échec-->
					<div class="detailedInput">
						<label for="email">Email *</label>
						<input
							type="text"
							id="email"
							name="email"
							placeholder="Mon email pour reinitialiser le mot de passe"
							value="<?= @$_POST['email'] /*@ évite les warning si champs vide*/?>"
							autocomplete="off"
							required />
							<span class="note"><em>*Champs requis</em></span>
					</div>
					
					<!-- Submit boutton  -->
					<div class="formBottom">
						<input type="submit" name="reset" value="Reinitialiser" />
					</div>
					
				</form>
				<p>
					<span>Annuler?</span>
					<a href="indexLocal.php">Accueil</a>
				</p>
				<p>
					<span>Réessayer avant?</span>
					<a href="login.php">Connexion</a>
				</p>
        <?php
            //retour du resultat $response affiché à l'utilisateur
                //si le resultat de la function est success =>newPassword est bien enregistré dans la dB
                //=>on signifie à l'utilisateur de récupérer le newPassword dans son mail 
            if(@$response == "success"){
                ?>
                <!--afficher : inscription réussi-->
                <p class="success" style='color:green'>Le mot de passe a été réinitialisé et envoyé avec succès, veuillez le récupérer depuis votre email pour vous connecter</p>
                <p class="success" style='font-style:italic'>Si nécessaire, vérifier le dossier spam</p>
                <?php
            }else{
                ?><!--sinon retourner le résultat de la sous function qui a soulevé une erreur dans resetPassword()-->
                    <p class="error" style ='color:darkred'><?=@$response?></p>
                <?php
            }
        ?>
			</div>
		</section>
	</div>
	<?php require_once "includes/footer.php" ?>
	<script type="module" src="./JS/login.js"></script>
</body>
</html>