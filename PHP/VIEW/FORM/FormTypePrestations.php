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
	$elm = TypePrestationsManager::findById($_GET['id']);
} else {
	$elm = new TypePrestations();
}
echo '<main class="center">';

echo '<section class="colonne center">';
echo '<form class="GridForm" action="index.php?page=ActionTypePrestations&mode=' . $_GET['mode'] . '" method="post"/>';
echo '<div class="bigEspace"></div>	';
echo '<div class="caseForm titreForm col-span-form">' . texte("Formulaire TypePrestations") . '</div>';
echo '<div class="bigEspace  col-span-form"></div>	';
echo '<div class="noDisplay"><input type="hidden" value="' . $elm->getIdTypePrestation() . '" name=IdTypePrestation></div>';
echo '<input type=hidden name=idEntite value=' . $_SESSION["entite"] . '> ';
echo '<label for=NumeroTypePrestation class="caseForm labelForm">' . texte("NumeroTypePrestation") . '</label>';
echo '<div class="caseForm donneeForm"><input type="number" ' . $disabled . 'value="' . $elm->getNumeroTypePrestation() . '" name=NumeroTypePrestation pattern="' . $regex['num'] . '" required></div>';
echo '<div></div><div></div>';

echo '<label for=LibelleTypePrestation class="caseForm labelForm">' . texte("LibelleTypePrestation") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getLibelleTypePrestation() . '" name=LibelleTypePrestation pattern="' . $regex["*"] . '" required></div>';
echo '<div></div><div></div>';

echo '<label for=MotifRequis class="caseForm labelForm">' . texte("MotifRequis") . '</label>';
$check = $elm->getMotifRequis() == 1 ? " checked " : " ";
echo '<div class="caseForm donneeForm toggle-switch"><input type="checkbox" class="toggle-input" ' . $check . $disabled . 'value="1" name=MotifRequis><label for="toggle" class="toggle-label"/></div>';
echo '<div></div><div></div>';

echo '<label for=UoRequis class="caseForm labelForm">' . texte("UoRequis") . '</label>';
$check = $elm->getUoRequis() == 1 ? " checked " : " ";
echo '<div class="caseForm donneeForm toggle-switch"><input type="checkbox" class="toggle-input" ' . $check . $disabled . 'value="1" name=UoRequis><label for="toggle" class="toggle-label"/></div>';
echo '<div></div><div></div>';

echo '<label for=ProjetRequis class="caseForm labelForm">' . texte("ProjetRequis") . '</label>';
$check = $elm->getProjetRequis() == 1 ? " checked " : " ";
echo '<div class="caseForm donneeForm toggle-switch "><input type="checkbox"  class="toggle-input" ' . $check . $disabled . 'value="1" name=ProjetRequis><label for="toggle" class="toggle-label"/></div>';
echo '<div></div><div></div>';

echo '<div class="bigEspace "></div>	';
echo '<div class="caseForm col-span-form">
	<div></div>
	<div><a href="index.php?page=ListeTypePrestations"><button type="button"><i class="fas fa-arrow-left fa-rotate-180"></i></button></a></div>
	<div class="cote"></div>';
echo ($mode == "Afficher") ? "" :(($mode == "Supprimer") ? "<div><button type=\"submit\"><i class=\"fas fa-trash-alt\"></i></button></div>" : " <div><button type=\"submit\"><i class=\"fas fa-paper-plane\"></i></button></div>");
echo '<div></div>
	</div>';

echo '</form>
<div class="flex-0-1"></div>';

if ($_GET['mode'] == "Modifier" || $_GET['mode'] == "Afficher") {
	include 'PHP/VIEW/LISTE/ListeActivites.php';
}

echo '<div class="flex-0-1"></div></section>';
echo '</main>';
