<?php
function DBconnection(){

    // DB credentials(cst de DB & start_session()).
    require_once "config.php";

    // Etablir la connection avec la BDD.
    try{
        //Old méthode avec cst du fichier config.php
        //$conn = new PDO("mysql:host=".DB_HOST .";dbname=".DB_NAME, DB_USER, DB_PASS) or die();
        //Méthode avec .env lié au fichier config.php
        $conn = new PDO("mysql:host=".$_ENV["DB_HOST"] .";dbname=".$_ENV["DB_NAME"], $_ENV["DB_USER"], $_ENV["DB_PASS"]) or die();
        $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //return "successs"; //POUR TEST UNIQUEMENT 
        return $conn;
    }
    catch(PDOException $e){ // il est recommandé de ne pas afficher les erreurs de connexions à la DB mais de les enregistrer dans un log
        $errorMessage = "Erreur de connexion:" .$e->getMessage() ;//on récupère l'erreur attrapée dans la variable $errorMessage
        $errorDate=date("d/m/Y_H:i:s");//jour/mois/Année et Heure/minutes/secondes
        $error= "{$errorDate} :\n\t {$errorMessage} \r\n";//on compile la date et le message d'erreur, on revient à la ligne (\n), avec le curseur en début de ligne (\r) pour la prochaine date
        file_put_contents("db-log.txt", $error, FILE_APPEND);//on écrit l'erreur dans le fichier cité en l'ajoutant au contenu déjà existant (FILE_APPEND)
        //echo "echec"; POUR TEST UNIQUEMENT ->+vérifier le fichier log-db.txt
        return false;

    }
}
/*Test de connection en décommentant la ligne ci dessous et return success /return echec ci dessus*/
//echo DBconnection();
?>