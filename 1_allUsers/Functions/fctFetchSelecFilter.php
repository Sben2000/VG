<?php

//requiert le fichier fctMenus.php pour récupérer ses potentielles fonctions
require_once "fctMenus.php";



//Vérification/écoute d'un éventuel POST possédant la clé "firstSelection" (via une url)

if(isset($_POST['firstSelection'])){

    //Récupèration de la valeur séléctionnée et transmise
    $firstSelection = $_POST['firstSelection'];
    //vérification de cette valeur
    //si la valeur est égale à "all"
    if($firstSelection ==="all"){
        //on affiche toute les valeurs via la fonction dévellopée dans fctMenus.php
        $menus = getAllMenus();
    }
    //on renvoi le résultat au JS au format json

    echo json_encode($menus);
}






//Vérification/écoute d'un éventuel POST possédant la clé "selectedTheme" (via une url)

if(isset($_POST['selectedTheme'])){

    //Récupèration de la valeur séléctionnée et transmise
    $selectedTheme = $_POST['selectedTheme'];
    //vérification de cette valeur
    //si la valeur est égale à "all"
    if($selectedTheme ==="all"){
        //on affiche toute les valeurs via la fonction dévellopée dans fctMenus.php
        $menus = getAllMenus();
    }else{
        //sinon affichage uniquement le theme selectionné en passant celui ci dans la function getMenusByThemeOnly
        $menus = getMenusByThemeOnly($selectedTheme);
    }
    //on renvoi le résultat au JS au format json

    echo json_encode($menus);
}