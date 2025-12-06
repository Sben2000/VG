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

//function qui récupère les comandes du user
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

    $sql = "SELECT * FROM commande WHERE utilisateur_id = :user_id";
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
            $query->bindParam("orderMenuID",$orderMenuID,PDO::PARAM_INT);
            $query ->execute();
            $menuData = $query->fetch(PDO::FETCH_ASSOC);
            //merge des datas de la commande et du menu à chaque Loop
            $mergedResult = array_merge($results[$i], $menuData);
            //Push la table assoc.merged(data cde+menu) de chaque loop  dans La Table initialisée
            array_push($Table, $mergedResult);
        
    }
    //retourne Table recomposée complète (avec ss tables par cde+menu) pour exploitation dans Account.php 
    return $Table;

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

//Vérification du nom:
        if ($nom!="A COMPLETER SI LIVRAISON"){
        //si laissé vide
        if(empty($nom)){
        return "Veuillez renseigner un nom";
        }
    //Vérification des caractères autorisés (via function php is_numeric)
        if (is_string($nom)==FALSE){
        return "veuillez rentrer un nom composé de lettres";
        }
    //Vérification de la longueur du numéro de tél
        if(strlen($nom)>20){
            return "le nom ne peut dépasser 20 caractères";
        }

        }

//Vérification du Prénom:
        if ($prenom!="A COMPLETER SI LIVRAISON"){
        //si laissé vide
        if(empty($prenom)){
        return "Veuillez renseigner un prénom";
        }
    //Vérification des caractères autorisés (via function php is_numeric)
        if (is_string($prenom)==FALSE){
        return "veuillez rentrer un prénom composé de lettres";
        }
    //Vérification de la longueur du numéro de tél
        if(strlen($prenom)>15){
            return "le prénom ne peut dépasser 15 caractères";
        }

        }
//Vérification du format téléphone:
        if ($tel!="A COMPLETER SI COMMANDE"){
        //si laissé vide
        if(empty($tel)){
        return "Veuillez renseigner un numéro de téléphone";
        }
    //Vérification des caractères autorisés (via function php is_numeric)
        if (is_numeric($tel)==FALSE){
        return "le format du numéro ne doit être composé que de chiffres";
        }
    //Vérification de la longueur du numéro de tél
        if(strlen($tel)>15){
            return "le n° de tel ne peut dépasser 15 chiffres en incluant l'indicatif";
        }

        if(strlen($tel)<10){
            return "le numéro de tel ne peut être inférieur à 10 chiffres";
        }
        }
//Vérification Adresse:
    if ($adresse!="A COMPLETER SI LIVRAISON"){
        //si laissé vide
       if(empty($adresse)){
        return "Veuillez renseigner une adresse";
        }

        //Format adresse

        $masque ="(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$)";
        preg_match_all($masque, $adresse, $resultat);
        if (empty($resultat[0])){
        return "l'adresse doit comporter un N° et un nom de rue ";

    //Vérification de la longueur de l'adresse
        if(strlen($adresse)<5){
            return "veuillez svp indiquer une adresse complète > 6 caractères";
        }

        if(strlen($adresse)>30){
            return "Adresse trop longue, veuillez svp la réduire";
        }

        }
    }
//Vérification du format Code Postal:
     if ($codePostal!="A COMPLETER SI LIVRAISON"){
        if (is_numeric($codePostal)==FALSE){
        return "Veuillez rentrer un code Postal numérique";
        }
            //Vérification de la longueur du code Postal si Pays =France ou non renseigné
        if($pays = "FRANCE" || $pays=""){
            if(strlen($codePostal)<5 || strlen($codePostal)>5){
            return "veuillez svp indiquer un code Postal  à 5 chiffres, si pas en FRANCE => préciser le Pays";
        }
        
        }
     }


//Vérification du format PAYS:
    if ($pays!="A COMPLETER SI LIVRAISON"){
        //si laissé vide
        if(empty($pays)){
        return "Veuillez renseigner un Pays";
        }
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
            return "le nom du pays possède trop de caractères";
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
            return "success"; //affichera le message associé dans le fichier d'execution de la réponse
        }else{
            return "l'enregistrement a échoué, veuillez recommencer";
        }

}


?>

