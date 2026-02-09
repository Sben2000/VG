/**************************Import des functions extérieures********************************/

//Function importée et dévellopée dans selectPlat.js
import {getPlatJS} from './selectPlat.js';

//Function importée et dévellopée dans selectAllerg.js
import {getAllergeneJS} from './selectAllergene.js';

/******************************Application de la Function importée de confirmation et représentation du plat sélectionné ********************************************************/


//Initialisation d'une variable de récupération id
let idPlat="" ;

//target de la valeur de la cible (e)  du selector et application de  getPlatJS pour afficher les éléments séléctionnés
selectorPlats.addEventListener("change", (e) => {
 getPlatJS(e.target.value);
 //assignation de l'id de la target à la variable de récupération
 idPlat = e.target.value;


})


/******************************Application de la Function importée de confirmation et représentation de l'Allergène sélectionné ********************************************************/
//Initialisation d'une variable de récupération id
let idAllergene="" ;


//target de la valeur de la cible (e)  du selector et application de  getAllergeneJS pour afficher les éléments séléctionnés
selectorAllergenes.addEventListener("change", (e) => {
getAllergeneJS(e.target.value);
 //assignation de l'id de la target à la variable de récupération
idAllergene = e.target.value;

})