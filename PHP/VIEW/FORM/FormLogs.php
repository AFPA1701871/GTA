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
	$elm = LogsManager::findById($_GET['id']);
} else {
	$elm = new Logs();
}
echo '<main class="center">';

echo '<form class="GridForm" action="index.php?page=ActionLogs&mode='.$_GET['mode'].'" method="post"/>';
echo '<div class="bigEspace"></div>	';
echo '<div class="caseForm titreForm col-span-form">Formulaire Logs</div>';
echo '<div class="bigEspace  col-span-form"></div>	';
	echo '<div class="noDisplay"><input type="hidden" value="'.$elm->getIdLog().'" name=IdLog></div>';
echo '<label for=DateLog class="caseForm labelForm">'.texte("DateLog").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getDateLog().'" name=DateLog pattern="'.$regex["*"].'"></div>';
echo '<div></div><div></div>';

echo '<label for=ActionLog class="caseForm labelForm">'.texte("ActionLog").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getActionLog().'" name=ActionLog pattern="'.$regex["*"].'"></div>';
echo '<div></div><div></div>';

echo '<label for=PrisEnCompte class="caseForm labelForm">'.texte("PrisEnCompte").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getPrisEnCompte().'" name=PrisEnCompte pattern="'.$regex["*"].'"></div>';
echo '<div></div><div></div>';

echo '<label for=IdUtilisateur class="caseForm labelForm">'.texte("IdUtilisateur").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getIdUtilisateur().'" name=IdUtilisateur pattern="'.$regex["*"].'"></div>';
echo '<div></div><div></div>';

echo '<div class="bigEspace "></div>	';
echo '<div class="caseForm col-span-form">
	<div></div>
	<div><a href="index.php?page=ListeLogs"><button type="button"><i class="fas fa-arrow-left fa-rotate-180"></i></button></a></div>
	<div class="cote"></div>';
	echo ($mode == "Afficher") ? "" :(($mode == "Supprimer") ? "<div><button type=\"submit\"><i class=\"fas fa-trash-alt\"></i></button></div>" : " <div><button type=\"submit\"><i class=\"fas fa-paper-plane\"></i></button></div>");
	echo'<div></div>
	</div>';

echo'</form>';

echo '</main>';