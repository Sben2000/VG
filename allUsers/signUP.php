<?php

require_once "./Functions/fctAccount.php";
//execution de la function registerUser lors du submit
	//Note: variables traitées/nettoyées dans la function, $response=retour du traitement
	if(isset($_POST['createAccount'])){
	$response = registerUser($_POST['email'], $_POST['username'], $_POST['password'], $_POST['confirmPassword']);
	
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
	<link rel="stylesheet" href="CSS/disconnectMod.css" />  
</head>

<body>
  <?php include_once "includes/header.php" ?>
  <div class="main">
    <div class="separator">
      <h1 class="sectionTitle">S'enregistrer</h1>
    </div>

    <section class="Section" id="signUp">
      <div class="SectionContent">
        <h2>Je crée mes identifiants</h2>

        <form id="loginForm" action="" method="post" autocomplete="off"><!--response envoyée dans la même page -->
          <!-- Input group  -->
          <div class="detailedInput">
            <label for="email">Email *</label>
            <input type="email" name="email" value="<?=@$_POST['email']  /*@ évite les warning si champs vide*/ ?>" placeholder="Mon email" required>
          </div>
          <div class="detailedInput">
            <label for="username">Nom d'utilisateur *</label>
            <input
              type="text"
              id="username"
              name="username"
              value="<?= @$_POST['username']  /*@ évite les warning si champs vide*/ ?>"
              placeholder="Mon choix de nom d'utilisateur"
              autocomplete="off"
              required />
              <p class="requirement">requis: caract.: alphanum_- ,max:15 - min: 3</p>
          </div>
          
          <div class="detailedInput">
            <label for="password">Mot de passe *</label>
            <input
              type="password"
              id="pass1"
              name="password"
              value="<?php echo @$_POST["password"]?>"
              placeholder="Mon choix de mot de passe"
              autocomplete="off"
              required />
          </div>
          <p class="requirement">requis: caract.: au moins 1 Maj. 1min 1digit 1caract.spéc:$%!.&@* - ,max:20 - min: 10</p>
          <div class="detailedInput">
            <label for="confirmPassword">Confirmation du mot de passe *</label>
            <input type="password" name="confirmPassword" value="<?php echo @$_POST["confirmPassword"]?>" id="pass2" autocomplete="off" placeholder="Mon choix de mot de passe" required>
          </div>
          <div class="note" id="showPass">
            <label for="checkbox">Montrer les mots de passe</label>
            <input type="checkbox" name="checkbox" id="passCheckbox">
          </div>
          <span class="note"><em>*Champs requis</em></span>

          <div class="formBottom">
            <input type="submit" name="createAccount" value="Créer mon compte" />
          </div>
        </form>
        <p>
          <span>Déjà en possession d'un compte?</span>
          <a href="login.php">Se connecter ici</a>
        </p>
        <br>
         <?php
            //retour du resultat $response affiché à l'utilisateur
                //si  success =>retourner le message des balises <p> class= success ci dessous
            if(@$response == "success"){
                ?>
                <p class="success" style='color:green'>Votre inscription a été enregistré avec succès!</p>
                <p class="success" style='color:green'>Un mail de bienvenue vous a été envoyé :)</p>

                <?php
            }else{
                ?><!--sinon retour de la sous fonction qui a soulevée une erreur-->
                    <p class="error" style ='color:darkred'><?=@$response?></p>
                <?php
            }
        ?>
      </div>
    </section>
  </div>
  <?php require_once "includes/footer.php" ?>
  <script type="module" src="./JS/signUP.js"></script>
</body>

</html>