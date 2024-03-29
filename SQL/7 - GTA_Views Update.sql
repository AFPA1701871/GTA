USE GTA;

--
-- Vue Pointages avec satellites
--
DROP VIEW IF EXISTS gta_View_Pointages;

CREATE VIEW gta_View_Pointages AS
SELECT
    po.idPointage,
    po.idEntite,
    po.datePointage,
    date_format(po.datePointage, "%Y-%m") as periode,
    po.validePointage,
    po.reportePointage,
    po.nbHeuresPointage,
    po.idUo as "idUo_Pointage",
    po.idMotif,
    u.idUtilisateur,
    u.nomUtilisateur,
    u.mailUtilisateur,
    u.matriculeUtilisateur,
    u.passwordUtilisateur,
    u.idUo as "idUo_Utilisateur",
    u.idRole,
    u.idManager,
    uo.numeroUo,
    uo.libelleUo,
    m.codeMotif,
    m.libelleMotif,
    pro.idProjet,
    pro.codeProjet,
    pro.libelleProjet,
    pre.idPrestation,
    pre.codePrestation,
    pre.libellePrestation,
    pre.idActivite,
    tp.idTypePrestation,
    tp.numeroTypePrestation,
    tp.libelleTypePrestation
FROM
    gta_Pointages po
    LEFT JOIN gta_Utilisateurs u ON po.idUtilisateur = u.idUtilisateur
    LEFT JOIN gta_Uos uo ON po.idUo = uo.idUo
    LEFT JOIN gta_Motifs m ON po.idMotif = m.idMotif
    LEFT JOIN gta_Projets pro ON po.idProjet = pro.idProjet
    LEFT JOIN gta_Prestations pre ON po.idPrestation = pre.idPrestation
    LEFT JOIN gta_TypePrestations tp ON po.idTypePrestation = tp.idTypePrestation;

--
-- Vue Nombre heures pointages par personne par periode
--
DROP VIEW IF EXISTS gta_View_Pointages_Periode;

CREATE VIEW gta_View_Pointages_Periode AS
SELECT
    date_format(po.datePointage, "%Y-%m") as periode,
    sum(po.nbHeuresPointage) as cumulPointage,
    po.idEntite,
    po.validePointage,
    po.reportePointage,
    u.idUtilisateur,
    u.nomUtilisateur,
    u.mailUtilisateur,
    u.matriculeUtilisateur,
    u.idUo as "idUo_Utilisateur",
    u.idRole,
    u.idManager
FROM
    gta_Pointages po
    LEFT JOIN gta_Utilisateurs u ON po.idUtilisateur = u.idUtilisateur
Group BY u.idUtilisateur, periode, po.validePointage, po.reportePointage;

--
-- Vue Preferences
--
DROP VIEW IF EXISTS gta_View_Preferences;

CREATE VIEW gta_View_Preferences AS
SELECT
    p.idPreference,
    p.idEntite,
    p.idUo as "idUo_Pointage",
    p.idMotif,
    u.idUtilisateur,
    u.nomUtilisateur,
    u.mailUtilisateur,
    u.matriculeUtilisateur,
    u.passwordUtilisateur,
    u.idUo as "idUo_Utilisateur",
    u.idRole,
    u.idManager,
    uo.numeroUo,
    uo.libelleUo,
    m.codeMotif,
    m.libelleMotif,
    pro.idProjet,
    pro.codeProjet,
    pro.libelleProjet,
    pre.idPrestation,
    pre.codePrestation,
    pre.libellePrestation,
    pre.idActivite,
    tp.idTypePrestation,
    tp.numeroTypePrestation,
    tp.libelleTypePrestation
FROM
    gta_Preferences p
    LEFT JOIN gta_Utilisateurs u ON p.idUtilisateur = u.idUtilisateur
    LEFT JOIN gta_Uos uo ON p.idUo = uo.idUo
    LEFT JOIN gta_Motifs m ON p.idMotif = m.idMotif
    LEFT JOIN gta_Projets pro ON p.idProjet = pro.idProjet
    LEFT JOIN gta_Prestations pre ON p.idPrestation = pre.idPrestation
    LEFT JOIN gta_TypePrestations tp ON p.idTypePrestation = tp.idTypePrestation;

DROP VIEW IF EXISTS gta_View_Motifs;

CREATE VIEW gta_View_Motifs as
SELECT
    m.idMotif,
    m.idEntite,
    m.codeMotif,
    m.libelleMotif,
    t.idTypePrestation,
    t.numeroTypePrestation,
    t.libelleTypePrestation,
    t.motifRequis,
    t.uoRequis,
    t.projetRequis
FROM
    gta_Motifs as m
    INNER JOIN gta_TypePrestations as t on m.idTypePrestation = t.idTypePrestation;

DROP VIEW IF EXISTS gta_View_Prestations;

CREATE VIEW gta_View_Prestations as
SELECT
    p.idPrestation,
    p.idEntite,
    p.codePrestation,
    p.libellePrestation,
    a.idActivite,
    a.libelleActivite,
    pr.idProjet,
    pr.codeProjet,
    pr.libelleProjet
FROM
    gta_Prestations p
    INNER JOIN gta_Activites as a ON p.idActivite = a.idActivite
    LEFT JOIN gta_Associations ass ON p.idPrestation = ass.idPrestation
    LEFT JOIN gta_Projets pr ON ass.idProjet = pr.idProjet;

DROP VIEW IF EXISTS gta_View_TypePrestations;

CREATE VIEW gta_View_TypePrestations as
SELECT
    p.idPrestation,
    p.idEntite,
    p.codePrestation,
    p.libellePrestation,
    a.idActivite,
    a.libelleActivite,
    t.idTypePrestation,
    t.numeroTypePrestation,
    t.libelleTypePrestation
FROM
    gta_TypePrestations as t
    INNER JOIN gta_ActivitesParTypes at ON t.idTypePrestation = at.idTypePrestation
    INNER JOIN gta_Activites as a ON at.idActivite = a.idActivite
    INNER JOIN gta_Prestations p ON a.idActivite = p.idActivite;

DROP VIEW IF EXISTS gta_View_Prestations_Pref_Point;

CREATE VIEW gta_View_Prestations_Pref_Point as
SELECT
    p.idPrestation,
    p.idEntite,
    p.codePrestation,
    p.libellePrestation,
    t.numeroTypePrestation,
    t.libelleTypePrestation,
    t.motifRequis,
    t.uoRequis,
    t.projetRequis,
    w.idPreference,
    w.idMotif,
    m.codeMotif,
    m.libelleMotif,
    u.idUo,
    u.numeroUo,
    u.libelleUo,
    w.idProjet,
    pr.codeProjet,
    pr.libelleProjet,
    w.idTypePrestation,
    w.idUtilisateur,
    null as idPointage,
    null as datePointage,
    null as periode
FROM
    gta_View_Prestations p
    LEFT JOIN gta_Preferences w ON w.idPrestation = p.idPrestation
    LEFT JOIN gta_TypePrestations t ON w.idTypePrestation = t.idTypePrestation
    LEFT JOIN gta_Motifs m ON w.idMotif = m.idMotif
    LEFT JOIN gta_Uos u ON w.idUo = u.idUo
    LEFT JOIN gta_Projets pr ON w.idProjet = pr.idProjet
UNION
SELECT
    p.idPrestation,
    p.idEntite,
    p.codePrestation,
    p.libellePrestation,
    t.numeroTypePrestation,
    t.libelleTypePrestation,
    t.motifRequis,
    t.uoRequis,
    t.projetRequis,
    null as idPreference,
    po.idMotif,
    m.codeMotif,
    m.libelleMotif,
    u.idUo,
    u.numeroUo,
    u.libelleUo,
    po.idProjet,
    pr.codeProjet,
    pr.libelleProjet,
    po.idTypePrestation,
    po.idUtilisateur,
    po.idPointage,
    po.datePointage,
    date_format(po.datePointage, "%Y-%m") as periode
FROM
    gta_View_Prestations p
    LEFT JOIN gta_Pointages po ON po.idPrestation = p.idPrestation
    LEFT JOIN gta_TypePrestations t ON po.idTypePrestation = t.idTypePrestation
    LEFT JOIN gta_Motifs m ON po.idMotif = m.idMotif
    LEFT JOIN gta_Uos u ON po.idUo = u.idUo
    LEFT JOIN gta_Projets pr ON po.idProjet = pr.idProjet;

DROP VIEW IF EXISTS gta_View_Logs;

CREATE VIEW gta_View_Logs as
SELECT distinct u.idUtilisateur, nomUtilisateur, prisEnCompte, date_format(dateModifiee, "%Y-%m") as periode, l.idEntite 
FROM gta_Logs l 
INNER JOIN gta_Utilisateurs u On l.idUtilisateur=u.idUtilisateur;