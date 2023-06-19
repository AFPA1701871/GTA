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
	$elm = EntitesManager::findById($_GET['id']);
} else {
	$elm = new Entites();
}
echo '<main class="center">';

echo '<form class="GridForm" action="index.php?page=ActionEntites&mode=' . $_GET['mode'] . '" method="post"/>';
echo '<div class="bigEspace"></div>	';
echo '<div class="caseForm titreForm col-span-form">' . texte("Formulaire Entites") . '</div>';
echo '<div class="bigEspace  col-span-form"></div>	';
echo '<div class="noDisplay"><input type="hidden" value="' . $elm->getIdEntite() . '" name=IdEntite></div>';
echo '<label for=libelleEntite class="caseForm labelForm">' . texte("LibelleEntite") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getLibelleEntite() . '" name=LibelleEntite pattern="' . $regex["*"] . '" required></div>';
echo '<div></div><div></div>';

echo '<div class="bigEspace "></div>	';
echo '<div class="caseForm col-span-form">
	<div></div>
	<div><a href="index.php?page=ListeEntites"><button type="button"><i class="fas fa-arrow-left fa-rotate-180"></i></button></a></div>
	<div class="cote"></div>';
echo ($mode == "Afficher") ? "" : (($mode == "Supprimer") ? "<div><button type=\"submit\"><i class=\"fas fa-trash-alt\"></i></button></div>" : " <div><button type=\"submit\"><i class=\"fas fa-paper-plane\"></i></button></div>");
echo '<div></div>
	</div>';

echo '</form>';

echo '</main>';
