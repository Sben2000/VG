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
    
    //input "Masquer" affiché et input "Afficher" Masqué
    hideMyOrders.style.display='block';
    showMyOrders.style.display='none';
    
       
}
)

//Fermeture au click sur hideMyOrders

hideMyOrders.addEventListener('click', ()=>{
    myOrders.style.display='none';
    //input "Masquer" masqué et input "Afficher" affiché
    hideMyOrders.style.display='none';
    showMyOrders.style.display='block';
        

}
)
/******************************JS APPLIQUE A l'AFFICHAGE OU MASQUAGE DES DETAILS DE COMMANDES*************************/

// Gestion Ouverture/Fermeture des détails commandes

//input
const showDetails = document.getElementById('showDetails');
const hideDetails = document.getElementById('hideDetails');
//fenêtre des détails de commande à afficher/masquer
let orderDetails = document.querySelector('.orderDetails');
//Affichage au click
showDetails.addEventListener('click', ()=>{
    orderDetails.style.display='block';
    //input "Masquer" affiché et input "Afficher" Masqué
    hideDetails.style.display='block';
    showDetails.style.display='none';
       
}
)

//Fermeture au click sur hideDetails

hideDetails.addEventListener('click', ()=>{
    orderDetails.style.display='none';
    //input "Masquer" masqué et input "Afficher" affiché
    hideDetails.style.display='none';
    showDetails.style.display='block';
        

}
)
