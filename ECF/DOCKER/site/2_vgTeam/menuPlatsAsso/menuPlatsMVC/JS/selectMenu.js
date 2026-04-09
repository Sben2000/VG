
//Affichage de l'option séléctionnée après sélection dans une div préparée

//Div préparée pour afficher la catégorie sélectionnée 
const selectedMenu = document.querySelector('.selectedMenu');


function getMenuJS(menuID){//L'argument correspond à la valeur sélectionnée en option (onclick = get(this).value)

//on fetch (récupère) au travers du fichier model la clé(colonne)ID de notre table, celle correspondant à la valeur cliquée (getMenu(this.value)) 
fetch(`model/modFetchSelectMenu.php?ID=${menuID}`)
//si la réponse est bien récupérée, on la convertit en objet javascript 
.then(response => response.json())
.then(function(menuID){
    //Le placeholder dans lequel sera affiché le résultat (div dont la class a été récupérée)
	let placeholderMenu = selectedMenu; 
    //Comme on ne Loop pas et qu on a qu'un résultat=>on spécifie l'index du json retourné (un seul index de json  =>on spécifie [0])puis le nom de la clé

	let	out = `
            <p>Menu sélectionné: N°ID et Titre du Menu</p>
            <input type="text" class="menuChoosenID" readonly name="menuChoosenID" id="menuChoosenID" value="${menuID[0]['menu_id']}"><br>
            <input type="text" class="menuChoosenName" readonly name="menuChoosenName" id="menuChoosenName" value="${menuID[0]['titre']}"><br>
		`;
    
    //à l'intérieur du placeholder ('div'), on intégre l'ensemble des éléments cités dans la variable out 
	placeholderMenu.innerHTML = out;

}).catch((error) => {
    console.log("Erreur lors de la requête:", error);
  });

}



export {getMenuJS as getMenuJS};
