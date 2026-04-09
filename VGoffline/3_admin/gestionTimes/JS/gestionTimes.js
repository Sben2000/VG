/*****Application des choix de selection de statut*****/

//Attribution de la valeur de la selection statut à l'input Statut
selectStatut = document.getElementById('selectStatut');
statut = document.getElementById('statut');
selectStatut.addEventListener('change', (e) => {
	statut.value = e.target.value;
});

/*******Execution d'un preventDefault pour surveiller les valeurs input City et Contract soumis via un select et dont la présence de caractères et succeptible d'être ignorée en PHP ) */
//Le Formulaire au complet
let myForm = document.querySelector('#myForm');
let errorMessage = document.querySelector('.errorMessage');
let author = document.querySelector('#author');
let title = document.querySelector('#title');
let Btn = document.querySelector('#Btn');
//Function de contrôles à la soumission du formulaire
myForm.addEventListener('submit', function (event) {
	//temporisation de la soumission après série de contrôles
	event.preventDefault();

	//contrôle du contenu des inputs

	if (statut.value == '') {
		errorMessage.innerHTML = 'Veuillez sélectionner un statut ';
		return false;
	} else {
		errorMessage.innerHTML = '';
		/*Déblocage de l'envoi du formulaire: https://stackoverflow.com/questions/833032/submit-is-not-a-function-error-in-javascript
  form.submit() will not work if the form does not have a <button type="submit">submit</button>
  form element belongs to HTMLFormElement interface, therefore, we can call from prototype directly, this method will always work for any form element.*/
		HTMLFormElement.prototype.submit.call(myForm);
	}
});
