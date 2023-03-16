# Revue de code

* [ ] On ne garde pas une méthode qui s'appele SyntheseV3
  * [X] Fonction renommé RecupNombre
  * [X] NombrePointages
* [ ] Commentaires, il y a confusion entre les commentaires explicatifs et tes penses bêtes. Identifie tes penses bets par //FD texte du pense bete. Tu pourras les retirer facilement après
  * [ ] En cours, certains penses bêtes pourrais avoir été des commentaires mal tourné
* [ ] SyntheseV3 : gbH pour choisir entre nb jour ou nb utilisateur, il faut changer le nom de la variable. De plus, vrai ou faux oblige le dev à savoir comment s'est interprété. Je propose plutot Jour ou Utilisateur comme contenu
  * [X] gbH (et condGBH) remplacé par recherche (et condRecherche), string par défaut à "Utilisateurs" mais acceptant aussi "Jours"
  * [X] Regroupement
* [ ] la methode getSomme de ViewPointagesManager n'est plus utile. La remplacer par l'equivalent dans View_Pointages_PeriodesManager
  * [X] Fonction getSomme remplacé par RecupNombre avec arguments correspondants dans ActionMail, Outils et les deux tableaux de bord
* [ ] CheckModif : le nombre de paramètres ne correspond pas aux nombres de paramètres dans le commentaire
  * [X] Corrigé avec le passage à l'utilisation d'un objet au lieu des arguments à l'unité
* [ ] CheckModif : Methode qui va chercher en base de données une info. Appeler dans une boucle. Est ce qu'il n'y a pas moyen de traiter globalement le cas?
  * [X] Après reflection, utiliser MIN(validePointage) et MIN(reportePointage) dans le select de View_PointagesManager::getSomme() devrait retourner 1 seulement si tous les pointages sont validés/reportés. On aurait plus qu'a faire le test "==0" sur le champs voulu pour savoir s'il faut appliquer le style ".modif"... Ce qui rendrait la fonction CheckModif pour ainsi dire inutile puisque sa seule autre utilisation sert à ajouter les "(modifié)" dans la partie "statut" de la synthèse, chose que je le reconnais n'est pas du tout indispensable... Je prépare la modif pour refléter cette idée, sans remplacer ce qui est déjà là pour le moment. Je switcherais le code si tu valides l'idée.
* [ ] CheckModif : si on veut un detail, pourquoi ne pas passer un objet pointage plutot que tous les id
  * [X] Je n'y ai pensé que plus tard et ai oublié de faire la modif, corrigé maintenant
* [ ] CheckModif : pourquoi la requete renvoi une colonne appelée heuresDif. A quoi ca corerespond?
  * [X] HeuresDif correspond à la somme des heures pointés pour lesquelles les pointages ont été modifié. CheckModif renvoit "Vrai" si la requête renvoit quelque chose autre que null (même une somme de 0 veut dire que des pointages de cette prestation ont été retirés)
* [ ] Pointage.js : preformatFloat : cette méthode me parait trop compliquée. Pourquoi une gestion du point des miliers. essaie de variabiliser "." et "," pour ne pas faire 2 fois les mêmes traitements
* [ ] Pointage.js : CalculPrctGTA , SommeLigne : Cela me semble très riche de refaire encore et encore les calculs de sommeLigne, sommeColonne, etc... à chaque modification d'une valeur.
  Ne peut on pas imaginer mémoriser la valeur sur event getFocus et appliquer le calcul sur le blur ou à l'enregistrement pour impacter la somme de la ligne et la somme de la colonne?
  Se baser sur ces résultats pour le calcul du pourcentage
* [ ] Idem pour marquageAbsent qui déclenche l'event change qui relance tous les calculs
* [ ] A quoi sert la class cellBottom, colCachable, grid-lineSimple?
  * [X] retirer cellBottom,
  * [X] renommer colCachable en cellCachable,
  * [X] grid-lineSimple renommé en marginTopBottom
  * [ ] nettoyer css
