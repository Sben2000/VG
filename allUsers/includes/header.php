<?php 
require_once "./disconnect.php";

//Conditionnement du démarrage de session (Session déjà active?) pour éviter les doublons (et Notices)
if(session_status() !== PHP_SESSION_ACTIVE){
session_start();
}
?>
	<header>
		<!-----------------------------------------HTML du Menu Ecran------------------------->
	<div class="brand">Vite&Go</div>
		<nav class="large-menu">
			<!--<div class="brand">Vite&Go</div>-->
			<div class="inlineLinks">
				<div class="allUsers" id="allUsersLM">
					<li><a href="./indexLocal.php">Home</a></li>
					<li><a href="#">Nos menus</a></li>
					<li><a href="./contact.php">Contact</a></li>
					<?php 
					//Si aucune session (user,employé, admin) activé
					if(!isset($_SESSION['user'])){
						?>
					<li><a href="./login.php">Connexion</a></li>
					<?php 
					//Sinon, si session (user,employé, admin) activé
						}else{
					?> 
					<li><a href="./userAccount.php">Mon compte</a></li>
					<li class=disconnectModal><a href="#">Déconnexion</a></li>
					<?php 
					//Si il y a un niveau d'accès 2 (employé) ou 3 (admin)=>activation des options supplémentaires employé
					if(($_SESSION['accessLevel'])>1){
						?>
					<div class="rollingMenu">
					<li class="gestion"><a class="gestionLink" href="#">Gestion</a></li>
						<div class="vgTeam" id="vgTeamLM">
							<li><a class="gestionLink" href="#">Menus</a></li>
							<li><a class="gestionLink" href="#">Commandes</a></li>
					<?php 
					//Si il y a un niveau d'accès 3 (admin) =>activation des options supplémentaires admin
					if(($_SESSION['accessLevel'])>2){
						?>
							<div class="adminAccess">
								<li><a class="gestionLink" href="#">Employés</a></li>
								<li><a class="gestionLink" href="#">Libellés</a></li>
							</div>
					<?php } ?>
							<li id="vgTeamClose"><a class="gestionLink" href="#">>> Fermer <<</a></li>
						</div>
						</select>
					</div>
					<?php } ?>
					<?php } ?>
				</div>
			</div>
		</nav>
		<!-----------------------------------------HTML du Hamburger Menu (en Mode Responsive Mobile)------------------------->
		<nav class="ham-menu">
			<!--Logo hamburger de navigation (géré en css et JS)-->
			<span></span>
			<span></span>
			<span></span>
		</nav>

		<div class="off-screen-menu">
			<!--Menu translatant lors que le logo Hamburger est activé/Gestion des niveaux d'accès -->
			<ul class="panelLinks">
				<div class="allUsers" id="allUsersHM">
					<li><a href="./indexLocal.php">Home</a></li>
					<li><a href="#">Nos menus</a></li>
					<li><a href="./contact.php">Contact</a></li>
					<?php 
					//si session pas active => Connexion
					if(!isset($_SESSION["user"])){ 
						?>
					<li><a href="./login.php">Connexion</a></li>
					<?php 
					}else{ 
					?>
					<li><a href="./userAccount.php">Mon compte</a></li>
					<li class=disconnectModal><a href="#">Déconnexion</a></li>
					<div class="vgTeam" id="vgTeamHM">
						<hr />
						<span>Gestion:</span>
						<li><a href="#">Menus</a></li>
						<li><a href="#">Commandes</a></li>
						<div class="adminAccess">
							<li><a href="#">Employés</a></li>
							<li><a href="#">Libellés</a></li>
						</div>
					</div>
				<?php 
					} 
				?>
				</div>
			</ul>
		</div>
	</header>

<!--si la session est ouverte avec le nom d'utilisateur-->
<?php if(isset($_SESSION['user'])){ ?>
	<!--Un message de Bienvenue est affiché avec son username-->
	<p class="welcome">Bienvenue <?=$_SESSION['user'] ?></p> 
<?php
} 
?>


