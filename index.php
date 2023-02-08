<?php

include "./PHP/CONTROLLER/Outils.php";

spl_autoload_register("ChargerClasse");

Parametres::init();

DbConnect::init();

session_start();

/******Les langues******/
/***On récupère la langue***/
if (isset($_GET['lang']) && TextesManager::checkIfLangExist($_GET['lang'])) {
	// tester si la langue est gérée
	$_SESSION['lang'] = $_GET['lang'];
} else if (isset($_COOKIE['lang'])) {
	$_SESSION['lang'] = $_COOKIE['lang'];
} else {
	$_SESSION['lang'] = 'FR';
}
//Crée un cookie lang sur la machine de l'utilisateur d'une durée de 10h.
setcookie("lang", $_SESSION['lang'], time() + 36000, '/');
/******Fin des langues******/

$routes = [
	"Default" => ["PHP/VIEW/FORM/", "FormConnexion", "Connexion", 0, false],
	"Accueil" => ["PHP/VIEW/GENERAL/", "Accueil", "Accueil", 0, false],

	"ActionConnexion" => ["PHP/CONTROLLER/ACTION/", "ActionConnexion", "Action de la connexion", 0, false],
	"ActionDeconnexion" => ["PHP/CONTROLLER/ACTION/", "ActionDeconnexion", "Action de deconnexion", 0, false],
	"ChangePassword" => ["PHP/VIEW/GENERAL/", "ChangePassword", "Action de deconnexion", 0, false],

	"ListeMailAPI" => ["PHP/MODEL/API/", "ListeMailAPI", "ListeMailAPI", 0, true],
	"ListeAPI" => ["PHP/MODEL/API/", "ListeAPI", "ListeAPI", 0, true],

	"ListeActivites" => ["PHP/VIEW/LISTE/", "ListeActivites", "Liste Activites", 0, false],
	"FormActivites" => ["PHP/VIEW/FORM/", "FormActivites", "Formulaire Activites", 0, false],
	"ActionActivites" => ["PHP/CONTROLLER/ACTION/", "ActionActivites", "Action Activites", 0, false],

	"ListeActivitesParTypes" => ["PHP/VIEW/LISTE/", "ListeActivitesParTypes", "Liste ActivitesParTypes", 0, false],
	"FormActivitesParTypes" => ["PHP/VIEW/FORM/", "FormActivitesParTypes", "Formulaire ActivitesParTypes", 0, false],
	"ActionActivitesParTypes" => ["PHP/CONTROLLER/ACTION/", "ActionActivitesParTypes", "Action ActivitesParTypes", 0, false],

	"ListeAssociations" => ["PHP/VIEW/LISTE/", "ListeAssociations", "Liste Associations", 0, false],
	"FormAssociations" => ["PHP/VIEW/FORM/", "FormAssociations", "Formulaire Associations", 0, false],
	"ActionAssociations" => ["PHP/CONTROLLER/ACTION/", "ActionAssociations", "Action Associations", 0, false],

	"ListeCentres" => ["PHP/VIEW/LISTE/", "ListeCentres", "Liste Centres", 0, false],
	"FormCentres" => ["PHP/VIEW/FORM/", "FormCentres", "Formulaire Centres", 0, false],
	"ActionCentres" => ["PHP/CONTROLLER/ACTION/", "ActionCentres", "Action Centres", 0, false],

	"ListeContrats" => ["PHP/VIEW/LISTE/", "ListeContrats", "Liste Contrats", 0, false],
	"FormContrats" => ["PHP/VIEW/FORM/", "FormContrats", "Formulaire Contrats", 0, false],
	"ActionContrats" => ["PHP/CONTROLLER/ACTION/", "ActionContrats", "Action Contrats", 0, false],

	"ListeConversions" => ["PHP/VIEW/LISTE/", "ListeConversions", "Liste Conversions", 0, false],
	"FormConversions" => ["PHP/VIEW/FORM/", "FormConversions", "Formulaire Conversions", 0, false],
	"ActionConversions" => ["PHP/CONTROLLER/ACTION/", "ActionConversions", "Action Conversions", 0, false],

	"ListeFermetures" => ["PHP/VIEW/LISTE/", "ListeFermetures", "Liste Fermetures", 0, false],
	"FormFermetures" => ["PHP/VIEW/FORM/", "FormFermetures", "Formulaire Fermetures", 0, false],
	"ActionFermetures" => ["PHP/CONTROLLER/ACTION/", "ActionFermetures", "Action Fermetures", 0, false],

	"ListeLogs" => ["PHP/VIEW/LISTE/", "ListeLogs", "Liste Logs", 0, false],
	"FormLogs" => ["PHP/VIEW/FORM/", "FormLogs", "Formulaire Logs", 0, false],
	"ActionLogs" => ["PHP/CONTROLLER/ACTION/", "ActionLogs", "Action Logs", 0, false],

	"ListeMotifs" => ["PHP/VIEW/LISTE/", "ListeView_Motifs", "Liste Motifs", 0, false],
	"FormMotifs" => ["PHP/VIEW/FORM/", "FormMotifs", "Formulaire Motifs", 0, false],
	"ActionMotifs" => ["PHP/CONTROLLER/ACTION/", "ActionMotifs", "Action Motifs", 0, false],

	"ListePointages" => ["PHP/VIEW/LISTE/", "ListePointages", "Liste Pointages", 0, false],
	"FormPointages" => ["PHP/VIEW/FORM/", "FormPointages", "Formulaire Pointages", 0, false],
	"ActionPointages" => ["PHP/CONTROLLER/ACTION/", "ActionPointages", "Action Pointages", 0, false],

	"ListePreferences" => ["PHP/VIEW/LISTE/", "ListePreferences", "Liste Preferences", 0, false],
	"FormPreferences" => ["PHP/VIEW/FORM/", "FormPreferences", "Formulaire Preferences", 0, false],
	"ActionPreferences" => ["PHP/CONTROLLER/ACTION/", "ActionPreferences", "Action Preferences", 0, false],

	"ListePrestations" => ["PHP/VIEW/LISTE/", "ListeView_Prestations", "Liste Prestations", 0, false],
	"FormPrestations" => ["PHP/VIEW/FORM/", "FormPrestations", "Formulaire Prestations", 0, false],
	"ActionPrestations" => ["PHP/CONTROLLER/ACTION/", "ActionPrestations", "Action Prestations", 0, false],

	"ListeProjets" => ["PHP/VIEW/LISTE/", "ListeProjets", "Liste Projets", 0, false],
	"FormProjets" => ["PHP/VIEW/FORM/", "FormProjets", "Formulaire Projets", 0, false],
	"ActionProjets" => ["PHP/CONTROLLER/ACTION/", "ActionProjets", "Action Projets", 0, false],

	"ListeRoles" => ["PHP/VIEW/LISTE/", "ListeRoles", "Liste Roles", 0, false],
	"FormRoles" => ["PHP/VIEW/FORM/", "FormRoles", "Formulaire Roles", 0, false],
	"ActionRoles" => ["PHP/CONTROLLER/ACTION/", "ActionRoles", "Action Roles", 0, false],

	"ListeTypePrestations" => ["PHP/VIEW/LISTE/", "ListeTypePrestations", "Liste TypePrestations", 0, false],
	"FormTypePrestations" => ["PHP/VIEW/FORM/", "FormTypePrestations", "Formulaire TypePrestations", 0, false],
	"ActionTypePrestations" => ["PHP/CONTROLLER/ACTION/", "ActionTypePrestations", "Action TypePrestations", 0, false],

	"ListeUos" => ["PHP/VIEW/LISTE/", "ListeUos", "Liste Uos", 0, false],
	"FormUos" => ["PHP/VIEW/FORM/", "FormUos", "Formulaire Uos", 0, false],
	"ActionUos" => ["PHP/CONTROLLER/ACTION/", "ActionUos", "Action Uos", 0, false],

	"ListeUtilisateurs" => ["PHP/VIEW/LISTE/", "ListeView_Utilisateurs", "Liste Utilisateurs", 0, false],
	"FormUtilisateurs" => ["PHP/VIEW/FORM/", "FormUtilisateurs", "Formulaire Utilisateurs", 0, false],
	"ActionUtilisateurs" => ["PHP/CONTROLLER/ACTION/", "ActionUtilisateurs", "Action Utilisateurs", 0, false],

	"ListeView_Pointages_Satellites" => ["PHP/VIEW/LISTE/", "ListeView_Pointages_Satellites", "Liste View_Pointages_Satellites", 0, false],
	"FormView_Pointages_Satellites" => ["PHP/VIEW/FORM/", "FormView_Pointages_Satellites", "Formulaire View_Pointages_Satellites", 0, false],
	"ActionView_Pointages_Satellites" => ["PHP/CONTROLLER/ACTION/", "ActionView_Pointages_Satellites", "Action View_Pointages_Satellites", 0, false],

	"ListeView_Utilisateurs" => ["PHP/VIEW/LISTE/", "ListeView_Utilisateurs", "Liste View_Utilisateurs", 0, false],
	"FormView_Utilisateurs" => ["PHP/VIEW/FORM/", "FormView_Utilisateurs", "Formulaire View_Utilisateurs", 0, false],
	"ActionView_Utilisateurs" => ["PHP/CONTROLLER/ACTION/", "ActionView_Utilisateurs", "Action View_Utilisateurs", 0, false],

	"ListeView_Utilisateurs_Preferences_Prestations" => ["PHP/VIEW/LISTE/", "ListeView_Utilisateurs_Preferences_Prestations", "Liste View_Utilisateurs_Preferences_Prestations", 0, false],
	"FormView_Utilisateurs_Preferences_Prestations" => ["PHP/VIEW/FORM/", "FormView_Utilisateurs_Preferences_Prestations", "Formulaire View_Utilisateurs_Preferences_Prestations", 0, false],
	"ActionView_Utilisateurs_Preferences_Prestations" => ["PHP/CONTROLLER/ACTION/", "ActionView_Utilisateurs_Preferences_Prestations", "Action View_Utilisateurs_Preferences_Prestations", 0, false],

];

if (isset($_GET["page"])) {

	$page = $_GET["page"];

	if (isset($routes[$page])) {
		AfficherPage($routes[$page]);
	} else {
		AfficherPage($routes["Default"]);
	}
} else {
	AfficherPage($routes["Default"]);
}
