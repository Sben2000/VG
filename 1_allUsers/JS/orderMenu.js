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
//feedback sur nom de famille
let feedBackNameError = document.getElementById('feedBackNameError');
//Le prénom
let firstname = document.getElementById('firstname');
//feedback sur prénom
let feedBackFirstnameError = document.getElementById('feedBackFirstnameError');
//L'email
let email = document.getElementById('email');
//Le numéro de téléphone
let phoneNumber = document.getElementById('phoneNumber');
//feedback sur Numéro de téléphone
let feedBackPhoneError = document.getElementById('feedBackPhoneError');
//L'adresse
let adress = document.getElementById('adress');
//Le code postal
let postalCode = document.getElementById('postalCode');
//feedback sur input code Postal
let feedBackPostalCodeSuccess = document.getElementById('feedBackPostalCodeSuccess');
let feedBackPostalCodeError = document.getElementById('feedBackPostalCodeError');
//Info CodePostal
let postalCodeInfo = document.getElementById('postalCodeInfo');
//La date souhaitée, la date max et min affichées
let wishedDate = document.getElementById('wishedDate');
let wishedDateMax = wishedDate.max;
let wishedDateMin = wishedDate.min;
//feedback sur input wishedTime
let feedBackWishedDateSuccess = document.getElementById('feedBackWishedDateSuccess');
let feedBackWishedDateError = document.getElementById('feedBackWishedDateError');
//L'heure souhaitée
let wishedTime =  document.getElementById('wishedTime');
//feedback sur input wishedTime
let feedBackWishedTimeSuccess = document.getElementById('feedBackWishedTimeSuccess');
let feedBackWishedTimeError = document.getElementById('feedBackWishedTimeError');
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
let peopleNbrSpecTrim = peopleNbrSpec.value


/***Regex ci dessous ne fonctionne qu'avec un input = text pas avec un input = nombre *
//regex permettant de détecter tout les caractères non Digit ([^0-9]) sur le globale (g)
let regexNonDigit = /\D/g;
let matchMinPR = peopleNbrSpecTrim.match(regexNonDigit);
console.log(matchMinPR);
//Lorsque l'on convertit l'input en text et qu il existe un match (non détecté en type number),(caractères non autorisés détéctés), envoi d'un message d'erreur
   if(matchMinPR){
    feedBackPeopleError.innerHTML=`Veuillez entrer une quantité au <br>  format mentionné entre ${peopleNbrReq} et ${RemainingQty}`;
    feedBackPeopleSuccess.innerHTML ="";
	feedBackPeopleOtherInfo="";
	return false;
	
  }
*/

  //Vérifie si la valeur est un  Float (le modulo % du nombre sur la division par 1 est différent de zéro)
  const modulo = peopleNbrSpecTrim % 1;
  if(modulo != 0){
   feedBackPeopleError.innerHTML=`Seuls les nombres entiers <br> sont acceptés`;
    feedBackPeopleSuccess.innerHTML ="";
	feedBackPeopleOtherInfo="";
	return false;
  }
  //convertit en Int(=>parseInt) et contrôle complémentaire  du format 

  let peopleNbrSpecCleanValue = parseInt(peopleNbrSpecTrim);


  // si la valeur calculée est de type "NaN" ou si la valeur est vide , négative, égale à 0 
   if(isNaN(peopleNbrSpecCleanValue )|| peopleNbrSpecCleanValue  < 0){
    feedBackPeopleError.innerHTML=`Veuillez entrer une quantité au <br>  format mentionné entre ${peopleNbrReq} et ${RemainingQty}`;
    feedBackPeopleSuccess.innerHTML ="";
	feedBackPeopleOtherInfo="";
	return false;
  }



	//Nbr > quantité dispo (max value)

	if(peopleNbrSpecCleanValue > peopleNbrSpec.max){
		feedBackPeopleSuccess.innerHTML ="";
		feedBackPeopleError.innerHTML =`Quantité max disponible = ${RemainingQty}`; ;
		feedBackPeopleOtherInfo.innerHTML = "";
		return false;
	}
	//Nbr < min requis
	if(isNaN(peopleNbrSpecCleanValue)== false && peopleNbrSpec.value< peopleNbrSpec.min){
		feedBackPeopleSuccess.innerHTML = "";
		feedBackPeopleError.innerHTML = `Nbre Pers. min requis = ${peopleNbrReq}`;
		feedBackPeopleOtherInfo.innerHTML = "";	
		return false;
		
	}

//Nbr >5 et Nbr < Qté Max
 if (peopleNbrSpecCleanValue >=5 && peopleNbrSpecCleanValue <= RemainingQty){
		feedBackPeopleSuccess.innerHTML = `Réduction de ${ReducDix}% appliquée !`;
		nbrPersInfo.style.display = "none";
		reductionRate.value = ReducDix;
		feedBackPeopleError.innerHTML = "";
		feedBackPeopleOtherInfo.innerHTML = "";
			//Nbr = quantité dispo (max value)
		if(peopleNbrSpecCleanValue == RemainingQty){
		feedBackPeopleError.innerHTML ="" ;
		
		feedBackPeopleOtherInfo.innerHTML = "Quantité max atteinte";}


	}
}

//function de contrôle Code Postal
function checkPostalCode(){

//Trim de la valeur entrée par l'utilisateur
let postalCodeTrim = postalCode.value.trim()

//controle des données entrées dans l'input via un regex

//regex permettant de détecter tout les caractères non Digit ([^0-9]) sur le globale (g)
let regexNonDigit = /\D/g;
let matchPC = postalCodeTrim.match(regexNonDigit);
//console.log(match);
//si il existe un match ,(caractères non autorisés détéctés), envoi d'un message d'erreur
   if(matchPC){
    feedBackPostalCodeError.innerHTML="Code postal doit contenir <br> 5 chiffres, sans espace";
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


/***Construction d' iterateurs de tableaux pour vérifier si le code postal est eligible à la livraison***/

	//sur la table bordeaux
	const bordeauxIterator = bordeaux.values();
	//variable qui sera ou non incrémenté lors de l'iteration du tableau
	let bordeauxDelivery = 0;
	for (const value of bordeauxIterator){
		if(value == postalCodeCleanValue  ){
			bordeauxDelivery ++;
		}
	}

	//sur la table agglo
	const aggloIterator = agglo.values();
	//variable qui sera ou non incrémenté lors de l'iteration du tableau
	let aggloDelivery = 0;
	for (const value of aggloIterator){
		if (value == postalCodeCleanValue){
			aggloDelivery ++;
		}
	}

//Affichage de la possibilité de livraison et des frais en fonction des valeurs de bordeauxDelivery et aggloDelivery

if (bordeauxDelivery>0){
	feedBackPostalCodeError.innerHTML="";
    feedBackPostalCodeSuccess.innerHTML ="Livraison Offerte !";
	//la valeur de la livraison est à 0
	deliveryPrice.value = 0;
}else if(aggloDelivery>0){
	feedBackPostalCodeError.innerHTML="";
    feedBackPostalCodeSuccess.innerHTML ="Votre commune bénéficie <br> de la livraison à 5&#x20AC";
	//la valeur de la livraison est à 5
	deliveryPrice.value = 5;
}else{
	feedBackPostalCodeError.innerHTML="Désolé, livraison non prévue hors  <br>  agglo. via commande en ligne <br> Veuillez nous contacter ";
    feedBackPostalCodeSuccess.innerHTML ="";
	return false
}

}

//function de contrôle du numéro de téléphone
function checkPhoneNumber(){

	
//Trim de la valeur entrée par l'utilisateur
let phoneNumberTrim = phoneNumber.value.trim()

//controle des données entrées dans l'input via un regex

//regex permettant de détecter tout les caractères non Digit ([^0-9]) sur le globale (g)
let regexNonDigit = /\D/g;
let matchPH = phoneNumberTrim.match(regexNonDigit);
//console.log(matchPH);
//si il existe un match ,(caractères non autorisés détéctés), envoi d'un message d'erreur
   if(matchPH){
    feedBackPhoneError.innerHTML="Uniquement chiffres,<br> sans espace";
	return false;
  }

//Vérification de la longueur du numéro de tél

//regex permettant de détecter un match de 10 digits :/\d{10}/
let regexTenDigit = /\d{10}/;
let matchTenDigit = phoneNumberTrim.match(regexTenDigit);

//regex permettant de détecter un match de plus de 15 digits (Au moins 16) :/\d{16}/
let regexSixteenDigit = /\d{16}/;
let matchSixteenDigit = phoneNumberTrim.match(regexSixteenDigit);

//regex permettant de détecter un match correct entre 10 et 15  digits :/\d{10,16}/
let regexDigitOK = /\d{10,16}/;
let matchDigitOK = phoneNumberTrim.match(regexDigitOK);

//si il n'existe pas de match d'au moins 10 digits, envoi d'un message d'erreur
   if(! matchTenDigit){
    feedBackPhoneError.innerHTML="Le numéro  ne peut être <br> inférieur à 10 chiffres";

	return false;
 }

//si il existe un de match d'au moins 16 digits, envoi d'un message d'erreur
    if(matchSixteenDigit){
    feedBackPhoneError.innerHTML="le numero ne peut <br> dépasser  15 chiffres <br> en incluant l'indicatif";
	return false;
  }
  //si il existe un de match entre 10 et 15 digits, enlever les messages d'erreurs
  if(matchDigitOK) {
	feedBackPhoneError.innerHTML="";
  }


  //convertit en Int(=>parseInt) (si format récupéré de userProfil considéré string ou autre type) 

  let phoneNumberTrimCleanValue = parseInt(phoneNumberTrim);

}


function checkWishedDate(){
	//Conversion des dates (entrées, min et max) en objet Date JavaScript:
let	wishedDateJSvalue = new Date(wishedDate.value);
	//console.log(wishedDateJSvalue);
	//console.log(wishedDateJSvalue.getTime());
	wishedDateMin = new Date(wishedDateMin);
	wishedDateMax = new Date(wishedDateMax);
	//Le regex pour contrôler le format n'est pas utile car celui ci est déjà vérouillé par le format HTML

	//Contrôle si la date entrée est dans l'intervalle imposée
		//transformation des dates : entrée , min et max en temps millsecondes (écoulées depuis le premier janvier 1970, 00:00:00 UTC)
		const wishedDateTimeUTC = wishedDateJSvalue.getTime();
		const wishedDateMinTimeUTC = wishedDateMin.getTime();
		const wishedDateMaxTimeUTC = wishedDateMax.getTime();
		//si hors champs => renvoi d'un message d'erreur en rappelant la quinzaine en cours
		if (wishedDateTimeUTC > wishedDateMaxTimeUTC || wishedDateTimeUTC < wishedDateMinTimeUTC){
			feedBackWishedTimeSuccess.innerHTML = "";
			feedBackWishedTimeError.innerHTML = `Date hors quinzaine <br> 
			(du ${wishedDateMin.getUTCDate() + "/"+
			/*Note : .getUTCMonth() de 0 à 11 ==> ajouté +1)
			En fonction de la valeur de .getUTCMonth, un 0 et ajouté ou pas au mois avant  (cf. fonction ternaire)*/
				(wishedDateMin.getUTCMonth()<9 ? "0" : "")+
				+((wishedDateMin.getUTCMonth())+1) + 
				"/"+ wishedDateMin.getUTCFullYear() } 

			<br> au 
			
			${wishedDateMax.getUTCDate() + "/"+
				(wishedDateMax.getUTCMonth()<9 ? "0" : "")+
				+((wishedDateMax.getUTCMonth())+1) + "/"+
				 wishedDateMax.getUTCFullYear() })`
		return false
		}
		//Si date choisie est une date non ouvrée pour la livraison (dimanche =>getDay==0)
	else if (wishedDateJSvalue.getUTCDay()==0){
			feedBackWishedTimeSuccess.innerHTML = "";
			feedBackWishedTimeError.innerHTML = "Pas de livraison <br> le dimanche";
			return false
		}
		 

		//si dans le champs et hors jours chomé=> renvoi d'un message de la date sélectionnée dans success
	//if (wishedDateTimeUTC <= wishedDateMaxTimeUTC && wishedDateTimeUTC >= wishedDateMinTimeUTC &&wishedDate.getUTCDay()!=0){
	else{ feedBackWishedTimeSuccess.innerHTML = `Date sélectionnée : <br>
			<span style="text-align:center;">
			${wishedDateJSvalue.getUTCDate() + "/"+
			/*Note : .getUTCMonth() de 0 à 11 ==> ajouté +1)
			En fonction de la valeur de .getUTCMonth, un 0 et ajouté ou pas au mois avant  (cf. fonction ternaire)*/
				(wishedDateJSvalue.getUTCMonth()<9 ? "0" : "")+
				+((wishedDateJSvalue.getUTCMonth())+1) + 
				"/"+ wishedDateJSvalue.getUTCFullYear() } 
			</span>`;
			feedBackWishedTimeError.innerHTML = "";

		// conclusion avec attribution de cleanValue à la valeur choisie
		let wishedDateCleanValue = wishedDateJSvalue;
		}


	}


//function de contrôle du nom 

function checkName(){

	
//Trim de la valeur entrée par l'utilisateur
let nameTrim = name.value.trim()


//controle des données entrées dans l'input via un regex
//Tout ce qui est un non word (\W) ou un digit(\d) sauf (?!) - ou _ (-|_)
let regexNonWord = /(?!-|_)[\W\d]/g;
let matchNW = nameTrim.match(regexNonWord);
//console.log(matchNW);

//si il existe un match ,(caractères non autorisés détéctés), envoi d'un message d'erreur
   if(matchNW){
    feedBackNameError.innerHTML="Uniquement lettres, - ou _<br> sans espace";
	return false;
  }

//Vérification de la longueur du nom

//regex permettant de détecter un match de 21 lettres (case insensitive)
let regexTwenOneLetter = /[a-z]{21}/i;
let matchTwenOneLetters= nameTrim.match(regexTwenOneLetter);
//console.log(matchTwenOneLetter);
//regex permettant de détecter un match d'une lettre unique (case insensitive)
let regexTwoLetters = /[a-z]{2}/i;
let matchTwoLetters= nameTrim.match(regexTwoLetters);

//regex permettant de détecter un match correct entre 2 et 20 lettres :
let regexNameLengthOK = /[a-z]{2,20}/i;
let matchNameLengthOK = nameTrim.match(regexNameLengthOK);

//si il n'existe pas de nom d'au moins 2 lettres, envoi d'un message d'erreur
   if(!matchTwoLetters){
    feedBackNameError.innerHTML="Le nom ne contient pas <br> assez de lettres";
	return false;
 }

//si il existe un de match d'au moins 21 lettres, envoi d'un message d'erreur
    if(matchTwenOneLetters){
    feedBackNameError.innerHTML="le nom contient <br> trop de lettres";
	return false;
  }
  //si il existe un de match entre 2 et 20 lettres, enlever les messages d'erreurs
  if(matchNameLengthOK) {
	feedBackNameError.innerHTML="";

//On attribue à clean Value la valeur du nom Trim validée

  let nameTrimCleanValue = nameTrim;
  }



}


/*******************Intéractivité affichage avant soumission***************************** */

/******Interactivités utilisant les événement input/change*****/

//Affichage du message d'Info Nbre Pers en fonction de la valeur indiqué (nbre de personnes indiqué, caractère non numérique,...)
peopleNbrSpec.addEventListener("input", minPersRequest);

//Affichage du message d'info CodePostal en fonction de la valeur indiqué (nbre de digit, caractère non numérique,...)
postalCode.addEventListener("change", checkPostalCode);

//Affichage du message d'info phoneNumber souhaitée en fonction de la valeur indiqué (date hors champs, hors jour ouvré entreprise,...)
phoneNumber.addEventListener("change", checkPhoneNumber);

//Affichage du message d'info Date souhaitée en fonction de la valeur indiqué (date hors champs, hors jour ouvré entreprise,...)
wishedDate.addEventListener("change", checkWishedDate);

//Affichage du message d'info Nom en fonction de la valeur indiqué (date hors champs, hors jour ouvré entreprise,...)
name.addEventListener("change", checkName);

