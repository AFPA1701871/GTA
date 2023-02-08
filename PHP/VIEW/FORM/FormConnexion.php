<?php
global $regex;
?>

<main>
    <section class="center colonne">
        <form action="index.php?page=ActionConnexion" method="POST">
            <div class="colSpan2 center"><h1><?php echo texte('Connexion') ?></h1></div>

            <label for="mailUtilisateur"><?php echo texte('mailUtilisateur') ?> : </label>
            <input type="text" name="mailUtilisateur" required>

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