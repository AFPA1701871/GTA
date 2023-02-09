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
    <section class="center colonne">
        <form action="index.php?page=ActionInscription" method="POST">
            <div class="colSpan2 center"><h1><?php echo texte('Inscription') ?></h1></div>

            <label for="nom"><?php echo texte('Nom') ?> * : </label>
            <input type="text" id="nom" name="nom" pattern="^<?php echo $regex["alpha"] ?>$" required title=<?= texte("infoUsage")?>>

            <label for="prenom"><?php echo texte('Prenom') ?> * : </label>
            <input type="text" id="prenom" name="prenom" pattern="^<?php echo $regex["alpha"] ?>$" required title=<?= texte("infoPrenom")?>>

            <label for="mailUtilisateur"><?php echo texte('mailUtilisateur') ?> * : </label>
            <div class="relative">
                <input type="text" id="mailUtilisateur" name="mailUtilisateur" pattern="^<?php echo $regex["email"] ?>$" required title=<?= texte("infoMail")?>>
                <fieldset id="infoEmail" class="infoBulle noDisplay">
                    <div ><?= texte("erreurMail")?></div>
                </fieldset>
            </div>

            <label for="motDePasse"><?php echo texte('Mdp') ?> : </label> 
            <div class="relative">
                <input type="password" id="motDePasse" name="passwordUtilisateur" pattern="^<?php echo $regex["pwd"] ?>$"
                     required>
                <i class="oeil fas fa-eye"></i>
                <fieldset id="infoMDP" class="noDisplay infoBulle">
                <legend><?php echo texte('infoMdpLegend') ?></legend>
                    <div class="colonne gridAideMDP">
                        <i class="fas fa-times-circle fa-red"></i>
                        <label class="double" for=""><?php echo texte('uneMajuscule') ?></label>

                        <i class="fas fa-times-circle fa-red"></i>
                        <label class="double" for=""><?php echo texte('uneMinuscule') ?></label>

                        <i class="fas fa-times-circle fa-red"></i>
                        <label class="double" for=""><?php echo texte('UnChiffre') ?></label>

                        <i class="fas fa-times-circle fa-red"></i>
                        <label class="double" for=""><?php echo texte('UnCaractereSpecial') ?></label>
                        
                        <i class="fas fa-times-circle fa-red"></i>
                        <label class="double" for=""><?php echo texte('MinimumCaractere') ?></label>
                    </div>
                </fieldset>
            </div>


            <label for="confirmPassword"><?php echo texte('Confirmation') ?> : </label>
            <div class="relative">
                <input type="password" id="confirmPassword" name="confirmPassword"  required >
                <i class="oeil fas fa-eye"></i>
            </div>

            <div></div>
            <div></div>

            <input type="reset" value="<?php echo texte('Reset') ?>">
            <input type="submit" value="<?php echo texte('Envoyer') ?>">
        </form>
    </section>
</main>