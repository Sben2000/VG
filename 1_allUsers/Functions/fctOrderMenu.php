<?php

//accès aux constantes permettant l'accès à la dB
require_once "./DB/config.php";
//accès à la DB via la function listée
require_once "./DB/db.php";
//accès à la fonction sendMail pour messages automatiques
require_once './PHP_Mailer/SendMailFunction.php'; 
use PHPMailer\PHPMailer\PHPMailer; //classe PHPMailer pour instancier notre mail ;
use PHPMailer\PHPMailer\Exception;// Exception du dossier PHP Mailer pour gérer les erreurs d'envoi




//function qui récupère les détails menu/thème/régime du menu sélectionné (via le menuID envoyé via l'url encodé depuis menu.php)
function getSelectedMenu($selectedMenuID){
        //récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }
    //récupère les menus avec le thème choisi et la qté >0  et les tri du plus récent menu au plus ancien
    $sql = "
    SELECT menu.menu_id, menu.regime_id, menu.theme_id, menu.titre, menu.nombre_personne_minimum, menu.prix_par_personne, menu.description, menu.photo_menu, menu.quantite_restante,
     theme.theme_id,theme.libelle as theme,
    regime.regime_id, regime.libelle as regime
      FROM menu
    JOIN theme ON menu.theme_id = theme.theme_id
    JOIN regime ON menu.regime_id = regime.regime_id
    WHERE quantite_restante > 0 AND menu.menu_id =:selectedMenuID
    " ;
    $query = $conn->prepare($sql);
    $query->bindParam(":selectedMenuID",$selectedMenuID, PDO::PARAM_INT);
    $query ->execute();
    //fetch (sans ALL) car un seul menu sélectionné via l'url dans menu.php
    $result = $query->fetch(PDO::FETCH_OBJ);
    //var_dump($result);
    return $result;
}

//function élaborée pour récupérer les plats associés au menu en passant par la table Propose et menu_id 

function getProposePlatByMenuID($menuID){

    //récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }

    //récupération des détails des plats associés pour un menu_id identifié via les jointures sur la table propose 
    $sql = "
    SELECT propose.menu_id, menu.menu_id,
    plat.titre_plat, plat.plat_id, plat.photo
    FROM propose
    JOIN menu ON propose.menu_id = menu.menu_id
    JOIN plat ON propose.plat_id = plat.plat_id
    WHERE propose.menu_id =:menuID
    " ;
    $query = $conn->prepare($sql);
    $query->bindParam(":menuID", $menuID, PDO::PARAM_INT);
    $query ->execute();
    //fetch all car potentiellement plats 
    $result = $query->fetchAll(PDO::FETCH_OBJ);
    //var_dump($result);
    return $result;
}

//function qui récupère dans les éventuels allergènes associés à chaque plat
function getAllergenes($plat_id){
    $pdo = DBconnection();
    if(!$pdo){
            return false;
        }
$sql =     "SELECT contient.allergene_id, contient.plat_id,  allergene.libelle,  plat.titre_plat FROM contient 
JOIN allergene ON contient.allergene_id = allergene.allergene_id
JOIN plat ON contient.plat_id = plat.plat_id
WHERE contient.plat_id = :plat_id";
$query = $pdo->prepare($sql);
$query->bindParam(":plat_id", $plat_id, PDO::PARAM_INT);
$query->execute();
$result=$query->fetchAll(PDO::FETCH_OBJ);

return $result;



}




/****Ajout de journée(s) à la date du jour (cours studi)***/

//date du jour au format html (Année-Mois-Jour)
$today = date('Y-m-d');

//lendemain au format html (Année-Mois-Jour)
$tomorrow = date('Y-m-d', strtotime($today. ' + 1 days'));

//Quinzaine au format html (Année-Mois-Jour)
$twoWeeks = date('Y-m-d', strtotime($today. ' + 14 days'));


//Function qui met en forme et enregistre les données de la commande dans la DB (et maj le compte user éventuellement si ok )
function createUserOrder($userID, $name, $firstname, $email, $phoneNumber, $adress, $cityName, $postalCode,  $wishedDate, $wishedTime,  $selectedMenu, $peopleNbrSpec, $priceMenu, $reductionRate, $deliveryPrice, $totalPrice, $recordDeliveryDatas){
        
//récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }
//Récupèration de l'ensemble des arguments placés dans la fonction dans $args (qui devient un tableau contenant les entrées utilisateurs passés en argument)
$args=func_get_args();

    //assignation de function permettant de nettoyer les données des caractères spéciaux
    $sanitize_value = function($value){
        return htmlspecialchars($value);
    };

    //application de la fonction de rappel nettoyage sur tous les arguments récupérés et assignation à $args.
    array_map($sanitize_value, $args);

//mise en forme des datas (lettres capitales, majuscule, minuscules, ...)
$name = strtoupper($name);
$firstname = strtolower($firstname);//met l'ensemble du prénom en minsucule avant de capitaliser la 1ère lettre.
$firstname = ucfirst($firstname);
$adress = strtolower($adress);
$cityName = strtoupper($cityName);
//Par défaut, toutes les commandes acceptés sont en france
$country = "FRANCE";

//Si la checkbox contient la valeur "checked", les données sont enregistrés dans le compte user, (sinon pas d'update des données profil user)
if($recordDeliveryDatas == "checked"){
    $sql = "UPDATE utilisateur SET nom =:nameUser, prenom =:firstname, telephone =:phoneNumber, ville =:cityName, pays=:country, adresse_postale =:adress, code_postal =:postalCode WHERE utilisateur_id =:userID" ;
    $query=$conn->prepare($sql);
    $query->bindParam(":userID", $userID, PDO::PARAM_STR);
    $query->bindParam(":nameUser", $name, PDO::PARAM_STR);
    $query->bindParam(":firstname", $firstname, PDO::PARAM_STR);
    $query->bindParam(":phoneNumber", $phoneNumber, PDO::PARAM_STR);
    $query->bindParam(":cityName", $cityName, PDO::PARAM_STR);
    $query->bindParam(":country", $country, PDO::PARAM_STR);
    $query->bindParam(":adress", $adress, PDO::PARAM_STR);
    $query->bindParam(":postalCode", $postalCode, PDO::PARAM_STR);
    $query->execute();
    //on vérifie qu'une ligne a bien été affectée (confirmant l'enregistrement dans la dB) 
         $count=$query->rowCount();
    //si il n' y a pas un  $count >0 , l'enregistrement la modification n'a pas réussi, veuillez recommencer
        if (!$count > 0){
        return "l'enregistrement de vos données n'a pas réussi, veuillez recommencer";
        }
}

//Référecement de la commande: 

    //La réf se compose de : l'user_id +l'id commande+date du jour (AAMMJour) avec l'année sur 2 chiffres

    //partie ref1=>//user_id
    $ref1 = $userID;

    //partie ref2 =>//id de la dernière commande connue dans la DB +1 (+1 correspond à l'actuel commande en constructiion) 
    $sql ="SELECT MAX(commande_id) FROM commande " ;
    $query = $conn->prepare($sql);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $ref2 =  $result["MAX(commande_id)"] +1;
    
    //partie ref3 => //date du jour au format GMT (« Greenwich Mean Time » ) avec  AnMoisJour (année sur 2 digits)
    $ref3= gmdate("ymd");
        
    //réf commande:
    $refOrder =$ref1 ."-".$ref2 . "-" . $ref3;

//Mise au format des dates à envoyer par mail

$wishedDateMail = $wishedDate;
$dateOrderMail = gmdate("d/m/Y");

//Date de la commande (au format DATE SQL: YYYY-MM-dd)
$dateOrder = gmdate("Y-m-d"); //date d'aujourd'hui au format GMT    Année(4digits)-Mois-Jour

//Préparation pour mise de la date selectionnée au format DATE SQL (YYYY-MM-dd)

//date de prestation souhaitée ( au format dd/MM/YYYY)
$DDwishedDate = substr($wishedDate, 0,2);//dd
$MMwishedDate = substr($wishedDate, 3,2);//MM
$YYwishedDate = substr($wishedDate, 6,4);//YYYY
$wishedDate = "{$YYwishedDate}-{$MMwishedDate}-{$DDwishedDate}";//YYYY-MM-dd

//menu_id (récupéré de la DB)
    $sql ="SELECT menu_id FROM menu WHERE titre =:selectedMenu ";
    $query = $conn->prepare($sql);
    $query->bindParam(":selectedMenu", $selectedMenu, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $menuID =  $result["menu_id"];


//Insertion des données de la commande dans la DB - table commande
 $sql = "INSERT INTO commande (menu_id, utilisateur_id, numero_commande, date_commande, date_prestation, heure_livraison, prix_livraison, prix_TTC, nbr_pers, nom_livraison, prenom_livraison, telephone_livraison, ville_livraison, pays_livraison, adresse_postale_livraison, code_postal_livraison, reduction, commande_id) 
 VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $query=$conn->prepare($sql);
        $query->bindParam(1, $menuID, PDO::PARAM_INT);
        $query->bindParam(2, $userID, PDO::PARAM_INT);
        $query->bindParam(3, $refOrder, PDO::PARAM_STR);
        $query->bindParam(4, $dateOrder, PDO::PARAM_STR);
        $query->bindParam(5, $wishedDate, PDO::PARAM_STR);
        $query->bindParam(6, $wishedTime, PDO::PARAM_STR);
        $query->bindParam(7, $deliveryPrice, PDO::PARAM_STR);
        $query->bindParam(8, $totalPrice, PDO::PARAM_STR);
        $query->bindParam(9, $peopleNbrSpec, PDO::PARAM_STR);
        $query->bindParam(10, $name, PDO::PARAM_STR);
        $query->bindParam(11, $firstname, PDO::PARAM_STR);
        $query->bindParam(12, $phoneNumber, PDO::PARAM_STR);
        $query->bindParam(13, $cityName, PDO::PARAM_STR);
        $query->bindParam(14, $country, PDO::PARAM_STR);
        $query->bindParam(15, $adress, PDO::PARAM_STR);
        $query->bindParam(16, $postalCode, PDO::PARAM_STR);
        $query->bindParam(17, $reductionRate, PDO::PARAM_STR);
        $query->bindParam(18, $ref2, PDO::PARAM_STR);//pour rappel: $ref2=$result["MAX(commande_id)"] +1 , soit incrémentation de l'id_commande
        $query->execute();

        //on vérifie qu'une ligne a bien été affectée (confirmant l'enregistrement dans la dB) 
         $count=$query->rowCount();
        //si ce n'est pas le cas, envoi d'un message d'erreur
        if(!$count>0){
            return "l'enregistrement de la commande a échoué, veuillez recommencer"; //affichera le message associé dans le fichier d'execution de la réponse
        }

//Envoi du message à l'équipe Vite&Go


        //on instancie un nouvel objet $mail de la classe PHPMailer du fichier requis
                
            try{
                $mail = new PHPMailer(true);
                //on requiert la function sendMail() construite dans la classe PHPMailer dans laquelle sont passées les paramètres définis dans notre formulaire en concordance avec celles de la function
                //$email est le destinataire =>équivalent à $recipient de la function
                $recipient="soufyantestapp@gmail.com"; //Le destinataire est cette fois ci l'équipe Vite&Go dont le mail est enregistré dans PHP Mailer
                $subject="Commande en ligne crée- Menu  {$selectedMenu} -date souhaitée: {$wishedDateMail}";//sujet envoyé dans le mail
                 $body= 

                "<p> Commande de: <strong> {$name} {$firstname} </strong>
                 <br> Email: {$email} 
                 <br> Date de la commande: {$dateOrderMail}
                 <br> Numéro de commande: {$refOrder}
                 </p>
                 \r\n
                <p>&#x2B2A; <u><strong>Détails de la commande souhaitée: </strong><u></p>\r\n
                    <p>Menu: {$selectedMenu}, 
                    <br>Nbre de personnes: {$peopleNbrSpec},
                    <br>Date souhaitée: {$wishedDateMail},
                    <br>Plage horaire souhaitée: {$wishedTime},
                </p>\r\n
                <p>⬪ <u><strong>Coordonnées: </strong><u></p>\r\n
                    <p>Nom: {$name}, 
                    <br>Prénom: {$firstname},
                    <br>Adresse: {$adress},
                    <br>Ville: {$cityName},
                    <br>Code Postal: {$postalCode},
                    <br>Téléphone: {$phoneNumber},
                </p>\r\n
                <p>⬪ <u><strong>Prix: </strong><u></p>\r\n
                    <p>Prix du menu: {$priceMenu}€, 
                    <br>Réduction: {$reductionRate}%,
                    <br>Prix de la livraison: {$deliveryPrice}€,
                    <br>Prix total (TTC): {$totalPrice}€,
                </p>\r\n 
                
                Merci de bien vouloir donner suite à cette commande en la validant ou en la refusant (en précisant le motif).\r\n
                <br><br>
                Cordialement,
                <br>
                L'équipe Vite&Go
                ";
                sendMail($mail, $subject,$recipient, $body);
                } catch(Exception $e) {
                return "Erreur d'envoi de confirmation par mail pour cause suivante :\n {$mail->ErrorInfo} (potentiellement blocage pare Feu)";
            }; 

    //Envoi du mail de confirmation à l'utilisateur


  
//envoi d'un mail à l'utilisateur

//on instancie un nouvel objet $mail de la classe PHPMailer du fichier requis    
            try{
                $mail = new PHPMailer(true);
                //on requiert la function sendMail() construite dans la classe PHPMailer dans laquelle sont passées les paramètres définis dans notre formulaire en concordance avec celles de la function
                //$email est le destinataire =>équivalent à $recipient de la function
                            //éléments constituant l'email (sujet et corps) géré ensuite par la function sendMail() de PHPMailer
                $recipient =$email;//destinataire défini dans la function
                $subject="Résumé de votre commande Vite&Go du {$dateOrderMail}- Menu  {$selectedMenu} - réf: {$refOrder}";//sujet envoyé dans le mail
                $body= 
                "<p> Bonjour {$firstname}, nous vous confirmons l'envoi de votre demande de commande  de ce jour à l'équipe Vite&GO.<br>
                Nous reviendrons vers vous au plus vite pour vous informer de sa validation.<br>
                Veuillez trouvez ci dessous le résumé de celle ci.</p><br><br>
                \r\n

                <p> Commande de: <strong> {$name} {$firstname} </strong>
                 <br> Email: {$email} 
                 <br> Date de la commande: {$dateOrderMail}
                 <br> Numéro de commande: {$refOrder}
                 </p>
                 \r\n
                <p>&#x2B2A; <u><strong>Détails de la commande souhaitée: </strong><u></p>\r\n
                    <p>Menu: {$selectedMenu}, 
                    <br>Nbre de personnes: {$peopleNbrSpec},
                    <br>Date souhaitée: {$wishedDateMail},
                    <br>Plage horaire souhaitée: {$wishedTime},
                </p>\r\n
                <p>⬪ <u><strong>Coordonnées: </strong><u></p>\r\n
                    <p>Nom: {$name}, 
                    <br>Prénom: {$firstname},
                    <br>Adresse: {$adress},
                    <br>Ville: {$cityName},
                    <br>Code Postal: {$postalCode},
                    <br>Téléphone: {$phoneNumber},
                </p>\r\n
                <p>⬪ <u><strong>Prix: </strong><u></p>\r\n
                    <p>Prix du menu: {$priceMenu}€, 
                    <br>Réduction: {$reductionRate}%,
                    <br>Prix de la livraison: {$deliveryPrice}€,
                    <br>Prix total (TTC): {$totalPrice}€,
                </p>\r\n 
                
                
                <br><br>
                Cordialement,
                <br>
                L'équipe Vite&Go
                        "; //texte du mail puis retour à la ligne , curseur en début de ligne
            //on instancie un nouvel objet $mail de la classe PHPMailer du fichier requis
                sendMail($mail, $subject,$recipient, $body);

                //Si pas d'action utilisateur après message de succes, renvoi vers page d'acceuil après 10 secondes
                    header('Refresh:10; url=indexLocal.php');
                //Enfin, Retourne success à cette dernière étape pour affichage message de validation à l'utilisateur
                return "success";
                } catch(Exception $e) {
                return "Désolé, nous n'avons pas pu envoyer votre message pour cause suivante :\n {$mail->ErrorInfo} (potentiellement blocage pare Feu)";
            }; 

       

}

