USE GTA;

--
-- Table Motifs
--
ALTER TABLE
    gta_Motifs
ADD
    CONSTRAINT FK_Motifs_TypePrestations FOREIGN KEY(idTypePrestation) REFERENCES gta_TypePrestations(idTypePrestation);

--
-- Table Prestations
--
ALTER TABLE
    gta_Prestations
ADD
    CONSTRAINT FK_gta_Prestations_gta_Activites FOREIGN KEY(idActivite) REFERENCES gta_Activites(idActivite);

--
-- Table Utilisateurs
--
ALTER TABLE
    gta_Utilisateurs
ADD
    CONSTRAINT FK_Utilisateurs_Uos FOREIGN KEY(idUo) REFERENCES gta_Uos(idUo);

ALTER TABLE
    gta_Utilisateurs
ADD
    CONSTRAINT FK_Utilisateurs_Roles FOREIGN KEY(idRole) REFERENCES gta_Roles(idRole);

ALTER TABLE
    gta_Utilisateurs
ADD
    CONSTRAINT FK_Utilisateurs_Managers FOREIGN KEY(idManager) REFERENCES gta_Utilisateurs(idUtilisateur);

--
-- Table Logs
--
ALTER TABLE
    gta_Logs
ADD
    CONSTRAINT FK_Logs_Utilisateurs FOREIGN KEY(idUtilisateur) REFERENCES gta_Utilisateurs(idUtilisateur);

--
-- Table Associations
--
ALTER TABLE
    gta_Associations
ADD
    CONSTRAINT FK_Associations_Prestations FOREIGN KEY(idPrestation) REFERENCES gta_Prestations(idPrestation);

ALTER TABLE
    gta_Associations
ADD
    CONSTRAINT FK_Associations_Projets FOREIGN KEY(idProjet) REFERENCES gta_Projets(idProjet);

--
-- Table Contrats
--
ALTER TABLE
    gta_Contrats
ADD
    CONSTRAINT FK_Contrats_Centres FOREIGN KEY(idCentre) REFERENCES gta_Centres(idCentre);

ALTER TABLE
    gta_Contrats
ADD
    CONSTRAINT FK_Contrats_Utilisateurs FOREIGN KEY(idUtilisateur) REFERENCES gta_Utilisateurs(idUtilisateur);

--
-- Table Pointages
--
ALTER TABLE
    gta_Pointages
ADD
    CONSTRAINT FK_Pointages_Motifs FOREIGN KEY(idMotif) REFERENCES gta_Motifs(idMotif);

ALTER TABLE
    gta_Pointages
ADD
    CONSTRAINT FK_Pointages_Prestations FOREIGN KEY(idPrestation) REFERENCES gta_Prestations(idPrestation);

ALTER TABLE
    gta_Pointages
ADD
    CONSTRAINT FK_Pointages_TypePrestations FOREIGN KEY(idTypePrestation) REFERENCES gta_TypePrestations(idTypePrestation);

ALTER TABLE
    gta_Pointages
ADD
    CONSTRAINT FK_Pointages_Projets FOREIGN KEY(idProjet) REFERENCES gta_Projets(idProjet);

ALTER TABLE
    gta_Pointages
ADD
    CONSTRAINT FK_Pointages_Uos FOREIGN KEY(idUo) REFERENCES gta_Uos(idUo);

ALTER TABLE
    gta_Pointages
ADD
    CONSTRAINT FK_Pointages_Utilisateurs FOREIGN KEY(idUtilisateur) REFERENCES gta_Utilisateurs(idUtilisateur);

--
-- Table Preferences
--
ALTER TABLE
    gta_Preferences
ADD
    CONSTRAINT FK_Preferences_Motifs FOREIGN KEY(idMotif) REFERENCES gta_Motifs(idMotif);

ALTER TABLE
    gta_Preferences
ADD
    CONSTRAINT FK_Preferences_Prestations FOREIGN KEY(idPrestation) REFERENCES gta_Prestations(idPrestation);

ALTER TABLE
    gta_Preferences
ADD
    CONSTRAINT FK_Preferences_TypePrestations FOREIGN KEY(idTypePrestation) REFERENCES gta_TypePrestations(idTypePrestation);

ALTER TABLE
    gta_Preferences
ADD
    CONSTRAINT FK_Preferences_Projets FOREIGN KEY(idProjet) REFERENCES gta_Projets(idProjet);

ALTER TABLE
    gta_Preferences
ADD
    CONSTRAINT FK_Preferences_Uos FOREIGN KEY(idUo) REFERENCES gta_Uos(idUo);

ALTER TABLE
    gta_Preferences
ADD
    CONSTRAINT FK_Preferences_Utilisateurs FOREIGN KEY(idUtilisateur) REFERENCES gta_Utilisateurs(idUtilisateur);

--
-- Table ActivitesParTypes
--
ALTER TABLE
    gta_ActivitesParTypes
ADD
    CONSTRAINT FK_ActivitesParTypes_TypePrestations FOREIGN KEY(idTypePrestation) REFERENCES gta_TypePrestations(idTypePrestation);

ALTER TABLE
    gta_ActivitesParTypes
ADD
    CONSTRAINT FK_ActivitesParTypes_Activites FOREIGN KEY(idActivite) REFERENCES gta_Activites(idActivite);