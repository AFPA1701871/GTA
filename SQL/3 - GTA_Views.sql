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
 CREATE VIEW gta_View_Pointages AS 
 SELECT po.idPointage, po.datePointage, po.validePointage, po.reportePointage, po.nbHeuresPointage,  po.idUO as "idUO_Pointage",po.idMotif,
 u.idUtilisateur, u.nomUtilisateur, u.mailUtilisateur, u.matriculeUtilisateur, u.passwordUtilisateur, u.idUO as "idUO_Utilisateur", u.idRole, u.idManager, 
 uo.numeroUO, uo.libelleUO,  
 m.codeMotif, m.libelleMotif, 
 pro.idProjet, pro.codeProjet, pro.libelleProjet, 
 pre.idPrestation, pre.codePrestation, pre.libellePrestation, pre.idActivite,
 tp.idTypePrestation, tp.numeroTypePrestation, tp.libelleTypePrestation 
 FROM gta_Pointages po 
 LEFT JOIN gta_Utilisateurs u ON po.idUtilisateur=u.idUtilisateur 
 LEFT JOIN gta_Uos uo ON po.idUO=uo.idUO 
 LEFT JOIN gta_Motifs m ON po.idMotif=m.idMotif 
 LEFT JOIN gta_Projets pro ON po.idProjet=pro.idProjet 
 LEFT JOIN gta_Prestations pre ON po.idPrestation=pre.idPrestation
 LEFT JOIN gta_TypePrestations tp ON po.idTypePrestation = tp.idTypePrestation;

--
-- Vue Preferences
--
CREATE VIEW gta_View_Preferences AS 
 SELECT p.idPreference,   p.idUO as "idUO_Pointage",p.idMotif,
 u.idUtilisateur, u.nomUtilisateur, u.mailUtilisateur, u.matriculeUtilisateur, u.passwordUtilisateur, u.idUO as "idUO_Utilisateur", u.idRole, u.idManager, 
 uo.numeroUO, uo.libelleUO,  
 m.codeMotif, m.libelleMotif, 
 pro.idProjet, pro.codeProjet, pro.libelleProjet, 
 pre.idPrestation, pre.codePrestation, pre.libellePrestation, pre.idActivite,
 tp.idTypePrestation, tp.numeroTypePrestation, tp.libelleTypePrestation 
 FROM gta_Preferences p 
 LEFT JOIN gta_Utilisateurs u ON p.idUtilisateur=u.idUtilisateur 
 LEFT JOIN gta_Uos uo ON p.idUO=uo.idUO 
 LEFT JOIN gta_Motifs m ON p.idMotif=m.idMotif 
 LEFT JOIN gta_Projets pro ON p.idProjet=pro.idProjet 
 LEFT JOIN gta_Prestations pre ON p.idPrestation=pre.idPrestation
 LEFT JOIN gta_TypePrestations tp ON p.idTypePrestation = tp.idTypePrestation;


 CREATE VIEW  gta_View_Motifs as SELECT m.idMotif, m.codeMotif, m.libelleMotif, t.idTypePrestation, t.numeroTypePrestation, t.libelleTypePrestation, t.motifRequis, t.uoRequis, t.projetRequis FROM gta_Motifs as m
INNER JOIN gta_TypePrestations as t on m.idTypePrestation = t.idTypePrestation;

CREATE VIEW gta_View_Prestations as
SELECT p.idPrestation, p.codePrestation, p.libellePrestation,a.idActivite, a.libelleActivite  FROM gta_prestations p
INNER JOIN gta_Activites as a ON p.idActivite = a.idActivite

CREATE VIEW gta_View_Prestations_POintages_Preferences as
SELECT 
p.idPrestation,
p.codePrestation,
p.libellePrestation,
a.idActivite,
a.libelleActivite,
t.idTypePrestation,
t.numeroTypePrestation,
t.libelleTypePrestation,
t.motifRequis,
t.uoRequis,
t.projetRequis,
w.idPreference,
w.idMotif as idMotifPreference,
w.idPrestation as idPrestationPreference,
w.idProjet as idProjetPreference,
w.idTypePrestation as typePrestationPreference,
w.idUtilisateur as idUtilisateurPreference,
po.idPointage,
po.idMotif as idMotifPointage,
po.idPrestation as idPrestationPointage,
po.idProjet as idProjetPointage,
po.idTypePrestation as typePrestationPointage,
po.idUtilisateur as idUtilisateurPointage
FROM gta_view_prestations p 
INNER JOIN gta_activites a ON p.idActivite = a.idActivite
LEFT JOIN gta_activitespartypes apt ON apt.idActivite = a.idActivite
LEFT JOIN gta_typeprestations t ON apt.idTypePrestation = t.idTypePrestation
LEFT JOIN gta_preferences w ON  w.idPrestation = p.idPrestation
LEFT JOIN gta_utilisateurs u ON     w.idUtilisateur = u.idUtilisateur
LEFT JOIN gta_pointages po ON  po.idPrestation = p.idPrestation
LEFT JOIN gta_utilisateurs upo ON     po.idUtilisateur = upo.idUtilisateur;

































DROP VIEW gta_View_Prestations_Pref_Point;
CREATE VIEW gta_View_Prestations_Pref_Point as
SELECT 
p.idPrestation,
p.codePrestation,
p.libellePrestation,
t.numeroTypePrestation,
t.libelleTypePrestation,
t.motifRequis,
t.uoRequis,
t.projetRequis,
w.idPreference,
w.idMotif ,
w.idProjet ,
w.idTypePrestation ,
w.idUtilisateur ,
null as idPointage,
null as datePointage,
null as  mois

FROM gta_view_prestations p 
INNER JOIN gta_activites a ON p.idActivite = a.idActivite
LEFT JOIN gta_activitespartypes apt ON apt.idActivite = a.idActivite
LEFT JOIN gta_typeprestations t ON apt.idTypePrestation = t.idTypePrestation
LEFT JOIN gta_preferences w ON  w.idPrestation = p.idPrestation
UNION 

SELECT 
p.idPrestation,
p.codePrestation,
p.libellePrestation,
t.numeroTypePrestation,
t.libelleTypePrestation,
t.motifRequis,
t.uoRequis,
t.projetRequis,
null as idPreference,
po.idMotif ,
po.idProjet ,
po.idTypePrestation ,
po.idUtilisateur ,
po.idPointage,
po.datePointage,
date_format(po.datePointage,"%Y-%m") as mois

FROM gta_view_prestations p 
INNER JOIN gta_activites a ON p.idActivite = a.idActivite
LEFT JOIN gta_activitespartypes apt ON apt.idActivite = a.idActivite
LEFT JOIN gta_typeprestations t ON apt.idTypePrestation = t.idTypePrestation
LEFT JOIN gta_pointages po ON  po.idPrestation = p.idPrestation;


SELECT distinct `idPrestation`, `codePrestation`, `libellePrestation`, `numeroTypePrestation`, `libelleTypePrestation`, `motifRequis`, `uoRequis`, `projetRequis`,`idMotif`, `idProjet`, `idTypePrestation`, `idUtilisateur` FROM `gta_view_prestations_pref_point` WHERE idUtilisateur=1 AND (mois = "2023-02" || isnull(mois));

INSERT INTO `gta_preferences` (`idPreference`, `idMotif`, `idPrestation`, `idProjet`, `idUO`, `idUtilisateur`, `idTypePrestation`) VALUES
(1, 6, 1, 9, 68, 1, 1);
INSERT INTO `gta_pointages` (`idPointage`, `idMotif`, `idPrestation`, `idProjet`, `idUO`, `idUtilisateur`, `idTypePrestation`, `datePointage`, `validePointage`, `reportePointage`, `nbHeuresPointage`) VALUES
(1, 6, 1, 9, 68, 1, 1, '2023-02-14', NULL, NULL, '1.00'),
(2, 6, 1, 9, 68, 1, 1, '2023-02-15', NULL, NULL, '1.00');