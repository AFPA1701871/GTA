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
	$elm = MotifsManager::findById($_GET['id']);
} else {
	$elm = new Motifs();
}
echo '<main class="center">';

echo '<form class="GridForm" action="index.php?page=ActionMotifs&mode='.$_GET['mode'].'" method="post"/>';
echo '<div class="bigEspace"></div>	';
echo '<div class="caseForm titreForm col-span-form">'.texte("Formulaire Motifs").'</div>';
echo '<div class="bigEspace  col-span-form"></div>	';
	echo '<div class="noDisplay"><input type="hidden" value="'.$elm->getIdMotif().'" name=IdMotif></div>';
	echo '<input type=hidden name=idEntite value=' . $_SESSION["entite"] . '> ';
echo '<label for=CodeMotif class="caseForm labelForm">'.texte("CodeMotif").'</label>';
echo '<div class="caseForm donneeForm"><input type="number" '.$disabled .'value="'.$elm->getCodeMotif().'" name=CodeMotif pattern="'.$regex["num"].'" required></div>';
echo '<div></div><div></div>';

echo '<label for=LibelleMotif class="caseForm labelForm">'.texte("LibelleMotif").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getLibelleMotif().'" name=LibelleMotif pattern="'.$regex["*"].'" required></div>';
echo '<div></div><div></div>';

echo '<label for=IdTypePrestation class="caseForm labelForm">'.texte("IdTypePrestation").'</label>';
echo '<div class="caseForm donneeForm">' . creerSelect($elm->getIdTypePrestation(), "TypePrestations", ["libelleTypePrestation"], $disabled . ' required',null,null,null,"Choisir un type de prestation") . '</div>';
echo '<div></div><div></div>';

echo '<div class="bigEspace "></div>	';
echo '<div class="caseForm col-span-form">
	<div></div>
	<div><a href="index.php?page=ListeMotifs"><button type="button"><i class="fas fa-arrow-left fa-rotate-180"></i></button></a></div>
	<div class="cote"></div>';
	echo ($mode == "Afficher") ? "" :(($mode == "Supprimer") ? "<div><button type=\"submit\"><i class=\"fas fa-trash-alt\"></i></button></div>" : " <div><button type=\"submit\"><i class=\"fas fa-paper-plane\"></i></button></div>");
	echo'<div></div>
	</div>';

echo'</form>';

echo '</main>';