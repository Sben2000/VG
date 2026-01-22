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

/*
//Lors du chargement de la page, masquer le formulaire de commande (si pas déjà fait en css via display : none)
window.addEventListener("load", () => {
   orderSectionForm.style.display='none';
});
*/

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
//feedback sur l'adresse
let feedBackAdressError = document.getElementById('feedBackAdressError');
//La ville
let cityName = document.getElementById('cityName');
//feedback sur input cityName
let feedBackCityNameError = document.getElementById('feedBackCityNameError');
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
//feedback sur input wishedDate
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
//Soumission du formulaire de commande
let submitOrder = document.getElementById('submitOrder');
//Message d'erreur et succès suite à submitOrder
let errorMessage =  document.getElementById('errorMessage');
let successMessage = document.getElementById('successMessage');
//Variable liées à la modal de confirmation commande
let modalOrder = document.getElementById('modalOrder');
const imgCloseModalOrder = document.getElementById('imgCloseModalOrder');
//formulaire de confirmation de commande
let formToConfirmOrder = document.getElementById('formToConfirmOrder');
//Div contenant les datas dans le formulaire de confirmation de commande
let SectionContentOrderConf = document.getElementById('SectionContentOrderConf');
//Container de demande enregistrement coordonnées
let recordDeliveryDatas = document.getElementById('recordDeliveryDatas');
//Boutons de confirmation de commande ou de retour
let confirmOrder = document.getElementById('confirmOrder');
let backToOrder = document.getElementById('backToOrder');

/******input des éléments du formulaire de confirmation apparaissant en modal */
//Le nom de famille
let nameCheckedJS = document.getElementById('nameCheckedJS');
//Le prénom
let firstnameCheckedJS = document.getElementById('firstnameCheckedJS');
//L'email
let emailCheckedJS = document.getElementById('emailCheckedJS');
//Le numéro de téléphone
let phoneNumberCheckedJS = document.getElementById('phoneNumberCheckedJS');
//L'adresse
let adressCheckedJS = document.getElementById('adressCheckedJS');
//La ville
let cityNameCheckedJS = document.getElementById('cityNameCheckedJS');
//Le code postal
let postalCodeCheckedJS = document.getElementById('postalCodeCheckedJS');
//La date souhaitée, la date max et min affichées
let wishedDateCheckedJS = document.getElementById('wishedDateCheckedJS');
//L'heure souhaitée
let wishedTimeCheckedJS =  document.getElementById('wishedTimeCheckedJS');
//Titre du menu
let menuTitleCheckedJS = document.getElementById('menuTitleCheckedJS');
//Nbre de personnes précisé
let peopleNbrSpecCheckedJS = document.getElementById('peopleNbrSpecCheckedJS');
//Prix affiché
let priceMenuDispCheckedJS = document.getElementById('priceMenuDispCheckedJS');
//Réduction accordée
let reductionRateCheckedJS = document.getElementById('reductionRateCheckedJS');
//Prix de livraison calculé
let deliveryPriceCheckedJS = document.getElementById('deliveryPriceCheckedJS');
//Prix total
let totalPriceCheckedJS =  document.getElementById('totalPriceCheckedJS');

//Liste des inputs cachés comportant les coordonnées originales de l'utilisateur enregistrés dans la dB
let nameHidden = document.getElementById('nameHidden');
let firstnameHidden = document.getElementById('firstnameHidden');
let phoneNumberHidden = document.getElementById('phoneNumberHidden');
let adressHidden = document.getElementById('adressHidden');
let cityNameHidden = document.getElementById('cityNameHidden');
let postalCodeHidden = document.getElementById('postalCodeHidden');

//La checkBox pour confirmer l'enregistrement des coordonnées
let recordDatasCheckBox = document.getElementById('recordDatasCheckBox');

/******************Functions /variables générales utilisées pour une ou plusieurs analyses du formulaire************/

//Réduction de 10% dès 5 pers.

let ReducDix = 10;
//Réduction de 0% si inférieur à 5 pers.
let ReducZero = 0;
//Code postaux
let agglo = [33440, 33810, 33370, 33530, 33130, 33290, 33000, 33270, 33110, 33520, 33560, 33150, 33320, 33270, 33170, 33185, 33310, 33127, 33700, 33290, 33600, 33160, 33440, 33160, 33440, 33320, 33400, 33140]
let bordeaux =[30072, 33000, 33100, 33200, 33300, 33800]


//function qui affiche le prix total si les éléments sont correctemt renseignés
function finalPrice(){
	//Calcul du prix final si la réduction, le prix de la livraison et le nbre de personnes ont déjà été évalués
//Nettoyage et conversion des valeurs en Int ou Float (si string) pour les operations (et éviter ainsi des concaténations avec "+")
let peopleNbrSpecTrim = peopleNbrSpec.value.trim();
let peopleNbrSpecCleanValue = parseInt(peopleNbrSpecTrim);
let reductionRateTrim = reductionRate.value.trim();
let reductionRateCleanValue = parseFloat(reductionRateTrim);
let deliveryPriceTrim = deliveryPrice.value.trim();
let deliveryPriceCleanValue = parseFloat(deliveryPriceTrim);
let priceMenuDispTrim = priceMenuDisp.value.trim();
let priceMenuDispCleanValue = parseFloat(priceMenuDispTrim);
//Condition d'affichage Total et calculs
	//si les inputs ne sont pas vides
	if(peopleNbrSpecCleanValue !="" && reductionRate.value !="" && deliveryPrice.value !=""){
		//calcul en utilisant les équivalents numériques
		let	reducPercent = 0.01 * (reductionRateCleanValue);
		totalPrice.value = (peopleNbrSpecCleanValue * priceMenuDispCleanValue * ( 1- reducPercent) + deliveryPriceCleanValue).toFixed(2);
		// on attribue également à totalPriceCheckedJS la valeur à affichée dans la modal de confirmation
		totalPriceCheckedJS.value = totalPrice.value;
	}else{
		totalPrice.value ="";
	};
}

//function de contrôle du minimum de Personne requis
function minPersRequest(){
//Trim de la valeur entrée par l'utilisateur
let peopleNbrSpecTrim = peopleNbrSpec.value.trim();


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
	if(isNaN(peopleNbrSpecCleanValue)== false && peopleNbrSpecCleanValue < peopleNbrSpec.min){
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
		
		feedBackPeopleOtherInfo.innerHTML = "Quantité max atteinte";};

	}else{
		reductionRate.value = ReducZero;
	}

	//Attribution des valeurs nettoyée/finales aux variables à afficher dans la modal de confirmation
	peopleNbrSpecCheckedJS.value = peopleNbrSpecCleanValue;
	reductionRateCheckedJS.value = reductionRate.value;

	//Lancement de la function finalPrice qui gérera l'affichage du total  en fonction des prix évalués ou non (livraison, nbre total de personnes*Menu, Réduction ) 
	
	finalPrice();

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

  //Attribution de la valeur nettoyée/finale à la variable à afficher dans la modal de confirmation

	postalCodeCheckedJS.value= postalCodeCleanValue;

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

//Attribution de la valeur nettoyée/finale à la variable à afficher dans la modal de confirmation

	deliveryPriceCheckedJS.value= deliveryPrice.value;

//Lancement de la function finalPrice qui gérera l'affichage du total  en fonction des prix évalués ou non (livraison, nbre total de personnes*Menu, Réduction ) 
	
	finalPrice();

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
/*Option colorisation bordure si message d'erreur ou pas, non appliquée à ce stade pour ne pas surcharger avec le texte rouge
    //Dans tous les cas, si il existe une erreur , la bordure est mis en rouge,
if(feedBackPhoneError.innerHTML != ""){
	console.log("test=ok");
	phoneNumber.style.border = "2px solid red";
	}else{
	//si l'erreur disparait, la bordure reprend son style normal
	phoneNumber.style.border= "";
	}
*/

  //convertit en Int(=>parseInt) (si format récupéré de userProfil considéré string ou autre type) 

  let phoneNumberTrimCleanValue = parseInt(phoneNumberTrim);

  //Attribution de la valeur nettoyée/finale à la variable à afficher dans la modal de confirmation

  phoneNumberCheckedJS.value = phoneNumberTrimCleanValue;

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
			feedBackWishedDateSuccess.innerHTML = "";
			feedBackWishedDateError.innerHTML = `Date hors quinzaine <br> 
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
			feedBackWishedDateSuccess.innerHTML = "";
			feedBackWishedDateError.innerHTML = "Pas de livraison <br> le dimanche";
			return false
		}
		 

		//si dans le champs et hors jours chomé=> renvoi d'un message de la date sélectionnée dans success
	//if (wishedDateTimeUTC <= wishedDateMaxTimeUTC && wishedDateTimeUTC >= wishedDateMinTimeUTC &&wishedDate.getUTCDay()!=0){
	else{ feedBackWishedDateSuccess.innerHTML = `Date sélectionnée : <br>
			<span style="text-align:center;">
			${wishedDateJSvalue.getUTCDate() + "/"+
			/*Note : .getUTCMonth() de 0 à 11 ==> ajouté +1)
			En fonction de la valeur de .getUTCMonth, un 0 et ajouté ou pas au mois avant  (cf. fonction ternaire)*/
				(wishedDateJSvalue.getUTCMonth()<9 ? "0" : "")+
				+((wishedDateJSvalue.getUTCMonth())+1) + 
				"/"+ wishedDateJSvalue.getUTCFullYear() } 
			</span>`;
			feedBackWishedDateError.innerHTML = "";

		  //Attribution de la valeur nettoyée/finale à la variable à afficher dans la modal de confirmation
		wishedDateCheckedJS.value = 			
						`${wishedDateJSvalue.getUTCDate() + "/"+
						/*Note : .getUTCMonth() de 0 à 11 ==> ajouté +1)
						En fonction de la valeur de .getUTCMonth, un 0 et ajouté ou pas au mois avant  (cf. fonction ternaire)*/
							(wishedDateJSvalue.getUTCMonth()<9 ? "0" : "")+
							+((wishedDateJSvalue.getUTCMonth())+1) + 
							"/"+ wishedDateJSvalue.getUTCFullYear() }`;
		}
	}


//function de contrôle du nom 
function checkName(){

	
//Trim de la valeur entrée par l'utilisateur
let nameTrim = name.value.trim()


//controle des données entrées dans l'input via un regex
//Tout ce qui est un non word (\W) ou un digit(\d) sauf (?!)- ou _ ou espace ou apostrophe ou toutes les lettres avec accent(-|_|\s|'|[À-ú])
let regexNonWord = /(?!-|_|\s|'|[À-ú])[\W\d]/g;
let matchNW = nameTrim.match(regexNonWord);
//console.log(matchNW);

//si il existe un match ,(caractères non autorisés détéctés), envoi d'un message d'erreur
   if(matchNW){
    feedBackNameError.innerHTML="Uniquement lettres, - ou _<br> sans espace";
	return false;
  }

//Vérification de la longueur du nom

//regex permettant de détecter un match de 21 lettres (case insensitive)
let regexTwenOneLetter = /[A-zÀ-ú]{21}/i;
let matchTwenOneLetters= nameTrim.match(regexTwenOneLetter);
//console.log(matchTwenOneLetter);
//regex permettant de détecter un match d'une lettre unique (case insensitive)
let regexTwoLetters = /[A-zÀ-ú]{2}/i;
let matchTwoLetters= nameTrim.match(regexTwoLetters);

//regex permettant de détecter un match correct entre 2 et 20 lettres :
let regexNameLengthOK = /[A-zÀ-ú]{2,20}/i;
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

//On attribue à nameCheckedJS la valeur du nom Trim validée

nameCheckedJS.value = nameTrim;
  }



}



//function de contrôle du prénom 
function checkFirstname(){

	
//Trim de la valeur entrée par l'utilisateur
let firstnameTrim = firstname.value.trim();


//controle des données entrées dans l'input via un regex
//Tout ce qui est un non word (\W) ou un digit(\d) sauf (?!) - ou _ ou espace ou apostrophe ou toutes les lettres avec accent(-|_|\s|'|[À-ú])
let regexNonWord = /(?!-|_|\s|'|[À-ú])[\W\d]/g;
let matchNW = firstnameTrim.match(regexNonWord);

//console.log(matchNW);

//si il existe un match ,(caractères non autorisés détéctés), envoi d'un message d'erreur
   if(matchNW){
    feedBackFirstnameError.innerHTML="Uniquement lettres, - ou _<br>ou espace si prénom composé";
	return false;
  }

//Vérification de la longueur du nom

//regex permettant de détecter un match de 21 lettres (case insensitive)
let regexTwenOneLetter = /[A-zÀ-ú]{21}/i;
let matchTwenOneLetters= firstnameTrim.match(regexTwenOneLetter);
//console.log(matchTwenOneLetter);
//regex permettant de détecter un match d'une lettre unique (case insensitive)
let regexTwoLetters = /[A-zÀ-ú]{2}/i;
let matchTwoLetters= firstnameTrim.match(regexTwoLetters);

//regex permettant de détecter un match correct entre 2 et 20 lettres :
let regexFirstnameLengthOK = /[a-z]{2,20}/i;
let matchFirstnameLengthOK = firstnameTrim.match(regexFirstnameLengthOK);

//si il n'existe pas de nom d'au moins 2 lettres, envoi d'un message d'erreur
   if(!matchTwoLetters){
    feedBackFirstnameError.innerHTML="Le prénom ne contient pas <br> assez de lettres";
	return false;
 }

//si il existe un de match d'au moins 21 lettres, envoi d'un message d'erreur
    if(matchTwenOneLetters){
    feedBackFirstnameError.innerHTML="le prénom contient <br> trop de lettres";
	return false;
  }
  //si il existe un de match entre 2 et 20 lettres, enlever les messages d'erreurs
  if(matchFirstnameLengthOK) {
	feedBackFirstnameError.innerHTML="";

  //Attribution de la valeur nettoyée/finale à la variable à afficher dans la modal de confirmation

  firstnameCheckedJS.value = firstnameTrim;
  }

}

//function de contrôle du nom de ville
function checkCityName(){
	
//Trim de la valeur entrée par l'utilisateur
let cityNameTrim = cityName.value.trim()

//controle des données entrées dans l'input via un regex
//Tout ce qui est un non word (\W) ou un digit(\d) sauf (?!)- ou _ ou espace ou apostrophe ou toutes les lettres avec accent(-|_|\s|'|[À-ú])
let regexNonWord = /(?!-|_|\s|'|[À-ú])[\W\d]/g;
let matchNW = cityNameTrim.match(regexNonWord);
//console.log(matchNW);

//si il existe un match ,(caractères non autorisés détéctés), envoi d'un message d'erreur
   if(matchNW){
    feedBackCityNameError.innerHTML="Uniquement lettres, - ou _<br>ou espace ";
	return false;
  }

//Vérification de la longueur du nom

//regex permettant de détecter un match de 21 lettres (case insensitive)
let regexTwenOneLetter = /([A-zÀ-ú]){21}/i;
let matchTwenOneLetters= cityNameTrim.match(regexTwenOneLetter);
//console.log(matchTwenOneLetter);
//regex permettant de détecter un match d'une lettre unique (case insensitive)
let regexTwoLetters = /[A-zÀ-ú]{2}/i;
let matchTwoLetters= cityNameTrim.match(regexTwoLetters);

//regex permettant de détecter un match correct entre 2 et 20 lettres :
let regexCityNameLengthOK = /[A-zÀ-ú]{2,20}/i;
let matchCityNameLengthOK = cityNameTrim.match(regexCityNameLengthOK);

//si il n'existe pas de nom d'au moins 2 lettres, envoi d'un message d'erreur
   if(!matchTwoLetters){
    feedBackCityNameError.innerHTML="Le nom de ville ne contient <br> pas  assez de lettres";
	return false;
 }

//si il existe un de match d'au moins 21 lettres, envoi d'un message d'erreur
    if(matchTwenOneLetters){
    feedBackCityNameError.innerHTML="le nom de ville contient <br> trop de lettres";
	return false;
  }
  //si il existe un de match entre 2 et 20 lettres, enlever les messages d'erreurs
  if(matchCityNameLengthOK) {
	feedBackCityNameError.innerHTML="";

//Attribution de la valeur nettoyée/finale à la variable à afficher dans la modal de confirmation
 cityNameCheckedJS.value = cityNameTrim;
  }

}

//function de contrôle du nom de ville
function checkAdress(){
	
//Trim de la valeur entrée par l'utilisateur
let adressTrim = adress.value.trim()

//controle des données entrées dans l'input via un regex
//Tout ce qui est un non word (\W) sauf (?!)- ou _ ou \.(point échappé) ou espace ou apostrophe ou toutes les lettres avec accent ou digit ou (-|_|\s|'|[À-ú] [\d])
let regexNonWord = /(?!-|_|\s|'|\.|[À-ú]|[\d])[\W]/g;
let matchNW = adressTrim.match(regexNonWord);
//console.log(matchNW);

//si il existe un match ,(caractères non autorisés détéctés), envoi d'un message d'erreur
   if(matchNW){
    feedBackAdressError.innerHTML="Uniquement N°, lettres, <br> - , _ , . ou espace ";
	return false;
  }

//Vérification de la longueur de l'adresse

//regex permettant de détecter un match de 31 lettres (case insensitive)
let regexTwenOneLetter = /([A-zÀ-ú]){31}/i;
let matchTwenOneLetters= adressTrim.match(regexTwenOneLetter);
//console.log(matchTwenOneLetter);
//regex permettant de détecter un match d'une lettre unique (case insensitive)
let regexTwoLetters = /[A-zÀ-ú]{2}/i;
let matchTwoLetters= adressTrim.match(regexTwoLetters);

//regex permettant de détecter un match correct entre 2 et 20 lettres :
let regexAdressLengthOK = /[A-zÀ-ú]{2,30}/i;
let matchAdressLengthOK = adressTrim.match(regexAdressLengthOK);

//si il n'existe pas de nom d'au moins 2 lettres, envoi d'un message d'erreur
   if(!matchTwoLetters){
    feedBackAdressError.innerHTML="L'adresse ne contient <br> pas  assez de lettres";
	return false;
 }

//si il existe un de match d'au moins 21 lettres, envoi d'un message d'erreur
    if(matchTwenOneLetters){
    feedBackAdressError.innerHTML="l'adresse' contient <br> trop de lettres";
	return false;
  }

  //Vérification de la présence et longueur du N°

//regex permettant de détecter un match de 6 N°
let regexSixNumbers = /([\d]){6}/g;
let matchSixNumbers= adressTrim.match(regexSixNumbers);
//console.log(matchTwenOneLetter);
//regex permettant de détecter un match d'un numero ([\d])
let regexNumber = /[\d]/g;
let matchNumber= adressTrim.match(regexNumber);
//console.log(matchNumber);

//regex permettant de détecter un match correct entre 1 et 5 chiffres :
let regexNumberLengthOK = /[\d]{1,5}/i;
let matchNumberLengthOK = adressTrim.match(regexNumberLengthOK);

//si il n'existe pas de nom d'au moins 1 N° , envoi d'un message d'erreur
   if(!matchNumber){
    feedBackAdressError.innerHTML="Un N° de rue requis <br>(écrire 0 si pas de N°)";
	return false;
 }

//si il existe un de match d'au moins 6 N°, envoi d'un message d'erreur
    if(matchSixNumbers){
    feedBackAdressError.innerHTML="le N° contient <br> trop de chiffres";
	return false;
  }


  //si il existe un de match entre 2 et 20 lettres, enlever les messages d'erreurs
  if(matchAdressLengthOK && matchNumberLengthOK) {
	feedBackAdressError.innerHTML="";

//Attribution de la valeur nettoyée/finale à la variable à afficher dans la modal de confirmation

adressCheckedJS.value = adressTrim;
  }

}


//function de contrôle du nom de ville
function checkTime(e){

//Valeur selectionnée (event.target.value)
let choosenRange = e.target.value;

//Affichage de la valeur séléctionnée
feedBackWishedTimeSuccess.innerHTML = `Plage sélectionnée :<br> ${choosenRange}`
//On enlève les éventuels messages d'erreurs
feedBackWishedTimeError.innerHTML="";


//Attribution de la valeur nettoyée/finale à la variable à afficher dans la modal de confirmation
wishedTimeCheckedJS.value = choosenRange;

}



/*******************Intéractivité affichage avant soumission***************************** */

/******Interactivités utilisant les événement input/change*****/

//Affichage du message d'Info Nbre Pers en fonction de la valeur indiquée (nbre de personnes indiqué, caractère non numérique,...)
peopleNbrSpec.addEventListener("input", minPersRequest);

//Affichage du message d'info CodePostal en fonction de la valeur indiquée (nbre de digit, caractère non numérique,...)
postalCode.addEventListener("change", checkPostalCode);

//Affichage du message d'info phoneNumber souhaitée en fonction de la valeur indiquée 
phoneNumber.addEventListener("change", checkPhoneNumber);

//Affichage du message d'info Date souhaitée en fonction de la valeur indiquée (date hors champs, hors jour ouvré entreprise,...)
wishedDate.addEventListener("change", checkWishedDate);

//Affichage du message d'info Nom en fonction de la valeur indiquée 
name.addEventListener("change", checkName);

//Affichage du message d'info Prénom en fonction de la valeur indiquée
firstname.addEventListener("change", checkFirstname);

//Affichage du message d'info Ville en fonction de la valeur indiquée 
cityName.addEventListener("change", checkCityName);

//Affichage du message d'info Adresse en fonction de la valeur indiquée 
adress.addEventListener("change", checkAdress);

//Affichage du message d'info Plage horaire en fonction de la valeur indiquée 
wishedTime.addEventListener("change", checkTime);

/**********Interactivité lorsque la page est chargée avec les données utilisateur déjà enregistrées (nécessaire au calcul du prix par ex)*********/

//postalCode pour calcul prix de livraison(si déjà enregistré dans le compte user)
if(postalCode.value !=""){
	checkPostalCode();
}


/*******************Contrôle /Validation ou Rejet après soumission***************************** */
  //via event.preventDefault() => pour Prévenir l'action par défaut 

//Function de contrôles à la soumission du formulaire
submitOrder.addEventListener("click", function(event){

  //temporisation de la soumission après série de contrôles
  event.preventDefault();

   //contrôle du nom

  	//si vide
  if(name.value==""){
    errorMessage.innerHTML="Le champs 'Nom' ne peut être vide ";
	feedBackNameError.innerHTML="&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;"
    return false;
  }
 //Cas non vide , si au changement de la valeur apparait un message d'erreur (cf.fonctions précédentes dans Intéractivité affichage avant soumission*)
if(feedBackNameError.innerHTML!=""){
	errorMessage.innerHTML="Veuillez corriger l'erreur du champs 'Nom' ";
	return false;
}

  //contrôle du prénom
  	//si vide
  if(firstname.value==""){
    errorMessage.innerHTML="Le champs 'Prénom' ne peut être vide ";
	feedBackFirstnameError.innerHTML="&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;"
    return false;
  }
 //Cas non vide , si au changement de la valeur apparait un message d'erreur (cf.fonctions précédentes dans Intéractivité affichage avant soumission*)
if(feedBackFirstnameError.innerHTML!=""){
	errorMessage.innerHTML="Veuillez corriger l'erreur du champs 'Prénom' ";
	return false;
}

 //contrôle du numéro de téléphone

  	//si vide
  if(phoneNumber.value==""){
    errorMessage.innerHTML="Le champs 'Numéro de téléphone' ne peut être vide ";
	feedBackPhoneError.innerHTML="&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;"
    return false;
  }
 //Cas non vide , si au changement de la valeur apparait un message d'erreur et tentative de submit (cf.fonctions précédentes dans Intéractivité affichage avant soumission*)
if(feedBackPhoneError.innerHTML!=""){
	errorMessage.innerHTML="Veuillez corriger l'erreur du N° de téléphone ";
	return false;
}

 //contrôle de l'adresse

  	//si vide
  if(adress.value==""){
    errorMessage.innerHTML="Le champs 'Adresse' ne peut être vide ";
	feedBackAdressError.innerHTML="&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;"
    return false;
  }
 //Cas non vide , si au changement de la valeur apparait un message d'erreur et tentative de submit (cf.fonctions précédentes dans Intéractivité affichage avant soumission*)
if(feedBackAdressError.innerHTML!=""){
	errorMessage.innerHTML="Veuillez corriger l'erreur du champs 'Adresse' ";
	return false;
}

 //contrôle de la ville

  	//si vide
  if(cityName.value==""){
    errorMessage.innerHTML="Le champs 'Ville' ne peut être vide ";
	feedBackCityNameError.innerHTML="&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;"
    return false;
  }
 //Cas non vide , si au changement de la valeur apparait un message d'erreur et tentative de submit (cf.fonctions précédentes dans Intéractivité affichage avant soumission*)
if(feedBackCityNameError.innerHTML!=""){
	errorMessage.innerHTML="Veuillez corriger l'erreur du champs 'Ville' ";
	return false;
}

 //contrôle du code Postal

  	//si vide
  if(postalCode.value==""){
    errorMessage.innerHTML="Le Code Postal ne peut être vide ";
	feedBackPostalCodeError.innerHTML="&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;"
    return false;
  }
 //Cas non vide , si au changement de la valeur apparait un message d'erreur et tentative de submit (cf.fonctions précédentes dans Intéractivité affichage avant soumission*)
if(feedBackPostalCodeError.innerHTML!=""){
	errorMessage.innerHTML="Veuillez corriger l'erreur du champs 'Code Postal' ";
	return false;
}

 //contrôle de la Date souhaitée

  	//si vide
  if(wishedDate.value==""){
    errorMessage.innerHTML="La Date ne peut être vide ";
	feedBackWishedDateError.innerHTML="&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;"
    return false;
  }
 //Cas non vide , si au changement de la valeur apparait un message d'erreur et tentative de submit (cf.fonctions précédentes dans Intéractivité affichage avant soumission*)
if(feedBackWishedDateError.innerHTML!=""){
	errorMessage.innerHTML="Veuillez corriger l'erreur du champs 'Date' ";
	return false;
}

//Contrôle du nbre de personne
  	//si  vide 
  if(peopleNbrSpec.value==false){
    errorMessage.innerHTML="Le nombre de personnes doit être indiqué ";
	feedBackPeopleError.innerHTML="&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;"
    return false;
  }
 //Cas non vide , si au changement de la valeur apparait un message d'erreur et tentative de submit (cf.fonctions précédentes dans Intéractivité affichage avant soumission*)
if(feedBackPeopleError.innerHTML!=""){
	errorMessage.innerHTML="Veuillez corriger l'erreur du champs 'Nombre de personnes' ";
	return false;
}



 //contrôle de la plage horaire souhaitée

  	//si vide
  if(wishedTime.value=="none"){
    errorMessage.innerHTML="La plage horaire ne peut être vide ";
	feedBackWishedTimeError.innerHTML="&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;&nbsp;&nbsp;&nbsp;&nbsp;&#x2B9D;"
    return false;
  }

 //Cas non vide , si la confirmation de la plage horaire apparait 
if(feedBackWishedTimeSuccess.innerHTML!=""){
	//au click (ou prochain click,) on enlève les messages d'erreurs
	errorMessage.innerHTML=" ";
	feedBackWishedTimeError.innerHTML="";
}





//Ouverture de la modal (si arrive jusque cette étape en passant les tests défauts)
modalOrder.style.display ="block";

//Affichage du block de proposition de sauvegarde des coordonnées si différence avec les données user ds la DB

if(name.value != nameHidden.value || firstname.value != firstnameHidden.value || phoneNumber.value != phoneNumberHidden.value || 
	adress.value != adressHidden.value || cityName.value != cityNameHidden.value || postalCode.value != postalCodeHidden.value)
	{
		recordDeliveryDatas.style.display ="block";
		//on check par défaut la box pour enregistrement des nouvelles coordonnées
		recordDatasCheckBox.checked = true;
		//on attribue la valeur 1 à la checkBox
		recordDatasCheckBox.value = "checked";
	}else{
	recordDeliveryDatas.style.display ="none";
	//La check box est décochée pour ne pas enregistrer de nouveau sur le compte user les mêmes coordonnées
	recordDatasCheckBox.checked = false;
	//on attribue aucune valeur ou la valeur empty à la checkBox
	recordDatasCheckBox.value = "empty";
	}



});


/**************Test Devellopeur :  message d'enregistrement coordonnées si différent de la DB et checked checkbox ***************************** */

//Test =>ok , à reproduire dans le prevent Default ci dessus avec les valeurs récupérées et modifiées//
//if( 1!=1 || 2!=2 || 2!=3){
//recordDeliveryDatas.style.display ="block";
//recordDatasCheckBox.checked = true;
//}else{
//recordDeliveryDatas.style.display ="none";
//recordDatasCheckBox.checked = false;
//}

/******************************************************************************************************** */

/*****************************Gestion de la Modal de confirmation de commande (fermeture , retour, confirmation)********************************/




/*Gestion Fermeture de la modale de commande*/
//A travers l'image croix rouge
imgCloseModalOrder.addEventListener("click",()=>{
     modalOrder.style.display = "none";
})

//A travers le bouton retour
backToOrder.addEventListener("click",()=>{
     modalOrder.style.display = "none";
})





