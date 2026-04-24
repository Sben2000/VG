/*****Application des choix de selection de status*****/

let successMessage = document.querySelector('.successMessage');
let infoMessage = document.querySelector('.infoMessage');
let errorMessage = document.querySelector('.errorMessage');
let Btn = document.querySelector('#Btn');
let currentStatus=document.querySelector('#currentStatus');

//Attribution de la valeur de la selection du Filtre (statut) à l'input newStatus 
selectFilter = document.getElementById('selectFilter');
newStatus = document.getElementById('newStatus');

//Contrôle des données sélectionnées ou non

selectFilter.addEventListener("change", (e) => {
 newStatus.value = e.target.value;
console.log(currentStatus.value);
console.log(newStatus.value);
   //contrôle du contenu des inputs
  if(newStatus.value == currentStatus.value){
    console.log(true);
    errorMessage.innerHTML="Statut choisi identique à celui existant ";
    infoMessage.innerHTML="=>Veuillez sélectionner un statut de substitution conforme pour pouvoir Modifier";
    successMessage.innerHTML="";
    //Le Bouton n'est toujours pas rendu dispo
    Btn.disabled = true;
    return false;
  }
    if(newStatus.value == "none"){
    errorMessage.innerHTML="Veuillez sélectionner un nouveau statut";
    infoMessage.innerHTML="=>Veuillez sélectionner un statut de substitution conforme pour pouvoir Modifier";
    successMessage.innerHTML="";
    //Le Bouton n'est toujours pas rendu dispo
    Btn.disabled = true;
    return false;
  }
  else{
    errorMessage.innerHTML="";
    infoMessage.innerHTML="";
    successMessage.innerHTML="=>Vous pouvez désormais cliquer sur le bouton Modifier";
    //Le Bouton est enfin rendu dispo
    Btn.disabled = false;
  }
});

