/******************************Function importée_NavHeader***********************************/
//Function importée et dévellopée dans scriptHeader.js
import {mainNav} from './scriptHeader.js';
mainNav();


/**************************Liste préliminaire des variables nécessaires récupérés du DOM****************************** */
//Eléments de selection du choix ou filtre
let filterSelection = document.querySelector("#filterSelection");
//Div contenant le filtre Thème
let themeFilter = document.querySelector("#themeFilter");
//Div contenant le filtre Plages de prix
let priceRangeFilter = document.querySelector("#priceRangeFilter");
//Div contenant le filtre prix max
let maxPriceFilter = document.querySelector("#maxPriceFilter");
//Div contenant le filtre Type de Régime
let typeRegimeFilter = document.querySelector("#typeRegimeFilter");
//Div contenant l'affichage temporaire d'exemple filtre
let tempChoosenFilter = document.querySelector(".tempChoosenFilter");
//class des div filtres (pour action groupée)
let filterGroup = document.querySelector("#filterGroup");
// le contenu "heading" affiché pour préciser en titre le type de menu
let heading = document.querySelector('#heading');
//Eléments complémentaires nécessaires pour les filtres spécifiques
	//le container de présentation menus (sectionContent => id=menuContainer)
	let menuContainer = document.querySelector("#menuContainer");
	//la note situé sous le titre avec heading
	let notePlat = document.querySelector('#notePlat');
	//chemin du dossier image
	let uploadsPath="../2_vgTeam/gestionMenus/uploads/";
	//le footer (en cas de réajustement)
	let footer = document.querySelector('.footer');
//Eléments spécifiques du filtre "thème":
	// le selecteur de thèmes
	let selectThemes = document.querySelector("#selectThemes");
	//le titre du filtre thème sélectionné
	let filterThemeCriteria = document.querySelector("#themeCriteria");

//Eléments spécifiques du filtre "plages de prix":
	// le selecteur 
	let selectPriceRange = document.querySelector("#selectPriceRange");
	//le titre du filtre
	let filterpriceRangeCriteria = document.querySelector("#priceRangeCriteria");

//Eléments spécifiques du filtre "Prix max":
	// le selecteur 
	let selectMaxPrice = document.querySelector("#selectMaxPrice");
	//le titre du filtre
	let filtermaxPriceCriteria = document.querySelector("#maxPriceCriteria");

//Eléments spécifiques du filtre "Type de régime":
	// le selecteur 
	let selectRegime = document.querySelector("#selectRegime");
	//le titre du filtre
	let filtertypeRegimeCriteria = document.querySelector("#typeRegimeCriteria");

//Eléments spécifiques du "Panneau Theme" de gauche :
	// le selecteur 
	let selectThemesPanel = document.querySelector("#selectThemesPanel");
	//le titre du filtre
	let filterThemeCriteriaPanel = document.querySelector("#themeCriteriaPanel");

/**************************Affichage du Type de filtre en fonction du 1er choix****************************** */

//lors d'un choix ou une selection de filtre
filterSelection.addEventListener("change", function(e){
	//récupération de la valeur sélectionnée au selecteur et assignation
    let selectedFilter = e.target.value;
	//en fonction de la valeur récupérée , un filtre est affiché ou pas
	switch (selectedFilter) {
		case "theme":
		//Affichage de la div possédant les filtres si précédemment masquée
		filterGroup.style.display="block";
		//masquage de tout les autres filtres non nécessaires(si précédemment ouvert)
		maxPriceFilter.style.display="none";
		priceRangeFilter.style.display="none";
		typeRegimeFilter.style.display="none";
		//masquage du filtre temporaire d'exemple
		tempChoosenFilter.style.display = "none";	
		//affichage du filtre concerné dans son index par défaut
		themeFilter.style.display ="block";	
		selectThemes.selectedIndex ="default";

		break;

		case "priceRange":
		//Affichage de la div possédant les filtres si précédemment masquée
		filterGroup.style.display="block";
		//masquage de tout les autres filtres non nécessaires (si précédemment ouvert)
		themeFilter.style.display="none";
		maxPriceFilter.style.display="none";
		typeRegimeFilter.style.display="none";
		//masquage du filtre temporaire d'exemple
		tempChoosenFilter.style.display = "none";	
		//affichage du filtre concerné dans son index par défaut
		priceRangeFilter.style.display ="block";
		selectPriceRange.selectedIndex ="default";
			break;

		case "maxPrice":
		//Affichage de la div possédant les filtres si précédemment masquée
		filterGroup.style.display="block";
		//masquage de tout les autres filtres non nécessaires(si précédemment ouvert)
		themeFilter.style.display="none";
		priceRangeFilter.style.display="none";
		typeRegimeFilter.style.display="none";
		//masquage du filtre temporaire d'exemple
		tempChoosenFilter.style.display = "none";	
		//affichage du filtre concerné dans son index par défaut
		maxPriceFilter.style.display ="block";
		selectMaxPrice.selectedIndex ="default";	

			break;

		case "regimeType":
		//Affichage de la div possédant les filtres si précédemment masquée
		filterGroup.style.display="block";
		//masquage de tout les autres filtres non nécessaires(si précédemment ouvert)
		themeFilter.style.display="none";
		priceRangeFilter.style.display="none";
		maxPriceFilter.style.display="none";
		//masquage du filtre temporaire d'exemple
		tempChoosenFilter.style.display = "none";	
		//affichage du filtre concerné dans son index par défaut
		typeRegimeFilter.style.display ="block";
		selectRegime.selectedIndex ="default";		
			break;
		
		//cas de sélection "Tous les menus"	
		case "all":
		//masquage de tout les filtres et invitation à sélectionner un filtre
		filterGroup.style.display="none";
		//Execution de la function showAllMenus sans rechargement de page
		showAllMenus();
		//Précision de la séléction (Tous) dans le titre
		heading.innerHTML= "Tout les menus"
		break;

		default:
		//Affichage de la div possédant les filtres si précédemment masquée
		filterGroup.style.display="block";
		//masquage de tout les filtres
		themeFilter.style.display="none";
		priceRangeFilter.style.display="none";
		maxPriceFilter.style.display="none";
		typeRegimeFilter.style.display ="none";
		//affichage du filtre temporaire d'exemple
		tempChoosenFilter.style.display = "block";
			break;
	}
})



/**************************Codage des filtres de sélection Menu****************************** */


//Function filterOnloadAJAX permettant de charger la réponse à la demande de choix filtre sans recharger la page
function filterOnloadAJAX(){
    //si la requête de l'objet est achevée et sa réponse prête (==4) et si son status est ok (==200)
            if (this.readyState == 4 && this.status == 200){ 
					//console.log(this.responseText);
                //récupération de la réponse JSON reçu du fichier Fetch php et conversion en JS (via JSON.parse)
					//la propriété responseText contient les données récupérés par le server
                let response = JSON.parse(this.responseText);
					//test de vérifications dév:
					//console.log(response.length);
					//(response.length=0)? console.log(true):console.log(false);
				//création d'une variable qui contiendra le format HTML/php connu de la présentation Menu et les données récupérés et convertit si pas vide, sinon une réponse appropriée
                let out="";
				//si le nombre de table objet récupéré est nulle (aucune donnée trouvé)
				if(response.length == 0){
					//la réponse suivante est intégrée à out pour être renvoyée
					out = "<p  style='color:darkred'> Désolé, nous n'avons pas encore ou plus de menu correspondant au critère sélectionné.</p>";
					//la note située sous le menu n'est pLUS affichée (détails plat)
					notePlat.innerHTML="";
					//Le footer est repositionné au niveau bottom:0 si décalage vers le haut (tendance à remonter un peu sans résultat)
					footer.style.position= "fixed";
					footer.style.bottom = 0;

				}else{
                //Loop au travers de la variable possedant les données récupérées pour en sortir chaque "data.objet" requis 
                for(let data of response){
                    //out reprend à chaque boucle le format html/php de base, les données "data.objet" correspondent aux données récupérés par la requête Fetch PHP
                    out+=`
							<div class="menu">
								<div class="menuLeft">
									<!--cheminPhotoMenu&NomdePhoto-->
									<img src="${uploadsPath+data.photo_menu}" alt="" width="200px">
								</div>
								<div class="menuRight">
									<h3 class="title">
										<!--titre menu-->
										<a href="">${data.titre}</a>
									</h3>
									<!--description menu-->
									<p class="description">
                                        ${data.description}
									</p>
									<div class="regimetheme">
										<div>
											<h5>&nbsp;<span>Thème: </span></h5>
											<!--thème menu-->
											<p>&nbsp;&nbsp;&nbsp;<span><em>${data.theme}</em></span></p>
										</div>
										<div>
											<h5><span>Régime: </span></h5>
											<!--régime menu-->
											<p>&nbsp;&nbsp;&nbsp;<em>${data.regime}</em></p>
										</div>
										<div>
											<h5><span>Nbre pers.min: </span></h5>
											<!--Nbre pers.min-->
											<p>&nbsp;&nbsp;&nbsp;<em>${data.nombre_personne_minimum}</em></p>
										</div>
										<div>
											<h5><span>Qté restante(s): </span></h5>
											<!--Qté restante(s)-->
											<p>&nbsp;&nbsp;&nbsp;<em>${data.quantite_restante}</em></p>
										</div>
										<!--prix menu-->
										<h5>Prix TTC:</h5>
										<p class="price">${data.prix_par_personne}&euro;/pers.</p>
									</div>
								</div>
							</div>
							<hr id="menuSeparation">
                    `;
                }
			}
            //Intégration du de la variable out dans la div avec la classe .menu (représentée par la varible menuContainer)
            menuContainer.innerHTML = out;
			
		}
};

// showAllMenus function, lorsque le premier selecteur est pointé sur "Tous les menus"
function showAllMenus(){
	//Création d'un objet de requête Ajax assignée à http
	let http = new XMLHttpRequest();
	//Assignation de la valeur "allMenus" lors de la première selection à la variable firstSelection
	let firstSelectionAllMenus = "all";
	//E2_ Récupération d'un éventuel retour de résultat de Fetch_php suite une éventuelle requête précédement envoyée
	//lorsque la transaction avec le server est complétée, au chargement (onload) une fonction est executée 
	http.onload = filterOnloadAJAX;//cf detail de la function filterOnloadAJAX dans la suite du document

	//E1_ Préparation de la requête avec la méthode open en ciblant via un POST le fichier d'execution et de façon asynchrone (true)
	http.open('POST', "Functions/fctFetchSelecFilter.php", true);
	//avec la méthode setRequestHeader définition et envoi du type de contenu (content-type=> url encodé (replaces unsafe ASCII characters with a "%" followed by two hexadecimal digits. Hello Günter = Hello%20G%C3%BCnter , les espaces sont encodés %20.)) 
	http.setRequestHeader("content-type", "application/x-www-form-urlencoded");
	//Envoi de la variable firstSelection (contenant la clé "allMenus")  à travers l'url encodé (même process qu'un envoi de donnée clé/valeur avec un html mais de forme encodé)
		//clé/valeur envoyé => libelle/selectThemes
	http.send("firstSelection="+firstSelectionAllMenus);

};


//Ecoute du changement sur le fitre thème et application de la function associée
selectThemes.addEventListener("change", function(){
    //récupération de la valeur sélectionnée au selecteur et assignation
    let selectThemes = this.value;
    // le texte de l'index sélectionnée [this.selectedIndex]
    let criteria = this[this.selectedIndex].text;
	// le texte du Filtre thème
	let filterThemeName = filterThemeCriteria.innerHTML;
	//Personalisation du titre de la selection
	heading.innerHTML = ` ${filterThemeName}   → Choix: "${criteria}"`;
	//Création d'un objet de requête Ajax assignée à http
	let http = new XMLHttpRequest();

	//E2_ Récupération d'un éventuel retour de résultat de Fetch_php suite une éventuelle requête précédement envoyée
	//lorsque la transaction avec le server est complétée, au chargement (onload) une fonction est executée 
	http.onload = filterOnloadAJAX;//cf detail de la function filterOnloadAJAX dans la suite du document

	//E1_ Préparation de la requête avec la méthode open en ciblant via un POST le fichier d'execution et de façon asynchrone (true)
	http.open('POST', "Functions/fctFetchSelecFilter.php", true);
	//avec la méthode setRequestHeader définition et envoi du type de contenu (content-type=> url encodé (replaces unsafe ASCII characters with a "%" followed by two hexadecimal digits. Hello Günter = Hello%20G%C3%BCnter , les espaces sont encodés %20.)) 
	http.setRequestHeader("content-type", "application/x-www-form-urlencoded");
	//Envoi du menu Selectionné à travers l'url encodé (même process qu'un envoi de donnée clé/valeur avec un html mais de forme encodé)
		//clé/valeur envoyé => libelle/selectThemes
	http.send("selectedTheme="+selectThemes);
});





//Ecoute du changement sur le fitre régime et application de la function associée
selectRegime.addEventListener("change", function(){
    //récupération de la valeur sélectionnée au selecteur et assignation
    let selectRegime = this.value;
    // le texte de l'index sélectionnée [this.selectedIndex]
    let criteria = this[this.selectedIndex].text;
	// le texte du Filtre 
	let filterRegimeName = filtertypeRegimeCriteria.innerHTML;
	//Personalisation du titre de la selection
	heading.innerHTML = ` ${filterRegimeName}   → Choix: "${criteria}"`;
	//Création d'un objet de requête Ajax assignée à http
	let http = new XMLHttpRequest();

	//E2_ Récupération d'un éventuel retour de résultat de Fetch_php suite une éventuelle requête précédement envoyée
	//lorsque la transaction avec le server est complétée, au chargement (onload) une fonction est executée 
	http.onload = filterOnloadAJAX;//cf detail de la function filterOnloadAJAX dans la suite du document

	//E1_ Préparation de la requête avec la méthode open en ciblant via un POST le fichier d'execution et de façon asynchrone (true)
	http.open('POST', "Functions/fctFetchSelecFilter.php", true);
	//avec la méthode setRequestHeader définition et envoi du type de contenu (content-type=> url encodé (replaces unsafe ASCII characters with a "%" followed by two hexadecimal digits. Hello Günter = Hello%20G%C3%BCnter , les espaces sont encodés %20.)) 
	http.setRequestHeader("content-type", "application/x-www-form-urlencoded");
	//Envoi du menu Selectionné à travers l'url encodé (même process qu'un envoi de donnée clé/valeur avec un html mais de forme encodé)
		//clé/valeur envoyé => libelle/selectRegime
	http.send("selectedRegime="+selectRegime);
});





//Ecoute du changement sur le fitre maxPrice (Prix max) et application de la function associée
selectMaxPrice.addEventListener("change", function(){
    //récupération de la valeur sélectionnée au selecteur et assignation
    let selectMaxPrice = this.value;
    // le texte de l'index sélectionnée [this.selectedIndex]
    let criteria = this[this.selectedIndex].text;
	// le texte du Filtre 
	let filterMaxPriceName = filtermaxPriceCriteria.innerHTML;
	//Personalisation du titre de la selection
	heading.innerHTML = ` ${filterMaxPriceName}   → Choix: "${criteria}"`;
	//Création d'un objet de requête Ajax assignée à http
	let http = new XMLHttpRequest();

	//E2_ Récupération d'un éventuel retour de résultat de Fetch_php suite une éventuelle requête précédement envoyée
	//lorsque la transaction avec le server est complétée, au chargement (onload) une fonction est executée 
	http.onload = filterOnloadAJAX;//cf detail de la function filterOnloadAJAX dans la suite du document

	//E1_ Préparation de la requête avec la méthode open en ciblant via un POST le fichier d'execution et de façon asynchrone (true)
	http.open('POST', "Functions/fctFetchSelecFilter.php", true);
	//avec la méthode setRequestHeader définition et envoi du type de contenu (content-type=> url encodé (replaces unsafe ASCII characters with a "%" followed by two hexadecimal digits. Hello Günter = Hello%20G%C3%BCnter , les espaces sont encodés %20.)) 
	http.setRequestHeader("content-type", "application/x-www-form-urlencoded");
	//Envoi du menu Selectionné à travers l'url encodé (même process qu'un envoi de donnée clé/valeur avec un html mais de forme encodé)
		//clé/valeur envoyé => libelle/selectRegime
	http.send("selectedMaxPrice="+selectMaxPrice);
});


//Ecoute du changement sur le fitre PriceRange (Plage de Prix) et application de la function associée
selectPriceRange.addEventListener("change", function(){
    //récupération de la valeur sélectionnée au selecteur et assignation
    let selectPriceRange = this.value;
    // le texte de l'index sélectionnée [this.selectedIndex]
    let criteria = this[this.selectedIndex].text;
	// le texte du Filtre 
	let filterPriceRangeName = filterpriceRangeCriteria.innerHTML;
	//Personalisation du titre de la selection
	heading.innerHTML = ` ${filterPriceRangeName}   → Choix: "${criteria}"`;
	//Création d'un objet de requête Ajax assignée à http
	let http = new XMLHttpRequest();

	//E2_ Récupération d'un éventuel retour de résultat de Fetch_php suite une éventuelle requête précédement envoyée
	//lorsque la transaction avec le server est complétée, au chargement (onload) une fonction est executée 
	http.onload = filterOnloadAJAX;//cf detail de la function filterOnloadAJAX dans la suite du document

	//E1_ Préparation de la requête avec la méthode open en ciblant via un POST le fichier d'execution et de façon asynchrone (true)
	http.open('POST', "Functions/fctFetchSelecFilter.php", true);
	//avec la méthode setRequestHeader définition et envoi du type de contenu (content-type=> url encodé (replaces unsafe ASCII characters with a "%" followed by two hexadecimal digits. Hello Günter = Hello%20G%C3%BCnter , les espaces sont encodés %20.)) 
	http.setRequestHeader("content-type", "application/x-www-form-urlencoded");
	//Envoi du menu Selectionné à travers l'url encodé (même process qu'un envoi de donnée clé/valeur avec un html mais de forme encodé)
		//clé/valeur envoyé => libelle/selectRegime
	http.send("selectedPriceRange="+selectPriceRange);
});


//Ecoute du changement sur le panneau thème de gauche et application de la function associée
selectThemesPanel.addEventListener("change", function(){
    //récupération de la valeur sélectionnée au selecteur et assignation
    let selectThemesPanel = this.value;
    // le texte de l'index sélectionnée [this.selectedIndex]
    let criteria = this[this.selectedIndex].text;
	// le texte du Filtre thème du panneau
	let filterThemeNamePanel = filterThemeCriteriaPanel.innerHTML;
	//Personalisation du titre de la selection
	heading.innerHTML = ` ${filterThemeNamePanel}   → Choix: "${criteria}"`;
	//Création d'un objet de requête Ajax assignée à http
	let http = new XMLHttpRequest();

	//E2_ Récupération d'un éventuel retour de résultat de Fetch_php suite une éventuelle requête précédement envoyée
	//lorsque la transaction avec le server est complétée, au chargement (onload) une fonction est executée 
	http.onload = filterOnloadAJAX;//cf detail de la function filterOnloadAJAX dans la suite du document

	//E1_ Préparation de la requête avec la méthode open en ciblant via un POST le fichier d'execution et de façon asynchrone (true)
	http.open('POST', "Functions/fctFetchSelecFilter.php", true);
	//avec la méthode setRequestHeader définition et envoi du type de contenu (content-type=> url encodé (replaces unsafe ASCII characters with a "%" followed by two hexadecimal digits. Hello Günter = Hello%20G%C3%BCnter , les espaces sont encodés %20.)) 
	http.setRequestHeader("content-type", "application/x-www-form-urlencoded");
	//Envoi du menu Selectionné à travers l'url encodé (même process qu'un envoi de donnée clé/valeur avec un html mais de forme encodé)
		//clé/valeur envoyé => libelle/selectThemes
	http.send("selectedThemePanel="+selectThemesPanel);
});