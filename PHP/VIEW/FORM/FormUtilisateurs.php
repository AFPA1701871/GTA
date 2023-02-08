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
	$elm = UtilisateursManager::findById($_GET['id']);
} else {
	$elm = new Utilisateurs();
}
echo '<main class="center">';

echo '
<section class="colonne center" >';
echo '<form class="GridForm" action="index.php?page=ActionUtilisateurs&mode='.$_GET['mode'].'" method="post"/>';
echo '<div class="bigEspace"></div>	';
echo '<div class="caseForm titreForm col-span-form">Formulaire Utilisateurs</div>';
echo '<div class="bigEspace  col-span-form"></div>	';
	echo '<div class="noDisplay"><input type="hidden" value="'.$elm->getIdUtilisateur().'" name=IdUtilisateur></div>';
echo '<label for=NomUtilisateur class="caseForm labelForm">'.texte("NomUtilisateur").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getNomUtilisateur().'" name=NomUtilisateur pattern="'.$regex["*"].'"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=MailUtilisateur class="caseForm labelForm">'.texte("MailUtilisateur").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getMailUtilisateur().'" name=MailUtilisateur pattern="'.$regex["*"].'"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=MatriculeUtilisateur class="caseForm labelForm">'.texte("MatriculeUtilisateur").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getMatriculeUtilisateur().'" name=MatriculeUtilisateur pattern="'.$regex["*"].'"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=PasswordUtilisateur class="caseForm labelForm">'.texte("PasswordUtilisateur").'</label>';
echo '<div class="caseForm donneeForm"><input type="text" '.$disabled .'value="'.$elm->getPasswordUtilisateur().'" name=PasswordUtilisateur pattern="'.$regex["*"].'"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=IdUO class="caseForm labelForm">'.texte("IdUO").'</label>';
echo '<div class="caseForm donneeForm">'.creerSelect($elm->getIdUO(), 'Uos', ['numeroUO', 'libelleUO'], $disabled).'</div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=IdRole class="caseForm labelForm">'.texte("IdRole").'</label>';
echo '<div class="caseForm donneeForm">'.creerSelect($elm->getIdRole(), 'Roles', ['nomRole'], $disabled).'</div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=IdManager class="caseForm labelForm">'.texte("IdManager").'</label>';
echo '<div class="caseForm donneeForm">'.creerSelect($elm->getIdManager(), 'Utilisateurs', ['nomUtilisateur'], $disabled, ['idRole' => 2]).'</div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<div class="bigEspace "></div>	';
echo '<div class="caseForm col-span-form">
	<div></div>
	<div><a href="index.php?page=ListeUtilisateurs"><button type="button"><i class="fas fa-sign-out-alt fa-rotate-180"></i></button></a></div>
	<div class="cote"></div>';
	echo ($mode == "Afficher") ? "" : " <div><button type=\"submit\"><i class=\"fas fa-paper-plane\"></i></button></div>";
	echo'<div></div>
	</div>';

echo'</form>
<div class=flex-0-1></div>';

if ($_GET['mode'] == "Modifier")
{
	include 'PHP/VIEW/LISTE/ListeContrats.php';
}
echo ' <div class=flex-0-1></div></section>';
echo '</main>';
