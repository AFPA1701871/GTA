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
	$elm = PointagesManager::findById($_GET['id']);
} else {
	$elm = new Pointages();
}
echo '<main class="center">';

echo '<form class="GridForm" action="index.php?page=ActionPointages&mode='.$_GET['mode'].'" method="post"/>';
echo '<div class="bigEspace"></div>	';
echo '<div class="caseForm titreForm col-span-form">Formulaire Pointages</div>';
echo '<div class="bigEspace  col-span-form"></div>	';
	echo '<div class="noDisplay"><input type="hidden" value="'.$elm->getIdPointage().'" name=IdPointage></div>';
echo '<label for=IdMotif class="caseForm labelForm">'.texte("IdMotif").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getIdMotif().'" name=IdMotif pattern="'.$regex["*"].'"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=IdPrestation class="caseForm labelForm">'.texte("IdPrestation").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getIdPrestation().'" name=IdPrestation pattern="'.$regex["*"].'"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=IdProjet class="caseForm labelForm">'.texte("IdProjet").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getIdProjet().'" name=IdProjet pattern="'.$regex["*"].'"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=IdUO class="caseForm labelForm">'.texte("IdUO").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getIdUO().'" name=IdUO pattern="'.$regex["*"].'"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=IdUtilisateur class="caseForm labelForm">'.texte("IdUtilisateur").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getIdUtilisateur().'" name=IdUtilisateur pattern="'.$regex["*"].'"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=DatePointage class="caseForm labelForm">'.texte("DatePointage").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getDatePointage().'" name=DatePointage pattern="'.$regex["*"].'"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=ValidePointage class="caseForm labelForm">'.texte("ValidePointage").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getValidePointage().'" name=ValidePointage pattern="'.$regex["*"].'"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=ReportePointage class="caseForm labelForm">'.texte("ReportePointage").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getReportePointage().'" name=ReportePointage pattern="'.$regex["*"].'"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=NbHeuresPointage class="caseForm labelForm">'.texte("NbHeuresPointage").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getNbHeuresPointage().'" name=NbHeuresPointage pattern="'.$regex["*"].'"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<div class="bigEspace "></div>	';
echo '<div class="caseForm col-span-form">
	<div></div>
	<div><a href="index.php?page=ListePointages"><button type="button"><i class="fas fa-sign-out-alt fa-rotate-180"></i></button></a></div>
	<div class="flex-0-1"></div>';
	echo ($mode == "Afficher") ? "" : " <div><button type=\"submit\"><i class=\"fas fa-paper-plane\"></i></button></div>";
	echo'<div></div>
	</div>';

echo'</form>';

echo '</main>';