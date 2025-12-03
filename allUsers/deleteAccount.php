<?php

require_once "./Functions/fctAccount.php";
//execution de la function logoutUser lors du submit

    //si l'utilisateur confirme la suppression du compte dans la modal
	if(isset($_POST['deleteAccountConf'])){
    //=> Function de suppression 
	deleteAccount();

}
?> 
 
 
 <div class="modalGroup">
    <div class="modal" id="modalDel">
        <div class="modalContainer">
            <img src="./includes/default_pictures/buttonClose.png" alt="imgCloseModal" id="imgCloseModalDel">
            <h2>Confirmez vous la <br> suppression du compte?</h2>
            <form action="" method="POST">
                <div class="modalInputs">
                    <input type="submit" name="deleteAccountConf" value="Je confirme la suppression">
                </div>
            </form>
        </div>
    </div>

   <script type="module" src="./JS/scriptHeader.js"></script>
