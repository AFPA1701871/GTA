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
	$elm = View_UtilisateursManager::findById($_GET['id']);
} else {
	$elm = new View_Utilisateurs();
}
echo '<main class="center">';

echo '<form class="GridForm" action="index.php?page=ActionView_Utilisateurs&mode=' . $_GET['mode'] . '" method="post"/>';
echo '<div class="bigEspace"></div>	';
echo '<div class="caseForm titreForm col-span-form">Formulaire View_Utilisateurs</div>';
echo '<div class="bigEspace  col-span-form"></div>	';
echo '<div class="noDisplay"><input type="hidden" value="' . $elm->getIdUtilisateur() . '" name=IdUtilisateur></div>';
echo '<label for=NomUtilisateur class="caseForm labelForm">' . texte("NomUtilisateur") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getNomUtilisateur() . '" name=NomUtilisateur pattern="' . $regex["*"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=MailUtilisateur class="caseForm labelForm">' . texte("MailUtilisateur") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getMailUtilisateur() . '" name=MailUtilisateur pattern="' . $regex["*"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=MatriculeUtilisateur class="caseForm labelForm">' . texte("MatriculeUtilisateur") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getMatriculeUtilisateur() . '" name=MatriculeUtilisateur pattern="' . $regex["*"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=PasswordUtilisateur class="caseForm labelForm">' . texte("PasswordUtilisateur") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getPasswordUtilisateur() . '" name=PasswordUtilisateur pattern="' . $regex["*"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=IdUO_Utilisateur class="caseForm labelForm">' . texte("IdUO_Utilisateur") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getIdUO_Utilisateur() . '" name=IdUO_Utilisateur pattern="' . $regex["*"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=IdRole_Utilisateur class="caseForm labelForm">' . texte("IdRole_Utilisateur") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getIdRole_Utilisateur() . '" name=IdRole_Utilisateur pattern="' . $regex["*"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=IdManager class="caseForm labelForm">' . texte("IdManager") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getIdManager() . '" name=IdManager pattern="' . $regex["*"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=NomManager class="caseForm labelForm">' . texte("NomManager") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getNomManager() . '" name=NomManager pattern="' . $regex["*"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=MailManager class="caseForm labelForm">' . texte("MailManager") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getMailManager() . '" name=MailManager pattern="' . $regex["*"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=MatriculeManager class="caseForm labelForm">' . texte("MatriculeManager") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getMatriculeManager() . '" name=MatriculeManager pattern="' . $regex["*"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=PasswordManager class="caseForm labelForm">' . texte("PasswordManager") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getPasswordManager() . '" name=PasswordManager pattern="' . $regex["*"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=IdUO_Manager class="caseForm labelForm">' . texte("IdUO_Manager") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getIdUO_Manager() . '" name=IdUO_Manager pattern="' . $regex["*"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=IdRole_Manager class="caseForm labelForm">' . texte("IdRole_Manager") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getIdRole_Manager() . '" name=IdRole_Manager pattern="' . $regex["*"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<label for=IdManager2 class="caseForm labelForm">' . texte("IdManager2") . '</label>';
echo '<div class="caseForm donneeForm"><input type="text" ' . $disabled . 'value="' . $elm->getIdManager2() . '" name=IdManager2 pattern="' . $regex["*"] . '"></div>';
echo '<div class="caseForm infoForm"><i class="fas fa-question-circle"></i></div>';
echo '<div class="caseForm checkForm"><i class="fas fa-check-circle"></i></div>';

echo '<div class="bigEspace "></div>	';
echo '<div class="caseForm col-span-form">
	<div></div>
	<div><a href="index.php?page=ListeView_Utilisateurs"><button type="button"><i class="fas fa-house fa-rotate-180"></i></button></a></div>
	<div class="cote"></div>';
echo ($mode == "Afficher") ? "" : " <div><button type=\"submit\"><i class=\"fas fa-paper-plane\"></i></button></div>";
echo '<div></div>
	</div>';

echo '</form>';

echo '</main>';
