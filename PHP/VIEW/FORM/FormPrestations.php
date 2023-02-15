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
	$elm = PrestationsManager::findById($_GET['id']);
} else {
	$elm = new Prestations();
}
echo '<main class="center">';

echo '<form class="GridForm" action="index.php?page=ActionPrestations&mode='.$_GET['mode'].'" method="post"/>';
echo '<div class="bigEspace"></div>	';
echo '<div class="caseForm titreForm col-span-form">'.texte("Formulaire Prestations").'</div>';
echo '<div class="bigEspace  col-span-form"></div>	';
	echo '<div class="noDisplay"><input type="hidden" value="'.$elm->getIdPrestation().'" name=IdPrestation></div>';
echo '<label for=CodePrestation class="caseForm labelForm">'.texte("CodePrestation").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getCodePrestation().'" name=CodePrestation pattern="'.$regex["*"].'" required></div>';
echo '<div></div><div></div>';

echo '<label for=LibellePrestation class="caseForm labelForm">'.texte("LibellePrestation").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getLibellePrestation().'" name=LibellePrestation pattern="'.$regex["*"].'"></div>';
echo '<div></div><div></div>';

echo '<label for=IdActivite class="caseForm labelForm">'.texte("LibelleActivite").'</label>';
echo '<div class="caseForm donneeForm">'.creerSelect($elm->getIdActivite(),"Activites",["libelleActivite"],$disabled . ' required',null,"libelleActivite",null ).'</div>';
echo '<div></div><div></div>';

echo '<div class="bigEspace "></div>	';
echo '<div class="caseForm col-span-form">
	<div></div>
	<div><a href="index.php?page=ListePrestations"><button type="button"><i class="fas fa-arrow-left fa-rotate-180"></i></button></a></div>
	<div class="cote"></div>';
	echo ($mode == "Afficher") ? "" : " <div><button type=\"submit\"><i class=\"fas fa-paper-plane\"></i></button></div>";
	echo'<div></div>
	</div>';

echo'</form>';

echo '</main>';