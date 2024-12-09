<?php

use App\Modele\Modele_Commande;
use App\Vue\Vue_Action_Sur_Commande_Entreprise;
use App\Vue\Vue_Menu_Administration;
use App\Vue\Vue_Commande_Etat;
use App\Vue\Vue_Panier_Client;
use App\Vue\Vue_Commande_Histo;
use App\Vue\Vue_Commande_Info;
use App\Vue\Vue_Commande_Liste;
use App\Vue\Vue_Structure_Entete;

$Vue->setEntete(new Vue_Structure_Entete());
$Vue->setMenu(new Vue_Menu_Administration($typeConnexion));

$listeEtatCommande = Modele_Commande::EtatCommande_Liste();
$Vue->addToCorps(new Vue_Commande_Etat($listeEtatCommande));

switch ($action) {
    case "boutonCategorie":
        //On a demandé les commandes d'une catégorie
        $idEtatcommande = $_REQUEST["idEtatCommande"];
        $listeCommande = Modele_Commande::Commande_Select_Par_Etat($idEtatcommande);
        $Vue->addToCorps(new Vue_Commande_Liste($listeCommande));
        break;
    case "Toute" :
        $listeCommande = Modele_Commande::Commande_Select_Toute();
        $Vue->addToCorps(new Vue_Commande_Liste($listeCommande));
        break;
    case "VoirDetailCommande":
        $listeArticleCommande = Modele_Commande::Commande_Avoir_Article_Select_ParIdCommande($_REQUEST["idCommande"]);
        $infoCommande = Modele_Commande::Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $histoEtatCommande = Modele_Commande::Historique_Etat_Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $Vue->addToCorps(new Vue_Panier_Client($listeArticleCommande, true, $infoCommande));
        $Vue->addToCorps(new Vue_Action_Sur_Commande_Entreprise($infoCommande));
        $Vue->addToCorps(new Vue_Commande_Info($infoCommande));
        $Vue->addToCorps(new Vue_Commande_Histo($histoEtatCommande));
        break;
    case "Signaler_CommandePayee":
        if (isset($_REQUEST["info"]))
            $infoComplementaire = $_REQUEST["info"];
        else
            $infoComplementaire = "";
        Modele_Commande::HistoriqueEtatCommande_Inserer($_REQUEST["idCommande"], 3, $infoComplementaire, -1, $_SESSION["idUtilisateur"]);

        $listeArticleCommande = Modele_Commande::Commande_Avoir_Article_Select_ParIdCommande($_REQUEST["idCommande"]);
        $infoCommande = Modele_Commande::Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $histoEtatCommande = Modele_Commande::Historique_Etat_Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $Vue->addToCorps(new Vue_Panier_Client($listeArticleCommande, true, $infoCommande));
        $Vue->addToCorps(new Vue_Action_Sur_Commande_Entreprise($infoCommande));
        $Vue->addToCorps(new Vue_Commande_Info($infoCommande));
        $Vue->addToCorps(new Vue_Commande_Histo($histoEtatCommande));
        break;
    case "Signalee_CommandeEnPreparation":
        if (isset($_REQUEST["info"]))
            $infoComplementaire = $_REQUEST["info"];
        else
            $infoComplementaire = "";
        Modele_Commande::HistoriqueEtatCommande_Inserer($_REQUEST["idCommande"], 4, $infoComplementaire, -1, $_SESSION["idUtilisateur"]);
        $listeArticleCommande = Modele_Commande::Commande_Avoir_Article_Select_ParIdCommande($_REQUEST["idCommande"]);
        $infoCommande = Modele_Commande::Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $histoEtatCommande = Modele_Commande::Historique_Etat_Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $Vue->addToCorps(new Vue_Panier_Client($listeArticleCommande, true, $infoCommande));
        $Vue->addToCorps(new Vue_Action_Sur_Commande_Entreprise($infoCommande));
        $Vue->addToCorps(new Vue_Commande_Info($infoCommande));
        $Vue->addToCorps(new Vue_Commande_Histo($histoEtatCommande));
        break;
    case "Signalee_CommandeProblemeStock":
        if (isset($_REQUEST["info"]))
            $infoComplementaire = $_REQUEST["info"];
        else
            $infoComplementaire = "";
        Modele_Commande::HistoriqueEtatCommande_Inserer($_REQUEST["idCommande"], 5, $infoComplementaire, -1, $_SESSION["idUtilisateur"]);
        $listeArticleCommande = Modele_Commande::Commande_Avoir_Article_Select_ParIdCommande($_REQUEST["idCommande"]);
        $infoCommande = Modele_Commande::Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $histoEtatCommande = Modele_Commande::Historique_Etat_Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $Vue->addToCorps(new Vue_Panier_Client($listeArticleCommande, true, $infoCommande));
        $Vue->addToCorps(new Vue_Action_Sur_Commande_Entreprise($infoCommande));
        $Vue->addToCorps(new Vue_Commande_Info($infoCommande));
        $Vue->addToCorps(new Vue_Commande_Histo($histoEtatCommande));
        break;
    case "Signalee_CommandeEnvoyée":
        if (isset($_REQUEST["info"]))
            $infoComplementaire = $_REQUEST["info"];
        else
            $infoComplementaire = "";
        Modele_Commande::HistoriqueEtatCommande_Inserer($_REQUEST["idCommande"], 6, $infoComplementaire, -1, $_SESSION["idUtilisateur"]);
        $listeArticleCommande = Modele_Commande::Commande_Avoir_Article_Select_ParIdCommande($_REQUEST["idCommande"]);
        $infoCommande = Modele_Commande::Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $histoEtatCommande = Modele_Commande::Historique_Etat_Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $Vue->addToCorps(new Vue_Panier_Client($listeArticleCommande, true, $infoCommande));
        $Vue->addToCorps(new Vue_Action_Sur_Commande_Entreprise($infoCommande));
        $Vue->addToCorps(new Vue_Commande_Info($infoCommande));
        $Vue->addToCorps(new Vue_Commande_Histo($histoEtatCommande));
        break;
}
