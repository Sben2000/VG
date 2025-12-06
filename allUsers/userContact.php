<?php
require_once ("./Functions/fctAccount.php");
//sécurisation de la page afin que seul l'utilisateur identifié ait accès à sa page
/*si session non active, redirection de l'utilisateur automatiquement  vers la page de login.php */
	    if(!isset($_SESSION["user"])){
        header("location: login.php");
        exit;
    }

	require_once ("./Functions/fctUserProfil.php");
	/*si session user active => réccupérer ses données de profil connus et les afficher*/
		if(isset($_SESSION["user"])){
			/*Récupérer le résultat de la function données de profil user*/
			$response = userProfilDatas($_SESSION["user"]);
			//si non nul =>assigner à $userProfil
		    if($response != NULL){
		      $userProfil = $response;
    	}else{
         $errorDatas = "echec de chargement de vos données personelles";
    		}
        //execution de la function updateUserProfil lors du submit "Enregistrer"
	    //Note: variables traitées/nettoyées dans la function, $response=retour du traitement
	    if(isset($_POST['enregistrer'])){
	    $feedback = updateUserProfil($_POST['userId'], $_POST['username'], $_POST['nom'], $_POST['prenom'], $_POST['tel'], $_POST['adresse'], $_POST['ville'], $_POST['codePostal'], $_POST['pays']);
	
    }
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
      <h1 class="sectionTitle">Mes coordonnées</h1>
    </div>

    <section class="Section">
      <div class="SectionContent">
        <h2>Je renseigne ou modifie mes coordonnées</h2>

        <form id="userContactForm" action ="#feedback" method="post"><!--reponse envoyée dans la même page au niveau de l'id "feedback"-->
          <div class="detailedInput">
          <!--utilisateur_id hidden , affiché et récupéré lors du post-->
            <input type="hidden" name="userId" value="<?= @$userProfil->utilisateur_id ?>" placeholder="Email" autocomplete="off" readonly >
          <div>
        <div class="detailedInput">
            <label for="nom">Mon email </label>
            <span class="requirement"><em>Non modifiable. Veuillez contacter la direction en cas de besoin</em></span>
            <input type="text" name="email" value="<?= @$userProfil->email ?>" placeholder="Email" autocomplete="off" disabled >
            
          </div>
          <div class="detailedInput">
            <label for="nom">Nom d'utilisateur</label>
            <input type="text" name="username" value="<?= @$userProfil->nom_utilisateur ?>" placeholder="Nom d'utilisateur Vite&Go" autocomplete="off" required>
          </div>
          <div class="detailedInput">
            <label for="nom">Nom *</label>
            <input type="text" name="nom" value="<?= @$userProfil->nom ?>" placeholder="Mon Nom de famille" autocomplete="off" required>
          </div>
          <div class="detailedInput">
            <label for="prenom">Prénom *</label>
            <input type="text" name="prenom" value="<?= @$userProfil->prenom ?>" placeholder="Mon Prénom" autocomplete="off" required>
          </div>
          <div class="detailedInput">
            <label for="tel">Numéro de téléphone *</label>
            <span class="requirement"><em>Ne rentrer que des chiffres de 0 à 9 (sans - / +,...)</em></span><br>
            <span class="requirement"><em>Si numéro étranger, veuillez noter l'indicatif (00 au lieu de + , puis indicatif)</em></span>
            <input type="text" name="tel"  value="<?= @$userProfil->telephone ?>" placeholder="0123456789" autocomplete="off" required>
          </div>
          <div class="detailedInput">
            <label for="adresse">Adresse </label>
            <span class="requirement"><em>N° de rue + nom de rue (Si pas de N° de rue, entrer 0 + nom de rue) </em></span>
            <input type="text" name="adresse" value="<?= @$userProfil->adresse_postale ?>" placeholder="Mon adresse (rue/Allée/Av/Bvd...)" autocomplete="off">
          </div>
          <div class="detailedInput">
            <label for="ville">Ville </label>
            <input type="text" name="ville" value="<?= @$userProfil->ville ?>" placeholder="Ma ville" autocomplete="off">
          </div>
          <div class="detailedInput">
            <label for="codePostal">Code Postal </label>
            <input type="text" name="codePostal" value="<?= @$userProfil->code_postal ?>" placeholder="Le Code Postal de ma ville" autocomplete="off">
          </div>
          <div class="detailedInput">
            <label for="pays">Pays </label>
            <input type="text" name="pays" value="<?= @$userProfil->pays ?>" placeholder="Le pays où je réside actuellement" autocomplete="off">
          </div>
          <span class="requirement"><em>* Sera à minima requis en cas de commande à retirer chez nous</em></span>
          <div class="formBottom">
            <input type="submit" name="enregistrer" value="Enregistrer" />
          </div>
        </form>
        <div id="feedback">
                 <?php
            //retour du resultat $response affiché à l'utilisateur
                //si  success =>retourner le message des balises <p> class= success ci dessous
            if(@$feedback == "success"){
                ?>
                <p class="success" style='color:green'>Vos données ont été enregistrées avec succès!</p>
                <?php
            }else{
                ?><!--sinon retour de la sous fonction qui a soulevée une erreur-->
                    <p class = "error" style ='color:darkred'><?=@$feedback?></p>
                <?php
            }
        ?>
        </div>
      </div>
    </section>
  </div>
  <?php require_once "includes/footer.php" ?>
  <script type="module" src="./JS/userContact.js"></script>
</body>

</html>