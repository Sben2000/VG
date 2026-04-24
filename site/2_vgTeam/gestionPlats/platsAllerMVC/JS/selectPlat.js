
//Affichage de l'option séléctionnée après sélection dans une div préparée

//Div préparée pour afficher la catégorie sélectionnée 
const selectedPlat = document.querySelector('.selectedPlat');

function getPlatJS(platID){//L'argument correspond à la valeur sélectionnée en option (onclick = get(this).value)

//on fetch (récupère) au travers du fichier model la clé(colonne)ID de notre table, celle correspondant à la valeur cliquée (getPlat(this.value)) 
fetch(`model/modFetchSelectPlat.php?ID=${platID}`)
//si la réponse est bien récupérée, on la convertit en objet javascript 
.then(response => response.json())
//.then(response=>console.log(response))
.then(function(platID){
    //Le placeholder dans lequel sera affiché le résultat (div dont la class a été récupérée)
	let placeholder = selectedPlat; 
    //Comme on ne Loop pas et qu on a qu'un résultat=>on spécifie l'index du json retourné (un seul index de json  =>on spécifie [0])puis le nom de la clé

	let	out = `
            <p>Plat sélectionné: N°ID et Titre</p>
            <input class="platChoosenID" type="text"  readonly name="platChoosenID" id="platChoosenID" value="${platID[0]['plat_id']}"><br>
            <input class="platChoosenName" type="text" readonly name="platChoosenName" id="platChoosenName" value="${platID[0]['titre_plat']}"><br>
		`;
    
    //à l'intérieur du placeholder ('div'), on intégre l'ensemble des éléments cités dans la variable out 
	placeholder.innerHTML = out;

})
.catch((error) => {
    console.log("Erreur lors de la requête:", error);
  });

}




export {getPlatJS as getPlatJS};
