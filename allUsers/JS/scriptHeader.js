
function scriptHeader(){

/******************************JS APPLIQUE AU MENU NAVBAR ECRAN ET TABLET*************************/


// Gestion de l'Ouverture /Fermeture du sous Menu Gestion en Mode Large
    //Gère l'ouverture (Link+li "Gestion")
const gestion =document.querySelector('.gestion');

    //Sous menu à ouvrir/Fermer
const vgTeamLM = document.querySelector('#vgTeamLM');

const gestionLink =document.querySelector('.gestionLink');
    //Gère la fermeture (link "Fermer")
const vgTeamClose = document.getElementById('vgTeamClose');

    //function wait avec Promesse de retour pour la gestion des effets de transtions
    //en callback les fonctions de transitions et leur setTimeout propre
    function wait(fonction, millisecondes) {
			return new Promise((resolve) => {
				setTimeout(() => {
					fonction();
					resolve();
				}, millisecondes);
			});
		}


    /*Function rendant active le block vgTeamLM au click
    Ajout de transition via une gestion asynchrone de l'apparition et de l'opacité (initié à 0 par défaut dans le CSS)
    */
   async function vgTeamLMShow(){
    vgTeamLM.style.opacity = 0;
    vgTeamLM.style.display='block';
    /*refactorisé en loop
    await wait(()=>{vgTeamLM.style.opacity = 0.3}, 100);
    await wait(()=>{vgTeamLM.style.opacity = 0.5}, 100);
    await wait(()=>{vgTeamLM.style.opacity = 0.8}, 100);
    await wait(()=>{vgTeamLM.style.opacity = 1}, 100);*/
  let x =0;
  do {
        x=x+0.2;
        await wait(()=>{vgTeamLM.style.opacity = x}, 100);
} while (x <1);
    vgTeamLM.style.opacity = 1;
    vgTeamLM.style.zIndex = 30;
   }

gestion.addEventListener('click', vgTeamLMShow);

//Fermer VgTeam Menu List (avec effet de transition géré par la function Asynchrone vgTeamLMHide())

   async function vgTeamLMHide(){
    vgTeamLM.style.opacity = 1;
    vgTeamLM.style.display='block';
    /*refactorisé en une boucle
    await wait(()=>{vgTeamLM.style.opacity = 0.8}, 100);
    await wait(()=>{vgTeamLM.style.opacity = 0.5}, 100);
    await wait(()=>{vgTeamLM.style.opacity = 0.3}, 100);
    await wait(()=>{vgTeamLM.style.opacity = 0}, 100);*/
let x =1;
do {
    x=x-0.2;
    await wait(()=>{vgTeamLM.style.opacity=x},100);
} while (x>0);
    vgTeamLM.style.opacity = 0;
    vgTeamLM.style.display='none';
   }
vgTeamClose.addEventListener('click',vgTeamLMHide)




/******************************JS APPLIQUE AU HAMBURGER MENU*************************/

const hamMenu =document.querySelector('.ham-menu');

const offScreenMenu = document.querySelector('.off-screen-menu');

//lorsque l'on clique sur le hamMenu,
    

hamMenu.addEventListener('click', ()=>{

    /*on ajoute en cliquant et enlève en recliquant le terme active de la classe .ham-menu (.classList.toggle())
    le changement de logo hamMenu et la sortie ou rentrée du menu latéral avec les liens*/
    hamMenu.classList.toggle('active');
    offScreenMenu.classList.toggle('active');

})

/*
rappel:
.off-screen-menu.active {/*active =>quand il sera appelé via le JS , le parametre right sera =0 de sorte qu'il apparaitra*/
        //right: 0px;//fera apparaitre le menu en forçant right=0 via le JS
    //}

}

export {scriptHeader as mainNav};