/********************************Construction de la Function de Prévisualisation avec image Selectionnée et image de Destination***************************************************************************/
//function gérant la prévisualisation de l'img et la gestion des messages d'erreurs

function previewImage(e) {
	//on récupère via la target, lors de la selection de l'img:
	const selected = e.target;
	//on récupère l'id de l'img de destination (previsualisé au final)
	const imageDestination = document.getElementById('previewImage');
	/***********************************Gestion de la previsualisation********************************************/
	//si l'img selected est bien uploadé (objet .files existant)
	//et que l'objet files contient  bien une propriété à l'indice [0]
	//console.log(selected.files);

	if (selected.files && selected.files[0]) {
		//on crée un reader depuis la classe FileReader qui permet
		//de lire le contenu de fichier objet File(fichier obtenu à partir d'objet FileList) ou Blob (données) de façon asynchrone
		const reader = new FileReader();
		//.onload est déclenché dès lors qu 'une opération de lecture est menée à bien,
		//la function est ensuite déclenché sur la réalisation à bien de la lecture achevé (reader.onload)
		reader.onload = function (e) {
			//dans l'attribut src de l'image à prévisualiser,
			//on va charger les résultats datas lus par reader vers la destination (en base 64: encodage des données binaires sous forme d'un texte au format ASCII, utilisé pour transférer certains contenus MIME)
			imageDestination.src = e.target.result;
			//Note: ici e.target fait référence l'image lue par reader et contenant l'objet result
			//console.log(e.target);
			//console.log(e.target.result);
		};
		//puis pour pouvoir lire les datas de la destination, on lit l'url contenu dans l'indice [0] du fichier sélectionnée
		reader.readAsDataURL(selected.files[0]);

		//A ce stade le fichier est uniquement prévisualisé mais pas chargé (sera à faire en php si l'image est validée)
	}
	/***********************************Gestion de l'affichage image et des messages de validation ********************************************/
	//intégration des infos du fichier pour l'utilisateur (à maintenir en front end)

	//info fichier récupéré de la propriété [0] du fichier sélectionné:  selected.files[0]
	let file = selected.files[0];
	let fileName = file.name;
	let fileSize = file.size;
	let fileType = file.type;

	//Affichage en fonction des caractéristiques de l'image et mention des caractéristiques ok/nok

	//#fileName
	let name = document.querySelector('#fileName');
	//if nok
	if (fileName.length > 20) {
		//message affiché avec limitation du nbre de caractères du nom de fichier
		name.innerHTML = `${fileName.slice(0, 6)}... => Nb caractères: Nok`;
		name.style.color = 'darkred';
		//bloque affichage de l'image
		imageDestination.style.display = 'none';
		return false; //on clot ainsi la function sans rien retourner en évitant la soumission du formulaire
	} else {
		//else if ok
		name.innerHTML = ` ${fileName} => Nb caractères: ok`;
		name.style.color = 'darkgreen';
	}
	//#fileSize
	let size = document.querySelector('#fileSize');
	//if nok
	if (fileSize > 1024 * 1024 * 2) {
		//message affiché
		size.innerHTML = `${(fileSize / 10e6).toFixed(3)}Mb => Taille: Nok`;
		size.style.color = 'darkred';
		//bloque affichage de l'image
		imageDestination.style.display = 'none';
		return false; //on clot ainsi la function sans rien retourner en évitant la soumission du formulaire
	} else {
		//else if ok
		size.innerHTML = `${(fileSize / 10e6).toFixed(3)}Mb => Taille: ok`;
		size.style.color = 'darkgreen';
	}

	//#fileType
	let type = document.querySelector('#fileType');

	//if nok
	if (!fileType.includes(['image/jpeg, image/jpg, image/png'])) {
		//message affiché
		type.innerHTML = ` ${fileType} => Type: Nok`;
		type.style.color = 'darkred';
		//bloque affichage de l'image
		imageDestination.style.display = 'none';
		return false; //on clot ainsi la function sans rien retourner en évitant la soumission du formulaire
	} else {
		//else if ok
		type.innerHTML = ` ${fileType} => Type: ok`;
		type.style.color = 'darkgreen';
	}

	//Affichage de l'image si toutes les caractéristiques sont OK
	imageDestination.style.display = 'block';

	//Les autres messages seront gérés par le backend  si l'utilisateur persiste à envoyer le fichier invalide
}
/***************************************Application de la Function de prévisualisation à la Sélection de l'image ********************************************************/
//assigne  l'id de l'image sélectionné à la variable imageSelected
let imageSelected = document.getElementById('imageSelected');
//Dès que l'img est sélectionné (change) on lui applique la function previewImage qui se chargera de l'affecter temporairement dans la destination (intégration définitive en php après validation)
imageSelected.addEventListener('change', previewImage);

export { previewImage as prImg };

/*
Suite du code fictif pour une éventuelle soumission

on vérifie que les autres inputs type text ne sont pas vides

si tout est ok

on autorise la soumission
   --In a real scenario, you would allow the form to submit or use AJAX.
    this.submit(); // or use AJAX
});

Gestion du reste avec le back end

}*/
