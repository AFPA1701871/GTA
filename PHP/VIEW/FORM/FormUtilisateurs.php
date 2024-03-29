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
echo '<form class="GridForm" action="index.php?page=ActionUtilisateurs&mode=' . $_GET['mode'] . '" method="post"/>';
echo '<div class="bigEspace"></div>	';
echo '<div class="caseForm titreForm col-span-form">' . texte("Formulaire Utilisateurs") . '</div>';
echo '<div class="bigEspace  col-span-form"></div>	';
echo '<div class="noDisplay"><input type="hidden" value="' . $elm->getIdUtilisateur() . '" name=IdUtilisateur><input type="hidden" value="' . ($elm->getPasswordUtilisateur() ? $elm->getPasswordUtilisateur() : ' ') . '" name=PasswordUtilisateur></div>';
echo '<label for=NomUtilisateur class="caseForm labelForm">' . texte("NomUtilisateur") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getNomUtilisateur() . '" name=NomUtilisateur pattern="' . $regex["*"] . '" required></div>';
echo '<div></div><div></div>';

echo '<label for=MailUtilisateur class="caseForm labelForm">' . texte("MailUtilisateur") . '</label>';
echo '<div class="caseForm donneeForm"><input type="email" ' . $disabled . 'value="' . $elm->getMailUtilisateur() . '" name=MailUtilisateur pattern="' . $regex["email"] . '" required></div>';
echo '<div></div><div></div>';

echo '<label for=MatriculeUtilisateur class="caseForm labelForm">' . texte("MatriculeUtilisateur") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getMatriculeUtilisateur() . '" name=MatriculeUtilisateur pattern="' . $regex["*"] . '" required></div>';
echo '<div></div><div></div>';

echo '<label for=IdUo class="caseForm labelForm">' . texte("IdUo") . '</label>';
echo '<div class="caseForm donneeForm">' . creerSelect($elm->getIdUo(), 'Uos', ['numeroUo', 'libelleUo'], $disabled,null, null, null, "Choisir une Uo") . '</div>';
echo '<div></div><div></div>';

echo '<label for=IdRole class="caseForm labelForm">' . texte("IdRole") . '</label>';
echo '<div class="caseForm donneeForm">' . creerSelect($elm->getIdRole(), 'Roles', ['nomRole'], $disabled . ' required',["idRole"=>"1->4"] , null, null, "Choisir un rôle") . '</div>';
echo '<div></div><div></div>';

echo '<label for=IdManager class="caseForm labelForm">' . texte("IdManager") . '</label>';
echo '<div class="caseForm donneeForm">' . creerSelect($elm->getIdManager(), 'Utilisateurs', ['nomUtilisateur'], $disabled, ['idRole' => 2], null, 'idManager', "Choisir un manager") . '</div>';
echo '<div></div><div></div>';

echo '<div class="bigEspace "></div>	';
echo '<div class="caseForm col-span-form">
	<div></div>
	<div><a href="index.php?page=ListeUtilisateurs"><button type="button"><i class="fas fa-arrow-left fa-rotate-180"></i></button></a></div>
	<div class="cote"></div>';
	echo ($mode == "Afficher") ? "" :(($mode == "Supprimer") ? "<div><button type=\"submit\"><i class=\"fas fa-box-archive\"></i></button></div>" : " <div><button type=\"submit\"><i class=\"fas fa-paper-plane\"></i></button></div>");
	
echo '<div></div>
	</div>';

echo '</form>
<div class=flex-0-1></div>';

if ($_GET['mode'] == "Modifier" || $_GET['mode'] == "Afficher") {
	include 'PHP/VIEW/LISTE/ListeContrats.php';
}
echo ' <div class=flex-0-1></div></section>';
echo '</main>';
