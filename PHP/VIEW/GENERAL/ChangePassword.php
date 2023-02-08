<section>
    <div class="mini"></div>
    <form action="index.php?page=ActionConnexion&mode=change" method="post" class="double">
        <div class="colSpan2 center">
            <h1>Vous devez changer votre mot de passe pour continuer</h1>
        </div>

        <div class="colonne">
            <div class="info colonne relative">
                <label for="passwordUtilisateur">Mot de passe :</label>
                <div>
                    <div class="triple">
                        <input type="password" id="mdpUser" name="passwordUtilisateur" required class="minWidth"
                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[!@#\$%\^&\*+])[a-zA-Z\d!@#\$%\^&\*+]{8,}$">
                    </div>
                    <div class=" mini oeil ">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
                <div class="mini">

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
           <div class="info colonne relative">
                <label for="confirmation">Confirmation de mot de passe :</label>
                <div>
                    <div class="triple">
                        <input type="password" id="confirmation" name="confirmation" title="remettre le même mot de passe" class="minWidth"
                    required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[!@#\$%\^&\*+])[a-zA-Z\d!@#\$%\^&\*+]{8,}$">
                </div>
                    <div class=" mini oeil ">
                        <i class="fas fa-eye"></i>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="espace"></div>
        <div>
            <div class="mini"></div>
            <div><button id="submit" class="bouton" type="submit" disabled>Valider</button></div>
        <div class="mini"></div>
        </div>
        <div>
            <div class="info center">
                <div class="erreur"></div>
            </div>
        </div>
    </form>
    
    <div class="mini"></div>
</section>
