<!DOCTYPE html>
<html>
<head>
<?php


//Si le titre est indiqué, on l'affiche entre les balises <title>
echo (!empty($titre)) ? '<title>' . $titre . '</title>' : '<title> Titre de la page </title>';
echo '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="icon" type="image/png" href="IMG/favicon.ico">

<link rel="stylesheet" href="CSS/root.css">
<link rel="stylesheet" href="CSS/style.css">
<link rel="stylesheet" href="CSS/icon.css">
<link rel="stylesheet" href="CSS/header.css">';
if (substr($nom,0,4)=="Form"){
    echo '  <link rel="stylesheet" href="CSS/grids.css">
            <link rel="stylesheet" href="CSS/form.css">';
}
else if (substr($nom,0,4)=="List"){
    echo '  <link rel="stylesheet" href="CSS/grids.css">';
}
 echo '</head>';
//  <script src="https://kit.fontawesome.com/ce4feb7268.js" crossorigin="anonymous"></script>