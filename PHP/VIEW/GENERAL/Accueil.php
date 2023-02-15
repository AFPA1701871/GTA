<?php

if ($roleConnecte == 1) {
    header('Location: index.php?page=FormPointages');
} else if ($roleConnecte == 2) {
    header('Location: index.php?page=dbManager');
} else if ($roleConnecte == 3) {
    header('Location: index.php?page=dbAssistante');
} else if ($roleConnecte == 4) {
    header('Location: index.php?page=dbAdmin');
}