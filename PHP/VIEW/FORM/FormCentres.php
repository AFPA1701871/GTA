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
	$elm = CentresManager::findById($_GET['id']);
} else {
	$elm = new Centres();
}
echo '<main class="center">';

echo '<form class="GridForm" action="index.php?page=ActionCentres&mode=' . $_GET['mode'] . '" method="post"/>';
echo '<div class="bigEspace"></div>	';
echo '<div class="caseForm titreForm col-span-form">' . texte("Formulaire Centres") . '</div>';
echo '<div class="bigEspace  col-span-form"></div>	';
echo '<div class="noDisplay"><input type="hidden" value="' . $elm->getIdCentre() . '" name=IdCentre></div>';
echo '<input type=hidden name=idEntite value=' . $_SESSION["entite"] . '> ';
echo '<label for=NomCentre class="caseForm labelForm">' . texte("NomCentre") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getNomCentre() . '" name=NomCentre pattern="' . $regex["*"] . '" required></div>';
echo '<div></div><div></div>';

echo '<label for=NumeroCentre class="caseForm labelForm">' . texte("NumeroCentre") . '</label>';
echo '<div class="caseForm donneeForm"><input type="number" ' . $disabled . 'value="' . $elm->getNumeroCentre() . '" name=NumeroCentre pattern="' . $regex["num"] . '" required></div>';
echo '<div></div><div></div>';

echo '<div class="bigEspace "></div>	';
echo '<div class="caseForm col-span-form">
	<div></div>
	<div><a href="index.php?page=ListeCentres"><button type="button"><i class="fas fa-arrow-left fa-rotate-180"></i></button></a></div>
	<div class="cote"></div>';
echo ($mode == "Afficher") ? "" : (($mode == "Supprimer") ? "<div><button type=\"submit\"><i class=\"fas fa-trash-alt\"></i></button></div>" : " <div><button type=\"submit\"><i class=\"fas fa-paper-plane\"></i></button></div>");
echo '<div></div>
	</div>';

echo '</form>';

echo '</main>';
