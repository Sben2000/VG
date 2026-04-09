
//Affichage de l'option séléctionnée après sélection dans une div préparée

//Div préparée pour afficher la catégorie sélectionnée 
const selectedTheme = document.querySelector('.selectedTheme');
let idTheme
function getThemeJS(themeID){//L'argument correspond à la valeur sélectionnée en option (onclick = get(this).value)

//on fetch (récupère) au travers du fichier model la clé(colonne)ID de notre table, celle correspondant à la valeur cliquée (getTheme(this.value)) 
fetch(`Functions/modelTheme.php?ID=${themeID}`)
//si la réponse est bien récupérée, on la convertit en objet javascript 
.then(response => response.json())
.then(function(themeID){
    //Le placeholder dans lequel sera affiché le résultat (div dont la class a été récupérée)
	let placeholder = selectedTheme; 
    //Comme on ne Loop pas et qu on a qu'un résultat=>on spécifie l'index du json retourné (un seul index de json  =>on spécifie [0])puis le nom de la clé

	let	out = `
            <p>Thème sélectionné: N°ID et Libellé</p>
            <input class="themeChoosenID" type="text"  readonly name="themeChoosenID" id="themeChoosenID" value="${themeID[0]['theme_id']}">
            <input class="themeChoosenName" type="text" readonly name="themeChoosenName" id="themeChoosenName" value="${themeID[0]['libelle']}">
		`;
    
    //à l'intérieur du placeholder ('div'), on intégre l'ensemble des éléments cités dans la variable out 
	placeholder.innerHTML = out;

})
.catch((error) => {
    console.log("Erreur lors de la requête:", error);
  });

}




export {getThemeJS as getThemeJS};
