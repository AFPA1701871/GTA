USE GTA;
--
-- Vue regroupant toutes les infos des utilisateurs actifs et de leurs managers
--
CREATE VIEW gta_View_Utilisateurs AS SELECT
    u.idUtilisateur,
    u.nomUtilisateur,
    u.mailUtilisateur,
    u.matriculeUtilisateur,
    u.idUO ,
    u.idRole ,
    u.idManager,
    m.nomUtilisateur AS "nomManager",
    m.mailUtilisateur AS "mailManager",
    m.matriculeUtilisateur AS "matriculeManager",
    (c.dateDebutContrat <= CURRENT_DATE AND c.dateFinContrat >= CURRENT_DATE) as actif,
    uo.numeroUO,
    uo.libelleUO,
    r.nomRole
FROM
    gta_utilisateurs u
LEFT JOIN gta_Utilisateurs m ON u.idManager = m.idUtilisateur
LEFT JOIN gta_Uos as uo ON u.idUO = uo.idUO
LEFT JOIN gta_Roles as r ON u.idRole = r.idRole
LEFT JOIN gta_Contrats as c ON  c.idContrat in (SELECT idContrat FROM gta_Contrats WHERE gta_Contrats.idUtilisateur = u.idUtilisateur);

 --
 -- Vue regroupant les utilisateurs et leurs prestations préférées
 --
 CREATE
 ALGORITHM = UNDEFINED
 VIEW gta_View_Utilisateurs_Preferences_Prestations
 AS SELECT w.idPreference, u.idUtilisateur, u.nomUtilisateur, u.mailUtilisateur, u.matriculeUtilisateur, u.passwordUtilisateur, u.idUO, u.idRole, u.idManager, p.idPrestation, p.codePrestation, p.libellePrestation, p.idActivite FROM gta_preferences w LEFT JOIN gta_utilisateurs u ON w.idUtilisateur=u.idUtilisateur LEFT JOIN gta_prestations p ON w.idPrestation=p.idPrestation;

 --
 -- Vue Pointages avec satellites
 --
 CREATE
 ALGORITHM = UNDEFINED
 VIEW gta_View_Pointages_Satellites
 AS SELECT po.idPointage, po.datePointage, po.validePointage, po.reportePointage, po.nbHeuresPointage, u.idUtilisateur, u.nomUtilisateur, u.mailUtilisateur, u.matriculeUtilisateur, u.passwordUtilisateur, u.idUO as "idUO_Utilisateur", u.idRole, u.idManager, po.idUO as "idUO_Pointage", uo.numeroUO, uo.libelleUO, po.idMotif, m.codeMotif, m.libelleMotif, m.idTypePrestation, pro.idProjet, pro.codeProjet, pro.libelleProjet, pre.idPrestation, pre.codePrestation, pre.libellePrestation, pre.idActivite FROM gta_pointages po LEFT JOIN gta_utilisateurs u ON po.idUtilisateur=u.idUtilisateur LEFT JOIN gta_uos uo ON po.idUO=uo.idUO LEFT JOIN gta_motifs m ON po.idMotif=m.idMotif LEFT JOIN gta_projets pro ON po.idProjet=pro.idProjet LEFT JOIN gta_prestations pre ON po.idPrestation=pre.idPrestation;

 CREATE VIEW  gta_View_Motifs as SELECT m.idMotif, m.codeMotif, m.libelleMotif, t.idTypePrestation, t.numeroTypePrestation, t.libelleTypePrestation, t.motifRequis, t.uoRequis, t.projetRequis FROM gta_Motifs as m
INNER JOIN gta_TypePrestations as t on m.idTypePrestation = t.idTypePrestation;

CREATE VIEW gta_View_Prestations as
SELECT p.idPrestation, p.codePrestation, p.libellePrestation,a.idActivite, a.libelleActivite  FROM gta_prestations p
INNER JOIN gta_Activites as a ON p.idActivite = a.idActivite