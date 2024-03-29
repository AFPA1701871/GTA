use gta;

INSERT INTO
    gta_Textes (`idTexte`, `codeTexte`, `fr`, `en`)
VALUES
    (1, 'Bonjour', 'Bonjour', 'Hello'),
    (2, 'Connexion', 'Connexion', 'Log in'),
    (3, 'Deconnexion', 'Déconnexion', 'Log out'),
    (4, 'Accueil', 'Accueil', 'Home'),
    (
        5,
        'AdresseEmail',
        'Adresse email',
        'Email address'
    ),
    (6, 'Mdp', 'Mot de passe', 'Password'),
    (7, 'Inscription', 'Inscription', 'Registration'),
    (8, 'Nom', 'Nom', 'Last name'),
    (9, 'Prenom', 'Prénom', 'First name'),
    (
        10,
        'InfoMdpLegend',
        'Veuillez saisir au minimum',
        'Please enter at least'
    ),
    (11, 'UneMajuscule', '1 majuscule', '1 uppercase'),
    (12, 'UneMinuscule', '1 minuscule', '1 lowercase'),
    (13, 'UnChiffre', '1 chiffre', '1 number'),
    (
        14,
        'UnCaractereSpecial',
        '1 caractère spécial ( ! @ & # * ^ $ % +)',
        '1 special character ( ! @ & # * ^ $ % +)'
    ),
    (
        15,
        'MinimumCaractere',
        '8 caractères',
        '8 character'
    ),
    (
        16,
        'Confirmation',
        'Confirmation',
        'Confirmation'
    ),
    (17, 'Reset', 'Réinitialiser', 'Reset'),
    (
        18,
        'inputDefault',
        'Choisir une valeur',
        'Choose a value'
    ),
    (19, 'Envoyer', 'Envoyer', 'Send'),
    (20, 'mailUtilisateur', 'E-mail', 'Mail'),
    (
        21,
        'TypePrestations',
        'Types de prestations',
        'Type of service'
    ),
    (22, 'Activites', 'Activités', 'Activities'),
    (23, 'NomCentre', 'Centre', 'Centre'),
    (24, 'NumeroCentre', 'Numéro', 'Number'),
    (
        25,
        'NbHeureConversion',
        "Nombre d'heures",
        'Number of hours'
    ),
    (26, 'CoeffConversion', 'Quotient', 'Quotient'),
    (
        27,
        'DateFermeture',
        'Date de fermeture',
        'Closing date'
    ),
    (28, 'NumeroUo', "Numéro", 'Number'),
    (29, 'LibelleUo', "U.O", 'U.O'),
    (31, "NomUtilisateur", "Nom", "Name"),
    (32, "MailUtilisateur", "E-mail", "Mail"),
    (
        33,
        "MatriculeUtilisateur",
        "Matricule",
        "ID number"
    ),
    (34, "NomManager", "Manager", "Manager"),
    (35, "NomRole", "Rôle", "Role"),
    (
        36,
        "Liste des View_Utilisateurs",
        "Liste des utilisateurs",
        "Users list"
    ),
    (
        37,
        "Liste des View_Motifs",
        "Liste des motifs",
        "Grounds list"
    ),
    (38, "CodeMotif", "Code", "Code"),
    (39, "LibelleMotif", "Motif", "Ground"),
    (40, "NumeroTypePrestation", "Numéro", "Number"),
    (
        41,
        "LibelleTypePrestation",
        "Prestation",
        "Service"
    ),
    (
        42,
        "Liste des View_Prestations",
        "Liste des prestations",
        "Services list"
    ),
    (43, "CodePrestation", "Code", "Code"),
    (44, "LibellePrestation", "Prestation", "Service"),
    (45, "LibelleActivite", "Activité", "Activitie"),
    (46, "CodeProjet", "Code", "Code"),
    (47, "LibelleProjet", "Projet", "Project"),
    (
        48,
        "Liste des Projets",
        "Liste des projets",
        "Projects list"
    ),
    (
        49,
        "Liste des TypesPrestations",
        "Liste des types de prestations",
        "Services types list"
    ),
    (
        50,
        "MotifRequis",
        "Motif requis",
        "Ground necessary"
    ),
    (51, "UoRequis", "U.O requis", "U.O necessary"),
    (
        52,
        "ProjetRequis",
        "Projet requis",
        "Project necessary"
    ),
    (
        53,
        "Liste des Activites",
        "Liste des activités",
        "Activities list"
    ),
    (
        54,
        "Liste des Pointages",
        "Liste des pointages",
        "Check-ins list"
    ),
    (55, "IdMotif", "Motif", "Ground"),
    (56, "IdPrestation", "Prestation", "Service"),
    (57, "IdProjet", "Projet", "Project"),
    (58, "IdUtilisateur", "Utilisateur", "User"),
    (
        59,
        "DatePointage",
        "Date du pointage",
        "Clock in date"
    ),
    (60, "ValidePointage", "Validé", "Approved"),
    (61, "ReportePointage", "Reporté", "Delayed"),
    (
        62,
        "NbHeuresPointage",
        "Heures pointées",
        "Hours dotted"
    ),
    (
        63,
        "Formulaire Activites",
        "Formulaire activité",
        "Activitie form"
    ),
    (
        64,
        "Formulaire Centres",
        "Formulaire du centre",
        "Centre form"
    ),
    (
        65,
        "Formulaire Contrats",
        "Formulaire du contrat",
        "Agreement form"
    ),
    (
        66,
        "Formulaire Fermetures",
        "Formulaire des dates de fermetures",
        "Closing dates form"
    ),
    (
        67,
        "infoUsage",
        "Renseigner votre nom d'usage",
        "Enter your last name"
    ),
    (
        68,
        "infoPrenom",
        "Renseigner votre prénom",
        "Enter your first name"
    ),
    (
        69,
        "infoMail",
        "Renseigner une adresse mail valide, elle sera utilisé pour la connection",
        "Enter a valid email address, it will be used for the connection"
    ),
    (
        70,
        "erreurMail",
        "Un compte a déjà été créé avec ce mail",
        "An account has already been created with this email"
    ),
    (
        71,
        "Formulaire Motifs",
        "Formulaire du motif",
        "Ground form"
    ),
    (
        72,
        "Formulaire Pointages",
        "Formulaire du pointage",
        "Clock in form"
    ),
    (
        73,
        "Formulaire Prestations",
        "Formulaire de prestation",
        "Service form"
    ),
    (
        74,
        "Formulaire Projets",
        "Formulaire de projet",
        "Project form"
    ),
    (
        75,
        "Formulaire Roles",
        "Formulaire de rôle",
        "Role form"
    ),
    (
        76,
        "Formulaire TypePrestations",
        "Formulaire de type de prestation",
        "Type of service form"
    ),
    (
        77,
        "Formulaire Uos",
        "Formulaire U.O",
        "U.O form"
    ),
    (
        78,
        "Formulaire Utilisateurs",
        "Formulaire de l'utilisateur",
        "User form"
    ),
    (
        79,
        "Formulaire View_Pointages",
        "Formulaire du pointage",
        "Clock in form"
    ),
    (
        80,
        "Formulaire View_Utilisateurs_Preferences_Prestations",
        "Formulaire de l'utilisateur",
        "User form"
    ),
    (
        81,
        "Formulaire View_Utilisateurs",
        "Formulaire des utilisateurs",
        "Users form"
    ),
    (
        82,
        "Données administratives",
        "Données administratives",
        "Administratives data"
    ),
    (83, "Centres", "Centres", "Centres"),
    (84, "Conversions", "Conversions", "Conversions"),
    (85, "Fermetures", "Fermetures", "Closures"),
    (86, "Uos", "U.O", "U.O"),
    (87, "Utilisateurs", "Utilisateurs", "Users"),
    (
        88,
        "Données pointage",
        "Données du pointage",
        "Score data"
    ),
    (89, "Motifs", "Motifs", "Grounds"),
    (90, "Prestations", "Prestations", "Services"),
    (91, "Projets", "Projets", "Projects"),
    (92, "TypePrestation", "Prestation", "Service"),
    (93, "Liste des Uos", "Liste des U.O", "U.O list"),
    (94, "Pointage", "Pointage", "Clock in"),
    (
        95,
        "infoSearch",
        "Entrer le mot à chercher puis cliquer sur le filtre",
        "Enter the search word and click on the filter"
    ),
    (
        97,
        "mot à chercher",
        "Recherche...",
        "Search..."
    ),
    (98, "NbElement", "Résultat", "Result"),
    (
        99,
        "ListeCentres",
        "Liste des centres",
        "Centres list"
    ),
    (
        100,
        "ListeContrats",
        "Liste des Contrats",
        "Contracts list"
    ),
    (101, "IdUo", "U.O", "U.O"),
    (
        102,
        "PasswordUtilisateur",
        "Mot de passe",
        "Password"
    ),
    (103, "IdRole", "Rôle", "Role"),
    (104, "IdManager", 'Manager', "Manager"),
    (
        105,
        "IdTypePrestation",
        "Type de prestation",
        "Service type"
    ),
    (106, "IdCentre", "Centre", "Centre"),
    (107, "IdUtilisateur", "Utilisateur", "User"),
    (
        108,
        "DateDebutContrat",
        "Date de début de contrat",
        "Contract start date"
    ),
    (
        109,
        "DateFinContrat",
        "Date de fin de contrat",
        "Contract end date"
    ),
    (110, 'annee', 'Année', 'Year'),
    (
        111,
        'addholidays',
        'Ajout des jours fériés',
        'Add holidays'
    ),
    (112, 'total', 'Total', 'Total'),
    (
        113,
        'onlymnsp',
        'Le projet à renseigner ne concerne que les prestations MNSP !',
        'The project needs to be filled only for MNSP services!'
    ),
    (114, 'TbAssistante', 'Tableau de Bord Assistante', 'Assistant Dashboard'),
    (115, 'TbManager', 'Tableau de Bord Manager', 'Manager Dashboard'),
    (116, 'TableauBord', 'Tableau de Bord ', 'Dashboard'),

    (117, 'Syntheses', 'Synthèses', 'Syntheses'),
    (118, 'Recaps', 'Récapitulatifs', 'Summaries')
    ;