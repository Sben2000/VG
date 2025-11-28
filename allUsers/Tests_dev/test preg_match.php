<?php
$arg='QS';
$masque = "/[<>\'\"]/";
            
            preg_match_all($masque, $arg,$resultat);
            var_dump($resultat);
            echo count($resultat[0]);
            /*foreach($resultat as $k=>$v){
                       echo $v;}*/

            
            if(count($resultat)>1){//on compte par défaut au moins un resultat vide lorsqu'il n 'y a pas de match
            echo " < > \" \' characters are not allowed";
            }
        
?>