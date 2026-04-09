<?php require_once "disconnect.php"?>
<header>
	<!-----------------------------------------HTML du Menu Ecran------------------------->
	<div class="brand">Vite&Go</div>
	<nav class="large-menu">
		<!--<div class="brand">Vite&Go</div>-->
		<div class="inlineLinks">
			<div class="allUsers" id="allUsersLM">
				<li><a href="./1_allUsers/indexLocal.php">Accueil</a></li>
				<li><a href="./1_allUsers/menus.php">Nos menus</a></li>
				<li><a href="./1_allUsers/contact.php">Contact</a></li>
				<li class="					
					<?php
					//Si username identifié (user,employé, admin) active =>ajout class= hide sinon class=show
					if (isset($_SESSION['user'])) {
						echo "-hide";
					} else {
						echo "-show";
					}
					?>">
					<a href="./1_allUsers/login.php">Connexion</a>
				</li>
				<li class="					
					<?php
					//Si   session avec niveau accès==2 ou accès==3 (employé, admin) active =>ajout class=show  sinon class= hide
					if (isset($_SESSION['accessVgTeam']) ||isset($_SESSION['accessAdmin'])) {
						echo "-show";
					} else {
						echo "-hide";
					}
					?>"><a href="./1_allUsers/userAccount.php">Mon compte</a></li>
				<li class="disconnectModal
															
					<?php
					//Si  PAS de session (user,employé, admin) active =>ajout class= hide sinon class=show
					if (!isset($_SESSION['user'])) {
						echo "-hide";
					} else {
						echo "-show";
					}
					?>"><a href="#">Déconnexion</a></li>
				<div class="rollingMenu
					<?php
					//Si  PAS de session avec niveau accès>1 (employé, admin) active =>ajout class= hide sinon class=show
					if (!isset($_SESSION['accessVgTeam'])) {
						echo "-hide";
					} else {
						echo "-show";
					}
					?>">
					<li class="gestion"><a class="gestionLink" href="#">Gestion</a></li>
					<div class="vgTeam" id="vgTeamLM">
						<li ><a class="gestionLink" href="./2_vgTeam/gestionMenus/creationMenu.php" target="_blank" id="gestMenuWindowLM">Menus</a></li>
						<li><a class="gestionLink" href="./2_vgTeam/gestionPlats/platMVC/index.php" target="_blank" id="gestPlatWindowLM">Plats</a></li>
						<li><a class="gestionLink" href="./2_vgTeam/gestionLibelles/themeMVC/index.php" target="_blank" id="gestLibelleWindowLM">Libellés</a></li>						
						<li><a class="gestionLink"  href="./2_vgTeam/menuPlatsAsso/menuPlatsMVC/index.php" target="_blank" id="menuPlatsWindowLM">Menu<->plat</a></li>
						<li><a class="gestionLink" href="./1_allUsers/onProgress.php">Commandes</a></li>
						<div class="adminAccess
							<?php
						//Si   session avec niveau accès==2 ou accès==3 (employé, admin) active =>ajout class=show  sinon class= hide
						if (isset($_SESSION['accessVgTeam']) ||isset($_SESSION['accessAdmin'])) {
							echo "-show";
						} else {
							echo "-hide";
						}
							?>">										
							<li><a class="gestionLink" href="#">Employés</a></li>
							<li><a href="./3_admin/gestionTimes/mongoMVC/index.php" target="_blank" id="gestTimesWindowTM">Horaires</a></li>
						</div>
						<li id="vgTeamClose"><a class="gestionLink" href="#">>> Fermer <<</a>
						</li>
					</div>
					</select>
				</div>
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
					
					<li><a href="./1_allUsers/indexLocal.php">Accueil</a></li>
					<li><a href="./1_allUsers/menus.php">Nos menus</a></li>
					<li><a href="./1_allUsers/contact.php">Contact</a></li>
					<li class="					
					<?php
					//Si username identifié (user,employé, admin) active =>ajout class= hide sinon class=show
					if (isset($_SESSION['user'])) {
						echo "-hide";
					} else {
						echo "-show";
					}
					?>"><a href="./1_allUsers/login.php">Connexion</a></li>
					<li class="					
					<?php
					//Si  PAS de session (user,employé, admin) active =>ajout class= hide sinon class=show
					if (!isset($_SESSION['user'])) {
						echo "-hide";
					} else {
						echo "-show";
					}
					?>"><a href="./1_allUsers/userAccount.php">Mon compte</a></li>
					<li class="disconnectPhone
															
					<?php
					//Si  PAS de session (user,employé, admin) active =>ajout class= hide sinon class=show
					if (!isset($_SESSION['user'])) {
						echo "-hide";
					} else {
						echo "-show";
					}
					?>"><a href="#">Déconnexion</a></li>
					<div id="vgTeamHM" class="vgTeam
					<?php
					//Si  PAS de session avec niveau accès>1 (employé, admin) active =>ajout class= hide sinon class=show
					if (!isset($_SESSION['accessVgTeam'])) {
						echo "-hide";
					} else {
						echo "-show";
					}
					?>">
						<hr />
						<span>Gestion:</span>
						<li><a href="./2_vgTeam/gestionMenus/creationMenu.php" target="_blank" id="gestMenuWindowTM">Menus</a></li>
						<li><a href="./2_vgTeam/gestionPlats/platMVC/index.php" target="_blank" id="gestPlatWindowTM">Plats</a></li>
						<li><a href="./2_vgTeam/gestionLibelles/themeMVC/index.php" target="_blank" id="gestLibelleWindowTM">Libellés</a></li>
						<li><a  href="./2_vgTeam/menuPlatsAsso/menuPlatsMVC/index.php" target="_blank" id="menuPlatsWindowTM">Menu<->plat</a></li>						
						<li><a  href="./1_allUsers/onProgress.php">Commandes</a></li>
						<div class="adminAccess<?php
							//Si  PAS de session avec niveau accès>2 (admin Only) active =>ajout class= hide sinon class=show
							if (!isset($_SESSION['accessAdmin'])) {
								echo "-hide";
							} else {
								echo "-show";
							}
							?>">
							<li><a href="#">Employés</a></li>
							<li><a href="./3_admin/gestionTimes/mongoMVC/index.php" target="_blank" id="gestTimesWindowTM">Horaires</a></li>
						</div>
					</div>
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