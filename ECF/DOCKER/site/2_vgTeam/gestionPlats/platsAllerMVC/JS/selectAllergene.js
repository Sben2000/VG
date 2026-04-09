
//Affichage de l'option séléctionnée après sélection dans une div préparée

//Div préparée pour afficher la catégorie sélectionnée 
const selectedAllergene = document.querySelector('.selectedAllergene');


function getAllergeneJS(allergeneID){//L'argument correspond à la valeur sélectionnée en option (onclick = get(this).value)

//on fetch (récupère) au travers du fichier model la clé(colonne)ID de notre table, celle correspondant à la valeur cliquée (getAllergene(this.value)) 
fetch(`model/modFetchSelectAllerg.php?ID=${allergeneID}`)
//si la réponse est bien récupérée, on la convertit en objet javascript 
.then(response => response.json())
.then(function(allergeneID){
    //Le placeholder dans lequel sera affiché le résultat (div dont la class a été récupérée)
	let placeholderAllergene = selectedAllergene; 
    //Comme on ne Loop pas et qu on a qu'un résultat=>on spécifie l'index du json retourné (un seul index de json  =>on spécifie [0])puis le nom de la clé

	let	out = `
            <p>Allergène sélectionné: N°ID et Libellé</p>
            <input type="text" class="allergeneChoosenID" readonly name="allergeneChoosenID" id="allergeneChoosenID" value="${allergeneID[0]['allergene_id']}"><br>
            <input type="text" class="allergeneChoosenName" readonly name="allergeneChoosenName" id="allergeneChoosenName" value="${allergeneID[0]['libelle']}"><br>
		`;
    
    //à l'intérieur du placeholder ('div'), on intégre l'ensemble des éléments cités dans la variable out 
	placeholderAllergene.innerHTML = out;

}).catch((error) => {
    console.log("Erreur lors de la requête:", error);
  });

}



export {getAllergeneJS as getAllergeneJS};
