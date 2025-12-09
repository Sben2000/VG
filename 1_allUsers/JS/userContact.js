/******************************Function importée_NavHeader***********************************/
//Function importée et dévellopée dans scriptHeader.js
import {mainNav} from './scriptHeader.js';
mainNav();


/*******Montrer les mots de passes du formulaire d'enregistrement SignUp**************************/
const checkbox = document.getElementById("passCheckbox");
const passInput1 = document.getElementById("pass1");//querySelectorAll("input[type=password]"); --> n'arrive pas à tous les modifier avec une seule query (même avec une classe commune) donc décomposé en id
const passInput2 = document.getElementById("pass2");


checkbox.addEventListener("change",()=>{
    if(checkbox.checked){      //si la checkbox est coché (checked)        
        passInput1.type="text";// "change le type de l'input password en text"
        passInput2.type="text";  

    }else{
        passInput1.type="password";
        passInput2.type="password";

    }
})

