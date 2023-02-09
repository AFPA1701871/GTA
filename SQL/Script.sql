USE gta;

CREATE TABLE IF NOT EXISTS utilisateurs (
idUtilisateur int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
nom varchar(50) NOT NULL,
prenom varchar(50) NOT NULL,
adresseMail varchar(50) UNIQUE NOT NULL,
motDePasse varchar(50) NOT NULL,
role int(11) NOT NULL COMMENT '2 Admin 1 User'
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE IF NOT EXISTS gta_textes (
idTexte int (11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
codeTexte varchar (50) NOT NULL,
fr LONGTEXT NOT NULL,
en LONGTEXT NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8;