/******************************Function importée_NavHeader***********************************/
//Function importée et dévellopée dans scriptHeader.js
import {mainNav} from './scriptHeader.js';
mainNav();

/******************************JS APPLIQUE A l'AFFICHAGE OU MASQUAGE DES COMMANDES*************************/

// Gestion Ouverture/Fermeture des commandes

//input
const showMyOrders = document.getElementById('showMyOrders');
const hideMyOrders = document.getElementById('hideMyOrders');
//fenêtre des commandes à afficher/masquer
let myOrders = document.querySelector('.myOrders');
//Affichage au click
showMyOrders.addEventListener('click', ()=>{
     myOrders.style.display='block';
//Code ci dessous Rendu inactif pour le moment => les 2 boutons sont constamment montrés 
/*
     //input "Masquer" affiché et input "Afficher" Masqué
    hideMyOrders.style.display='block';
    showMyOrders.style.display='none';
*/
        
}
)

//Fermeture au click sur hideMyOrders

hideMyOrders.addEventListener('click', ()=>{
    myOrders.style.display='none';
//Code ci dessous Rendu inactif pour le moment => les 2 boutons sont constamment montrés 
/*
    //input "Masquer" masqué et input "Afficher" affiché
    hideMyOrders.style.display='none';
    showMyOrders.style.display='block';
*/
}
)

/*****************************Gestion de la Modal de déconnexion de compte lors du clic sur bouton deconnexion de la page "MonCompte********************************/

/*Gestion Modal de déconnexion userAccount.php*/
const disconnectAccount = document.querySelector(".disconnectAccount");
disconnectAccount.addEventListener("click",()=>{
    console.log('clicked');
    modal.style.display ="block";

})

/*Gestion Fermeture de la modale de déconnexion*/
    //=>géré dans le fichier JS du Header importé en tant que module en début de script (fonction mainNav()).

/*****************************Gestion de la Modal de suppression de compte liée à la page deleteAccount.php********************************/


/*Gestion Ouverture de la modale de deconnexion*/
const deleteAccount = document.getElementById('deleteAccount');
const modalDel = document.getElementById("modalDel")
deleteAccount.addEventListener("click",()=>{
console.log('clicked');
modalDel.style.display ="block";
})

/*Gestion Fermeture de la modale de déconnexion*/
const imgCloseModalDel= document.getElementById("imgCloseModalDel");
imgCloseModalDel.addEventListener("click",()=>{
     modalDel.style.display = "none";
})

