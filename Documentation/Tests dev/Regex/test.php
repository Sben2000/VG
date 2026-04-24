<?php

$password = "aa11&AA.";
        //Vérification des caractères autorisés 
        $masque ="(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@_&%$!.]).+$)";
        preg_match_all($masque, $password, $resultat);
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




$ville="sdsds";
        $masque1 ="/[\W]/"; // Tout caractères n'étant pas considéré comme word =>exclut les tirets et apostrophes égalements";
        preg_match_all($masque1, $ville, $resultat1);
        var_dump($resultat1);
        $masque2 ="/[\d]/"; // Tout digit;
        preg_match_all($masque2, $ville, $resultat2);
        var_dump($resultat2);
        if (!empty($resultat1[0])||!empty($resultat2[0])){
        echo "la ville ne doit comporter que des lettres ";
        }

$adresse = "aaAA22";
        //Vérification des caractères autorisés (lettres (case insensitive) , - et _ ') uniquement (Upper&Lowercase)
        $masque1 ="/[^a-z_0-9\-\']/i"; //classe:[], ne contenant pas: ^(interne), les caractères: aàz - _ ', minuscule ou majuscule:/i*
         preg_match_all($masque1, $adresse, $resultat);
        var_dump($resultat[0]);
        if (count($resultat[0])!=0){
        return "les caractères spéciaux hormis  les tirets '-' '_' et apostrophe ' ne sont pas admis";
        }

        //si ok =>Vérification des caractères minimum requis (lettres et num de rue) 
        $masque ="(^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$)";
        preg_match_all($masque, $adresse, $result);
        if (empty($result[0])){
        echo "l'adresse doit comporter un numéro , un nom de rue, sont admis '-' et '_' ' , si pas de numéro de rue, noter 0";
        }


$ville="aze-2333";
        //Vérification des caractères autorisés (lettres (case insensitive) , - et _ ') uniquement (Upper&Lowercase)
        $masque ="/[^a-z_\-\']/i"; //classe:[], ne contenant pas: ^(interne), les caractères: aàz - _ ', minuscule ou majuscule:/i*
        preg_match_all($masque, $ville, $resultat);
        var_dump($resultat[0]);
        if (count($resultat[0])!=0){
        return "la ville ne doit comporter que des lettres ,sont également admis les tirets '-' '_' et apostrophe '";
        }



