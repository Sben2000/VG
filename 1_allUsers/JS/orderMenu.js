/******************************Function importée_NavHeader***********************************/
//Function importée et dévellopée dans scriptHeader.js
import {mainNav} from './scriptHeader.js';
mainNav();



/******************************JS APPLIQUE A l'AFFICHAGE OU MASQUAGE DE COMMANDE*************************/

// Gestion Ouverture/Fermeture des commandes

//input
const displayOrderForm = document.getElementById('displayOrderForm');
const hideOrderForm = document.getElementById('hideOrderForm');
//fenêtre de commande à afficher/masquer
let orderSectionForm = document.querySelector('#orderSectionForm');
//Affichage au click
displayOrderForm.addEventListener('click', ()=>{
     orderSectionForm.style.display='block';
    
    //input "Masquer" affiché et input "Afficher" Masqué
    hideOrderForm.style.display='block';
    displayOrderForm.style.display='none';
    
       
}
)

//Fermeture

hideOrderForm.addEventListener('click', ()=>{
    orderSectionForm.style.display='none';
    //input "Masquer" masqué et input "Afficher" affiché
    hideOrderForm.style.display='none';
    displayOrderForm.style.display='block';
        

}
)