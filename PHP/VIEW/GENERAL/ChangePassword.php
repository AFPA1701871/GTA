<?php
global $regex;
if (isset($_GET['src'])) {
    if ($_GET['src']) {
        include './PHP/VIEW/GENERAL/Nav.php';
    }
}
?>
<main>

    <section class="center colonne">
        <form action="index.php?page=ActionConnexion&mode=change" method="post">
            <div class="colSpan2 center">
                <?php
                if (isset($_GET['src'])) {
                    if ($_GET['src']) {
                        echo '<h1 class=titre>Changement de mot de passe</h1>';
                    }
                } else {
                    echo '<h1 class=titre>Vous devez changer votre mot de passe pour continuer</h1>';
                }
                ?>

            </div>
            <div class="bigEspace"></div>
            <div class="relative col-span-form-chg-pwd ligne">
                <label for="passwordUtilisateur" class=center><?= texte('Mdp'); ?> :</label>
                <div>
                    <input type="password" id="mdpUser" name="passwordUtilisateur" required class="minWidth" pattern="<?= $regex["pwd"] ?>">
                    <i class="oeil fas fa-eye"></i>
                </div>

                <div class="aideMdp absolu">
                    <div>Liste des critères à respecter !! </div>
                    <div>
                        <div class="mini"><i class="fas fa-times-circle fa-red"></i>
                        </div>
                        <div>majuscule(s)</div>
                    </div>
                    <div>
                        <div class="mini"><i class="fas fa-times-circle fa-red"></i>
                        </div>
                        <div>minuscule(s)</div>
                    </div>
                    <div>
                        <div class="mini"><i class="fas fa-times-circle fa-red"></i>
                        </div>
                        <div>nombre(s)</div>
                    </div>
                    <div>
                        <div class="mini"><i class="fas fa-times-circle fa-red"></i>
                        </div>
                        <div>caractères spéciaux</div>
                    </div>
                    <div>
                        <div class="mini"><i class="fas fa-times-circle fa-red"></i>
                        </div>
                        <div> 8 caractères minimum</div>
                    </div>
                </div>
            </div>

            <div class="relative col-span-form-chg-pwd ligne">
                <label for="confirmation" class=center>Confirmation de mot de passe :</label>
                <div>
                    <input type="password" id="confirmation" name="confirmation" title="remettre le même mot de passe" class="minWidth" required pattern="<?= $regex["pwd"] ?>">

                    <i class="oeil fas fa-eye"></i>
                </div>
            </div>
            <div></div>
            <div></div>
            <div class="relative col-span-form-chg-pwd ligne">
                <div></div>
                <div>
                    <input class="btnPrincipale" type="submit" id="submit" value="<?= texte('Modifier')  ?>" disabled></button>
                </div>
            </div>

            <div></div>

        </form>
    </section>
</main>