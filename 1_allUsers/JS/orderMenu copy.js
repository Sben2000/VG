/******************************Function importée_NavHeader***********************************/
//Function importée et dévellopée dans scriptHeader.js
import {mainNav} from './scriptHeader.js';
mainNav();

/**************************Gestion des redirections des boutons de la page****************************** */


//Récupération du Bouton "previous page" et chargement de la page précédente au click
let previousPage = document.querySelector("#closePage");
previousPage.addEventListener("click", function(){
	//=>Ferme la page,
	window.close();
});


// Gestion Ouverture/Fermeture de la fenêtre "commandes"

//boutons Ouvertures (Commander) /Fermetures (Annuler)
let orderButton = document.querySelector("#orderButton");
let cancelOrderProcess = document.querySelector('#cancelOrderProcess');
//le footer (en cas de réajustement)
let footer = document.querySelector('.footer');
//fenêtre de commande à afficher/masquer
let orderSectionForm = document.querySelector("#orderSectionForm");

//Affichage au click
orderButton.addEventListener('click', ()=>{
     orderSectionForm.style.display='block';
});

//Masquage lors de l'annulation
cancelOrderProcess.addEventListener('click', ()=>{
	orderSectionForm.style.display = 'none'
	//Le footer est repositionné au niveau bottom:0 si décalage vers le haut (tendance à remonter un peu lors de la fermeture)
	footer.style.position= "fixed";
	footer.style.bottom = 0;
});



/*******************Déclaration des variables nécessaires à la soumission de la commande et représentant les éléments du DOM***************************** */
/****Eléments ou Valeurs des éléments renseignés dans la présentation du menu (innerText):*****/
//titre du menu
let heading = document.getElementById('heading').innerText;
//Thème du menu
let ThemeMenu = document.getElementById('ThemeMenu').innerText;
//Régime du menu
let RegimeMenu = document.getElementById('RegimeMenu').innerText;
//Nbre personnes min requis
let peopleNbrReq = document.getElementById('peopleNbrReq').innerText;
//Quantité restante
let RemainingQty = document.getElementById('RemainingQty').innerText;
//prix du menu
let priceMenu = document.getElementById('priceMenu').innerText;

/**** Eléments renseignés dans le formulaire (value):*****/
//Le Formulaire au complet
let myForm =  document.getElementById('orderForm');
//Le nom de famille
let name = document.getElementById('name');
//Le prénom
let firstname = document.getElementById('firstname');
//L'email
let email = document.getElementById('email');
//Le numéro de téléphone
let phoneNumber = document.getElementById('phoneNumber');
//L'adresse
let adress = document.getElementById('adress');
//Le code postal
let postalCode = document.getElementById('postalCode');
//feedback sur input code Postal
let feedBackPostalCodeSuccess = document.getElementById('feedBackPostalCodeSuccess');
let feedBackPostalCodeError = document.getElementById('feedBackPostalCodeError');
//Info CodePostal
let postalCodeInfo = document.getElementById('postalCodeInfo');
//La date souhaitée
let wishedDate = document.getElementById('wishedDate');
//L'heure souhaitée
let wishedTime =  document.getElementById('wishedTime');
//Titre du menu
let menuTitle = document.getElementById('menuTitle');
//Nbre de personnes précisé
let peopleNbrSpec = document.getElementById('peopleNbrSpec');
//Info Nbre personnes 
let nbrPersInfo = document.getElementById('nbrPersInfo');
//Message de Nbre requis min
let messageMinReq = document.getElementById('messageMinReq');
//Message de condition de réduction
let discount = document.getElementById('discount');
//feedback sur input Nbre de personne
let feedBackPeopleSuccess = document.getElementById('feedBackPeopleSuccess');
let feedBackPeopleError = document.getElementById('feedBackPeopleError');
let feedBackPeopleOtherInfo = document.getElementById('feedBackPeopleOtherInfo');
//Prix affiché
let priceMenuDisp = document.getElementById('priceMenuDisp');
//Réduction accordée
let reductionRate = document.getElementById('reductionRate');
//Prix de livraison calculé
let deliveryPrice = document.getElementById('deliveryPrice');
//Prix total
let totalPrice =  document.getElementById('totalPrice');


/******************Functions /variables générales utilisées pour une ou plusieurs analyses du formulaire************/

//Réduction de 10% dès 5 pers.

let ReducDix = 10;

//Code postaux
let agglo = [33440, 33810, 33370, 33530, 33130, 33290, 33000, 33270, 33110, 33520, 33560, 33150, 33320, 33270, 33170, 33185, 33310, 33127, 33700, 33290, 33600, 33160, 33440, 33160, 33440, 33320, 33400, 33140]
let bordeaux =[30072, 33000, 33100, 33200, 33300, 33800]

//function de contrôle du minimum de Personne requis

function minPersRequest(){

//Trim de la valeur entrée par l'utilisateur
let peopleNbrSpecTrim = peopleNbrSpec.value.trim()

//controle des données entrées dans l'input via un regex

//regex permettant de détecter tout les caractères non Digit ([^0-9]) sur le globale (g)
let regexNonDigit = /\D/g;
let match = peopleNbrSpecTrim.match(regexNonDigit);
//console.log(match);
//si il existe un match ,(caractères non autorisés détéctés), envoi d'un message d'erreur
   if(match){
    feedBackPeopleError.innerHTML=`Veuillez entrer une quantité au <br>  format mentionné entre ${peopleNbrReq} et ${RemainingQty}`;
    feedBackPeopleSuccess.innerHTML ="";
	feedBackPeopleOtherInfo="";
	return false;
  }

  //convertit en Int(=>parseInt) et contrôle complémentaire  du format 

  let peopleNbrSpecCleanValue = parseInt(peopleNbrSpecTrim);

  // si la valeur calculée est de type "NaN" ou si la valeur est vide , négative, égale à 0 ou Float (le reminder %1 différent de zéro)
   if(peopleNbrSpecCleanValue * 2 =="NaN" || peopleNbrSpecCleanValue * 2 =="" || peopleNbrSpecCleanValue * 2 < 0 
	|| peopleNbrSpecCleanValue == 0 ){
    feedBackPeopleError.innerHTML=`Veuillez entrer une quantité au <br>  format mentionné entre ${peopleNbrReq} et ${RemainingQty}`;
    feedBackPeopleSuccess.innerHTML ="";
	feedBackPeopleOtherInfo="";
	return false;
  }


//Nbr >5 et Nbr < Qté Max
else if (peopleNbrSpecCleanValue >=5 && peopleNbrSpecCleanValue <= RemainingQty){
		feedBackPeopleSuccess.innerHTML = `Réduction de ${ReducDix}% appliquée !`;
		nbrPersInfo.style.display = "none";
		reductionRate.value = ReducDix;
		feedBackPeopleError.innerHTML = "";
		feedBackPeopleOtherInfo.innerHTML = "";
			//Nbr = quantité dispo (max value)
		if(peopleNbrSpecCleanValue == RemainingQty){
		feedBackPeopleError.innerHTML ="" ;
		
		feedBackPeopleOtherInfo.innerHTML = "Quantité max atteinte";}

	//Nbr > quantité dispo (max value)
	}else if(peopleNbrSpecCleanValue > peopleNbrSpec.max){
		feedBackPeopleSuccess.innerHTML ="";
		feedBackPeopleError.innerHTML =`Quantité max disponible = ${RemainingQty}`; ;
		feedBackPeopleOtherInfo.innerHTML = "";
		return false;
	
	//Nbr < min requis
	}else if(isNaN(peopleNbrSpecCleanValue)== false && peopleNbrSpec.value< peopleNbrSpec.min){
		feedBackPeopleSuccess.innerHTML = "";
		feedBackPeopleError.innerHTML = `Nbre Pers. min requis = ${peopleNbrReq}`;
		feedBackPeopleOtherInfo.innerHTML = "";	
		return false;
		
	}else{
		nbrPersInfo.style.display ="block";
		nbrPersInfo.style.style = "#note"
		feedBackPostalCodeSuccess.innerHTML = "";
		reductionRate.value = 0;
	}
}

function checkPostalCode(){

//Trim de la valeur entrée par l'utilisateur
let postalCodeTrim = postalCode.value.trim()

//controle des données entrées dans l'input via un regex

//regex permettant de détecter tout les caractères non Digit ([^0-9]) sur le globale (g)
let regexNonDigit = /\D/g;
let match = postalCodeTrim.match(regexNonDigit);
//console.log(match);
//si il existe un match ,(caractères non autorisés détéctés), envoi d'un message d'erreur
   if(match){
    feedBackPostalCodeError.innerHTML="Code postal doit contenir <br> 5 chiffres et sans espace";
    feedBackPostalCodeSuccess.innerHTML ="";
	return false;
  }



//regex permettant de détecter un match de 5 digits :/\d{5}/
let regexFiveDigit = /\d{5}/;
let matchFiveDigit = postalCodeTrim.match(regexFiveDigit);
//console.log(matchFiveDigit);
//si il n'existe pas de match d'au moins 5 digits, envoi d'un message d'erreur
   if(! matchFiveDigit){
    feedBackPostalCodeError.innerHTML="Le code postal doit contenir <br> 5 chiffres";
    feedBackPostalCodeSuccess.innerHTML ="";
	return false;
  }
//regex permettant de détecter un match de plus de 5 digits (Au moins 6) :/\d{6}/
let regexSixDigit = /\d{6}/;
let matchSixDigit = postalCodeTrim.match(regexSixDigit);
//console.log(matchSixDigit);
//si il existe un de match d'au moins 6 digits, envoi d'un message d'erreur
   if(matchSixDigit){
    feedBackPostalCodeError.innerHTML="Le code postal ne doit pas <br>contenir  plus de 5 chiffres";
    feedBackPostalCodeSuccess.innerHTML ="";
	return false;
  }

  //convertit en Int(=>parseInt) (si format récupéré de userProfil considéré string ou autre type) 

  let postalCodeCleanValue = parseInt(postalCodeTrim);



//Nbr >5 et Nbr < Qté Max
 if (postalCodeCleanValue >=5 && postalCodeCleanValue <= RemainingQty){
		feedBackPostalCodeSuccess.innerHTML = `Réduction de ${ReducDix}% appliquée !`;
		nbrPersInfo.style.display = "none";
		reductionRate.value = ReducDix;
		feedBackPostalCodeError.innerHTML = "";
		feedBackPostalCodeOtherInfo.innerHTML = "";
			//Nbr = quantité dispo (max value)
		if(postalCodeCleanValue == RemainingQty){
		feedBackPostalCodeError.innerHTML ="" ;
		
		feedBackPostalCodeOtherInfo.innerHTML = "Quantité max atteinte";}

	//Nbr > quantité dispo (max value)
	}else if(postalCodeCleanValue > postalCode.max){
		feedBackPostalCodeSuccess.innerHTML ="";
		feedBackPostalCodeError.innerHTML =`Quantité max disponible = ${RemainingQty}`; ;
		return false;
	
	//Nbr < min requis
	}else if(isNaN(postalCodeCleanValue)== false && postalCode.value< postalCode.min){
		feedBackPostalCodeSuccess.innerHTML = "";
		feedBackPostalCodeError.innerHTML = `Nbre Pers. min requis = ${peopleNbrReq}`;
		feedBackPostalCodeOtherInfo.innerHTML = "";	
		return false;
		
	}else{
		nbrPersInfo.style.display ="block";
		nbrPersInfo.style.style = "#note"
		feedBackPostalCodeSuccess.innerHTML = "";
		reductionRate.value = 0;
	}


}




/*******************Intéractivité affichage avant soumission***************************** */

/******Interactivités utilisant les événement input/change*****/

//Affichage du message d'Info Nbre Pers en fonction de la valeur indiqué (nbre de personnes indiqué, caractère non numérique,...)
peopleNbrSpec.addEventListener("change", minPersRequest);

//Affichage du message d'info CodePostal en fonction de la valeur indiqué (nbre de digit, caractère non numérique,...)
postalCode.addEventListener("change", checkPostalCode);













