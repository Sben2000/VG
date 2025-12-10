-- Active: 1744145110317@@localhost@3306@vgo

/************CREATION DES TABLES***********************/

CREATE TABLE horaire(
  horaire_id INT NOT NULL AUTO_INCREMENT,
  jour VARCHAR(50) NOT NULL DEFAULT 'cf.page d\' accueil', 
  heure_ouverture VARCHAR(50) NOT NULL DEFAULT 'cf.page d\' accueil',
  heure_fermeture VARCHAR(50) NOT NULL DEFAULT 'cf.page d\' accueil', 
  CONSTRAINT horaire_PK PRIMARY KEY (horaire_id)
)ENGINE=InnoDB;

CREATE TABLE avis (
  avis_id INT NOT NULL AUTO_INCREMENT,
  note VARCHAR(50), /*pas de contrainte NOT NULL car facultatif et  sera vérifié */
  description VARCHAR(50), /*pas de contrainte NOT NULL car facultatif et  sera vérifié */
  statut VARCHAR(50) DEFAULT 'A vérifier', /*par défaut ‘à vérifier’*/
  CONSTRAINT avis_PK PRIMARY KEY (avis_id)
)ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS role (
  role_id INT NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(50) NOT NULL DEFAULT 'allUsers',/*par défaut compte allUsers*/
  CONSTRAINT role_PK PRIMARY KEY (role_id)
)ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS regime (
  regime_id INT NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(50) NOT NULL DEFAULT 'non precisé',
  CONSTRAINT regime_PK PRIMARY KEY (regime_id)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS theme (
  theme_id INT NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(50) NOT NULL DEFAULT 'non precisé',
  CONSTRAINT theme_PK PRIMARY KEY (theme_id)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS plat (
  plat_id INT NOT NULL AUTO_INCREMENT,
  titre_plat VARCHAR(50) NOT NULL , /*sera exigé lors de la création*/
  photo BLOB ,/*peut etre null mais sera géré par la creation menu*/
  CONSTRAINT plat_PK PRIMARY KEY (plat_id)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS allergene (
  allergene_id INT NOT NULL AUTO_INCREMENT,
  libelle VARCHAR(50) NOT NULL DEFAULT 'non precisé',/*par défaut pour ne pas avoir de valeur vide*/
  CONSTRAINT allergene_PK PRIMARY KEY (allergene_id)
)ENGINE=InnoDB;


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
)ENGINE=InnoDB;


CREATE TABLE IF NOT EXISTS contient (
  allergene_id INT, /*peut etre null si pas d’allergène particulier*/
  plat_id INT  , 
  CONSTRAINT contient_PK PRIMARY KEY (allergene_id, plat_id),
  CONSTRAINT contient_allergene_id_FK FOREIGN KEY (allergene_id) REFERENCES allergene (allergene_id),
  CONSTRAINT contient_plat_id_FK FOREIGN KEY (plat_id) REFERENCES plat (plat_id)
)ENGINE=InnoDB;

DROP TABLE menu;

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
)ENGINE=InnoDB;



CREATE TABLE IF NOT EXISTS propose (
  menu_id INT,
  plat_id INT,
  CONSTRAINT propose_PK PRIMARY KEY (menu_id, plat_id),
  CONSTRAINT propose_menu_id_FK FOREIGN KEY (menu_id) REFERENCES menu (menu_id),
  CONSTRAINT propose_plat_id_FK FOREIGN KEY (plat_id) REFERENCES plat (plat_id)
)ENGINE=InnoDB;

DROP TABLE commande;

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
)ENGINE=InnoDB;

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


