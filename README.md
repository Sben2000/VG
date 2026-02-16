

# ------------------- Vite&Go -----------------

**Application personnalisée d’une entreprise de restauration permettant la présentation de celle-ci et la création/commande de menu en ligne**



# -------------- I _ Déploiement --------------


## I.1 _ Stack technique - Configuration utilisée et à avoir au minimum

- **Front-end:** HTML5, CSS3, JavaScript
- **Backend :** PHP >= PHP Version 8.2.12 utilisée avec PDO
- **Base de données:** MySQL
- **Serveur de base de données :** XAMPP 
`(Détails : Version du serveur : 10.4.32-MariaDB, Serveur : 127.0.0.1 via TCP/IP, Type de serveur : MariaDB, Version du protocole : 10, Utilisateur : root@localhost, Jeu de caractères du serveur : UTF-8 Unicode (utf8mb4))`
- **Autres options possibles :** WAMP / MAMP/LAMP
- **Navigateur web populaires** (Chrome, Firefox, etc.)
- **IDE (Environnement de Développement Intégré) utilisé:** VScode 
-**Autres options possibles :** IDE JetBrains,  Editeur de texte: NotePad++, Sublime Text, Brackets, …

**Pour plus de détails, cf. Cf . Partie 2 .1 (choix technologiques)  du document soumis pour évaluation:** `ECF_TPDeveloppeurWebEtWebMobile_copiearendre_BENSITEL_Soufyan`  


## I.2 _ Lien du projet à cloner

`https://github.com/Sben2000/VG.git`  

branche à prendre en compte : `main` => contient la version finale pour l'évaluation.

Les autres branches étant des branches de développement utilisées à certaines périodes du projet (dév de fonctions/parties avant merge) et ne sont donc pas à prendre en compte pour évaluer celui ci.

## I.3 _ Commandes à utiliser pour cloner le projet dans le terminal(bash/shell ou Ide)

`git clone https://github.com/Sben2000/VG.git`

## I.4 Configuration de la base de données

* Créer une base de données nommée `vgo` 
* Identifier le fichier sql présent au chemin `SQL\vgo_last.sql`
* Exécuter l’ensemble des requêtes du fichier ou Importer le fichier ` vgo_last.sql ` dans PhpMyAdmin 
* Vérifier ensuite que la base de données `vgo` précédemment crée est alimentée des tables et données citées dans le fichier ` vgo_last.sql `

## I.5 _ Connexion à la BDD


Les fichiers config.php sont définis avec les valeurs de constantes suivantes afin de faciliter la connexion pour la démo:
**DB credentials:**
`define('DB_HOST','127.0.0.1');` **adresse localhost,**
`define('DB_USER','root');` **par défaut nom d'utilisateur(pour la démo uniquement)**
`define('DB_NAME','vgo');`**Nom de la BDD**
`define('DB_PASS','');`**par défaut pas de MDP pour la démo (uniquement)**

Assurez vous d’implémenter ces mêmes accès pour la Base de donnée créée .
Si vous souhaitez par ailleurs personnaliser ces accès, veuillez modifier les fichiers config.php concernés et listés dans  le document du **dossier DOCKER** (fichier local Readme ou Instructions Docker à lire)=>`VG\DOCKER`

## I.6 _ Lancement de l’application

* Placer le dossier `VG` dans `htdocs` (XAMPP) ou le dossier appropriée pour votre webserver 
* Accéder à l'application via :
`http://localhost/VG`

Ou 

`http://localhost/VG/index.php`


## I.7 _ Déploiement sur DOCKER :
-Aller dans le dossier  `VG\DOCKER`
-Lire et appliquer les instructions du fichier local (**Readme.md en local*** pour le résumé ou **Instructions Docker à lire** pour les détails)


# ---------- II _ Compte de connexion :--------

**Si besoin, cf en détail les instructions fournies en partie 4.2 (Informations complémentaires) dans le document soumis pour évaluation :** 
`ECF_TPDeveloppeurWebEtWebMobile_copiearendre_BENSITEL_Soufyan`

**En résumé ci-dessous :**
**>>comptes administrateurs:<<**
o	Utilisation d’un Compte existant possible:
**>>>Email :**`    MrJose@vgo.fr    `**>>>Mot de passe :**`    José33000.      `
**>>>Email :**`    MmeJulie@vgo.fr    `**>>>Mot de passe :**`    Julie33000.      `
Ou 
o	Créer un compte admin via  un **lien caché** mis en place uniquement pour les tests et évaluations (**sera supprimé lors de la mise en production et livraison**)
`http://localhost/VG/1_allUsers/fakeProfilVgTeam.php`

**>>comptes employés:<<**
o	Utilisation d’un Compte existant possible:
**>>>Email :**`    ChefJean@vgo.fr    `**>>>Mot de passe :**`    Jean33000.      `
**>>>Email :**`    CommisMarc@vgo.fr    `**>>>Mot de passe :**`    Marc33000.      `
Ou 
•	créer un  compte employé en étant **connecté en tant qu’admin** puis en accédant depuis la nav bar à l’onglet **« gestion »** puis **« Employés »** . 
Ou 

o	Créer un compte employé via  un le **raccourci caché** mis en place uniquement pour les tests et évaluations (**sera supprimé lors de la mise en production et livraison**)
`http://localhost/VG/1_allUsers/fakeProfilVgTeam.php`

**>>comptes utilisateur:<<**
o	Créer un compte utilisateur **via l’onglet connexion depuis le menu de navigation**, puis cliquer sur le **lien s’inscrire** (renvoyant au même chemin que le lien uri ci-dessous )
Ou
o	en entrant l’uri suivante dans votre navigateur :`http://localhost/VG/1_allUsers/signUP.php`


# III _ Résumé projet et des fonctions principales -

**Cf . Partie 1 du document soumis pour évaluation** `ECF_TPDeveloppeurWebEtWebMobile_copiearendre_BENSITEL_Soufyan`


# ------ IV _ Charte graphique & Maquettes ------

**Cf. dossier:** `VG/MaquetteVG` => débuter avec le document `Notes Maquette_à lire` (avec détails : .doc, .pdf ou en résumé : .txt)

# ------------------ #V _ MCD_MLD -----------------

**Cf. dossier:** `VG/MCD_MLD` => débuter avec le document `Construction du MLD_Readme` (au choix en .doc ou  .pdf)


