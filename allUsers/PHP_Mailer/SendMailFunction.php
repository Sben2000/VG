<?php
/************************************Function qui envoie l'email**********************************/

//1) Télécharger la librairie PHPMailer dans Github: github.com/PHPMailer/PHPMailer ->PHPMailer-master.zip
//2)Dezipper le dossier dans le projet (Dossier PHPMailer-master) , puis supprimer le zip d'origine si pas besoin
//3)Copier le code affiché dans le github est nommé " A simple Example" ci dessous


        //Import PHPMailer classes into the global namespace
        //These must be at the top of your script, not inside a function
            /*Note: /*Au téléchargement le dossier se prénomme PHPMailer-master, le renommer PHPMailer uniquement pour convenir avec les use et require_once*/
        require_once 'PHPMailer-master/src/PHPMailer.php';
        require_once 'PHPMailer-master/src/SMTP.php';
        require_once 'PHPMailer-master/src/Exception.php';
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        //Load Composer's autoloader (created by composer, not included with PHPMailer)
        /*require 'vendor/autoload.php'; // dans notre cas on ne va pas utiliser composer*/

        //Create an instance; passing `true` enables exceptions
        /*$mail = new PHPMailer(true);*/ //-->instancié directement dans la page index
        
        function sendMail($mail,$subject,$recipient,$body){//mise sous la forme de function qui sera appelée
        
             //To load the French version /*dans le github -> traduction des erreurs dispo via la sélection de la langue telle quelle pour la gestion des erreurs*/
            $mail->setLanguage('fr', '/optional/path/to/language/directory/');
            //Server settings
            $mail->SMTPDebug = /*SMTP::DEBUG_SERVER;*/ 0;                 //Enable verbose debug output ->passé à 0 dans notre cas, sinon va nous dire tout ce qui s'est passé pendant la phase d'envoi
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = /*smtp.example.com'*/'smtp.gmail.com';                       //Set the SMTP server to send through ->Host dans notre cas: 'stmp.gmail.com', possible avec outlook également
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = /*'user@example.com'*/'soufyantestapp@gmail.com'; //SMTP username ->notre compte mail utilisateur
            $mail->Password   = /*'secret'*/'syegyhkybyfjanim';         //SMTP password ->donnée dans google/sécurité en ajoutant la vérif à deux étapes, mot de passe des applications/entrer le nom de l'appli/puis copier et coller ici le code sans espace
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients (par défaut on met notre compte utilisateur pour se l'envoyer à nous même de nous même)
            $mail->setFrom('soufyantestapp@gmail.com', 'Vite&Go ');/*('from@example.com', 'Mailer')*/ //apparaitra avec mon Mail avec le message posté en entête
            $mail->addAddress ($recipient, 'User');/*('joe@example.net', 'Joe User');*/     //Add a recipient ->remplacé par le mail du destinataire
            
            /* Pour ajouter d'autres destinataire en principal ou en CC, utiliser le code ci dessous:
            $mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com');*/

            /*pour envoyer des fichiers , nommer le chemin et le nom du fichier en utilisant les méthodes ci dessous:

            //Attachments
            $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
            */
            $mail->CharSet='utf-8'; //mis à utf-8 car par défaut en ISO88591 -> cf public $CharSet = self::CHARSET_ISO88591 (fichier PHPMailer.php)
            //Content
            $mail->isHTML(true);         //Set email format to HTML ->possibilité d'envoi de code HTML (dans le cas ou on met du style html à notre mail)
            $mail->Subject = $subject; /*'Here is the subject';*/    //sujet/objet de l'envoi apparaissant dans le mail->cf ds function 
            /*$mail->Body    = 'This is the HTML message body <b>'.$Content.'</b>';*/ 
            // structure et style css de notre  de mail (si dévellopé ici) + Contenu ($Content) contenant le code ou texte à faire apparaitre*/
            $mail->Body =$body;// voir le contenu du message dans la function resetPassword à la variable $body
            

            //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; /*Dans le cas ou on a pas réalisé de style, text basique envoyé avec une description brêve de l'img non construit qui n'est pas visible*/



            $mail->send(); /*fait l'execution du programme en envoyant le mail*/
 
        }
    
?>