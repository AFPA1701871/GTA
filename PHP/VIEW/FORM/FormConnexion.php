<?php
global $regex;
?>

<main>
    <section class="center colonne">
        <form action="index.php?page=ActionConnexion" method="POST">
            <div class="colSpan2 center"><h1><?php echo texte('Connexion') ?></h1></div>

            <label for="matriculeUtilisateur"><?php echo texte('matriculeUtilisateur') ?> : </label>
            <input type="text" name="matriculeUtilisateur" required>

            <label for="passwordUtilisateur"><?php echo texte('Mdp') ?> : </label>
            <div class="relative">
                <input type="Password" name="passwordUtilisateur" required>
                <i class="oeil fas fa-eye"></i>
            </div>

            <div></div>
            <div></div>

            <div></div>
            <input type="submit" value="<?php echo texte('Envoyer') ?>">
        </form>
    </section>
    
</main>