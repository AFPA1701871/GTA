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
	$elm = UosManager::findById($_GET['id']);
} else {
	$elm = new Uos();
}
echo '<main class="center">';

echo '<form class="GridForm" action="index.php?page=ActionUos&mode=' . $_GET['mode'] . '" method="post"/>';
echo '<div class="bigEspace"></div>	';
echo '<div class="caseForm titreForm col-span-form">' . texte("Formulaire Uos") . '</div>';
echo '<div class="bigEspace  col-span-form"></div>	';
echo '<div class="noDisplay"><input type="hidden" value="' . $elm->getIdUo() . '" name=IdUo></div>';
echo '<input type=hidden name=idEntite value=' . $_SESSION["entite"] . '> ';
echo '<label for=NumeroUo class="caseForm labelForm">' . texte("NumeroUo") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getNumeroUo() . '" name=NumeroUo pattern="' . $regex["numTirret"] . '" required></div>';
echo '<div></div><div></div>';

echo '<label for=LibelleUo class="caseForm labelForm">' . texte("LibelleUo") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getLibelleUo() . '" name=LibelleUo pattern="' . $regex["*"] . '"></div>';
echo '<div></div><div></div>';

echo '<div class="bigEspace "></div>	';
echo '<div class="caseForm col-span-form">
	<div></div>
	<div><a href="index.php?page=ListeUos"><button type="button"><i class="fas fa-arrow-left fa-rotate-180"></i></button></a></div>
	<div class="cote"></div>';
echo ($mode == "Afficher") ? "" :(($mode == "Supprimer") ? "<div><button type=\"submit\"><i class=\"fas fa-trash-alt\"></i></button></div>" : " <div><button type=\"submit\"><i class=\"fas fa-paper-plane\"></i></button></div>");
echo '<div></div>
	</div>';

echo '</form>';

echo '</main>';
