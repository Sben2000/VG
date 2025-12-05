<?php

$Table1=["animal"=>"oiseau", "caractéristiques"=>"vol"];

$Table2=["nourriture"=>"graines", "possede"=>"bec"];

$Table3 = array_merge($Table1, $Table2);//merge les 2 Tables associatifs

var_dump($Table3);

/*
array(4) {
  ["animal"]=>
  string(6) "oiseau"
  ["caractéristiques"]=>
  string(3) "vol"
  ["nourriture"]=>
  string(7) "graines"
  ["possede"]=>
  string(3) "bec"
}
*/