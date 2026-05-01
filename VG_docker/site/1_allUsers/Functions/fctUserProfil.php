<?php
//accès aux constantes permettant l'accès à la dB
require_once "./DB/config.php";
//accès à la DB via la function listée
require_once "./DB/db.php";


//function qui récupère les coordonnées du user
function userProfilDatas($username){

    //récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }

    //récupération des coordonnées user enregistrés dans la DB
    $sql = "SELECT * FROM utilisateur WHERE nom_utilisateur = :username";
    $query = $conn->prepare($sql);
    $query->bindParam(":username", $username, PDO::PARAM_STR);
    $query ->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    return $result;

}

//function qui récupère les commandes du user
function fetchUserOrders($username){

    //récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }

    //récupération de l'id du user
    $sql = "SELECT utilisateur_id FROM utilisateur WHERE nom_utilisateur = :username";
    $query = $conn->prepare($sql);
    $query->bindParam(":username", $username, PDO::PARAM_STR);
    $query ->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $userID= $result["utilisateur_id"];
    
    //récupération des commandes passées par le user

    $sql = "SELECT * FROM commande WHERE utilisateur_id = :user_id ORDER BY commande_id DESC";
    $query = $conn->prepare($sql);
    $query->bindParam(":user_id", $userID, PDO::PARAM_INT);
    $query ->execute();
    //potentiellement +eurs commandes (fetchAll)
    $results = $query->fetchAll(PDO::FETCH_ASSOC);

//Récupération des datas du (table) menu correspondant à chaque commande identifiée
    //initialisation de la Table commune
    $Table=[];
    //Loop à travers chacune des commandes pour en récupérer le menu_id
    for ($i=0; $i<count($results);$i++){
            $orderMenuID = $results[$i]["menu_id"];
            //récupération des datas du menu identifié à chaque loop
            $sql = "SELECT * FROM menu WHERE menu_id = :orderMenuID";
            $query = $conn->prepare($sql);
            $query->bindParam(":orderMenuID", $orderMenuID,PDO::PARAM_INT);
            $query ->execute();
            $menuData = $query->fetch(PDO::FETCH_ASSOC);
            //var_dump($menuData);
            //merge des datas de la commande et du menu à chaque Loop
            $mergedResult = array_merge($results[$i], $menuData);
            //Push la table assoc.merged(data cde+menu) de chaque loop  dans La Table initialisée
            array_push($Table, $mergedResult);
        
    }
    //retourne Table recomposée complète (avec ss tables par cde+menu) pour exploitation dans Account.php 
    return $Table;

}

// function d'instanciatiant d'une date (type SQL par ex) avec la class DateTime et mise au format souhaitée PHP .
function dateTime($SQLdate){
    $dateTime = new DateTime($SQLdate);
    $datePHP = $dateTime->format("d/m/Y");// le mois avec un 0 en initial, le jour avec un 0 en initial, l’année sur 4 digit.
    return $datePHP;

}


function updateUserProfil($userID,$username, $nom, $prenom, $tel, $adresse, $ville, $codePostal, $pays){

    
//récupération de la connection BDD
    $conn = DBconnection();
    if(!$conn){
        return false;
    }

//Traitement général

    //récupération des arguments de la function et trim des valeurs
    
    $args=func_get_args();//=>récupère l'ensemble des arguments placés dans la fonction dans $args (qui devient un tableau contenant les entrées utilisateurs passés en argument)
    $trim_value = function($value){
        return trim($value);
    };

    //application de la fonction de rappel sur tous les arguments et assignation à $args.
    $args = array_map($trim_value, $args);


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





//Vérification sur le nom_utilisateur (en cas de souhait de changement):
            //vérification qu'a minima le nom d'utilisateur est toujours renseigné (email étant disabled)
            if(empty($username)){
            return "Un nom d'utilisateur est à minima requis";
            }

        //Vérification de la longueur du nom d'utilisateur
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

        //Si le username est modifié, =>Vérification de l'exitence d'un nom d'utilisateur similaire dans la DB
        if($username!=$_SESSION["user"]){
        
        $sql = "SELECT nom_utilisateur FROM utilisateur where nom_utilisateur= :username";
        $query = $conn->prepare($sql);
        $query->bindParam(":username", $username);
        $query->execute();
        $results =$query->fetch(PDO::FETCH_ASSOC);
            //si résultat trouvé =>envoyé un message d'erreur
        if (!empty($results["nom_utilisateur"])){
            return "le nom d'utilisateur existe déjà dans notre base, veuillez en choisir un différent";
        }
        }

//Vérification du nom si celui ci est complété (à l'origine vide):
        if (!empty($nom)){

    //Vérification des caractères autorisés (via function php is_numeric)
        if (is_string($nom)==FALSE){
        return "veuillez rentrer un nom composé de lettres";
        }

        //si il existe un match ,(caractères non autorisés détéctés), envoi d'un message d'erreur
        $masque ="/(?!-|_|\s|'|[À-ú])[\W\d]/"; 
        preg_match_all($masque, $nom, $resultat);
        if (count($resultat[0])!=0){
        return "Uniquement lettres, - ou _ou espace si nom composé";
        }

    //Vérification de la longueur du nom
        if(strlen($nom)>20){
            return "le nom contient trop de caractères";
        }

            if(strlen($nom)<2){
            return "le nom ne contient pas assez de caractères";
        }

        }

//Vérification du Prénom si celui ci est complété (à l'origine vide):
        if (!empty($prenom)){
    //Vérification des caractères autorisés (via function php is_numeric)
        if (is_string($prenom)==FALSE){
        return "veuillez rentrer un prénom composé de lettres";
        }
        //si il existe un match ,(caractères non autorisés détéctés), envoi d'un message d'erreur
        $masque ="/(?!-|_|\s|'|[À-ú])[\W\d]/"; 
        preg_match_all($masque, $prenom, $resultat);
        if (count($resultat[0])!=0){
        return "Uniquement lettres, - ou _ou espace si prénom composé";
        }

    //Vérification de la longueur du nom
        if(strlen($prenom)>20){
            return "le prénom contient trop de caractères";
        }

            if(strlen($prenom)<2){
            return "le prénom ne contient pas assez de caractères";
        }
        }
//Vérification du format téléphone si celui ci est complété (à l'origine vide):
        if(!empty($tel)){

    //Vérification des caractères autorisés (via function php is_numeric)
        if (is_numeric($tel)==FALSE){
        return "le format du numéro ne doit être composé que de chiffres sans espace";
        }
        //si il existe un match ,(caractères non autorisés détéctés), envoi d'un message d'erreur
        $masque ="/\D/"; 
        preg_match_all($masque, $tel, $resultat);
        if (count($resultat[0])!=0){
        return "le format du numéro ne doit être composé que de chiffres sans espace";
        }
    //Vérification de la longueur du numéro de tél
        if(strlen($tel)>15){
            return "le n° de tel ne peut dépasser 15 chiffres en incluant l'indicatif";
        }

        if(strlen($tel)<10){
            return "le numéro de tel ne peut être inférieur à 10 chiffres";
        }
        }
        
//Vérification Adresse si celle ci est complétée (à l'origine vide):

       if(!empty($adresse)){

        //Format adresse

        //Vérification des caractères autorisés )
        $masque1 ="/(?!-|_|\s|'|\.|[À-ú]|[\d])[\W]/"; //Tout ce qui est un non word (\W) sauf (?!)- ou _ ou \.(point échappé) ou espace ou apostrophe ou toutes les lettres avec accent ou digit ou (-|_|\s|'|[À-ú] [\d])
         preg_match_all($masque1, $adresse, $resultat);
        //var_dump($resultat[0]);
        if (count($resultat[0])!=0){
        return "Adresse => uniquement N°, lettres, <br> - , _ , . ou espace ";
        }

     //Vérification de la longueur de l'adresse
        if(strlen($adresse)<4){
            return "veuillez svp indiquer une adresse complète ";
        }

        if(strlen($adresse)>30){
            return "Adresse trop longue, veuillez svp la réduire";
        }
    }
//Vérification Adresse si celle ci est complétée (à l'origine vide):

       if(!empty($ville)){

        //Format ville
        //Vérification des caractères autorisés 
        $masque ="/(?!-|_|\s|'|[À-ú])[\W\d]/"; //Tout ce qui est un non word (\W) ou un digit(\d) sauf (?!)- ou _ ou espace ou apostrophe ou toutes les lettres avec accent(-|_|\s|'|[À-ú])
        preg_match_all($masque, $ville, $resultat);
        //var_dump($resultat[0]);
        if (count($resultat[0])!=0){
        return "la ville ne doit comporter que des lettres ,sont également admis les tirets '-' '_' et apostrophe '";
        }
    //Vérification de la longueur de l'adresse
        if(strlen($ville)<2){
            return "veuillez svp indiquer le nom de ville complet";
        }

        if(strlen($ville)>20){
            return "le nom de ville est trop long, veuillez le réduire";
        }

    }
            
//Vérification du format Code Postal si celui ci est complété (à l'origine vide):
     if (!empty($codePostal)||$codePostal!=0){
        if (is_numeric($codePostal)==FALSE){
        return "Veuillez rentrer un code Postal numérique";
        }
        //Vérification des caractères autorisés 
        $masque ="/\D/"; //regex permettant de détecter tout les caractères non Digit ([^0-9])
        preg_match_all($masque, $codePostal, $resultat);
        //var_dump($resultat[0]);
        if (count($resultat[0])!=0){
        return "Veuillez rentrer un code Postal numérique sans espace ni caractères spéciaux";
        }

            //Vérification de la longueur du code Postal 
            if(strlen($codePostal)!=5){
            return "veuillez svp indiquer un code Postal  à 5 chiffres, supprimez les espaces si nécessaires";
        }
        
        //codes postaux de l'agglo Bordelaise :=> https://comersis.com/geo/geo/export-epci.php?dpt=33&epci=243300316 et google
        $arrayPostalCode = array(30072, 33000, 33100, 33200, 33300, 33800, 33440, 33810, 33370, 33530, 33130, 33290, 33000, 33270, 33110, 33520, 33560, 33150, 33320, 33270, 33170, 33185, 33310, 33127, 33700, 33290, 33600, 33160, 33440, 33160, 33440, 33320, 33400, 33140);
        if(!in_array($codePostal, $arrayPostalCode)){
            return "Désolé, nous livrons uniquement en métropole Bordelaise, nous contacter pour une autre localisation";
        }

        }
     


//Vérification du format PAYS si celui ci est complété (à l'origine vide)::
    if (!empty($pays)){

        //mise en uppercase
    $pays=strtoupper($pays);
    //format
    if(is_numeric($pays)){
        return "Veuillez saisir le nom du pays en lettres";
    }
    //Vérification de la longueur de l'adresse
        if(strlen($pays)<3){
            return "le nom du pays possède peu de caractères";
        }

        if(strlen($pays)>20){
            return "le nom du pays possède trops de caractères";
        }

        if($pays!="FRANCE"){
            return "Désolé, nous ne livrons qu'en FRANCE dans la métropole Bordelaise";
        }

    }



    //Mise à jour des data finaux dans la DB (le cas échéant si tout est ok)
        $sql = "UPDATE utilisateur SET nom_utilisateur=?, nom= ?, prenom=?, telephone=?, adresse_postale=?, ville=?, code_postal=?, pays=? WHERE utilisateur_id=? ";
        $query=$conn->prepare($sql);
        $query->bindParam(1, $username, PDO::PARAM_STR);
        $query->bindParam(2, $nom, PDO::PARAM_STR);
        $query->bindParam(3, $prenom, PDO::PARAM_STR);
        $query->bindParam(4, $tel, PDO::PARAM_INT);
        $query->bindParam(5, $adresse, PDO::PARAM_STR);
        $query->bindParam(6, $ville, PDO::PARAM_STR);
        $query->bindParam(7, $codePostal, PDO::PARAM_INT);
        $query->bindParam(8, $pays, PDO::PARAM_STR);
        $query->bindParam(9, $userID, PDO::PARAM_STR);//id récupéré dans le post (type= hidden) et correspondant au WHERE utilisateur_id=
        $query->execute();

        //Vérification que le dernier ID enregistré est > 0 (confirmation enregistrement)
        //Lors d'un insert, update ou delete une entrée de la dB, identification des lignes affectées via fct ->PDO : rowCount() ( Returns the number of rows affected by the last SQL statement)        
        $lastInserted =$query->rowCount();
        
        if($lastInserted>0){
            header("location:userAccount.php");
            return "success"; //affichera le message associé dans le fichier d'execution de la réponse
        }else{
            return "l'enregistrement a échoué, veuillez recommencer";
        }

}


?>

