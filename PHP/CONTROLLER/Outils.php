<?php
function ChargerClasse($classe)
{
	if (file_exists("PHP/CONTROLLER/CLASSE/" . $classe . ".Class.php")) {
		require "PHP/CONTROLLER/CLASSE/" . $classe . ".Class.php";
	}
	if (file_exists("PHP/MODEL/MANAGER/" . $classe . ".Class.php")) {
		require "PHP/MODEL/MANAGER/" . $classe . ".Class.php";
	}
}
spl_autoload_register("ChargerClasse");

function uri()
{
	$uri = $_SERVER['REQUEST_URI'];
	if (substr($uri, strlen($uri) - 1) == "/") // se termine par /
	{
		$uri .= "index.php?";
	} else if (in_array("?", str_split($uri))) // si l'uri contient deja un ?
	{
		$uri .= "&";
	} else {
		$uri .= "?";
	}
	return $uri;
}

function crypte($mot)
{
	return md5(md5($mot));
}
function passwordDefault($uti)
{
	return strtoupper($uti->getMatriculeUtilisateur());
}
function texte($codeTexte)
{
	$retour = TextesManager::findByCodes($_SESSION['lang'], $codeTexte);
	if ($retour == false) return $codeTexte;
	return $retour;
}

function afficherPage($page)
{
	$chemin = $page[0];
	$nom = $page[1];
	$titre = $page[2];
	$roleRequis = $page[3];
	$api = $page[4];
	$roleConnecte = isset($_SESSION["utilisateur"]) ? $_SESSION["utilisateur"]->getIdRole() : 0;
	if ($roleConnecte >= $roleRequis) {
		if ($api) {
			include $chemin . $nom . '.php';
		} else {
			include 'PHP/VIEW/GENERAL/Head.php';
			include 'PHP/VIEW/GENERAL/Header.php';

			// On affiche la navigation si :
			// - on est connecté
			// - on est pas dans une des pages d'action
			// - on ne modifie pas de force son mot de passe
			// - on est manager (id 2) ou assistante (id 3) ou admin (id 4)
			if (isset($_SESSION["utilisateur"]) && (stripos($chemin, "PHP/CONTROLLER/ACTION/") !== 0) && $nom != "ChangePassword" && $roleConnecte >= 2) {
				include 'PHP/VIEW/GENERAL/Nav.php';
			}

			include $chemin . $nom . '.php'; //Chargement de la page en fonction du chemin et du nom
			include 'PHP/VIEW/GENERAL/Footer.php';
		}
	} else {
		$nom = "FormInscriptionConnexion";
		$titre = "Authorisation insuffisante";
		include 'PHP/VIEW/GENERAL/Head.php';
		include 'PHP/VIEW/GENERAL/Header.php';
		include 'PHP/VIEW/FORM/FormConnexion.php';
		include 'PHP/VIEW/GENERAL/Footer.php';
	}
}

// A coder pour décoder les informations base de données dans le json
function decode($texte)
{
	return $texte;
}
$regex = [
	"alpha" => "[A-Za-z]{2,}-?[A-Za-z]{2,}",
	"alphaNum" => "[A-Za-z0-9]*",
	"alphaMaj" => "[A-Z]*",
	"alphaMin" => "[a-z]*",
	"num" => "[0-9]*",
	"numTirret" => "[\d\-]*",
	"ucFirst" => "[A-Z][a-z]+",
	"email" => "[A-Za-z]([\.\-_]?[A-Za-z0-9])+@[A-Za-z]([\.\-_]?[A-Za-z0-9])+\.[A-Za-z]{2,4}",
	"date" => "[0-3]?[0-9](\/|-)(0|1)?[0-9](\/|-)[0-9]{4}",
	"pwd" => '(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_])([a-zA-Z0-9\W_]{8,})',
	"tel" => "0[0-9]([-/. ]?[0-9]{2}){4}",
	"postal" => "[0-9]{5}",
	"*"  => ".*"
];
$mois = [1 => "Janvier", 2 => "Février", 3 => "Mars", 4 => "Avril", 5 => "Mai", 6 => "Juin", 7 => "Juillet", 8 => "Aout", 9 => "Septembre", 10 => "Octobre", 11 => "Novembre", 12 => "Décembre"];


$joursSemaine = ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"];

function appelGet($obj, $chaine)
{
	$methode = 'get' . ucfirst($chaine);
	return call_user_func(array($obj, $methode));
}

/**
 * Crée un select a partir des informations passées en parametre
 *
 * @param integer $valeur => Id de l'element a Selectionner
 * 
 * @param string $table => contient Nom de la table sur laquelle la requête sera effectuée.
 * Exemple : nomTable => "FROM nomTable"
 * 
 * @param array $nomColonnes => contient le noms des champs désirés dans la requête.
 * Exemple :  [nomColonne1,nomColonne2] => "SELECT nomColonne1, nomColonne2"
 * 
 * @param string $attributs => attributs attendu dans la balise select
 * 
 * Exemples : <select class="filtrefiche" data-serie=3 >
 * 
 * @param array|null $condition => null par défaut, attendu un tableau associatif 
 * qui peut prendre plusieurs formes en fonction de la complexité des conditions.
 *
 *  Exemples : tableau associatif
 *  [nomColonne => '1'] => "WHERE nomColonne = 1"
 *  [nomColonne => ['1','3']] => "WHERE nomColonne in (1,3)"
 *  [nomColonne => '%abcd%'] => "WHERE nomColonne like "%abcd%"
 *  [nomColonne => '1->5'] => "WHERE nomColonne BETWEEN 1 and 5 "
 *  Si il y a plusieurs conditions alors :
 *  [nomColonne1 => '1', nomColonne2 => '%abcd%' ] => "WHERE nomColonne1 = 1 AND nomColonne2 LIKE "%abcd%"
 * 
 * @param string|null $orderBy $orderBy => null par défaut, contient un string qui contient les noms de colonnes et le type de tri
 * Exemple :"nomColonne1 , nomColonne2 DESC" => "Order By nomColonne1 , nomColonne2 DESC"
 * 
 * @param string|null $attributId $attributId => null par défaut, contient un string qui contient le name à donner au formulaire s'il est différent de la table
 * 
 * @param string $invite l'invite de la combobox
 * @return void
 */
function creerSelect(?int $valeur, string $table, array $nomColonnes, ?string $attributs = "", ?array $condition = null, string $orderBy = null, string $attributId = null, string $invite = "inputDefault")
{
	$nomId = $table::getAttributes()[0];
	$atrId = ($attributId == null ? $nomId : $attributId);

	$select = '<select id="' . $atrId . '" name="' . $atrId . '"' . $attributs . '>';
	$methode = $table . 'Manager';
	$libelle = $nomColonnes;
	array_push($nomColonnes, $nomId);
	$liste = $methode::getList($nomColonnes, $condition, $orderBy,  null, false, false);
	if ($valeur == null) {
		$select .= '<option value="" SELECTED>' . texte($invite) . '</option>';
	} else {
		$select .= '<option value="">' . texte($invite) . '</option>';
	}
	foreach ($liste as $elt) {
		$content = "";
		foreach ($libelle as $value) {
			$content .= appelGet($elt, $value) . " | ";
		}

		$content=substr($content, 0,-3);

		if ($valeur == appelGet($elt, $nomId)) {
			$select .= '<option value="' . appelGet($elt, $nomId) . '" SELECTED>' . $content . '</option>';
		} else {
			$select .= '<option value="' . appelGet($elt, $nomId) . '">' . $content . '</option>';
		}
	}
	$select .= "</select>";
	return $select;
}

/**
 * Créer un select (combobox) à partir d'un tableau
 *
 * @param integer|null $valeur
 * @param array $tab
 * @param string|null $attributs
 * @param string $attributId
 * @return void
 */
function creerSelectTab($valeur, array $tab,  string $attributId, bool $tabAssoc,  ?string $attributs = "", string $invite = "inputDefault")
{
	$select = '<select id="' . $attributId . '" name="' . $attributId . '"' . $attributs . '>';

	if ($valeur == null) {
		$select .= '<option value="" SELECTED>' . texte($invite) . '</option>';
	} else {
		$select .= '<option value="">' . texte($invite) . '</option>';
	}
	foreach ($tab as $key => $elt) {
		$key = $tabAssoc ? $key : $elt;
		if ($key == $valeur) {
			$select .= '<option value="' . $key . '" SELECTED>' . $elt . '</option>';
		} else {
			$select .= '<option value="' . $key . '">' . $elt . '</option>';
		}
	}
	$select .= "</select>";
	return $select;
}

/**
 * Créer un tableau associatif contenant les mois et années
 *
 * @param array $mois
 * @return array
 */
function tabMoisAnnee()
{
	global $mois;
	// Récupération des années et des mois
	$annees = Parametres::getAnneeDisponible();
	// Parcours des tableaux
	foreach ($annees as $annee) {
		foreach ($mois as $key => $value) {
			// Création de la future key
			if ($key < 10) {
				$date = $annee . "-0" . $key;
			} else {
				$date = $annee . "-" . $key;
			}
			// Ajout de la case dans le tableau
			$tabMoisAnnee[$date] = $value . " " . $annee;
		}
	}
	return $tabMoisAnnee;
}

function periodeEnCours($idUtilisateur, $type)
{
	// on teste uniquement sur le mois précédent
	$periode = date("Y") . '-' . str_pad(date("m") * 1 - 1, 2, "0", STR_PAD_LEFT);
	switch ($type) {
		case 'Pointage': // le mois précédent doit complètement être saisi pour passer au mois en cours
			$nbJour = View_Pointages_PeriodeManager::NombrePointages($idUtilisateur, $periode, null, "Utilisateur", "Jours");
			$nbJourAPointe = NbJourParPeriode($periode);

			if ($nbJour == false || $nbJour < $nbJourAPointe)
				return date("Y") . '-' . str_pad(date("m") * 1 - 1, 2, "0", STR_PAD_LEFT);
			return date("Y") . '-' . str_pad(date("m"), 2, "0", STR_PAD_LEFT);
			break;
		case 'Valide': // le mois précédent doit complètement être validé pour tous les agents pour passer au mois en cours
			$nbValide = View_Pointages_PeriodeManager::NombrePointages($idUtilisateur, $periode, "valide","Manager");
			// Ancienne version
			// $nbValide = View_Pointages_PeriodeManager::NbValide($idUtilisateur, $periode,"Manager");
			$nbAgent = count(UtilisateursManager::getList(['idUtilisateur'], [ 'idManager' => $idUtilisateur]));
			if ($nbValide < $nbAgent)
				return date("Y") . '-' . str_pad(date("m") * 1 - 1, 2, "0", STR_PAD_LEFT);
			return date("Y") . '-' . str_pad(date("m"), 2, "0", STR_PAD_LEFT);

			break;
		case 'Reporte': // le mois précédent doit complètement être reporté pour passer au mois en cours
			$nbReporte = View_Pointages_PeriodeManager::NombrePointages(null, $periode, "reporte",null);
			// Ancienne version
			// $nbReporte = View_Pointages_PeriodeManager::NbReporte($idUtilisateur, $periode,"Manager");
			
			$nbAgent = count(UtilisateursManager::getList(['idUtilisateur']));
			if ($nbReporte < $nbAgent)
				return date("Y") . '-' . str_pad(date("m") * 1 - 1, 2, "0", STR_PAD_LEFT);
			return date("Y") . '-' . str_pad(date("m"), 2, "0", STR_PAD_LEFT);

			break;
	}
}
function NbJourParPeriode($periode)
{
	global $joursSemaine;
	$nbJourPointe = 0;
	$periodeTab = explode("-", $periode);
	$nbrJoursMois = cal_days_in_month(CAL_GREGORIAN, (int) $periodeTab[1], $periodeTab[0]);
	$listeFermeturesDuMois = FermeturesManager::getDates($periode);

	for ($i = 1; $i <= $nbrJoursMois; $i++) {
		//on crée la date au format DateTime
		$jour = (new Datetime())->setDate($periodeTab[0], $periodeTab[1], $i);

		// $jour->format('w') donne le jour dans la semaine 0 pour dimanche, 1 pour lundi
		if ($jour->format('w') != 0 && $jour->format('w') != 6 && !in_array($jour->format("Y-m-d"), $listeFermeturesDuMois)) {
			$nbJourPointe++;
		}
	}
	return $nbJourPointe;
}
function moisPrecedent(DateTime $date)
{
	$date->modify('first day of this month'); // Positionne la date sur le premier jour du mois en cours
	$month = $date->modify('-1 day')->format('Y-m'); // on retire un jour et on reformate au format ANNEE-MOIS
	return $month;
}
