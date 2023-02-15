<?php

if ($roleConnecte == 1) {
    header('Location: index.php?page=FormPointages');
} 
else if ($roleConnecte == 2) {
    header('Location: index.php?page=TbManager');
} 
else if ($roleConnecte == 3) {
    header('Location: index.php?page=TbAssistante');
}
