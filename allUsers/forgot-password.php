
<?php
    require "functions.php";
    //on vérifie si le formulaire est soumis via le bouton submit
    if(isset ($_POST["submit"])){
        //on passe en argument de passwordRest la variable posté par l'utilisateur
        //on assigne alors la function passwordReset à la variable $response
                //pour info, l'email soumis est nettoyée au sein de la function
        $response = passwordReset($_POST["email"]);

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset password</title>
</head>
<body>
    <form action="" method="post" autocomplete="off"><!--action est vide car on envoi les données dans la même page-->

        <h2>Password reset</h2>

        <h4> Please enter your email so we can send you a new password.</h4>


            <div>
                <label for="email">Email *</label> 
                <!--on passe en valeur la donnée entrée dans l'input, le @ permet de dire au serveur de ne pas lancer un warning si aucune donnée n'est entrée-->
                <input type="text" name="email" value="<?= @$_POST['email']; ?>"  required>
            </div>

        
        <button type="submit" name="submit">Submit</button>

        <p>
            <a href="login.php">Back to login page?</a>
        </p>
        <?php
            //retour du resultat $response affiché à l'utilisateur
                //si le resultat de la function est success =>newPassword est bien enregistré dans la dB
                //=>on signifie à l'utilisateur de récupérer le newPassword dans son mail 
            if(@$response == "success"){
                ?>
                <!--afficher : inscription réussi-->
                <p class="success" style='color:green'>The password was successfully reset and sent, Please go to your email account and use it to log in</p>
                <p class="success" style='font-style:italic'>If neccessary, check the spam folder</p>
                <?php
            }else{
                ?><!--sinon retourner le résultat de la sous function qui a soulevé une erreur dans resetPassword()-->
                    <p class="error" style ='color:darkred'><?=@$response?></p>
                <?php
            }
        ?>

</form>

    <script src="script.js"></script>
</body>
</html>