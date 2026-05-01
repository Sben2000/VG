<?php
//execution de la function logoutUser lors du submit

	if(isset($_POST['disconnect'])){
    //Suppression des variables de sessions (la session existe encore)
    session_unset();
    //Destruction complète de la session active
    session_destroy();
    //redirection vers la page index
    header("location: indexLocal.php");
    //Sortie du script sans rien retourner
    exit();
	
}
?> 
  
 <div class="modalGroup">
    <div class="modal" id="modal">
        <div class="modalContainer">
            <img src="./includes/default_pictures/buttonClose.png" alt="imgCloseModal" id="imgCloseModal">
            <h2>Je confirme la deconnexion</h2>
            <form action="" method="POST">
                <div class="modalInputs">
                    <input type="submit" name="disconnect" value="Me déconnecter">
                </div>
            </form>
        </div>
    </div>

   <script type="module" src="./JS/scriptHeader.js"></script>
