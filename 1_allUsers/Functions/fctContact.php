<?php
//accès aux constantes permettant l'accès à la dB
require_once "./DB/config.php";
//accès à la DB via la function listée
require_once "./DB/db.php";
//accès à la fonction sendMail pour messages automatiques(Reset MotDePasse, Confirmation création de compte,...)
require_once './PHP_Mailer/SendMailFunction.php'; 
use PHPMailer\PHPMailer\PHPMailer; //classe PHPMailer pour instancier notre mail dans resetPassord() et autre fctions;
use PHPMailer\PHPMailer\Exception;// Exception du dossier PHP Mailer pour gérer les erreurs d'envoi


//functions lié à la page contact.php

//function registerUser
function contactUs($nom, $email, $message){
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

    //Sanitanization des données postées (même si pas enregistrées dans la DB)
    $email = htmlspecialchars($email);
    $nom = htmlspecialchars($nom);
    $message = htmlspecialchars($message);

    //Vérification du format de l'email (fonction filter_var() avec option FILTER_VALIDATE_EMAIL)
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return "le format de l'email n'est pas valide";
    }

    //Envoi du message à l'équipe Vite&Go


        //on instancie un nouvel objet $mail de la classe PHPMailer du fichier requis
                
            try{
                $mail = new PHPMailer(true);
                //on requiert la function sendMail() construite dans la classe PHPMailer dans laquelle sont passées les paramètres définis dans notre formulaire en concordance avec celles de la function
                //$email est le destinataire =>équivalent à $recipient de la function
                $recipient="soufyantestapp@gmail.com"; //Le destinataire est cette fois ci l'équipe Vite&Go dont le mail est enregistré dans PHP Mailer
                $subject="Contact Utilisateur/Visiteur";//sujet envoyé dans le mail
                 $body= 

                "<p> Message de {$email}  </p><br>\r\n
                 <p> Nom/Prénom {$nom}  </p><br>\r\n
                <p>Message: </p>\r\n
                <p>{$message}</p>\r\n";
                sendMail($mail, $subject,$recipient, $body);
                } catch(Exception $e) {
                return "Erreur d'envoi Message pour cause suivante :\n {$mail->ErrorInfo}, veuillez recommencer";
            }; 

    //Envoi du mail de confirmation à l'utilisateur


            //on instancie un nouvel objet $mail de la classe PHPMailer du fichier requis    
            try{
                $mail = new PHPMailer(true);
                //on requiert la function sendMail() construite dans la classe PHPMailer dans laquelle sont passées les paramètres définis dans notre formulaire en concordance avec celles de la function
                //$email est le destinataire =>équivalent à $recipient de la function
                            //éléments constituant l'email (sujet et corps) géré ensuite par la function sendMail() de PHPMailer
                $recipient =$email;//destinataire défini dans la function
                $subject="Confirmation d'envoi de votre message à Vite&Go";//sujet envoyé dans le mail
                $body= "<p> Bonjour {$nom}, nous vous confirmons l'envoi de votre message de ce jour à l'équipe Vite&GO.</p><br>\r\n
                        <p>Nous reviendrons vers vous dès que possible - L'équipe Vite&Go </p>\r\n
                        <hr><br>
                        <p><strong><em><u>Récapitulatif de votre message: </u></em></strong></p>\r\n
                        <p><em>{$message}</em></p>
                        "; //texte du mail puis retour à la ligne , curseur en début de ligne
            //on instancie un nouvel objet $mail de la classe PHPMailer du fichier requis
                sendMail($mail, $subject,$recipient, $body);
                return "success";
                } catch(Exception $e) {
                return "Désolé, nous n'avons pas pu envoyer votre message, veuillez recommencer ! :\n {$mail->ErrorInfo}";
            }; 

}
    ?>