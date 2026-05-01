
/**************************Liste préliminaire des variables nécessaires récupérés du DOM****************************** */
//le container de présentation menus (sectionContent => id=orderContainer)
let orderContainer = document.querySelector("#orderContainer");
// le selecteur de filtres
let selectFilter = document.querySelector("#selectFilter");
// le contenu "heading" affiché pour préciser en titre le type de status séléctionné
let heading = document.querySelector('#heading');

/**************************Codage des filtres de sélection Commande****************************** */
//Function filterOnloadAJAX permettant de charger la réponse à la demande de choix filtre sans recharger la page
function filterOnloadAJAX(){
    //si la requête de l'objet est achevée et sa réponse prête (==4) et si son status est ok (==200)
            if (this.readyState == 4 && this.status == 200){ 
					//console.log(this.responseText);
                //récupération de la réponse JSON reçu du fichier Fetch php et conversion en JS (via JSON.parse)
					//la propriété responseText contient les données récupérés par le server
                let response = JSON.parse(this.responseText);
					//test de vérifications dév:
                    //console.log(this.responseText);
					//console.log(response.length);
					//(response.length=0)? console.log(true):console.log(false);
				//création d'une variable qui contiendra le format HTML/php connu de la présentation Menu et les données récupérés et convertit si pas vide, sinon une réponse appropriée
                let out="";
				//si le nombre de table objet récupéré est nulle (aucune donnée trouvé)
				if(response.length == 0){
					//la réponse suivante est intégrée à out pour être renvoyée
					out = "<br><br><p id='noOrderFound' style='color:darkred'> Il n'existe pas encore ou plus de commande avec ce statut</p> <hr class='menuSeparation'>";


				}else{
                //Loop au travers de la variable possedant les données récupérées pour en sortir chaque "data.objet" requis 
                for(let data of response){
                    //En préambule , on convertit les dates sql en date au format fr
                    const dateCommande = new Date(data.date_commande);
                    const datePrestation = new Date(data.date_prestation);
                    //out reprend à chaque boucle le format html/php de base, les données "data.objet" correspondent aux données récupérés par la requête Fetch PHP
                    out+=`    
                            <table class="access">
                                    <thead>
                                        <tr>
                                            <th>Réf.Commande </th>
                                            <th><strong>${data.numero_commande}</strong><br>
                                        </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            <tr>
                                                <th class="firstC">N°Id et date de Cde</th>
                                                <td class="idMenu">
                                                <label>Id: </label><strong>${data.commande_id}</strong><br>
                                                <label>cde du: </label><strong>${dateCommande.toLocaleDateString("fr")}</strong>
                                                </td>
                                            <tr>
                                                <th class="firstC">nom_du_menu <br>Nbre de pers.</th>
                                                <td class="idMenu"><strong>
                                                    ${data.titre}<br>
                                                     ${data.nbr_pers} personne(s)
                                                </strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="firstC">Date et horaires <br> de prestation</th>
                                                <td class="idMenu">
                                                <strong>${datePrestation.toLocaleDateString("fr")}</strong><br>
                                                <strong>${data.heure_livraison}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="firstC">Statut cde</th>
                                                <td><strong>${data.statut}</strong></td>
                                            </tr>
                                            <tr>
                                                <th class="firstC">Prix détaillé</th>
                                                <td>
                                                    <em>Menu: ${data.prix_par_personne} &euro;, Réduct.: ${data.reduction}%, Livr.: ${data.prix_livraison} &euro;</em><br>
                                                    <strong>Prix total (TTC): ${data.prix_TTC} &euro;</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="firstC">Coordonnées</th>
                                                <td>
                                                    ${data.nom_livraison}&nbsp;${data.prenom_livraison}<br>
                                                    ${data.adresse_postale_livraison},<br>
                                                    ${data.code_postal_livraison}&nbsp;${data.ville_livraison}.<br>
                                                    &#x260E;:0${data.telephone_livraison}<br>
                                                    ${data.email}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th class="firstC">Actions</th>
                                                <div class="actionButtons">
                                                    
                                                    <td>
                                                            <button class="modifyButton"><a href="index.php?action=edit&id=${data.commande_id}">Modifier le status</a></button>
                                                    </td>
                                                </div>
                                            </tr>
                                    </tbody>
                                </table>
                    `;
                }
			}
            //Intégration du de la variable out dans la div avec la classe .menu (représentée par la varible menuContainer)
            orderContainer.innerHTML = out;
			
		}
};


//Ecoute du changement sur le fitre et application de la function associée
selectFilter.addEventListener("change", function(){
    //récupération de la valeur sélectionnée au selecteur et assignation
    let selectFilter = this.value;
    // le texte de l'index sélectionnée [this.selectedIndex]
    let criteria = this[this.selectedIndex].text;
	//Personalisation du titre de la selection
	heading.innerHTML = ` "${criteria}"`;
	//Création d'un objet de requête Ajax assignée à http
	let http = new XMLHttpRequest();

	//E2_ Récupération d'un éventuel retour de résultat de Fetch_php suite une éventuelle requête précédement envoyée
	//lorsque la transaction avec le server est complétée, au chargement (onload) une fonction est executée 
	http.onload = filterOnloadAJAX;//cf detail de la function filterOnloadAJAX dans la suite du document

	//E1_ Préparation de la requête avec la méthode open en ciblant via un POST le fichier d'execution et de façon asynchrone (true)
	http.open('POST', "model/fctFetchSelecFilter.php", true);
	//avec la méthode setRequestHeader définition et envoi du type de contenu (content-type=> url encodé (replaces unsafe ASCII characters with a "%" followed by two hexadecimal digits. Hello Günter = Hello%20G%C3%BCnter , les espaces sont encodés %20.)) 
	http.setRequestHeader("content-type", "application/x-www-form-urlencoded");
	//Envoi du menu Selectionné à travers l'url encodé (même process qu'un envoi de donnée clé/valeur avec un html mais de forme encodé)
		//clé/valeur envoyé => libelle/selectedFilter
	http.send("selectedFilter="+selectFilter);
});

