/******************************Function importée_NavHeader***********************************/
//Function importée et dévellopée dans scriptHeader.js
import {mainNav} from './scriptHeader.js';
mainNav();


/*******Montrer le mot de passe de la page Login**************************/
const checkbox = document.getElementById("passCheckbox");
const passInput1 = document.getElementById("pass1");//querySelectorAll("input[type=password]"); --> n'arrive pas à tous les modifier avec une seule query (même avec une classe commune) donc décomposé en id

checkbox.addEventListener("change",()=>{
    if(checkbox.checked){      //si la checkbox est coché (checked)        
        passInput1.type="text";// "change le type de l'input password en text"
    }else{
        passInput1.type="password";
    }
})
