

<?php
//Conditionnement du démarrage de session (Session déjà active?) pour éviter les doublons (et Notices)
if (session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>

<style>
/*********************************CSS léger********************************************/	
:root{      /*palette couleurs*/

   --rosyLight:rgb(205, 178, 178);
}
	body{
	
    background-color: var(--rosyLight);
	}

</style>

<!--si la session est ouverte avec un compte admin ou Employé-->
<?php if (isset($_SESSION['accessVgTeam']) ||isset($_SESSION['accessAdmin'])) { ?>
	<!--Un message de Bienvenue est affiché avec son username-->
	<p class="welcome" style="color:darkgreen">Accès autorisé</p>
<?php
}else{
    ?>
	<p class="forbidden" style="color:darkred">Accès Non autorisé, veuillez revenir à la page d'acceuil ou vous connecter</p>
    <?php
    exit;
}
?>


<!--si la session est ouverte avec le nom d'utilisateur-->
<?php if (isset($_SESSION['user'])) { ?>
	<!--Un message de Bienvenue est affiché avec son username-->
	<p class="welcome" style="color:black">Bienvenue <?= $_SESSION['user'] ?></p>
<?php
}
?>

