<?php

use App\Modele\Modele_Commande;
use App\Modele\Modele_Entreprise;
use App\Vue\Vue_Utilisateur_Changement_MDP;
use App\Vue\Vue_AfficherMessage;
use App\Vue\Vue_Connexion_Formulaire_client;
use App\Vue\Vue_Menu_Entreprise_Client;
use App\Vue\Vue_Entreprise_Gerer_Compte;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;


$Vue->setEntete(new Vue_Structure_Entete());
//Vue__MenuEntrepriseClient();
//Vue_Entreprise_Gerer_Compte();
switch ($action) {
    case "ChangerMDPEntreprise":
        $Vue->setEntete(new Vue_Structure_Entete());
        $quantiteMenu = Modele_Commande::Panier_Quantite($_SESSION["idEntreprise"]);
        $Vue->setMenu(new Vue_Menu_Entreprise_Client($quantiteMenu));
        $Vue->addToCorps(new Vue_Utilisateur_Changement_MDP());
        break;
    case  "submitModifMDP":
        //il faut récuperer le mdp en BDD et vérifier qu'ils sont identiques
        $entreprise_connectee = Modele_Entreprise::Entreprise_Select_ParId($_SESSION["idEntreprise"]);
        if (password_verify($_REQUEST["AncienPassword"], $entreprise_connectee["motDePasse"])) {
            //on vérifie si le mot de passe de la BDD est le même que celui rentré
            if ($_REQUEST["NouveauPassword"] == $_REQUEST["ConfirmPassword"]) {
                //Utilisateur_Modifier_motDePasse(  $_SESSION["idEntreprise"], $_REQUEST["NouveauPassword"] );
                $Vue->setMenu(new Vue_Menu_Entreprise_Client());
                $Vue->addToCorps(new Vue_Entreprise_Gerer_Compte());
                // Dans ce cas les mots de passe sont bons, il est donc modifié
                $Vue->addToCorps(new Vue_AfficherMessage("<label><b>Votre mot de passe a bien été modifié</b></label>"));
            } else {
                $Vue->addToCorps(new Vue_Utilisateur_Changement_MDP());
                $Vue->addToCorps(new Vue_AfficherMessage("<label><b>Les nouveaux mots de passe ne sont pas identiques</b></label>"));
            }
        } else {
            $Vue->addToCorps(new Vue_Utilisateur_Changement_MDP());
            $Vue->addToCorps(new Vue_AfficherMessage("<label><b>Vous n'avez pas saisi le bon mot de passe</b></label>"));
        }
        $Vue->addToCorps(new Vue_Utilisateur_Changement_MDP());
        break;
    case "deconnexionEntreprise":
        //L'utilisateur a cliqué sur "se déconnecter"
        session_destroy();
        unset($_SESSION["idEntreprise"]);
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->addToCorps(new Vue_Connexion_Formulaire_client());
        break;
    case "infoEntreprise":
        $Vue->setEntete(new Vue_Structure_Entete());
        $quantiteMenu = Modele_Commande::Panier_Quantite($_SESSION["idEntreprise"]);
        $Vue->setMenu(new Vue_Menu_Entreprise_Client($quantiteMenu));
        break;
    case "salariesHabitites":
        $Vue->setEntete(new Vue_Structure_Entete());
        $quantiteMenu = Modele_Commande::Panier_Quantite($_SESSION["idEntreprise"]);
        $Vue->setMenu(new Vue_Menu_Entreprise_Client($quantiteMenu));
        break;
    default:
        //Cas par défaut: affichage du menu des actions.
        $Vue->setEntete(new Vue_Structure_Entete());
        $quantiteMenu = Modele_Commande::Panier_Quantite($_SESSION["idEntreprise"]);
        $Vue->setMenu(new Vue_Menu_Entreprise_Client($quantiteMenu));
        $Vue->addToCorps(new Vue_Entreprise_Gerer_Compte());
        break;
}


$Vue->setBasDePage(new Vue_Structure_BasDePage());
