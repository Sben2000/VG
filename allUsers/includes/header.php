
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
					<li><a href="./login.php">Connexion</a></li>
					<li><a href="./userAccount.php">Mon compte</a></li>
					<li><a href="#">Déconnexion</a></li>
					<div class="rollingMenu">
					<li class="gestion"><a class="gestionLink" href="#">Gestion</a></li>
						<div class="vgTeam" id="vgTeamLM">
							<li><a class="gestionLink" href="#">Menus</a></li>
							<li><a class="gestionLink" href="#">Commandes</a></li>
							<div class="adminAccess">
								<li><a class="gestionLink" href="#">Employés</a></li>
								<li><a class="gestionLink" href="#">Libellés</a></li>
							</div>
							<li id="vgTeamClose"><a class="gestionLink" href="#">>> Fermer <<</a></li>
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
					<li><a href="./indexLocal.php">Home</a></li>
					<li><a href="#">Nos menus</a></li>
					<li><a href="./contact.php">Contact</a></li>
					<li><a href="./login.php">Connexion</a></li>
					<li><a href="./userAccount.php">Mon compte</a></li>
					<li><a href="#">Déconnexion</a></li>
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
				</div>
			</ul>
		</div>
	</header>


