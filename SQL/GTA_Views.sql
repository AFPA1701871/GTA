USE GTA;
--
-- Vue regroupant toutes les infos des utilisateurs actifs et de leurs managers
--
CREATE
 ALGORITHM = UNDEFINED
 VIEW `View_UtilisateurActif_Manager`
 AS SELECT u.idUtilisateur as "idUtilisateur", u.nomUtilisateur as "nomUtilisateur", u.mailUtilisateur as "mailUtilisateur", u.matriculeUtilisateur as "matriculeUtilisateur", u.passwordUtilisateur as "passwordUtilisateur", u.idUO as "idUO_Utilisateur", u.idRole as "idRole_Utilisateur", u.idManager as "idManager", m.nomUtilisateur as "nomManager", m.mailUtilisateur as "mailManager", m.matriculeUtilisateur as "matriculeManager", m.passwordUtilisateur as "passwordManager", m.idUO as "idUO_Manager", m.idRole as "idRole_Manager", m.idManager as "idManager2" FROM gta_utilisateurs u LEFT JOIN gta_utilisateurs m ON u.idManager=m.idUtilisateur WHERE u.idUtilisateur IN (SELECT idUtilisateur FROM gta_contrats WHERE dateDebutContrat < CURRENT_DATE AND dateFinContrat > CURRENT_DATE);