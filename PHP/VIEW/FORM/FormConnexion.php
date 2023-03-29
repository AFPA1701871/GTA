<?php
global $regex;
?>

<main>
    <section class="center colonne">
        <form action="index.php?page=ActionConnexion" method="POST">
            <div class="colSpan2 center">
                <h1 class="titre"><?php echo texte('Connexion') ?></h1>
            </div>
            <div class="colSpan2 center bigEspace"></div>
            <label for="matriculeUtilisateur" class="center"><?php echo texte('matriculeUtilisateur') ?> : </label>
            <input type="text" name="matriculeUtilisateur" required>

            <label for="passwordUtilisateur" class="center"><?php echo texte('Mdp') ?> : </label>
            <div class="relative">
                <input type="Password" name="passwordUtilisateur" required>
                <i class="oeil fas fa-eye"></i>
            </div>

            <div></div>
            <div></div>

            <div></div>
            <input class="btnPrincipale" type="submit" value="<?php echo texte('Se connecter') ?>">
        </form>

        <h3>A la première connexion, votre identifiant et votre mot de passe correspondent à votre matricule en MAJUSCULE</h3>
    </section>

</main>