
//Affichage de l'option séléctionnée après sélection dans une div préparée

//Div préparée pour afficher la catégorie sélectionnée 
const selectedRegime = document.querySelector('.selectedRegime');


function getRegimeJS(regimeID){//L'argument correspond à la valeur sélectionnée en option (onclick = get(this).value)

//on fetch (récupère) au travers du fichier model la clé(colonne)ID de notre table, celle correspondant à la valeur cliquée (getRegime(this.value)) 
fetch(`Functions/modelRegime.php?ID=${regimeID}`)
//si la réponse est bien récupérée, on la convertit en objet javascript 
.then(response => response.json())
.then(function(regimeID){
    //Le placeholder dans lequel sera affiché le résultat (div dont la class a été récupérée)
	let placeholderRegime = selectedRegime; 
    //Comme on ne Loop pas et qu on a qu'un résultat=>on spécifie l'index du json retourné (un seul index de json  =>on spécifie [0])puis le nom de la clé

	let	out = `
            <p>Régime sélectionné: N°ID et Libellé</p>
            <input type="text" class="regimeChoosenID" readonly name="regimeChoosenID" id="regimeChoosenID" value="${regimeID[0]['regime_id']}">
            <input type="text" class="regimeChoosenName" readonly name="regimeChoosenName" id="regimeChoosenName" value="${regimeID[0]['libelle']}">
		`;
    
    //à l'intérieur du placeholder ('div'), on intégre l'ensemble des éléments cités dans la variable out 
	placeholderRegime.innerHTML = out;

}).catch((error) => {
    console.log("Erreur lors de la requête:", error);
  });

}



export {getRegimeJS as getRegimeJS};
