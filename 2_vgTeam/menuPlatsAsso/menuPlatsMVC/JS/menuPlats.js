/**************************Import des functions extérieures********************************/

//Function importée et dévellopée dans selectPlat.js
import {getPlatJS} from './selectPlat.js';

//Function importée et dévellopée dans selectMenu.js
import {getMenuJS} from './selectMenu.js';

/******************************Application de la Function importée de confirmation et représentation du plat sélectionné ********************************************************/


//Initialisation d'une variable de récupération id
let idPlat="" ;

//target de la valeur de la cible (e)  du selector et application de  getPlatJS pour afficher les éléments séléctionnés
selectorPlats.addEventListener("change", (e) => {
 getPlatJS(e.target.value);
 //assignation de l'id de la target à la variable de récupération
 idPlat = e.target.value;


})


/******************************Application de la Function importée de confirmation et représentation du Menu sélectionné ********************************************************/
//Initialisation d'une variable de récupération id
let idMenu="" ;


//target de la valeur de la cible (e)  du selector et application de  getMenuJS pour afficher les éléments séléctionnés
selectorMenus.addEventListener("change", (e) => {
getMenuJS(e.target.value);
 //assignation de l'id de la target à la variable de récupération
idMenu = e.target.value;

})