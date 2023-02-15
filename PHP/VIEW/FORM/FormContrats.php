<?php
global $regex;
$mode = $_GET['mode'];
$disabled = " ";
switch ($mode) {
	case "Afficher":
	case "Supprimer":
		$disabled = " disabled ";
		break;
}

if (isset($_GET['id'])) {
	$elm = ContratsManager::findById($_GET['id']);
} else {
	$elm = new Contrats();
}
echo '<main class="center">';

echo '<form class="GridForm" action="index.php?page=ActionContrats&mode='.$_GET['mode'].'" method="post"/>';
echo '<div class="bigEspace"></div>	';
echo '<div class="caseForm titreForm col-span-form">'.texte("Formulaire Contrats").'</div>';
echo '<div class="bigEspace  col-span-form"></div>	';
echo '<div class="noDisplay"><input type="hidden" value="'.$elm->getIdContrat().'" name=IdContrat><input type="hidden" value="'.$_GET['idutilisateur'].'" name=IdUtilisateur></div>';
echo '<label for=IdCentre class="caseForm labelForm">'.texte("IdCentre").'</label>';
echo '<div class="caseForm donneeForm">'.creerSelect($elm->getIdCentre(), 'Centres', ['nomCentre'], $disabled . ' required').'</div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=IdUtilisateur class="caseForm labelForm">'.texte("IdUtilisateur").'</label>';
echo '<div class="caseForm donneeForm">'.creerSelect(($mode == "Ajouter" ? $_GET['idutilisateur'] : $elm->getIdUtilisateur()), 'Utilisateurs', ['nomUtilisateur'], ($mode == "Modifier" || $mode == "Ajouter" ? ' disabled ' : $disabled)).'</div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=DateDebutContrat class="caseForm labelForm">'.texte("DateDebutContrat").'</label>';
echo '<div class="caseForm donneeForm"><input type="date" ' . $disabled . 'value="' . date('Y-m-d', strtotime($elm->getDateDebutContrat() ?? date('Y-m-d'))) . '" name=DateDebutContrat pattern="' . $regex["date"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=DateFinContrat class="caseForm labelForm">'.texte("DateFinContrat").'</label>';
echo '<div class="caseForm donneeForm"><input type="date" ' . $disabled . 'value="' . date('Y-m-d', strtotime($elm->getDateFinContrat() ?? date('Y-m-d'))) . '" name=DateFinContrat pattern="' . $regex["date"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<div class="bigEspace "></div>	';
echo '<div class="caseForm col-span-form">
	<div></div>
	<div><a href="index.php?page=FormUtilisateurs&mode=Modifier&id='.$_GET['idutilisateur'].'"><button type="button"><i class="fas fa-arrow-left fa-rotate-180"></i></button></a></div>
	<div class="cote"></div>';
	echo ($mode == "Afficher") ? "" : " <div><button type=\"submit\"><i class=\"fas fa-paper-plane\"></i></button></div>";
	echo'<div></div>
	</div>';

echo'</form>';

echo '</main>';