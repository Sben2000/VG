
/******************************JS APPLIQUE AU MENU NAVBAR ECRAN ET TABLET*************************/



/*on apelle tout les liens a de la nav bar intégré */

let navLinks = document.querySelectorAll(".links a");

/*on récupère l'id du body de la page cliquée*/

let bodyId = document.querySelector("body").id;

/*on utilise une for of loop pour parcourir tous les links de la nav bar*/
for (let link of navLinks){
    /*dans la loop on vérifie si pour le lien, l'id du dataset.active attribut (data-active) est égale à celui de l'id du Body en cours de consultation
    ex: data-active = "index" et body id="index" => les deux font mentions de l'id "index" , on ajoute la class "active" au lien */
   if(link.dataset.active == bodyId){
        /**si c'est le cas, on ajoute au lien, la class "active" */
        link.classList.add("active");
   }
}

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
