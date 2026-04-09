<?php 

//source: https://vincent-vanneste.fr/views/php/co/Cookies.html
/*$_COOKIE[ ]
Définition
: Cookie

Un cookie est le moyen donné à l'administrateur d'un site, de stocker des informations chez le client.

Il est stocké dans un fichier texte, dans un répertoire particulier et pour une durée donnée.

Les limites :

    Leur nombre total est limité à 300.

    La taille maximale d'un cookie est de 4 ko.

    Il ne peut exister au maximum que 20 cookies par domaine.

    L'utilisateur peut les supprimer voir les modifier à tout moment.

L'intérêt des cookies est de pouvoir partager des informations entre toutes les pages de votre site.

Par exemple, dans l'index du site vous demandez la langue de l'utilisateur et vous la stockez dans la variable langue.

Désormais, vous pouvez accéder à cette information dans toutes les pages de votre site, sans devoir de nouveau interroger l'utilisateur.

Pour en savoir plus
Méthode
: Créer un Cookie

L'instruction setcookie permet de créer un cookie.

On donne un nom à son cookie et un contenu :
CTRL+C pour copier, CTRL+V pour coller
*/

setcookie('mon_cookie','ça fonctionne !');

setcookie('mon_cookie','ça fonctionne !');

/**Méthode
: Récupérer un Cookie

Pour récupérer un cookie on utilise le tableau associatif $_COOKIE[ ].
CTRL+C pour copier, CTRL+V pour coller
*/

$mon_cookie = $_COOKIE['mon_cookie'];

$mon_cookie = $_COOKIE['mon_cookie'];

/*
Méthode
: Tableau

Pour transmettre un tableau de données dans un cookie, on peut utiliser la fonction serialize qui transforme notre tableau en chaîne de caractères qui pourra être récupéré avec la fonction unserialize.
CTRL+C pour copier, CTRL+V pour coller

*/
$data = ['nom'=>'dupont', 'prenom'=>'jean'];



setcookie('mon_cookie',serialize($data));

$data = ['nom'=>'dupont', 'prenom'=>'jean'];
setcookie('mon_cookie',serialize($data));
/*
Récupération de notre cookie :
CTRL+C pour copier, CTRL+V pour coller
*/

$data = unserialize($_COOKIE['mon_cookie']);