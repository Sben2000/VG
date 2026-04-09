<?php

require_once "./Functions/fctContact.php";
//execution de la function contactUs lors du submit
	//Note: variables traitées/nettoyées dans la function, $response=retour du traitement

	if(isset($_POST['envoyer'])){
	$response = contactUs($_POST['nom'], $_POST['email'], $_POST['message']);
	
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

	<!--link css de la page actuelle-->
	<link rel="stylesheet" href="CSS/contact.css" />
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
			<h1 class="sectionTitle">Nous contacter</h1>
		</div>
		<section class="contact" id="contact">
			<div class="contactForm">
				<form action="#feedback" method="post" class="form-contact"><!--reponse envoyée dans la même page au niveau de l'id "feedback"-->
					<div class="formTop">

						<label for="nom">Nom / Prénom</label>
						<input type="text" name="nom" placeholder="Mon nom et prénom" value="<?= @$_POST['nom']?>" autocomplete="off" required />

						<label for="email">Email</label>
						<!--le type email permettant de s'assurer que l'utilisateur entre bien un email avec @-->
						<input type="email" name="email" value="<?= @$_POST['email']?>" placeholder="Email@NomdeDomain.com" autocomplete="off" required />

						<label for="message">Votre message</label>
						<textarea name="message" cols="40" rows="15"
							placeholder="Je vous contacte pour..." value="<?= @$_POST['message']?>" autocomplete="off"></textarea>
					</div>

					<div class="formBottom">
						<input type="submit" name="envoyer" value="Envoyer" />
					</div>
		        <div id="feedback">
         <?php
            //retour du resultat $response affiché à l'utilisateur
                //si  success =>retourner le message des balises <p> class= success ci dessous
            if(@$response == "success"){
                ?>
                <p class="success" style='color:green'>Votre message nous a bien été transmis!</p>
                <p class="success" style='color:green'>Nous reviendrons vers vous dès que possible...</p>

                <?php
            }else{
                ?><!--sinon retour de la sous fonction qui a soulevée une erreur-->
                    <p class="error" style ='color:darkred'><?=@$response?></p>
                <?php
            }
        ?>
        </div>
				</form>
		</section>

	</div>
	<?php require_once "includes/footer.php" ?>
	<script type="module" src="./JS/contact.js"></script>
</body>
</html>