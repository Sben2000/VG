/******************************Function importée_NavHeader***********************************/
//Function importée et dévellopée dans scriptHeader.js
import {mainNav} from './scriptHeader.js';
mainNav();


/*******Montrer le mot de passe de la page Login**************************/
const checkbox = document.getElementById("passCheckbox");
const passInput = document.querySelector("#pass2");

checkbox.addEventListener("change",()=>{
    if(checkbox.checked){      //si la checkbox est coché (checked)        
        passInput.type="text";// "change le type de l'input password en text"
    }else{
        passInput.type="password";
    }
})



