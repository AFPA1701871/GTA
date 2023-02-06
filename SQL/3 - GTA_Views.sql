USE GTA;
--
-- Vue regroupant toutes les infos des utilisateurs actifs et de leurs managers
--
CREATE
 ALGORITHM = UNDEFINED
 VIEW `View_UtilisateurActif_Manager`
 AS SELECT u.idUtilisateur as "idUtilisateur", u.nomUtilisateur as "nomUtilisateur", u.mailUtilisateur as "mailUtilisateur", u.matriculeUtilisateur as "matriculeUtilisateur", u.passwordUtilisateur as "passwordUtilisateur", u.idUO as "idUO_Utilisateur", u.idRole as "idRole_Utilisateur", u.idManager as "idManager", m.nomUtilisateur as "nomManager", m.mailUtilisateur as "mailManager", m.matriculeUtilisateur as "matriculeManager", m.passwordUtilisateur as "passwordManager", m.idUO as "idUO_Manager", m.idRole as "idRole_Manager", m.idManager as "idManager2" FROM gta_utilisateurs u LEFT JOIN gta_utilisateurs m ON u.idManager=m.idUtilisateur WHERE u.idUtilisateur IN (SELECT idUtilisateur FROM gta_contrats WHERE dateDebutContrat < CURRENT_DATE AND dateFinContrat > CURRENT_DATE);

 --
 -- Vue regroupant les utilisateurs et leurs prestations préférées
 --
 CREATE
 ALGORITHM = UNDEFINED
 VIEW `View_Utilisateurs_Preferences_Prestations`
 AS SELECT w.idPreference, u.idUtilisateur, u.nomUtilisateur, u.mailUtilisateur, u.matriculeUtilisateur, u.passwordUtilisateur, u.idUO, u.idRole, u.idManager, p.idPrestation, p.codePrestation, p.libellePrestation, p.idActivite FROM gta_preferences w LEFT JOIN gta_utilisateurs u ON w.idUtilisateur=u.idUtilisateur LEFT JOIN gta_prestations p ON w.idPrestation=p.idPrestation;

 --
 -- Vue Pointages avec satellites
 --
 CREATE
 ALGORITHM = UNDEFINED
 VIEW `View_Pointages_Satellites`
 AS SELECT po.idPointage, po.datePointage, po.validePointage, po.reportePointage, po.nbHeuresPointage, u.idUtilisateur, u.nomUtilisateur, u.mailUtilisateur, u.matriculeUtilisateur, u.passwordUtilisateur, u.idUO as "idUO_Utilisateur", u.idRole, u.idManager, po.idUO as "idUO_Pointage", uo.numeroUO, uo.libelleUO, po.idMotif, m.codeMotif, m.libelleMotif, m.idTypePrestation, pro.idProjet, pro.codeProjet, pro.libelleProjet, pre.idPrestation, pre.codePrestation, pre.libellePrestation, pre.idActivite FROM gta_pointages po LEFT JOIN gta_utilisateurs u ON po.idUtilisateur=u.idUtilisateur LEFT JOIN gta_uos uo ON po.idUO=uo.idUO LEFT JOIN gta_motifs m ON po.idMotif=m.idMotif LEFT JOIN gta_projets pro ON po.idProjet=pro.idProjet LEFT JOIN gta_prestations pre ON po.idPrestation=pre.idPrestation;