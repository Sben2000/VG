<?php

$username = "aa11&";
        //Vérification des caractères autorisés 
        $masque ="(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@_&%$!]).+$)";
        preg_match_all($masque, $username, $resultat);
        var_dump($resultat[0]);
        if (empty($resultat[0])){
        echo "le mot de passe doit contenir au moins 1 Maj., 1 minusc.  un caractère spécial autorisé: $%!.&@*  ";
        }else{
            echo "ok";
        }

echo "\n";
$user = "sszqq";

        //Vérification des caractères autorisés (alphanumériques (case insensitive) , - et _) uniquement (Upper&Lowercase)
        $masque ="/[^a-z_\-0-9]/i"; //classe:[], ne contenant pas: ^(interne), les caractères: aàz - _ 0à9, minuscule ou majuscule:/i
        preg_match_all($masque, $user, $resultat);
        var_dump(count($resultat[0]));
        if (count($resultat[0])!=0){
        return "le nom d'utilisateur ne doit comporter que des caractères alphanumériques ,sont également admis '-' et '_'";
        }