# Revue de code

* [ ] On ne garde pas une méthode qui s'appele SyntheseV3
  * [X] Fonction renommé RecupNombre
* [ ] Commentaires, il y a confusion entre les commentaires explicatifs et tes penses bêtes. Identifie tes penses bets par //FD texte du pense bete. Tu pourras les retirer facilement après
  * [ ] En cours, certains penses bêtes pourrais avoir été des commentaires mal tourné
* [ ] SyntheseV3 : gbH pour choisir entre nb jour ou nb utilisateur, il faut changer le nom de la variable. De plus, vrai ou faux oblige le dev à savoir comment s'est interprété. Je propose plutot Jour ou Utilisateur comme contenu
  * [X] gbH (et condGBH) remplacé par recherche (et condRecherche), string par défaut à "Utilisateurs" mais acceptant aussi "Jours"
* [ ] la methode getSomme de ViewPointagesManager n'est plus utile. La remplacer par l'equivalent dans View_Pointages_PeriodesManager
  * [X] Fonction getSomme remplacé par RecupNombre avec arguments correspondants dans ActionMail, Outils et les deux tableaux de bord
* [ ] CheckModif : le nombre de paramètres ne correspond pas aux nombres de paramètres dans le commentaire
* [ ] CheckModif : Methode qui va chercher en base de données une info. Appeler dans une boucle. Est ce qu'il n'y a pas moyen de traiter globalement le cas?
* [ ] CheckModif : si on veut un detail, pourquoi ne pas passer un objet pointage plutot que tous les id
* [ ] CheckModif : pourquoi la requete renvoi une colonne appelée heuresDif. A quoi ca corerespond?
* [ ] Pointage.js : preformatFloat : cette méthode me parait trop compliquée. Pourquoi une gestion du point des miliers. essaie de variabiliser "." et "," pour ne pas faire 2 fois les mêmes traitements
* [ ] Pointage.js : CalculPrctGTA , SommeLigne : Cela me semble très riche de refaire encore et encore les calculs de sommeLigne, sommeColonne, etc... à chaque modification d'une valeur.
  Ne peut on pas imaginer mémoriser la valeur sur event getFocus et appliquer le calcul sur le blur ou à l'enregistrement pour impacter la somme de la ligne et la somme de la colonne?
  Se baser sur ces résultats pour le calcul du pourcentage
* [ ] Idem pour marquageAbsent qui déclenche l'event change qui relance tous les calculs
* [ ] A quoi sert la class cellBottom, colCachable, grid-lineSimple?
