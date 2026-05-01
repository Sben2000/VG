-- Active: 1744145110317@@localhost@3306@vgo

/************CREATION DES TABLES***********************/

CREATE TABLE horaire(
  horaire_id INT NOT NULL AUTO_INCREMENT,
  jour VARCHAR(50) NOT NULL DEFAULT 'cf.page d\' accueil', 
  heure_ouverture VARCHAR(50) NOT NULL DEFAULT 'cf.page d\' accueil',
  heure_fermeture VARCHAR(50) NOT NULL DEFAULT 'cf.page d\' accueil', 
  CONSTRAINT horaire_PK PRIMARY KEY (horaire_id)
);

CREATE TABLE avis (
  avis_id INT NOT NULL AUTO_INCREMENT,
  note VARCHAR(50), /*pas de contrainte NOT NULL car facultatif et  sera vérifié */
  description VARCHAR(50), /*pas de contrainte NOT NULL car facultatif et  sera vérifié */
  statut VARCHAR(50) DEFAULT 'A vérifier', /*par défaut ‘à vérifier’*/
  CONSTRAINT avis_PK PRIMARY KEY (avis_id)
);


CREATE TABLE IF NOT EXISTS role (
  role_id INT NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(50) NOT NULL DEFAULT 'allUsers',/*par défaut compte allUsers*/
  CONSTRAINT role_PK PRIMARY KEY (role_id)
);


CREATE TABLE IF NOT EXISTS regime (
  regime_id INT NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(50) NOT NULL DEFAULT 'non precisé',
  CONSTRAINT regime_PK PRIMARY KEY (regime_id)
);

CREATE TABLE IF NOT EXISTS theme (
  theme_id INT NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(50) NOT NULL DEFAULT 'non precisé',
  CONSTRAINT theme_PK PRIMARY KEY (theme_id)
);

CREATE TABLE IF NOT EXISTS plat (
  plat_id INT NOT NULL AUTO_INCREMENT,
  titre_plat VARCHAR(50) NOT NULL , 
  photo BLOB ,/*peut etre null */
  CONSTRAINT plat_PK PRIMARY KEY (plat_id)
);

CREATE TABLE IF NOT EXISTS allergene (
  allergene_id INT NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(50) NOT NULL DEFAULT 'non precisé',/*par défaut pour ne pas avoir de valeur vide*/
  CONSTRAINT allergene_PK PRIMARY KEY (allergene_id)
);


CREATE TABLE IF NOT EXISTS utilisateur (
  utilisateur_id INT NOT NULL AUTO_INCREMENT,
nom_utilisateur VARCHAR(50) NOT NULL, /*ajouté , pas dans le MCD de départ, sera exigé dans la création de compte*/
  email VARCHAR(50) NOT NULL,
  password VARCHAR(50) NOT NULL, 
  nom VARCHAR(50) DEFAULT 'A COMPLETER SI LIVRAISON', /*ajouté , pas dans le MCD de départ*/
  prenom VARCHAR(50) DEFAULT 'A COMPLETER SI LIVRAISON', /*peut etre null si pas de commande à livrer*/
  telephone VARCHAR(50) NOT NULL,
  ville VARCHAR(50) DEFAULT 'A COMPLETER SI LIVRAISON' , /*peut etre null si pas de commande à livrer*/
  pays VARCHAR(50) DEFAULT 'A COMPLETER SI LIVRAISON', /*peut etre null si pas de commande à livrer*/
  adresse_postale VARCHAR(50) DEFAULT 'A COMPLETER SI LIVRAISON', /*peut etre null si pas de commande à livrer*/
  role_id INT ,
  CONSTRAINT utilisateur_PK PRIMARY KEY (utilisateur_id),
  CONSTRAINT utilisateur_role_id_FK FOREIGN KEY (role_id) REFERENCES role (role_id)
);


CREATE TABLE IF NOT EXISTS contient (
  allergene_id INT, /*peut etre null si pas d’allergène particulier*/
  plat_id INT  , 
  CONSTRAINT contient_PK PRIMARY KEY (allergene_id, plat_id),/*Clé primaire dont la référence est composée des valeurs combinés des deux clés étrangères : Composite Key. Une même combinaison est unique et ne peut être reproduite*/
  CONSTRAINT contient_allergene_id_FK FOREIGN KEY (allergene_id) REFERENCES allergene (allergene_id),
  CONSTRAINT contient_plat_id_FK FOREIGN KEY (plat_id) REFERENCES plat (plat_id)
);


CREATE TABLE IF NOT EXISTS menu (
    menu_id INT NOT NULL AUTO_INCREMENT,
    regime_id INT, /*peut être null*/
    theme_id INT, /*peut être null*/
    titre VARCHAR(50) NOT NULL, /*titre nécessaire -> géré par la création de menu*/
    nombre_personne_minimum INT, /*peut être vide par défaut*/
    prix_par_personne DOUBLE NOT NULL, /*prix nécessaire -> géré par la création de menu*/
    /*regime VARCHAR(50),  /*suppression car fait doublon avec le regime_id*/
    description VARCHAR(50) NOT NULL, /*description nécessaire -> géré par la création de menu*/
    quantite_restante INT, /*facultatif, donc NOT NULL pas necessaire*/
  CONSTRAINT menu_PK PRIMARY KEY (menu_id),
  CONSTRAINT menu_regime_id_FK FOREIGN KEY (regime_id) REFERENCES regime (regime_id),
  CONSTRAINT menu_theme_id_FK FOREIGN KEY (theme_id) REFERENCES theme (theme_id)
);



CREATE TABLE IF NOT EXISTS propose (
  menu_id INT,
  plat_id INT,
  CONSTRAINT propose_PK PRIMARY KEY (menu_id, plat_id),/*Clé primaire dont la référence est composée des valeurs combinés des deux clés étrangères : Composite Key. Une même combinaison est unique et ne peut être reproduite*/
  CONSTRAINT propose_menu_id_FK FOREIGN KEY (menu_id) REFERENCES menu (menu_id),
  CONSTRAINT propose_plat_id_FK FOREIGN KEY (plat_id) REFERENCES plat (plat_id)
);


CREATE TABLE IF NOT EXISTS commande (
  commande_id INT, /*ajouté car un user peut faire plusieurs commande avec le même menu_id (et même user_id)*/
  menu_id INT,
  utilisateur_id INT,
numero_commande VARCHAR(50) NOT NULL, /*sera fabriqué selon une règle particulière*/
date_commande DATE NOT NULL DEFAULT CURRENT_TIMESTAMP, /*(TIMESTAMP DEFAULT NOW())),CURRENT_TIMESTAMP, ou DEFAULT GETDATE()-'YYYY-MM-DD hh:mm:ss.mmm*/
date_prestation DATE, /*peut être null si facultatif*/
heure_livraison VARCHAR(50), /*peut être null si facultatif*/
prix_livraison DOUBLE NOT NULL DEFAULT 0, /*par défaut sera équivalent à 0, sinon sera calculé par règle*/
statut VARCHAR(50) NOT NULL DEFAULT 'crée', /*par défaut a le statut crée*/
pret_materiel BOOLEAN NOT NULL DEFAULT FALSE,
restitution_materiel BOOLEAN NOT NULL DEFAULT FALSE,
  CONSTRAINT commande_PK PRIMARY KEY (commande_id),
  CONSTRAINT commande_menu_id_FK FOREIGN KEY (menu_id) REFERENCES menu (menu_id),
  CONSTRAINT commande_utilisateur_id_FK FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (utilisateur_id)
);

ALTER TABLE commande MODIFY statut VARCHAR(50) NOT NULL DEFAULT 'créée'; /**modification crée en créée (s'agissant de la commande)*/

ALTER TABLE utilisateur MODIFY password VARCHAR(255) NOT NULL; /*Dans l'énoncé =>VARCHAR(50) hors il est conseillé de pouvoir storer au moins 60 carac par PHP pour un password, 255 char préconisés*/

ALTER TABLE utilisateur Add COLUMN code_postal VARCHAR(50) DEFAULT '0000'; /*Ajout du code_postal*/
ALTER TABLE commande Add COLUMN prix_TTC DOUBLE NOT NULL DEFAULT 0; /*Ajout du prix TTC payé dans le détail de la commande*/

ALTER TABLE commande Add COLUMN prix_HT DOUBLE NOT NULL DEFAULT 0; /*Ajout du prix HT dans le détail de la commande*/

ALTER TABLE commande Add COLUMN nbr_pers INT NOT NULL DEFAULT 0; /*Ajout du nbre de personne dans la commande*/

ALTER TABLE utilisateur MODIFY nom VARCHAR(50); /*Retrait du Default, car peut rester vide si pas de commande*/

ALTER TABLE utilisateur MODIFY prenom VARCHAR(50); /*Retrait du Default, car peut rester vide si pas de commande*/

ALTER TABLE utilisateur MODIFY telephone VARCHAR(50); /*Retrait du Default, car peut rester vide si pas de commande*/

ALTER TABLE utilisateur MODIFY ville VARCHAR(50); /*Retrait du Default, car peut rester vide si pas de Livraison*/

ALTER TABLE utilisateur MODIFY pays VARCHAR(50); /*Retrait du Default, car peut rester vide si pas de Livraison*/

ALTER TABLE utilisateur MODIFY adresse_postale VARCHAR(50); /*Retrait du Default, car peut rester vide si pas de commande/Livraison*/

ALTER TABLE utilisateur MODIFY code_postal VARCHAR(50); /*Retrait du Default, car peut rester vide si pas de commande/Livraison*/

ALTER TABLE utilisateur MODIFY telephone VARCHAR(50); /*Retrait du NOT NULL, car peut rester vide si pas de commande/Livraison*/

ALTER TABLE menu ADD COLUMN photo_menu VARCHAR(50); /*Ajouté pour  permettre au menu d'avoir sa propre photo générale suite à Upload des images*/

ALTER TABLE menu  MODIFY menu_id INT NOT NULL AUTO_INCREMENT ; /*Modifié en NOT NULL AUTO INCREMENT*/

ALTER TABLE menu DROP COLUMN regime; /*suppression de cette colonne car fait doublon avec la clé étrangère regime_id (et son libellé)*/

ALTER TABLE plat MODIFY photo MEDIUMBLOB ; /*passage de BLOB en MEDIUMBLOB pour permettre une taille supérieur (16MO max au lieu de 65KOmax)*/

ALTER TABLE plat ADD COLUMN contentType VARCHAR(50); /*Ajouté pour  permettre préciser l'extension de la photo à afficher et eviter les doublons  (doublons de nom sur même type)*/

ALTER TABLE commande MODIFY date_commande DATE ; /*suppression de la date courante par défaut car pose problème sur Docker et est géré en PHP */

/*Ajouté à la commande si l'utilisateur souhaite faire livrer ailleurs que l'adresse indiqué sur son profil*/
ALTER TABLE commande 
ADD  nom_livraison VARCHAR(50) DEFAULT 'A COMPLETER SI LIVRAISON', 
ADD  prenom_livraison VARCHAR(50) DEFAULT 'A COMPLETER SI LIVRAISON', 
ADD  telephone_livraison VARCHAR(50) NOT NULL,
ADD  ville_livraison VARCHAR(50) DEFAULT 'A COMPLETER SI LIVRAISON' , 
ADD  pays_livraison VARCHAR(50) DEFAULT 'A COMPLETER SI LIVRAISON', 
ADD  adresse_postale_livraison VARCHAR(50) DEFAULT 'A COMPLETER SI LIVRAISON'; 
ALTER TABLE commande Add COLUMN code_postal_livraison VARCHAR(50) DEFAULT '0000';

/*Ajout d'une colonne reducion à la table commande*/
ALTER TABLE commande Add COLUMN reduction VARCHAR(50) DEFAULT '0';

/*Augmentation du nombre de caractères dans la description du menu*/
ALTER TABLE menu MODIFY description VARCHAR(500) NOT NULL;


ALTER TABLE utilisateur ADD COLUMN avis_id INT; /*Oubli lors de la construction de la table*/

ALTER TABLE utilisateur
  ADD CONSTRAINT utilisateur_avis_id_FK FOREIGN KEY(avis_id) REFERENCES avis (avis_id) ON UPDATE CASCADE; /*ajout clé étrangère suite à oubli précédent)*/

/********AJOUT DE QUELQUES VALEURS SUR LES TABLES*********/

/*Type de role*/

INSERT INTO 
    role (libelle) 
VALUES 
    ('allUsers'),
    ('vgTeam'),
    ('adminAccess') ;

/*Type de régime*/

INSERT INTO 
    regime (libelle) 
VALUES 
    ('vegetarien'),
    ('vegan'),
    ('classique') ;

/*Type de Thème*/

INSERT INTO 
    theme (libelle) 
VALUES 
    ('specifique'),
    ('jour'),
    ('weekend') ,
    ('gouter') ,
    ('pasta') ;

/**Le reste sera ajouté au fur et à mesure via les interfaces de création/mises à jour intégrés dans les dossiers du projet*/

SELECT * FROM commande;

/**Pour Tests perso**/
INSERT INTO 
    commande (commande_id, utilisateur_id, numero_commande, date_commande, date_prestation, heure_livraison) 
VALUES 
    (1, 18, "827343", "27/09/2020", "28/09/2020","9h"),
    (2, 18, "90JSDFS3", "15/09/2024", "18/09/2024","11h");


/*Tests divers peso*/

/*JOINDRE plusieurs (>2) tables dont les id sont partagées*/
INSERT INTO allergene (allergene_id, libelle) VALUES
(2,"gluten"),
(3, "moutarde");

INSERT INTO plat (plat_id, titre_plat, photo, contentType) VALUES
(2,"café",NULL , "image/jpeg"),
(3, "pizza",NULL , "image/jpeg" );

INSERT INTO contient (plat_id, allergene_id) 
VALUES 
  (2, 1),
  (3, 3);

INSERT INTO contient (plat_id, allergene_id) 
VALUES 
  (49, 1),
  (50, 3);
INSERT INTO contient (plat_id, allergene_id) 
VALUES 
  (49, 2),
  (50, 1);


/*JOIN la table plat à la table contient*/
SELECT * FROM contient INNER JOIN plat ON contient.plat_id = plat.plat_id;
/*JOIN la table allergene à la table contient*/
SELECT * FROM contient INNER JOIN allergene ON contient.allergene_id = allergene.allergene_id;

/*JOIN les 2 tables : "plat" et "allergenes"  à la table contient en mentionnant les colonnes souhaités (plutôt que SELECT * contient pour éviter les doublons des FK)*/
/*important: mentionner le nom de table pour chaque colonne car les FK sont présentes dans 2 tables*/
SELECT contient.allergene_id, contient.plat_id,  allergene.libelle,  plat.titre_plat, plat.photo, plat.contentType FROM contient 
JOIN allergene ON contient.allergene_id = allergene.allergene_id
JOIN plat ON contient.plat_id = plat.plat_id
ORDER BY contient.plat_id ASC;

SELECT contient.allergene_id, contient.plat_id,  allergene.libelle,  plat.titre_plat, plat.photo, plat.contentType FROM contient 
JOIN allergene ON contient.allergene_id = allergene.allergene_id
JOIN plat ON contient.plat_id = plat.plat_id
WHERE contient.plat_id = 50;


/*Exercice et tests sur les tables menu et propose*/

INSERT INTO propose (menu_id, plat_id) 
VALUES 
  (11, 49),
  (10, 50),
  (10, 2),
  (9, 56),
  (9, 55);

  SELECT * FROM menu
  JOIN theme ON menu.theme_id = theme.theme_id;

  SELECT * FROM menu
  JOIN regime ON menu.regime_id = regime.regime_id;


SELECT * FROM propose
JOIN  menu ON propose.menu_id = menu.menu_id;


  SELECT * FROM menu
  JOIN theme ON menu.theme_id = theme.theme_id
  JOIN regime ON menu.regime_id = regime.regime_id;

SELECT propose.menu_id, propose.plat_id,  menu.titre, menu.menu_id,  plat.titre_plat, plat.plat_id, plat.photo FROM propose 
JOIN menu ON propose.menu_id = menu.menu_id
JOIN plat ON propose.plat_id = plat.plat_id;


    SELECT menu.menu_id, menu.regime_id, menu.theme_id, menu.titre, menu.nombre_personne_minimum, menu.prix_par_personne, menu.description, menu.photo_menu, menu.quantite_restante,
     theme.theme_id,theme.libelle as theme,
    regime.regime_id, regime.libelle as regime
      FROM menu
    JOIN theme ON menu.theme_id = theme.theme_id
    JOIN regime ON menu.regime_id = regime.regime_id
    WHERE quantite_restante > 0 AND theme.libelle = "gouter"
    ORDER BY menu_id DESC;
    
   SELECT propose.menu_id, menu.menu_id, menu.regime_id, menu.theme_id, menu.titre, menu.nombre_personne_minimum, menu.prix_par_personne, menu.description, menu.photo_menu, menu.quantite_restante,
    plat.titre_plat, plat.plat_id
    FROM propose
    JOIN menu ON propose.menu_id = menu.menu_id
    JOIN plat ON propose.plat_id = plat.plat_id
    WHERE propose.menu_id = 11;