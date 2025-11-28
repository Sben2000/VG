<?php
require "config.php";//accès aux constantes permettant l'accès à la dB

function connect(){ // connect php à mysql

    // Etablir la connection avec la BDD
    try{
        $conn = new PDO("mysql:host=".SERVER.";dbname=".DATABASE, USERNAME, PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//PDO::ATTR_ERRMODE=>Error reporting mode of PDO. Can take one of the following values, PDO::ERRMODE_EXCEPTION: Throws PDOExceptions.  
        //echo "successs"; POUR TEST UNIQUEMENT 
        return $conn;
    }
    catch(PDOException $e){ // il est recommandé de ne pas afficher les erreurs de connexions à la DB mais de les enregistrer dans un log
        $errorMessage = "Erreur de connexion:" .$e->getMessage() ;//on récupère l'erreur attrapée dans la variable $errorMessage
        $errorDate=date("d/m/Y_H:i:s");//jour/mois/Année et Heure/minutes/secondes
        $error= "{$errorDate} :\n\t {$errorMessage} \r\n";//on compile la date et le message d'erreur, on revient à la ligne (\n), avec le curseur en début de ligne (\r) pour la prochaine date
        file_put_contents("db-log.txt", $error, FILE_APPEND);//on écrit l'erreur dans le fichier cité en l'ajoutant au contenu déjà existant (FILE_APPEND)
        //echo "echec"; POUR TEST UNIQUEMENT ->+vérifier le fichier log-db.txt
        return false;//on retourne false

    }
}

function recordData(){ //enregistre l'utilisateur dans la dB
        $conn = connect(); //on se connecte à la dB
            
            $username = "Matteo";
            $password = "ZpasW0rd!23";
            $email= "Matteo28@gmail.com";


            //Encrypter le mot de passe avec la function hash et l'algo PASSWORD_DEFAULT utilisant Bcrypt ou directement PASSWORD_BCRYPT (password_hash: Creates a password hash , PASSWORD_DEFAULT - Use the bcrypt algorithm (default as of PHP 5.5.0),  it is recommended to store the result in a database column that can expand beyond 60 bytes (255 bytes would be a good choice).)
            $hashedPassword = password_hash($password,PASSWORD_BCRYPT);
            //echo "{$hashedPassword}\n"; vérification encrypt du mode passe , uncomment pour voir le résultat
            //Enregistrer les données validés dans la Table DB
            $sql = "INSERT INTO loginDF(username, password, email, date_added) VALUES (:username, :password, :email, :date )";
            $query = $conn->prepare($sql);
            $query->bindParam(":username", $username, PDO::PARAM_STR);
            $query->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
            $query->bindParam(":email", $email, PDO::PARAM_STR);
            $query->bindParam(":date", $date, PDO::PARAM_STR);

            //on définit le format de la date à ajouter avant d'executer la requête
            $date=date("Y-m-d");//Année/mois/jour au format date sql 

            $query->execute();
            //on vérifie que le dernier Id enregistré est supérieur à O (confirmant l'enregistrement dans la dB) ->PDO::lastInsertId() Returns the ID of the last inserted row, or the last value from a sequence object.
            $lastInserted=$conn->lastInsertId();

            //si il y a un id >0 , l'enregistrement a été réalisé avec succès, sinon l'enregistrement n'a pas réussi
            if ($lastInserted > 0){
                echo "Record inserted successfully\n";
            }else{
                echo "Record insertion failed, try again\n";
            }
}

recordData();
?>