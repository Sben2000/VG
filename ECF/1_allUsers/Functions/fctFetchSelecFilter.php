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


//Vérification/écoute d'un éventuel POST possédant la clé "selectedRegime" (via une url)

if(isset($_POST['selectedRegime'])){

    //Récupèration de la valeur séléctionnée et transmise
    $selectedRegime = $_POST['selectedRegime'];
    //vérification de cette valeur
    //si la valeur est égale à "all"
    if($selectedRegime ==="all"){
        //on affiche toute les valeurs via la fonction dévellopée dans fctMenus.php
        $menus = getAllMenus();
    }else{
        //sinon affichage uniquement le régime selectionné en passant celui ci dans la function getMenusByRegimeOnly
        $menus = getMenusByRegimeOnly($selectedRegime);
    }
    //on renvoi le résultat au JS au format json

    echo json_encode($menus);
}

//Vérification/écoute d'un éventuel POST possédant la clé "selectedmaxPrice" (via une url)

if(isset($_POST['selectedMaxPrice'])){

    //Récupèration de la valeur séléctionnée et transmise
    $selectedMaxPrice = $_POST['selectedMaxPrice'];
    //vérification de cette valeur
    //si la valeur est égale à "all"
    if($selectedMaxPrice ==="all"){
        //on affiche toute les valeurs via la fonction dévellopée dans fctMenus.php
        $menus = getAllMenus();
    }else{
        //sinon affichage uniquement le prix max selectionné en passant celui ci dans la function getMenusByMaxPriceOnly
        $menus = getMenusByMaxPriceOnly($selectedMaxPrice);
    }
    //on renvoi le résultat au JS au format json

    echo json_encode($menus);
}

//Vérification/écoute d'un éventuel POST possédant la clé "selectedPriceRange" (via une url)

if(isset($_POST['selectedPriceRange'])){

    //Récupèration de la valeur séléctionnée et transmise
    $selectedPriceRange = $_POST['selectedPriceRange'];
    //vérification de cette valeur
    //si la valeur est égale à "all"
    if($selectedPriceRange ==="all"){
        //on affiche toute les valeurs via la fonction dévellopée dans fctMenus.php
        $menus = getAllMenus();
    }elseif($selectedPriceRange ==="45"){
    //on affiche toute les valeurs supérieur à la valeur via la fonction dévellopée dans fctMenus.php
    $menus = getMenuUpperPrices($selectedPriceRange); 
    }else{
        //sinon définir le range min et max et les envoyer pour traitement dans la function getMenusByPriceRange
        //valeur min de la plage
        $selectedPriceRangeMin = $selectedPriceRange;
        //valeur max de la plage
        $selectedPriceRangeMax = $selectedPriceRange + 15;
        //les deux valeurs sont traités dans la function getMenusByPriceRange
        $menus = getMenusByPriceRange($selectedPriceRangeMin, $selectedPriceRangeMax);
    }
    //on renvoi le résultat au JS au format json

    echo json_encode($menus);
}

//Vérification/écoute d'un éventuel POST possédant la clé "selectedThemePanel" (via une url)

if(isset($_POST['selectedThemePanel'])){

    //Récupèration de la valeur séléctionnée et transmise
    $selectedThemePanel = $_POST['selectedThemePanel'];
    //vérification de cette valeur
    //si la valeur est égale à "all"
    if($selectedThemePanel ==="all"){
        //on affiche toute les valeurs via la fonction dévellopée dans fctMenus.php
        $menus = getAllMenus();
    }else{
        //sinon affichage uniquement le theme selectionné en passant celui ci dans la function getMenusByThemeOnly
        $menus = getMenusByThemeOnly($selectedThemePanel);
    }
    //on renvoi le résultat au JS au format json

    echo json_encode($menus);
}