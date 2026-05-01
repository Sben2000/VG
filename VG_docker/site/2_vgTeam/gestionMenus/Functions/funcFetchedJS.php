<?php

//accès aux constantes permettant l'accès à la dB
require_once "../DB/config.php";
//accès à la DB via la function listée
require_once "../DB/db.php";


/********Ecoute,Récupération et décodage des données arrivant************ */
// si une requête POST arrive (via script.js)
if(isset($_POST)){

//Récupération des éléments(file_get_content) du stream ("php://input") =>lecture des données brutes (flux I/O) depuis le corps de la requête.

$data = file_get_contents("php://input");

//Décodage des données json ($data) sous format d'un tableau (true)
$datas = json_decode($data, true);
//var_dump($datas);
//Récupération sous forme de variable et nettoyage supplémentaire (par précaution) des valeurs 
$idTheme = htmlspecialchars($datas["idTheme"]) ;
$idRegime = htmlspecialchars($datas["idRegime"]) ;
$imageSelected = htmlspecialchars($datas["imageSelected"]) ;
$menuTitle = htmlspecialchars($datas["menuTitle"]);
$textInput= htmlspecialchars($datas["textInput"]);
$remainQty= htmlspecialchars($datas["remainQty"]);
$minPeople= htmlspecialchars($datas["minPeople"]);
$menuPrice= htmlspecialchars($datas["menuPrice"]);



//Connexion à la Database

    $pdo=DBconnection();
    if(!$pdo){
        // si la connection n'est pas établi, on s'arrête ici 
        return false;

        
    }


    //Vérification que le nom de l'image n'existe pas dans la BDD 
    $sql = "SELECT * FROM menu WHERE (photo_menu = :photo_menu)";
    $query =$pdo->prepare($sql);
    $query->bindParam(':photo_menu', $imageSelected, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);

    //on vérifie si le résultat a renvoyé un nom similaire ou non
    if($result != NULL){
        //echo json_encode (["problem" => 'false']);
        echo json_encode([['success' => false],['message' => 'Nom ou Image déjà existante, changer le nom ou l\'image']]);
        return false;
        
    }



//
    //Si pas de doublons, Enregistrer les données dans la db
    $sql = "INSERT INTO menu(theme_id, regime_id, titre, description, photo_menu, quantite_restante, nombre_personne_minimum, prix_par_personne) VALUES (:idTheme, :idRegime, :titre, :description, :photo_menu, :quantite_restante, :nombre_personne_minimum, :prix_par_personne)";
    $query =$pdo->prepare($sql);
    $query->bindParam(':idTheme', $idTheme, PDO::PARAM_INT);
    $query->bindParam(':idRegime', $idRegime, PDO::PARAM_INT);
    $query->bindParam(':titre', $menuTitle, PDO::PARAM_STR);
    $query->bindParam(':description', $textInput, PDO::PARAM_STR);
    $query->bindParam(':photo_menu', $imageSelected, PDO::PARAM_STR);
    $query->bindParam(':quantite_restante', $remainQty, PDO::PARAM_INT);
    $query->bindParam(':nombre_personne_minimum', $minPeople, PDO::PARAM_INT);
    $query->bindParam(':prix_par_personne', $menuPrice, PDO::PARAM_STR);
    $query->execute();

    //Vérifie que le dernier Id enregistré est >0 et édition des clé/valeurs de status pour le JS
    $lastInserted=$pdo->lastInsertId();
    //si le dernier Id enregistré est >0 et si le nom de l'imageSélectionnée est celle enregistrée en locale
    if($lastInserted >0){
       // echo "succès";
        echo json_encode([['success' => true],['message' => 'Enregistrement des données réussies,finaliser l\'opération en chargeant l\'image acceptée....']]);
        return false;
        //echo json_encode(['ok' => 'ok']);
        //return json_encode(["success"=>true]);
    }else{
       // echo "echec";
       
        echo json_encode([['success' => false],['message' => 'Echec lors de l\'enregistrement des données']]);
        
        return false;
        
    }

}

/*ConfirmPicture => Fonctionne sans JS mais pas avec le fetch JS=>réalisé dans un fichier à part (confirmPicture.php)*/
/*
if (isset($_POST['submit'])) {	
 
    if(isset($_FILES['imageSelected']))
        echo "bonjour";
    { 
        $dossier = 'uploads/';
        $fichier = basename($_FILES['imageSelected']['name']);
        
        if(move_uploaded_file($_FILES['imageSelected']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
        {
            return ('Upload effectué avec succès !');
        }
        else //Sinon (la fonction renvoie FALSE).
        {
            return ('Echec de l\'upload !') ;
        }
   }
}*/

?>