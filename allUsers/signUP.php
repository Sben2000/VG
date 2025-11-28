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
      <h1 class="sectionTitle">S'enregistrer</h1>
    </div>

    <section class="Section">
      <div class="SectionContent">
        <h2>Je crée mes identifiants</h2>

        <form id="loginForm">
          <!-- Input group  -->
          <div class="detailedInput">
            <label for="email">Email *</label>
            <input type="email" name="email" value="" placeholder="Mon email" required>
          </div>
          <div class="detailedInput">
            <label for="username">Nom d'utilisateur *</label>
            <input
              type="text"
              id="username"
              name="username"
              value=""
              placeholder="Mon choix de nom d'utilisateur"
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
          </div>
          <div class="detailedInput">
            <label for="confirmPassword">Confirmation du mot de passe *</label>
            <input type="password" name="confirmPassword" value="" id="pass2" autocomplete="off" placeholder="Mon choix de mot de passe" required>
          </div>
          <div class="note" id="showPass">
            <label for="checkbox">Montrer les mots de passe</label>
            <input type="checkbox" name="checkbox" id="passCheckbox">
          </div>
          <span class="note"><em>*Champs requis</em></span>

          <div class="formBottom">
            <input type="submit" name="login" value="Créer mon compte" />
          </div>
        </form>
        <p>
          <span>Déjà en possession d'un compte?</span>
          <a href="login.php">Se connecter ici</a>
        </p>
      </div>
    </section>
  </div>
  <?php require_once "includes/footer.php" ?>
  <script type="module" src="./JS/signUP.js"></script>
</body>

</html>