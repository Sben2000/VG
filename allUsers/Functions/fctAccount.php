<?php
//accès aux constantes permettant l'accès à la dB
require_once "./DB/config.php";
//accès à la DB via la function listée
require_once "./DB/db.php";
//accès à la fonction sendMail pour messages automatiques(Reset MotDePasse, Confirmation création de compte,...)
require_once './PHP_Mailer/SendMailFunction.php'; 
use PHPMailer\PHPMailer\PHPMailer; //classe PHPMailer pour instancier notre mail dans resetPassord() et autre fctions;
use PHPMailer\PHPMailer\Exception;// Exception du dossier PHP Mailer pour gérer les erreurs d'envoi


//function lié à la page signUP.php
function registerUser($email, $username, $password, $confirm_password){
    //récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }

    //récupération des arguments de la function et trim des valeurs
    
    $args=func_get_args();//=>récupère l'ensemble des arguments placés dans la fonction dans $args (qui devient un tableau contenant les entrées utilisateurs passés en argument)
    $trim_value = function($value){
        return trim($value);
    };

    //application de la fonction de rappel sur tous les arguments et assignation à $args.
    $args = array_map($trim_value, $args);

    //vérification de l'ensemble des champs complétés
    foreach ($args as $arg){
        if(empty($arg)){
            return "Tous les champs doivent être complétés";
        }
    }

    //interdire les quotes, balises, chevrons et autres caractères non sécurisants
        $masque ="/[<>\'\"]/";
        foreach ($args as $arg){
            //via un preg_match
            preg_match_all($masque, $arg, $resultat);

            //via un controle complémentaire htmlchars
            $secureInput = htmlspecialchars($arg,  ENT_QUOTES | ENT_HTML5, 'UTF-8');

            //si carctères trouvés dans les deux cas=>avertir l'utilisateur
            if((count($resultat[0])>0) | ($arg != $secureInput)){
                return " Les caractères spéciaux: < > \" \' ne sont pas autorisé, Veuillez corriger {$arg}";
            }
        }

        //Vérification du format de l'email (fonction filter_var() avec option FILTER_VALIDATE_EMAIL)
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return "le format de l'email n'est pas valide";
        }

        //Vérification de l'exitence d'un email similaire dans la DB
        $sql = "SELECT email FROM utilisateur where email = :email";
        $query = $conn->prepare($sql);
        $query->bindParam(":email", $email);
        $query->execute();
        $results =$query->fetch(PDO::FETCH_ASSOC);
            //si résultat trouvé =>envoyé un message d'erreur
            if (!empty($results["email"])){
            return "l'email existe déjà dans notre base, veuillez choisir un email différent";
        }

        

        //Vérification de la longueur du nom d'utilisateur
        if(strlen($username)>10){
            return "le nom d'utilisateur ne doit pas dépasser 10 caractères";
        }

        if(strlen($username)<3){
            return "le nom d'utilisateur doit comporter au moins 3 caractères";
        }
        //Vérification de l'exitence d'un nom d'utilisateur similaire dans la DB
        $sql = "SELECT nom_utilisateur FROM utilisateur where nom_utilisateur= :username";
        $query = $conn->prepare($sql);
        $query->bindParam(":username", $username);
        $query->execute();
        $results =$query->fetch(PDO::FETCH_ASSOC);
            //si résultat trouvé =>envoyé un message d'erreur
        if (!empty($results["nom_utilisateur"])){
            return "le nom d'utilisateur existe déjà dans notre base, veuillez en choisir un différent";
        }

/* REGEX A TRAVAILLER
        //Vérification des caractères alphanumériques uniquement (Upper&Lowercase)
        $masque ="/[a-zA-Z0-9]/+";
        preg_match_all($masque, $username, $resultat);
        if ($resultat)
        return "le nom d'utilisateur ne doit comporter que des caractères alphanumériques";
*/
        //Vérification de la longueur du mot de passe

        if(strlen($password)>20){
            return "le mot de passe ne doit pas dépasser 20 caractères";
        }

        if(strlen($password)<8){
            return "le mot de passe doit comporter au moins 8 caractères";
        }
/*      REGEX A TRAVAILLER
        //Vérification des caractères alphanumériques uniquement (Upper&Lowercase)
        $masque ="/[a-zA-Z0-9]/+";
        preg_match_all($masque, $username, $resultat);
        return "le nom d'utilisateur ne doit comporter que des caractères alphanumériques";
*/
        //Vérification équvalence le Mot de Passe et la confirmation du Mot de Passe 
            if($password !== $confirm_password){
        return "les mots de passe ne correspondent pas, veuillez vérifier";
         }

        //Hashage&Encryption du mot de passe (en Bcrypt=>également algo par défaut PHP via PASSWORD_DEFAULT)
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        //echo "{$hashedPassword}\n"; vérification encrypt du mode passe , uncomment pour voir le résultat

         //Envoi de l'email de confirmation

            //éléments constituant l'email (sujet et corps) géré ensuite par la function sendMail() de PHPMailer
            $recipient =$email;//destinataire défini dans la function
            $subject="Votre inscription chez Vite&Go";//sujet envoyé dans le mail
            $body= "<p> Bonjour `{$username}`, nous vous confirmons votre inscription chez Vite&GO.</p><br>\r\n
                     <p>Bienvenue chez nous, nous espérons avoir de vos nouvelles très vite </p>\r\n"; //texte du mail puis retour à la ligne , curseur en début de ligne
        //on instancie un nouvel objet $mail de la classe PHPMailer du fichier requis
                
            try{
                $mail = new PHPMailer(true);
                //on requiert la function sendMail() construite dans la classe PHPMailer dans laquelle sont passées les paramètres définis dans notre formulaire en concordance avec celles de la function
                //$email est le destinataire =>équivalent à $recipient de la function
                sendMail($mail, $subject,$recipient, $body);
                } catch(Exception $e) {
                return "Désolé, nous n'avons pas pu vous confirmer l'enregistrement par mail, veuillez recommencer ! :\n {$mail->ErrorInfo}";
            }; 
    

        //Insertion des data finaux dans la DB (le cas échéant si tout est ok)
        $sql = "INSERT INTO utilisateur (role_id, nom_utilisateur, password, email) VALUES (1, :username, :password, :email)";//role_id =1 =>utilisateut par défaut (allUsers)
        $query=$conn->prepare($sql);
        $query->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
        $query->bindParam(":username", $username, PDO::PARAM_STR);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $query->execute();

        //Vérification que le dernier ID enregistré est > 0 (confirmation enregistrement)
        $lastInserted = $conn->lastInsertId();

        if($lastInserted>0){
            return "success"; //affichera le message associé dans le fichier d'execution de la réponse
        }else{
            return "l'enregistrement a échoué, veuillez recommencer";
        }

        //envoi du mail de confirmation à l'utilisateur


}




//function loginUser