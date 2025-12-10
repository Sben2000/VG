


//on récupère le selecteur de theme
const selectorThemes = document.getElementById('selectorThemes');
//on récupère la classe de la div de création  de theme
const newTheme = document.querySelector('.newTheme');
//on récupère la classe d'affichage du thème sélectionné' 
const selectedTheme = document.querySelector('.selectedTheme');

//on récupère l'id de l'option affiché issue de la DB
const optionDBthe = document.getElementById('optionDBthe');
//on récupère l'id du texte mentionnant l'option sélectionnée issue du fetch getThemeJS
const TheSelected = document.getElementById('TheSelected');
//on récupère l'id de l'option mentionnant "Créer thème" 
const creaTheme = document.getElementById('creaTheme');

//on récupère le bouton permettant de soumettre le thème à créer
const createThemeButton = document.getElementById('createThemeButton');
function manageThemeJS(){
//Lors du click sur le selecteur
selectorThemes.addEventListener("click",()=>{

    //on écoute les changements de valeurs et on définit une action à chaque cas
    selectorThemes.addEventListener('change', ()=>{
        switch (selectorThemes.value){
            case "Créertheme":
                //on affiche le block et bouton pour créer et on rend ou maintien inactif le block affichant le sélectionné
                newTheme.style.display = 'block';
                selectedTheme.style.display= 'none';
                createThemeButton.style.display= 'block';
                //console.log(selectorThemes.value);

                break;
            case "none":
                //on rend inactif tous les blocks
                newTheme.style.display= 'none';
                selectedTheme.style.display= 'none';
                createThemeButton.style.display='none';
                //console.log(selectorThemes.value);

                break;
            case "disabled":
                //on rend inactif tous les blocks
                newTheme.style.display= 'none';
                selectedTheme.style.display= 'none';
                createThemeButton.style.display='none';
                //console.log(selectorThemes.value);

                break;
            default:
                //on rend ou maintien inactif le block et bouton  pour créer et on affiche le selected
                newTheme.style.display= 'none';
                selectedTheme.style.display= 'block';
                createThemeButton.style.display='none';
                //console.log(selectorThemes.value);
          
                break;                

                
        }
    })
})
}
function getThemeJS(){

}

export {manageThemeJS as manageThemeJS};

export {getThemeJS as getThemeJS};
