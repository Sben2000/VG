<?php
echo "hello";
// DB credentials.
define('DB_HOST','127.0.0.1');/*adresse localhost, à reconfig si besoin*/
define('DB_USER','root');/*par défaut pas de MDP pour la démo=>à configurer si besoin*/
define('DB_NAME','vgo');/*Nom de la BDD*/
define('DB_PASS','');/*par défaut pas de MDP pour la démo=>à configurer si besoin*/





    // Etablir la connection avec la BDD.
    try{
        $conn = new PDO("mysql:host=".DB_HOST .";dbname=".DB_NAME, DB_USER, DB_PASS) or die();
        $conn ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "successs";
        
    }
    catch(PDOException $e){ // il est recommandé de ne pas afficher les erreurs de connexions à la DB mais de les enregistrer dans un log
        $errorMessage = "Erreur de connexion:" .$e->getMessage() ;//on récupère l'erreur attrapée dans la variable $errorMessage
        $errorDate=date("d/m/Y_H:i:s");//jour/mois/Année et Heure/minutes/secondes
        $error= "{$errorDate} :\n\t {$errorMessage} \r\n";//on compile la date et le message d'erreur, on revient à la ligne (\n), avec le curseur en début de ligne (\r) pour la prochaine date
        file_put_contents("db-log.txt", $error, FILE_APPEND);//on écrit l'erreur dans le fichier cité en l'ajoutant au contenu déjà existant (FILE_APPEND)
        //echo "echec"; POUR TEST UNIQUEMENT ->+vérifier le fichier log-db.txt
       

    }
$email='soufyane2000@hotmail.fr';

    $sql = "SELECT email FROM vgo.utilisateur where email = :email";
        $query = $conn->prepare($sql);
        $query->bindParam(":email", $email);
        $query->execute();
        $results =$query->fetch(PDO::FETCH_ASSOC);
        var_dump ($results["email"]);
   
        