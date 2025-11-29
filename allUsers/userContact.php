<?php
require ("./Functions/fctAccount.php");
//sécurisation de la page afin que seul l'utilisateur identifié est accès à sa page
/*si la session n'est pas active, on redirige l'utilisateur automatiquement  vers la page de login.php */
/*    if(!isset($_SESSION["user"])){
        header("location: login.php");
        //puis on sort de cette page
        exit;
    }

//si l'utilisateur appele la clé logout(href="?logout") via le lien du formulaire ci dessous =>clé/variable récupérant($GET_["logout"])), 
//on appelle la function logout qui détruit la session et redirige vers la page login.php

if (isset($_GET["logout"])){
    logoutUser();
}

//3) cas ou l'utilisateur confirme par deux fois la suppression du compte défini en fin de page

if(isset($_GET["enregistrer"])){
    /*on apelle alors la function deleteAccount() qui supprimera celui ci définitivement et 
    renverra vers la page de confirmation de compte supprimé (delete-message.php) qui contient également
    un lien pour recréer un compte sur la page index.php*/
    //updateDetails();
/*}
*/
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
      <h1 class="sectionTitle">Mes coordonnées</h1>
    </div>

    <section class="Section">
      <div class="SectionContent">
        <h2>Je renseigne ou modifie mes coordonnées</h2>

        <form id="userContactForm">
          <div class="detailedInput">
            <label for="nom">Mon email </label>
            <input type="text" name="email" value="" placeholder="Email" autocomplete="off" disabled >
          </div>
          <div class="detailedInput">
            <label for="nom">Nom d'utilisateur</label>
            <input type="text" name="username" value="" placeholder="Nom d'utilisateur Vite&Go" autocomplete="off" required>
          </div>
          <div class="detailedInput">
            <label for="nom">Nom *</label>
            <input type="text" name="nom" value="" placeholder="Mon Nom de famille" autocomplete="off" required>
          </div>
          <div class="detailedInput">
            <label for="prenom">Prénom *</label>
            <input type="text" name="prenom" value="" placeholder="Mon Prénom" autocomplete="off" required>
          </div>
          <div class="detailedInput">
            <label for="tel">Numéro de téléphone *</label>
            <span class="note"><em>Si numéro étranger, veuillez noter l'indicatif</em></span>
            <input type="text" name="tel" value="" placeholder="../../../../.." autocomplete="off" required>
          </div>
          <div class="detailedInput">
            <label for="adresse">Adresse </label>
            <input type="text" name="adresse" value="" placeholder="Mon adresse (rue/Allée/Av/Bvd...)" autocomplete="off">
          </div>
          <div class="detailedInput">
            <label for="ville">Ville </label>
            <input type="text" name="ville" value="" placeholder="Ma ville" autocomplete="off">
          </div>
          <div class="detailedInput">
            <label for="codePostal">Code Postal </label>
            <input type="text" name="codePostal" value="" placeholder="Le Code Postal de ma ville" autocomplete="off">
          </div>
          <div class="detailedInput">
            <label for="pays">Pays </label>
            <input type="text" name="pays" value="" placeholder="Le pays où je réside actuellement" autocomplete="off">
          </div>
          <div class="formBottom">
            <input type="submit" name="enregistrer" value="Enregistrer" />
          </div>
        </form>
      </div>
    </section>
  </div>
  <?php require_once "includes/footer.php" ?>
  <script type="module" src="./JS/userContact.js"></script>
</body>

</html>