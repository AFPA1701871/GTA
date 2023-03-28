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
	"TbAssistante" => ["PHP/VIEW/GENERAL/", "TbAssistante", "Tableau de bord de l'assistante", 3, false],
	"TbManager" => ["PHP/VIEW/GENERAL/", "TbManager", "Tableau de bord du manager", 2, false],
	"Synthese" => ["PHP/VIEW/GENERAL/", "Synthese", "Synthese utilisateur", 2, false],

	"ActionMail" => ["PHP/CONTROLLER/ACTION/", "ActionMail", "Action de la connexion", 0, false],
	
	"ActionConnexion" => ["PHP/CONTROLLER/ACTION/", "ActionConnexion", "Action de la connexion", 0, false],
	"ChangePassword" => ["PHP/VIEW/GENERAL/", "ChangePassword", "Modification du mot de passe", 0, false],

	"ListeAPI" => ["PHP/MODEL/API/", "ListeAPI", "ListeAPI", 0, true],
	"ListePointageAPI" => ["PHP/MODEL/API/", "ListePointageAPI", "ListePointageAPI", 0, true],
	"MAJActivitesParTypesAPI" => ["PHP/MODEL/API/", "MAJActivitesParTypesAPI", "MAJActivitesParTypesAPI", 0, true],
	"MAJPointageAPI" => ["PHP/MODEL/API/", "MAJPointageAPI", "MAJPointageAPI", 0, true],
	"MAJPreferencesAPI" => ["PHP/MODEL/API/", "MAJPreferencesAPI", "MAJPreferencesAPI", 0, true],
	"MAJJoursFeriesAPI" => ["PHP/MODEL/API/", "MAJJoursFeries", "MAJJoursFeries", 3, true],
	"ValidePointageAPI" => ["PHP/MODEL/API/", "ValidePointageAPI", "ValidePointage", 2, true],

	"ListeActivites" => ["PHP/VIEW/LISTE/", "ListeActivites", "Liste Activites", 3, false],
	"FormActivites" => ["PHP/VIEW/FORM/", "FormActivites", "Formulaire Activites", 3, false],
	"ActionActivites" => ["PHP/CONTROLLER/ACTION/", "ActionActivites", "Action Activites", 3, false],


	"ListeAssociations" => ["PHP/VIEW/LISTE/", "ListeAssociations", "Liste Associations", 3, false],
	"FormAssociations" => ["PHP/VIEW/FORM/", "FormAssociations", "Formulaire Associations", 3, false],
	"ActionAssociations" => ["PHP/CONTROLLER/ACTION/", "ActionAssociations", "Action Associations", 3, false],

	"ListeCentres" => ["PHP/VIEW/LISTE/", "ListeCentres", "Liste Centres", 3, false],
	"FormCentres" => ["PHP/VIEW/FORM/", "FormCentres", "Formulaire Centres", 3, false],
	"ActionCentres" => ["PHP/CONTROLLER/ACTION/", "ActionCentres", "Action Centres", 3, false],

	"ListeContrats" => ["PHP/VIEW/LISTE/", "ListeContrats", "Liste Contrats", 3, false],
	"FormContrats" => ["PHP/VIEW/FORM/", "FormContrats", "Formulaire Contrats", 3, false],
	"ActionContrats" => ["PHP/CONTROLLER/ACTION/", "ActionContrats", "Action Contrats", 3, false],

	"ListeConversions" => ["PHP/VIEW/LISTE/", "ListeConversions", "Liste Conversions", 3, false],
	"FormConversions" => ["PHP/VIEW/FORM/", "FormConversions", "Formulaire Conversions", 3, false],
	"ActionConversions" => ["PHP/CONTROLLER/ACTION/", "ActionConversions", "Action Conversions", 3, false],

	"ListeFermetures" => ["PHP/VIEW/LISTE/", "ListeFermetures", "Liste Fermetures", 3, false],
	"FormFermetures" => ["PHP/VIEW/FORM/", "FormFermetures", "Formulaire Fermetures", 3, false],
	"ActionFermetures" => ["PHP/CONTROLLER/ACTION/", "ActionFermetures", "Action Fermetures", 3, false],

	"FormFeries" => ["PHP/VIEW/FORM/", "FormFeries", "Formulaire des jours fériés", 3, false],

	"ListeLogs" => ["PHP/VIEW/LISTE/", "ListeLogs", "Liste Logs", 3, false],
	"FormLogs" => ["PHP/VIEW/FORM/", "FormLogs", "Formulaire Logs", 3, false],
	"ActionLogs" => ["PHP/CONTROLLER/ACTION/", "ActionLogs", "Action Logs", 3, false],

	"ListeMotifs" => ["PHP/VIEW/LISTE/", "ListeMotifs", "Liste Motifs", 3, false],
	"FormMotifs" => ["PHP/VIEW/FORM/", "FormMotifs", "Formulaire Motifs", 3, false],
	"ActionMotifs" => ["PHP/CONTROLLER/ACTION/", "ActionMotifs", "Action Motifs", 3, false],
	"Easter" => ["PHP/VIEW/FORM/", "FormEaster", "Easter", 0, false],

	"FormPointages" => ["PHP/VIEW/FORM/", "FormPointages", "Formulaire Pointages", 1, false],

	"ListePrestations" => ["PHP/VIEW/LISTE/", "ListePrestations", "Liste Prestations", 3, false],
	"FormPrestations" => ["PHP/VIEW/FORM/", "FormPrestations", "Formulaire Prestations", 3, false],
	"ActionPrestations" => ["PHP/CONTROLLER/ACTION/", "ActionPrestations", "Action Prestations", 3, false],

	"ListeProjets" => ["PHP/VIEW/LISTE/", "ListeProjets", "Liste Projets", 3, false],
	"FormProjets" => ["PHP/VIEW/FORM/", "FormProjets", "Formulaire Projets", 3, false],
	"ActionProjets" => ["PHP/CONTROLLER/ACTION/", "ActionProjets", "Action Projets", 3, false],

	"ListeTypePrestations" => ["PHP/VIEW/LISTE/", "ListeTypePrestations", "Liste TypePrestations", 3, false],
	"FormTypePrestations" => ["PHP/VIEW/FORM/", "FormTypePrestations", "Formulaire TypePrestations", 3, false],
	"ActionTypePrestations" => ["PHP/CONTROLLER/ACTION/", "ActionTypePrestations", "Action TypePrestations", 3, false],

	"ListeUos" => ["PHP/VIEW/LISTE/", "ListeUos", "Liste Uos", 3, false],
	"FormUos" => ["PHP/VIEW/FORM/", "FormUos", "Formulaire Uos", 3, false],
	"ActionUos" => ["PHP/CONTROLLER/ACTION/", "ActionUos", "Action Uos", 3, false],

	"ListeUtilisateurs" => ["PHP/VIEW/LISTE/", "ListeUtilisateurs", "Liste Utilisateurs", 3, false],
	"FormUtilisateurs" => ["PHP/VIEW/FORM/", "FormUtilisateurs", "Formulaire Utilisateurs", 3, false],
	"ActionUtilisateurs" => ["PHP/CONTROLLER/ACTION/", "ActionUtilisateurs", "Action Utilisateurs", 3, false],
	
	
	"Attente" => ["PHP/VIEW/GENERAL/", "Attente", "Encore un peu de patience", 0, false],


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
