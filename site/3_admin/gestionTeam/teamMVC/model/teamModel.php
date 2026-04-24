<?php

include_once "routes/rootPath.php";
include_once __ROOT__."/DB/db.php";

//accès à la fonction sendMail pour messages automatiques(Reset MotDePasse, Confirmation création de compte,...)
require_once ACCESSROOT."/PHP_Mailer/SendMailFunction.php";
use PHPMailer\PHPMailer\PHPMailer; //classe PHPMailer pour instancier notre mail dans resetPassord() et autre fctions;
use PHPMailer\PHPMailer\Exception;// Exception du dossier PHP Mailer pour gérer les erreurs d'envoi


/*******************************************Function cleanAndCheckValue appliquée à tous les champs ajoutés ou modifiés********************************************************************************/

function cleanAndCheckValue($value){
    //Vérification et Nettoyage la valeur de la variable récupérée 
    $value=htmlspecialchars($value);
    
    $args = func_get_args();//récupère l'ensemble des arguments placés dans la fonction dans $args 
            
        //function : enlever les espaces avant et après des valeurs récupérées dans le tableau $args
        $trim_value = function ($value){
        return trim($value); 
        };
                
        //array_map($callback, $array) =>applique la fonction de rappel sur tous les éléments d’un tableau, sans modifier le tableau d’origine.
        $args = array_map($trim_value, $args); // $trim_value appliqué sur les valeurs du tableau $args pour leur enlever les espaces

        //Parcourir l'ensemble des valeurs et si une est vide , retourner le message "tous les champs sont requis"
        foreach ($args as $arg) {
            if (empty($arg)){

            $error= "Tous les champs doivent être complétés";
            
        }
        //si la variable $error n a pas pu rester vide, elle est retourné pour être traitée
        if (!empty($error)) 
        //on affiche le message d'erreur
        return $error;

        }
}

/*******************************************Function alreadyExists appliquée à tous les types de champs ajoutés ou modifiés pour éviter les doublons********************************************************************************/

function alreadyExistsEmail($email,$pdo){
    $sql = "SELECT email FROM utilisateur where email =:email";
    $query =$pdo->prepare($sql);
    $query->bindParam(":email",$email);
    $query -> execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    //condition sur le paramètre objet ->  pour vérifier si déjà existant
    if(!empty($result->email )){
        // on affiche le message d'erreur
        $error = "l'email existe déjà dans la Base de Données";
        //si la variable $error n a pas pu rester vide, elle est retourné pour être traitée
        if (!empty($error)) 
        return $error;
    }

}

function alreadyExistsUsername($username,$pdo){
    $sql = "SELECT nom_utilisateur FROM utilisateur where nom_utilisateur =:username";
    $query =$pdo->prepare($sql);
    $query->bindParam(":username",$username);
    $query -> execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    //condition sur le paramètre objet ->  pour vérifier si déjà existant
    if(!empty($result->nom_utilisateur)){
        // on affiche le message d'erreur
        $error = "le nom d'utilisateur existe déjà dans la Base de Données";
        //si la variable $error n a pas pu rester vide, elle est retourné pour être traitée
        if (!empty($error)) 
        return $error;
    }
}
    function alreadyExistsPassword($password,$pdo){
    $sql = "SELECT password FROM utilisateur where password =:password";
    $query =$pdo->prepare($sql);
    $query->bindParam(":password",$password);
    $query -> execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    //condition sur le paramètre objet ->  pour vérifier si déjà existant
    if(!empty($result->password)){
        // on affiche le message d'erreur
        $error = "le mot de passe est déjà attribué dans la Base de Donnée";
        //si la variable $error n a pas pu rester vide, elle est retourné pour être traitée
        if (!empty($error)) 
        return $error;
    }

}
 /********vérification et traitement complémentaires reprises de la function registerUser() du fichier fctAccount.php dans le dossier allUsers*/

 //Vérification du format de l'email (fonction filter_var() avec option FILTER_VALIDATE_EMAIL)
    function addTreatmentEmail($email){
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return "le format de l'email n'est pas valide";
        }
    }
//Vérification de la longueur du nom d'utilisateur
    function addTreatmentUsername($username){
        if(strlen($username)>15){
            return "le nom d'utilisateur ne doit pas dépasser 10 caractères";
        }

        if(strlen($username)<3){
            return "le nom d'utilisateur doit comporter au moins 3 caractères";
        }
        //Vérification des caractères autorisés (alphanumériques (case insensitive) , - et _) uniquement (Upper&Lowercase)
        $masque ="/[^[\w]_\-0-9]/i"; //classe:[], ne contenant pas: ^(interne), les caractères: Toutes lettres(\w) - _ 0à9, minuscule ou majuscule:/i
        preg_match_all($masque, $username, $resultat);
        if (count($resultat[0])!=0){
        return "le nom d'utilisateur ne doit comporter que des caractères alphanumériques ,sont également admis '-' et '_'";
        }
        }
//Vérification de la longueur du mot de passe
        function addTreatmentPassword($password){
        if(strlen($password)>20){
            return "le mot de passe ne doit pas dépasser 20 caractères";
        }

        if(strlen($password)<10){
            return "le mot de passe doit comporter au moins 10 caractères";
        }
        //Vérification des caractères autorisés 
        $masque ="(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@_&%$!.]).+$)"; // du début ^ à la fin $ =>(?=.*)match la position si elle est suivie par au moins un caractère de type \d (digit) a-z A-Z caractères spéciaux:$%!.&@*,au moins une fois +
        preg_match_all($masque, $password, $resultat);
        if (empty($resultat[0])){
        return "le mot de passe doit contenir au moins 1 Maj., 1 minusc.,1 chiffre, un caractère spécial autorisé: $%!.&@*  ";
        }
   
        }



/****************************************ENSEMBLE DES FONCTIONS DE BASE DU MVC*********************************************** */
/*recupérer les acces des employés du plus récent au plus ancien*/
function latests_access()
{
    $pdo = DBconnection();
    if(!$pdo){
            return false;
        }
    //récupération de l'ensemble des données du tableau Ou le role_id =2 (employé VGTeam) et en affichant les derniers enregistrés en prmier
    $access = $pdo->query("SELECT * FROM utilisateur WHERE role_id=2 ORDER BY utilisateur_id DESC")->fetchAll(PDO::FETCH_OBJ);
    return $access; // return access au Controller qui sera utilisé par la views (for each $access as $acces)
    
}

function create($username, $email, $password)//function qui ajoute des libelles en récupérant les champs remplis
{
    
        $pdo = DBconnection();
        if(!$pdo){
            return false;
        }

    $args = func_get_args();//récupère l'ensemble des arguments placés dans la fonction dans $args 

    foreach ($args as $arg){
    //Application de la function de nettoyage et vérification à la valeur intégrée (htmlchars, trim et valeur non vide) à $libelle
    cleanAndCheckValue($arg);
        //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(cleanAndCheckValue($arg))){
        return cleanAndCheckValue($arg);
    }
}
    //Application de la function alreadyExists pour éviter les doublons dans la BDD en récupérant la connection ouverte
           //nom_utilisateur
    //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(alreadyExistsUsername($username,$pdo))){
        return alreadyExistsUsername($username,$pdo);
    }
     
    //idem pour les autres champs

    //email
        alreadyExistsEmail($email,$pdo);
    if (!empty(alreadyExistsEmail($email,$pdo))){
        return alreadyExistsEmail($email,$pdo);
    }    
    //mot de passe

 
    if (!empty(alreadyExistsPassword($password,$pdo))){
        return alreadyExistsPassword($password,$pdo);
    }

    //Application des functions de traitements Complémentaires conformément à la function registerUser() pour l'enregistrement d'un quelconque utilisateur
    addTreatmentUsername($username);
    addTreatmentEmail($email);
    addTreatmentPassword($password);

    //Hashage&Encryption du mot de passe (en Bcrypt=>également algo par défaut PHP via PASSWORD_DEFAULT)
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

/* Envoi du mail mis en suspend pour la version render.com gratuite => bloque le SMTP
    //Envoi de l'email de confirmation

            //éléments constituant l'email (sujet et corps) géré ensuite par la function sendMail() de PHPMailer
            $recipient =$email;//destinataire défini dans la function (replacer $email avec votre mail "...@..." pour tester si necessaire )
            $subject="Votre accès VgTeam chez Vite&Go";//sujet envoyé dans le mail
            $body= "<p> Bonjour {$username},</p>\r\n 
                    <p>Nous vous confirmons la création de votre accès Employé chez Vite&GO.</p><br>\r\n
                     <p>Veuillez vous rapprocher de la direction pour obtenir vos identifiants et mot de passe </p>\r\n
                     <p>La direction Vite&Go </p>\r\n"; //texte du mail puis retour à la ligne , curseur en début de ligne
                     
            //on instancie un nouvel objet $mail de la classe PHPMailer du fichier requis
                
            try{
                $mail = new PHPMailer(true);
                //on requiert la function sendMail() construite dans la classe PHPMailer dans laquelle sont passées les paramètres définis dans notre formulaire en concordance avec celles de la function
                //$email est le destinataire =>équivalent à $recipient de la function
                sendMail($mail, $subject,$recipient, $body);
                } catch(Exception $e) {
                return "Désolé, nous n'avons pas pu envoyer la confirmation par mail à l'interessé due à l'erreur suivante  :\n {$mail->ErrorInfo}, blocage potentiel du firewall";
            }; 

*/
    //on prépare la requête comme il s'agit de données récupérés de champs  via create.php 
        //on précise le role_id=2 pour créer un utilisateur VgTeam
    $sql = "INSERT INTO utilisateur (utilisateur_id, nom_utilisateur, email, password, role_id) VALUES (null, :username, :email, :password, 2)";
    $query=$pdo->prepare($sql);
    $query->bindParam(":username", $username, PDO::PARAM_STR);
    $query->bindParam(":email", $email, PDO::PARAM_STR);
    $query->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
    $query->execute();
    
    //on vérifie que le dernier Id enregistré est supérieur à O (confirmant l'enregistrement dans la dB) ->PDO::lastInsertId() Returns the ID of the last inserted row, or the last value from a sequence object.
            $lastInserted=$pdo->lastInsertId();
    //si il y a un id >0 , l'enregistrement a été réalisé avec succès, sinon l'enregistrement n'a pas réussi
        if ($lastInserted > 0){
        return "success";
        }else{
        return "l'enregistrement n'a pas réussi, veuillez recommencer";
        }
    
}

/****************************************************Afficher et modifier le libellé selectionné******************************************************************/
function view($id){//on récupère l'id du theme à modifier (sélectionné dans la page d'acceuil)
    $pdo = DBconnection();
    if(!$pdo){
        return false;
    }
    $sql="SELECT * FROM utilisateur WHERE utilisateur_id=:id";
    $query=$pdo->prepare($sql);
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    $query->execute();
    //on affiche l'unique  clé  sélectionnée (donc pas de fetchAll ) =>function récupéré dans editAction partie controller
    return $query->fetch(PDO::FETCH_OBJ);
}

function edit($id, $username, $email, $password){//edite les valeurs extraites de la fonction updateAction() du fichier controller qui a récupéré  les valeurs $_POST 
    //Nettoyage des valeurs de variables récupérées 
    
    $pdo = DBconnection();
    if(!$pdo){
        return false;
    }
    $args = func_get_args();//récupère l'ensemble des arguments placés dans la fonction dans $args 

    foreach ($args as $arg){
    //Application de la function de nettoyage et vérification à la valeur intégrée (htmlchars, trim et valeur non vide) à $libelle
    cleanAndCheckValue($arg);
        //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
    if (!empty(cleanAndCheckValue($arg))){
        return cleanAndCheckValue($arg);
    }
}

        //Récupération des données actuelles de la Table pour agir sur les valeurs modifiées
        $sql="SELECT * FROM utilisateur WHERE utilisateur_id=:id";
        $query=$pdo->prepare($sql);
        $query->bindParam(":id", $id, PDO::PARAM_INT);
        $query->execute();
        //on affiche l'unique  clé sélectionnée (donc pas de fetchAll ) =>function récupéré dans editAction partie controller
        $currentDatas = $query->fetch(PDO::FETCH_OBJ);

    //Application des functions de vérifications/contrôles utilisées dans create si les données ont été modifiées.

       // Si nom d'utilisateur modifié
    
    if (($username != $currentDatas->nom_utilisateur)){
            //Application de la function alreadyExists pour éviter les doublons dans la BDD en récupérant la connection ouverte
            //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné
            if (!empty(alreadyExistsUsername($username,$pdo))){
                return alreadyExistsUsername($username,$pdo);
            }
         //on applique la function de traitement complémentaire
            //si le résultat de la fonction n'est pas vide ($error contient un retour), le contenu de l'erreur est retourné           
            if (!empty(addTreatmentUsername($username))){
                return addTreatmentUsername($username);
        }
    }




    //idem pour les autres champs

        //si email d'utilisateur modifié
    if ($email != $currentDatas->email){
        if (!empty(alreadyExistsEmail($email,$pdo))){
        return alreadyExistsEmail($email,$pdo);
    } 
    if (!empty(addTreatmentEmail($email))){
            return addTreatmentEmail($email);
        }
    }

     //si mot de passe modifié

    //si password d'utilisateur modifié
    if ($password != $currentDatas->password){
        if (!empty(alreadyExistsPassword($password,$pdo))){
            return alreadyExistsPassword($password,$pdo);
        }    
        //on applique la function de traitement complémentaire
        if (!empty(addTreatmentPassword($password))){
            return addTreatmentPassword($password);
        }
    }

    //si aucune n'a été modifié, aucune mise a jour ni envoi de mail
    if($username == $currentDatas->nom_utilisateur){
        if ($email == $currentDatas->email){
            if ($password == $currentDatas->password){
                return "Toute les données sont identiques, aucune modification n'a été détectée";
            }
        }
    }

    //Hashage&Encryption du mot de passe (en Bcrypt=>également algo par défaut PHP via PASSWORD_DEFAULT)
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    //Envoi de l'email de confirmation

            //éléments constituant l'email (sujet et corps) géré ensuite par la function sendMail() de PHPMailer
            $recipient =$email;//destinataire défini dans la function (replacer $email avec votre mail "...@..." pour tester si necessaire )
            $subject="Votre accès VgTeam chez Vite&Go";//sujet envoyé dans le mail
            $body= "<p> Bonjour {$username},</p>\r\n 
                    <p>Nous vous confirmons la modification de votre accès Employé chez Vite&GO.</p><br>\r\n
                     <p>Veuillez vous rapprocher de la direction pour obtenir vos identifiants et mot de passe </p>\r\n
                     <p>La direction Vite&Go </p>\r\n"; //texte du mail puis retour à la ligne , curseur en début de ligne
                     
            //on instancie un nouvel objet $mail de la classe PHPMailer du fichier requis
                
            try{
                $mail = new PHPMailer(true);
                //on requiert la function sendMail() construite dans la classe PHPMailer dans laquelle sont passées les paramètres définis dans notre formulaire en concordance avec celles de la function
                //$email est le destinataire =>équivalent à $recipient de la function
                sendMail($mail, $subject,$recipient, $body);
                } catch(Exception $e) {
                return "Désolé, nous n'avons pas pu envoyer la confirmation par mail à l'interessé due à l'erreur suivante  :\n {$mail->ErrorInfo}. Blocage potentiel du firewall";
            }; 


    //on update les valeurs sauf l'id qui ne se modifie pas( auto incrémenté) 
    $query=$pdo->prepare("UPDATE utilisateur 
                            SET  nom_utilisateur=:username, email=:email, password=:password 
                            WHERE utilisateur_id =:id");
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    $query->bindParam(":username", $username, PDO::PARAM_STR);
    $query->bindParam(":email", $email, PDO::PARAM_STR);
    $query->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
    $query->execute();
   return "success";// on termine la function en retournant success qui envoi un message de bonne execution de la requête                       
}

/******************************************************************************************************************************************/
function destroy($id) /*function qui supprime l'id get ($id = $_GET['id']) en argument suite à appui sur bouton supprimer dans le fichier views/delete.php (href="index.php?action=destroy&?id=<?php echo $id ?>">Valider la suppression</a>)*/
{
     
    $id=htmlspecialchars($id);//Nettoyage la valeur de la variable récupérée

    $pdo = DBconnection();
    if(!$pdo){
        return false;
    }
    $sql="DELETE FROM utilisateur WHERE utilisateur_id=:id";
    $query=$pdo->prepare($sql);
    $query->bindParam(":id", $id, PDO::PARAM_INT);
    $query->execute();
    //si il y a une ligne affectée , la suppression a été réalisée avec succès, sinon la suppression n'a pas réussi
        if ($query->rowCount()>0){
        return "success";
        }else{
        return "la suppression n'a pas réussi, veuillez recommencer";
        }
    
}


