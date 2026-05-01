<?php

/*Note, le bouton de chargement permettant le process ci dessous n'est disponible que lorsque le JS a validé le fichier
(il n'est plus possible d'en choisir un autre, bouton "choisir un fichier" rendu innaccessible)
Cette étape est réalisée en PHP car le JS ne parvient pas à uploader dans le dossier 
 l'image prévisualisée en intégrant une seconde fonction (après enregistrement des données du menu dans la DB)"
*/

/*Lors de la soumission du fichier image Confirmé*/
function confirmPicture(){
if (isset($_POST['uploadButton'])) {
    //Si image chargée
    if(isset($_FILES['imageUpload']))
        
    { 
        $dossier = 'uploads/';
        $fichier = basename($_FILES['imageUpload']['name']);
        $target_dir = $dossier . $fichier;

        if(move_uploaded_file($_FILES['imageUpload']['tmp_name'], $target_dir)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
        {
            return ('success');
        }
        else //Sinon (la fonction renvoie FALSE).
        {
            return ('Echec de l\'upload !') ;
        }
  }
}
}

?>