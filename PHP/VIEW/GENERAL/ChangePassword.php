<main>
    <section class="center colonne">
        <form action="index.php?page=ActionConnexion&mode=change" method="post">
            <div class="colSpan2 center">
                <h1>Vous devez changer votre mot de passe pour continuer</h1>
            </div>

            <div class="relative col-span-form-chg-pwd ligne">
                <label for="passwordUtilisateur"><?= texte('Mdp'); ?> :</label>
                <div>
                    <input type="password" id="mdpUser" name="passwordUtilisateur" required class="minWidth"
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[!@#\$%\^&\*+])[a-zA-Z\d!@#\$%\^&\*+]{8,}$">
                    <i class="oeil fas fa-eye"></i>
                </div>

                <div class="aideMdp absolu">
                    <div>Liste des critères à respecter !! </div>
                    <div>
                        <div class="mini"><i class="fas fa-times-circle fa-red"></i>
                        </div>
                        <div> 8 caractères minimum</div>
                    </div>
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
                </div>
            </div>

            <div class="relative col-span-form-chg-pwd ligne">
                <label for="confirmation">Confirmation de mot de passe :</label>
                <div>
                    <input type="password" id="confirmation" name="confirmation" title="remettre le même mot de passe" class="minWidth"
                        required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[!@#\$%\^&\*+])[a-zA-Z\d!@#\$%\^&\*+]{8,}$">

                    <i class="oeil fas fa-eye"></i>
                </div>
            </div>

            <div></div>
            <div></div>
            <div></div>
            <input type="submit" value="<?= texte('Envoyer')  ?>"></button>
        </form>
    </section>
</main>