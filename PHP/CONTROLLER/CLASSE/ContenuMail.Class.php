<?php
class ContenuMail
{

    /*****************Attributs***************** */
    private $_idUtilisateur;
    private $_nomUtilisateur;
    private $_mailUtilisateur;
    private $_idRole;
    private $_idManager;
    private $_nomManager;
    private $_etatPointage;
    private $_validePointage;
    private $_reportePointage;
    private $_listeARelancer;
    private $_listeAValider;
    private $_listeAReporter;
    private $_actif;

    /*****************Accesseurs***************** */


    public function getIdUtilisateur()
    {
        return $this->_idUtilisateur;
    }

    public function setIdUtilisateur($idUtilisateur)
    {
        $this->_idUtilisateur = $idUtilisateur;
    }

    public function getNomUtilisateur()
    {
        return $this->_nomUtilisateur;
    }

    public function setNomUtilisateur($nomUtilisateur)
    {
        $this->_nomUtilisateur = $nomUtilisateur;
    }
    

    public function getMailUtilisateur()
    {
        return $this->_mailUtilisateur;
    }
    public function setMailUtilisateur($mailUtilisateur)
    {
        $this->_mailUtilisateur = $mailUtilisateur;
    }

    public function getListeAReporter()
    {
        return $this->_listeAReporter;
    }
    public function getIdRole()
    {
        return $this->_idRole;
    }

    public function setIdRole($role)
    {
        $this->_idRole = $role;
    }
    

    public function getIdManager()
    {
        return $this->_idManager;
    }

    public function setIdManager($idManager)
    {
        $this->_idManager = $idManager;
    }

    public function getNomManager()
    {
        return $this->_nomManager;
    }

    public function setNomManager($nomManager)
    {
        $this->_nomManager = $nomManager;
    }

    public function getEtatPointage()
    {
        return $this->_etatPointage;
    }



    public function getListeAValider()
    {
        return $this->_listeAValider;
    }

    
    public function getActif()
    {
        return $this->_actif;
    }

    public function setActif($actif)
    {
        $this->_actif = $actif;
    }
    public function getValidePointage()
    {
        return $this->_validePointage;
    }

    public function getListeARelancer()
    {
        return $this->_listeARelancer;
    }


    public function getReportePointage()
    {
        return $this->_reportePointage;
    }


    /*****************Constructeur***************** */

    public function __construct(array $options = [])
    {
        if (!empty($options)) // empty : renvoi vrai si le tableau est vide
        {
            $this->hydrate($options);
        }
    }
    public function hydrate($data)
    {
        foreach ($data as $key => $value) {
            $methode = "set" . ucfirst($key); //ucfirst met la 1ere lettre en majuscule
            if (is_callable(([$this, $methode]))) // is_callable verifie que la methode existe
            {
                $this->$methode($value);
            }
        }
    }

    /*****************Autres Méthodes***************** */

    public function CalculTableauPointage($pointage, $test = null)
    {
        $somme = 0;
        foreach ($pointage as $elm) {
            if ($test != null) {
                if ($elm[$test]==1)
                    $somme += $elm['nb'];
            } else
                $somme += $elm['nb'];
        }
        return $somme;
    }
    public function setEtatPointage($pointage, $periode)
    {
        $nbJours = $this->CalculTableauPointage($pointage);
        $this->_etatPointage = ($nbJours == 0) ? "Vide" : (($nbJours == NbJourParPeriode($periode)) ? "Complet" : "Incomplet");
    }
    public function setValidePointage($pointage, $periode)
    {
        $nbJours = $this->CalculTableauPointage($pointage, "validePointage");
        $this->_validePointage = ($nbJours == 0) ? "Vide" : (($nbJours == NbJourParPeriode($periode)) ? "Complet" : "Incomplet");
    }
    public function setReportePointage($pointage, $periode)
    {
        $nbJours = $this->CalculTableauPointage($pointage, "reportePointage");
        $this->_reportePointage = ($nbJours == 0) ? "Vide" : (($nbJours == NbJourParPeriode($periode)) ? "Complet" : "Incomplet");
    }
    public function setListeAValider($key,$pointageAValider)
    {
        $this->_listeAValider[$key] = $pointageAValider;
    }
    public function setListeAReporter($key,$pointageAReporter)
    {
        $this->_listeAReporter[$key] = $pointageAReporter;
    }
    public function setListeARelancer($key,$pointageARelancer)
    {
        $this->_listeARelancer[$key] = $pointageARelancer;
    }
}
