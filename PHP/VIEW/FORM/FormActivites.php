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
	$elm = ActivitesManager::findById($_GET['id']);
} else {
	$elm = new Activites();
}
echo '<main class="center">';

echo '<form class="GridForm" action="index.php?page=ActionActivites&mode='.$_GET['mode'].'" method="post"/>';
echo '<div class="bigEspace"></div>	';
echo '<div class="caseForm titreForm col-span-form">'.texte("Formulaire Activites").'</div>';
echo '<div class="bigEspace  col-span-form"></div>	';
	echo '<div class="noDisplay"><input type="hidden" value="'.$elm->getIdActivite().'" name=IdActivite></div>';
echo '<label for=LibelleActivite class="caseForm labelForm">'.texte("LibelleActivite").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getLibelleActivite().'" name=LibelleActivite pattern="'.$regex["*"].'" required></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<div class="bigEspace "></div>	';
echo '<div class="caseForm col-span-form">
	<div></div>
	<div><a href="index.php?'.(isset($_GET['idtypeprestation']) ? 'page=FormTypePrestations&mode=Modifier&id='.$_GET['idtypeprestation'] : 'page=ListeActivites').'"><button type="button"><i class="fas fa-arrow-left fa-rotate-180"></i></button></a></div>
	<div class="cote"></div>';
	echo ($mode == "Afficher") ? "" : " <div><button type=\"submit\"><i class=\"fas fa-paper-plane\"></i></button></div>";
	echo'<div></div>
	</div>';

echo'</form>';

echo '</main>';