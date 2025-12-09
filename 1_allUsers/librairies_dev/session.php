<?php
//ATTENTION: Il faut absolument que l'instruction de démarrage de session se trouve avant tout contenu HTML.

/*Pour utiliser les sessions, il faut le préciser avant tout contenu html.

Pour cela, on doit écrire l'instruction :
CTRL+C pour copier, CTRL+V pour coller*/


session_start();


/*Dans la suite de la page, il suffit d'utiliser le tableau associatif $_SESSION[ ] :
CTRL+C pour copier, CTRL+V pour coller*/

$_SESSION['ma_session'] = 'je suis une variable de session';

$_SESSION['ma_session'] = 'je suis une variable de session';

/*Méthode
: Récupérer une variable de Session

Pour récupérer une variable de session, on doit démarrer la session et utiliser le tableau associatif $_SESSION[ ].
CTRL+C pour copier, CTRL+V pour coller
*/

session_start();


echo $_SESSION['ma_session'];

session_start();
echo $_SESSION['ma_session'];

/*Méthode
: Détruire une variable de Session

Pour détruire une variable de session, on doit effacer le contenu de la variable et couper la session.
CTRL+C pour copier, CTRL+V pour coller
*/

session_start();


// On écrase le tableau de session


$_SESSION = array();


// On détruit la session


session_destroy();

