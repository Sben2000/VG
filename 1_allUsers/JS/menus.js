/******************************Function importée_NavHeader***********************************/
//Function importée et dévellopée dans scriptHeader.js
import {mainNav} from './scriptHeader.js';
mainNav();

/**************************Codage des filtres de sélection Menu****************************** */

//Eléments généraux des filtres sur la sélection de thème
	//le container de présentation menus (sectionContent => id=menuContainer)
	let menuContainer = document.querySelector("#menuContainer");
	// le contenu "heading" affiché pour préciser en titre le type de menu
	let heading = document.querySelector('#heading');
	//la note situé sous le titre avec heading
	let notePlat = document.querySelector('#notePlat');
//Eléments spécifique du filtre thème:
	// le selecteur de thèmes
	let selectThemes = document.querySelector("#selectThemes");
	//le titre du filtre thème sélectionné
	let filterThemeCriteria = document.querySelector("#themeCriteria");

//chemin du dossier image

let uploadsPath="../2_vgTeam/gestionMenus/uploads/";

//Ecoute du changement sur le fitre thème et application de la function associée
selectThemes.addEventListener("change", function(){
    //récupération de la valeur sélectionnée au selecteur et assignation
    let selectThemes = this.value;
    // le texte de l'index sélectionnée [this.selectedIndex]
    let criteria = this[this.selectedIndex].text;
	// le texte du Filtre thème
	let filterThemeName = filterThemeCriteria.innerHTML;

	


//Création d'un objet de requête Ajax assignée à http
let http = new XMLHttpRequest();

//E2_ Récupération d'un éventuel retour de résultat de Fetch_php suite une éventuelle requête précédement envoyée
//lorsque la transaction avec le server est complétée, au chargement (onload) une fonction est executée 
http.onload = function(){
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
                    `;
                }
			}
            //Intégration du de la variable out dans la div avec la classe .menu (représentée par la varible menuContainer)
            menuContainer.innerHTML = out;
			
		}
		//Personalisation du titre de la selection
		heading.innerHTML = ` ${filterThemeName}   → Choix: "${criteria}"`;
}


//E1_ Préparation de la requête avec la méthode open en ciblant via un POST le fichier d'execution et de façon asynchrone (true)
http.open('POST', "Functions/fctFetchSelecTheme.php", true);
//avec la méthode setRequestHeader définition et envoi du type de contenu (content-type=> url encodé (replaces unsafe ASCII characters with a "%" followed by two hexadecimal digits. Hello Günter = Hello%20G%C3%BCnter , les espaces sont encodés %20.)) 
http.setRequestHeader("content-type", "application/x-www-form-urlencoded");
//Envoi du menu Selectionné à travers l'url encodé (même process qu'un envoi de donnée clé/valeur avec un html mais de forme encodé)
    //clé/valeur envoyé => libelle/selectThemes
http.send("selectedTheme="+selectThemes);
});

