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
function registerUser($email){ //enregistre l'utilisateur dans la dB
        $conn = connect(); //on se connecte à la dB

            //Vérifier si l'email existe déjà ou pas dans la dB

            /**
             * selon le tuto, le code est :
             * $stmt = $conn->prepare("SELECT email FROM users where email = ?");
             * stmt->bind_param("s", $email);
             * $stmt->execute();
             * $result = $stmt->get_result();
             * $data = $result->fetch_assoc();
             * if ($data !=NULL){
             *  return "Email already exists, please use a different username";
             * }
             */
            
            //mon essai
            $sql = "SELECT email FROM logindf where email = :email";
            $query = $conn -> prepare($sql);
            $query->bindParam(":email", $email);
            $query ->execute();
            //on récupère sous forme de tableau associatif, 
            //le résultat (unique) correspondant à notre requête (donc pas besoin de FETCH_ALL car on spécifie bien de récupérer la ligne correspondant à notre variable pour éviter les doublons)
            $results = $query->fetch(PDO::FETCH_ASSOC);
            var_dump($results);
            //option 1 : la plus simple
            //if($query ->rowCount()>0){ //si on a plus d'une ligne du tableau assoc 
             //   return "Email already exists, please use a different login or click on forggoten password";
            //}
            //option 2:
            //foreach ($results as $result[$email]) {
                if($results[$email] != false){
                    echo "Email already exists, please use a different login or click on forggoten password";
                }/*else{
                echo "Email doesn't exists";
                }*/
                /*}*/
        
        
    }
//;

registerUser("mark347@hotmail.fr");

function verifUsername($username){
           $conn = connect(); 
         //Vérifier si le username existe déjà ou pas dans la dB 
            $sql = "SELECT username FROM loginDF where username =:username";
            $query =$conn->prepare($sql);
            $query->bindParam(":username",$username);
            $query -> execute();
            //cette fois ci, on varie en choisissant un fetch OBJ pour changer les méthodes de temps en temps
            $result = $query->fetch(PDO::FETCH_OBJ);
            //condition sur le paramètre $objet -> username pour vérifier si déjà pris
            if($result->username != false){
                echo "The username already exists, please choose another one";
            } 
        }
verifUsername("mark");

