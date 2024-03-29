DROP DATABASE IF EXISTS GTA;

CREATE DATABASE GTA DEFAULT CHARACTER SET utf8;

USE GTA;

--
-- Table TypePrestations
--
DROP TABLE IF EXISTS gta_TypePrestations;

CREATE TABLE gta_TypePrestations(
   idTypePrestation INT AUTO_INCREMENT PRIMARY KEY,
   numeroTypePrestation INT NOT NULL,
   libelleTypePrestation VARCHAR(255) NOT NULL,
   motifRequis INT,
   uoRequis INT,
   projetRequis INT,
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table Activites
--
DROP TABLE IF EXISTS gta_Activites;

CREATE TABLE gta_Activites(
   idActivite INT AUTO_INCREMENT PRIMARY KEY,
   libelleActivite VARCHAR(100) NOT NULL,
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table Projets
--
DROP TABLE IF EXISTS gta_Projets;

CREATE TABLE gta_Projets(
   idProjet INT AUTO_INCREMENT PRIMARY KEY,
   codeProjet VARCHAR(20) NOT NULL,
   libelleProjet TEXT NOT NULL,
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table Fermetures
--
DROP TABLE IF EXISTS gta_Fermetures;

CREATE TABLE gta_Fermetures(
   idFermeture INT AUTO_INCREMENT PRIMARY KEY,
   dateFermeture DATE NOT NULL UNIQUE,
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table Conversions
--
DROP TABLE IF EXISTS gta_Conversions;

CREATE TABLE gta_Conversions(
   idConversion INT AUTO_INCREMENT PRIMARY KEY,
   nbHeureConversion INT NOT NULL,
   coeffConversion DECIMAL(3, 2),
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table Uos
--
DROP TABLE IF EXISTS gta_Uos;

CREATE TABLE gta_Uos(
   idUo INT AUTO_INCREMENT PRIMARY KEY,
   numeroUo varchar(10) NOT NULL,
   libelleUo VARCHAR(200),
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table Centres
--
DROP TABLE IF EXISTS gta_Centres;

CREATE TABLE gta_Centres(
   idCentre INT AUTO_INCREMENT PRIMARY KEY,
   nomCentre VARCHAR(50) NOT NULL,
   numeroCentre VARCHAR(10) NOT NULL,
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table Roles
--
DROP TABLE IF EXISTS gta_Roles;

CREATE TABLE gta_Roles(
   idRole INT AUTO_INCREMENT PRIMARY KEY,
   nomRole VARCHAR(50) NOT NULL,
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table Motifs
--
DROP TABLE IF EXISTS gta_Motifs;

CREATE TABLE gta_Motifs(
   idMotif INT AUTO_INCREMENT PRIMARY KEY,
   codeMotif INT NOT NULL,
   libelleMotif VARCHAR(255) NOT NULL,
   idTypePrestation INT,
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table Prestations
--
DROP TABLE IF EXISTS gta_Prestations;

CREATE TABLE gta_Prestations(
   idPrestation INT AUTO_INCREMENT PRIMARY KEY,
   codePrestation VARCHAR(10) NOT NULL,
   libellePrestation TEXT,
   idActivite INT NOT NULL,
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table Utilisateurs
--
DROP TABLE IF EXISTS gta_Utilisateurs;

CREATE TABLE gta_Utilisateurs(
   idUtilisateur INT AUTO_INCREMENT PRIMARY KEY,
   nomUtilisateur VARCHAR(100) NOT NULL,
   mailUtilisateur VARCHAR(50) NOT NULL,
   matriculeUtilisateur VARCHAR(50) NOT NULL UNIQUE,
   passwordUtilisateur VARCHAR(250) NOT NULL,
   idUo INT NULL,
   idRole INT NOT NULL,
   idManager INT,
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table Logs
--
DROP TABLE IF EXISTS gta_Logs;

CREATE TABLE IF NOT EXISTS gta_Logs (
   idLog int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   actionLog varchar(100) NOT NULL,
   idUtilisateur int(11) NOT NULL,
   dateModifiee date DEFAULT NULL,
   prisEnCompte tinyint(1) DEFAULT '0',
   dateLog datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   userLog varchar(50) DEFAULT NULL,
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table Associations
--
DROP TABLE IF EXISTS gta_Associations;

CREATE TABLE gta_Associations(
   idAssociation INT AUTO_INCREMENT PRIMARY KEY,
   idPrestation INT,
   idProjet INT,
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table Contrats
--
DROP TABLE IF EXISTS gta_Contrats;

CREATE TABLE gta_Contrats(
   idContrat INT AUTO_INCREMENT PRIMARY KEY,
   idCentre INT,
   idUtilisateur INT,
   dateDebutContrat DATE NOT NULL,
   dateFinContrat DATE NOT NULL,
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table Pointages
--
DROP TABLE IF EXISTS gta_Pointages;

CREATE TABLE gta_Pointages(
   idPointage INT AUTO_INCREMENT PRIMARY KEY,
   idMotif INT,
   idPrestation INT,
   idProjet INT,
   idUo INT,
   idUtilisateur INT NOT NULL,
   idTypePrestation INT NOT NULL,
   datePointage DATE NOT NULL,
   validePointage BOOLEAN DEFAULT 0,
   reportePointage BOOLEAN DEFAULT 0,
   nbHeuresPointage DECIMAL(15, 2),
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table Preferences
--
DROP TABLE IF EXISTS gta_Preferences;

CREATE TABLE gta_Preferences(
   idPreference INT AUTO_INCREMENT PRIMARY KEY,
   idMotif INT,
   idPrestation INT NOT NULL,
   idProjet INT,
   idUo INT,
   idUtilisateur INT NOT NULL,
   idTypePrestation INT NOT NULL,
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

--
-- Table ActivitesParTypes
--
DROP TABLE IF EXISTS gta_ActivitesParTypes;

CREATE TABLE gta_ActivitesParTypes(
   idActivitesParTypes INT AUTO_INCREMENT PRIMARY KEY,
   idTypePrestation INT,
   idActivite INT,
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS gta_Textes (
   idTexte int (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   codeTexte varchar (50) NOT NULL,
   fr LONGTEXT NOT NULL,
   en LONGTEXT NOT NULL,
   dateCreation datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
   dateModification datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE = InnoDB DEFAULT CHARSET = utf8;
