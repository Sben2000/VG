/**************************Import des functions extérieures********************************/
//Function importée et dévellopée dans previewImage.js
import {prImg} from './previewImg.js';

//Function importée et dévellopée dans selectTheme.js
import {getThemeJS} from './selectTheme.js';

//Function importée et dévellopée dans selectRegime.js
import {getRegimeJS} from './selectRegime.js';

/*******************Déclaration des variables nécessaires à l'interactivité et représentant les éléments du DOM***************************** */
/****Elément renseignés dans le formulaire:*****/
  //Le Formulaire au complet
let myForm =  document.getElementById('myForm');
  //Le Selecteur de thèmes
let selectorThemes=document.getElementById('selectorThemes');

  //Le Selecteur de régimes
let selectorRegimes=document.getElementById('selectorRegimes');

  //Image sélectionnée 
let imageSelected = document.getElementById("imageSelected")
  //Titre du Menu
let menuTitle = document.getElementById('menuTitle');
  //Description du menu
let textInput = document.getElementById('textInput');
  //Nbre pers min
let minPeople= document.getElementById('minPeople');
  //Quantité restante
let remainQty= document.getElementById('remainQty');
  //Prix du menu
let menuPrice= document.getElementById('menuPrice');
  //bouton submit "Créer le menu"
let sendData= document.getElementById('sendData');
  //Gestion/affichage des erreurs du formulaire
let errorMessage = document.getElementById('errorMessage');

/*****Eléments de Prévisualisation:****/
  //Image prévisualisée
let previewImage= document.getElementById('previewImage');
  //Titre prévisualisé
let inputTitleContent = document.getElementById('inputTitleContent');
  //Description prévisualisée
let inputContent = document.getElementById('inputContent');
//Quantité prévisualisée
let inputQtyNumber = document.querySelector('.qtyNumber');
//Nbre Pers. prévisualisé
let inputPeopleNumber = document.querySelector('.peopleNumber');

  //Prix prévisualisé
let inputPriceNumber = document.querySelector('.priceNumber');

//Message de succès du retour de la function funcFetchedJS
let successFetch = document.getElementById('successFetch');

/*****Etape finale de chargement de l'image:****/
  //Upload form
  let Uploadform = document.getElementById('Uploadform');
  //image à Uploader
let imageUpload = document.getElementById('imageUpload');



/******************************Application de la Function importée de confirmation et représentation du thème sélectionné ********************************************************/


//Initialisation d'une variable de récupération id
let idTheme="" ;

//target de la valeur de la cible (e)  du selector et application de  getThemeJS pour afficher les éléments séléctionnés
selectorThemes.addEventListener("change", (e) => {
 getThemeJS(e.target.value);
 //assignation de l'id de la target à la variable de récupération
 idTheme = e.target.value;


})


/******************************Application de la Function importée de confirmation et représentation du régime sélectionné ********************************************************/
//Initialisation d'une variable de récupération id
let idRegime="" ;


//target de la valeur de la cible (e)  du selector et application de  getThemeJS pour afficher les éléments séléctionnés
selectorRegimes.addEventListener("change", (e) => {
getRegimeJS(e.target.value);
 //assignation de l'id de la target à la variable de récupération
idRegime = e.target.value;

})

/***************************************Application de la Function importée de prévisualisation à la Sélection de l'image ********************************************************/

//Dès que l'img est sélectionné (change) on lui applique la function previewImage qui se chargera de l'affecter temporairement dans la destination (intégration définitive en php après validation)
 imageSelected.addEventListener('change', prImg);


/**********************************Interactivities utilisant les événement oninput *******************************************/

//Recopie de du textarea dans la prévisualisation
  textInput.oninput = function(){
    inputContent.innerHTML = textInput.value;
    }

//Recopie du textarea dans la prévisualisation
  menuTitle.oninput = function(){
    inputTitleContent.innerHTML = menuTitle.value;
    }
//Recopie du nombre de pers. min dans la prévisualisation
  minPeople.oninput = function(){
    inputPeopleNumber.innerHTML = minPeople.value;
    }
//Recopie de la quantité min dans la prévisualisation
  remainQty.oninput = function(){
    inputQtyNumber.innerHTML = remainQty.value;
    }
//Recopie du Prix dans la prévisualisation
  menuPrice.oninput = function(){
    inputPriceNumber.innerHTML = menuPrice.value;
    }
/***************************************Contrôle des données soumises et envoi des données au Back End********************************************************/
  //via event.preventDefault() => pour Prévenir l'action par défaut 

//Function de contrôles à la soumission du formulaire
myForm.addEventListener("submit", function(event){
  //temporisation de la soumission après série de contrôles
  event.preventDefault();

  //contrôle de la selection d'un thème
  if(idTheme==false){
    errorMessage.innerHTML="Veuillez sélectionner un thème ";
    return false;
  }
  
  //contrôle de la selection d'un régime
  if(idRegime==false){
    errorMessage.innerHTML="Veuillez sélectionner un régime ";
    return false;
  }

  //contrôle de la validation de l'image du menu
  
  if (previewImage.style.display !="block"){
    errorMessage.innerHTML="Une image respectant les caratéristiques doit être chargée ";
    return false;
 }
  //Trim du nom de l'image (contrôle de la longueur faite dans  previewImg.js importée)
  let imageSelectedName = imageSelected.files[0].name;
  let imageSelectedCleanName = imageSelectedName.trim();


  //Trim de la valeur du Titre et contrôle de la longueur de cette valeur
  
   let menuTitleCleanValue = menuTitle.value.trim();
  if(menuTitleCleanValue.length<5 || menuTitleCleanValue.length>30){
    errorMessage.innerHTML="Le titre doit comporter entre 5 et 30 caractères ";
    return false;
  }


   //Trim de la valeur de la description et contrôle de la longueur de cette valeur
  
 let textInputCleanValue = textInput.value.trim();
  if(textInputCleanValue.length<10 || textInputCleanValue.length>500){
    errorMessage.innerHTML="La description doit comporter entre 10 et 500 caractères ";
    return false;
  }


  //Contrôle de la catégorie

 //Trim de la valeur de quantité personnes min et contrôle du format

  let minPeopleCleanValue = minPeople.value.trim();
  // si la valeur calculée est de type "NaN" ou si la valeur est vide ou si la valeur est négative
  if(minPeopleCleanValue * 2 =="NaN" || minPeopleCleanValue =="" || minPeopleCleanValue * 2 < 0 ){
    errorMessage.innerHTML="Veuillez entrer un nbre de pers.min  au format mentionné entre 00 et 500 ";
    return false;
  }  


  //Trim de la valeur de Qté et contrôle du format

  let remainQtyCleanValue = remainQty.value.trim();
  // si la valeur calculée est de type "NaN" ou si la valeur est vide ou si la valeur est négative
  if(remainQtyCleanValue * 2 =="NaN" || remainQtyCleanValue =="" || remainQtyCleanValue * 2 < 0 ){
    errorMessage.innerHTML="Veuillez entrer une quantité au format mentionné entre 00 et 500 ";
    return false;
  }



  //Trim de la valeur du prix et contrôle du format

  let menuPriceCleanValue = menuPrice.value.trim();
  // si la valeur calculée est de type "NaN" ou si la valeur est vide ou si la valeur est négative
  if(menuPriceCleanValue * 2 =="NaN" || menuPriceCleanValue =="" || menuPriceCleanValue * 2 < 0 ){
    errorMessage.innerHTML="Veuillez entrer un prix au format mentionné entre 0.00 et 500.00 ";
    return false;
  }


//Echapper les éventuels caractères indésirables (< > " ') des inputs

  //1) via encodeURIComponent() (anciennement escape()) ->échappe tous sauf :  - _ . ! ~ * ' ( )
  //remplace:  " par %22, < par %3C et > par %3E

  const regex1 = /["<>]/gs;/*Note: normalement flag g pour matcher toutes les instances (i si besoin Lower+Uppercase) et s pour les multilignes
                       dans notre cas, on encode dès le premier cas rencontré(gs facultatif mais laissé par défaut)*/

  if(regex1.test(imageSelectedCleanName)== true){
    //console.log(imageSelectedCleanName);
  imageSelectedCleanName=encodeURIComponent(imageSelectedCleanName);
    //console.log(imageSelectedCleanName);
  }



  if(regex1.test(menuTitleCleanValue)== true){
    //console.log(menuTitleCleanValueValue);
  menuTitleCleanValue=encodeURIComponent(menuTitleCleanValue);
    //console.log(menuTitleCleanValue);
  }
  if (regex1.test(textInputCleanValue)== true){
  //console.log(textInput);
  textInputCleanValue=encodeURIComponent(textInputCleanValue);
  //console.log(textInputCleanValue);
  }

    //categorie à ajouter après création

  if (regex1.test(menuPriceCleanValue)== true){
  menuPriceCleanValue=encodeURIComponent(menuPriceCleanValue);
  //console.log(menuPriceCleanValue);
  }

  if (regex1.test(remainQtyCleanValue)== true){
  remainQtyCleanValue=encodeURIComponent(remainQtyCleanValue);
  //console.log(remainQtyCleanValue);
  }

  if (regex1.test(minPeopleCleanValue)== true){
  minPeopleCleanValue=encodeURIComponent(minPeopleCleanValue);
  //console.log(minPeopleCleanValue);
  }


 //2)Remplacer les éventuels ' par \' dans les valeurs des inputs
 const regex2 = /'/gs;

   if(regex2.test(imageSelectedCleanName)== true){
    //console.log(imageSelectedCleanName);
  imageSelectedCleanName=imageSelectedCleanName.replaceAll("'","\'");
    //console.log(imageSelectedCleanName);
  }

   if(regex2.test(menuTitleCleanValue)== true){
    //console.log(menuTitleCleanValueValue);
  menuTitleCleanValue=menuTitleCleanValue.replaceAll("'","\'");
    //console.log(menuTitleCleanValue);
  }
  if (regex2.test(textInputCleanValue)== true){
  //console.log(textInput);
  textInputCleanValue=textInputCleanValue.replaceAll("'","\'");
  //console.log(textInputCleanValue);
  }

    //categorie à ajouter après création


  if (regex2.test(menuPriceCleanValue)== true){
  menuPriceCleanValue=menuPriceCleanValue.replaceAll("'","\'");
  //console.log(menuPriceCleanValue);
  }

 //3) Test des outputs pour confirmer l'encodage et la restitution au décodage 
  //console.log(menuTitleCleanValue);
  //console.log(textInputCleanValue);
  //console.log(menuPriceCleanValue);
  //console.log(decodeURIComponent(menuTitleCleanValue));
  //console.log(decodeURIComponent(textInputCleanValue));
  //console.log(decodeURIComponent(menuPriceCleanValue));

/****Préparation des datas nettoyées et envoi au Back End *****/

//Initialisation de la variable contenant les clés-valeurs(datas clean)
let datas = {
   "idTheme"  : idTheme,
    "idRegime"  : idRegime,
    "imageSelected": imageSelectedCleanName,
    "menuTitle": menuTitleCleanValue,
    "textInput": textInputCleanValue,
    "remainQty": remainQtyCleanValue,
    "minPeople": minPeopleCleanValue,
    "menuPrice": menuPriceCleanValue
};
/*Controle de l'ensemble des valeurs de l'objet data*/
//console.log(datas.idTheme);
//console.log(datas.idRegime);
//console.log(datas.imageSelected);
//console.log(datas.menuTitle);
//console.log(datas.textInput);
//console.log(datas.menuPrice);

//appel de la function fetch pour envoi des données au back en JSON
      //destination
fetch("Functions/funcFetchedJS.php",
  {//arguments complémentaires
      //methode utilisée
      method: "POST",
      //type et format du contenu:
      headers:{"Content-Type": "application/json; charset=utf8"},
      //Conversion des datas de JS à JSON:
      body: JSON.stringify(datas)
      }
)
  //Promesse et reception de la réponse du php visible dans la console
    //promesse du fichier php convertit au format JS                       
    .then(response=>response.json()) 
    
                                                                    /*Lecture du retour détaillé au format texte si besoin de débugguer*/
                                                                    //  .then(response=>response.text())
                                                                    // .then(datas=>console.log(datas))
  //traitement de la réponse du php et renvoi message au user en fonction du status
  .then(function(status){
    //console.log(status["success"])
      //si success existe dans la réponse php(true),
    if (status[0].success){
      
      //le bouton de confirmation d'upload image apparait pour finaliser l'operation
            //Note: Le bouton "créer le menu" et l'input de prévisualisation sont rendus inaccessibles pour éviter tout changement en cours
       imageSelected.disabled = true;
       sendData.disabled = true; 
      imageUpload.disabled = false;
     alert("Enregistrement des données réussies!! \n =>  finaliser l\'opération en chargeant l\'image acceptée....");
     successFetch.innerHTML="Enregistrement des données réussies <br> => finaliser l\'opération en chargeant ci dessous l\'image acceptée....";
      //sinon affichage du message associée à success=>false
   }else{
    console.log(status[1].message);
    errorMessage.innerHTML=(status[1].message);
    //le block de confirmation image reste inactive 
    
   }
  })
  //gestion des cas d'erreur via la console
  .catch((error)=>{
   console.log(`Erreur lors de la soumission: ${error}`);
  });


})



/**********Contrôle de l'image à Uploadé avec Correspondance image prévisualisé avant Chargement****************** */

imageUpload.addEventListener("change", function(){
  //temporisation de la soumission après série de contrôles

//Récupération des caractéristiques des images 
let imageUploadFile= imageUpload.files[0];
let imageSelectedFile= imageSelected.files[0];

  //Nom
  let imageUploadFileName= imageUploadFile.name;
  let imageSelectedFileName= imageSelectedFile.name;

  //Taille
  let imageUploadFileSize= imageUploadFile.size;
  let imageSelectedFileSize= imageSelectedFile.size;


  //Type(déjà inclus dans la comparaison dans le nom)

if(imageUploadFile.length == 0){
  errorMessage.innerHTML="Veuillez charger un fichier";
  return false;
}
// Comparaison de l'équivalence des noms 
if(imageUploadFileName != imageSelectedFileName){
  errorMessage.innerHTML="Veuillez charger le fichier du même nom";
  return false;
}

// Comparaison de l'équivalence des tailles (à régler à +/- 10 Octets si besoin) (scénarioen cas d'attribution du même nom à autre fichier, par défaut: ajustable)
if(imageUploadFileSize != imageSelectedFileSize  ){
  errorMessage.innerHTML="La taille du fichier ne correspond pas avec le prévisualisé";
  return false;
}

// Comparaison de l'équivalence des extensions (pas utile car déjà dans le nom)


//Si tout est ok, le bouton de chargement n'est plus disable mais le bouton de sélection l'est (afin de prévenir tout changement)

uploadButton.disabled = false;
imageUpload.style.display ="none" ;

})

  

