<?php

use App\Modele\Modele_Commande;
use App\Modele\Modele_Entreprise;
use App\Vue\Facture_BasPageBrulerie;
use App\Vue\Facture_EnteteBrulerie;
use App\Vue\Vue_Action_Sur_Commande_Client;
use App\Vue\Vue_Panier_Client;
use App\Vue\Vue_Afficher_Button_Facture;
use App\Vue\Vue_Commande_Info_Entreprise;
use App\Vue\Vue_Commande_Histo;
use App\Vue\Vue_Menu_Entreprise_Salarie;
use App\Vue\Vue_Structure_Entete;
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;


//Premier switch pour gérer les PDFs
switch ($action) {
    case "AfficherCommandePDF":

        //Le pdf n'a pas besoin des entêtes HTML
        ob_start(); //activation de la redirction HTML vers une variable
        $listeArticlePanier = Modele_Commande::Commande_Avoir_Article_Select_ParIdCommande($_REQUEST["idCommande"]);
        $infoCommande =  Modele_Commande::Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $infoEntreprise = Modele_Entreprise::Entreprise_Select_ParId($_SESSION["idEntreprise"]);
        $Vue->setEntete(new Facture_EnteteBrulerie($infoCommande, $infoEntreprise));
        $Vue->addToCorps(new Vue_Panier_Client($listeArticlePanier, true));
        $Vue->setBasDePage(new Facture_BasPageBrulerie($infoCommande, $infoEntreprise));
        $Vue->afficher();
        $content = ob_get_clean(); //Fin de la redirection et transfert du HTML capturé vers un fichier
        $html2pdf = new Html2Pdf('L', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $html2pdf->output('facture.pdf');
        exit();
        break;
    default:
        //Pas PDF => Génération entête HTML
        $Vue->setEntete(new Vue_Structure_Entete());
        $quantiteMenu = Modele_Commande::Panier_Quantite($_SESSION["idEntreprise"]);
        $Vue->setMenu(new Vue_Menu_Entreprise_Salarie($quantiteMenu));
        break;
}

//Switch uniquement si page HTML
switch ($action) {
    case "VoirDetailCommande":
        $listeArticleCommande = Modele_Commande::Commande_Avoir_Article_Select_ParIdCommande($_REQUEST["idCommande"]);
        $infoCommande = Modele_Commande::Commande_Select_ParIdCommande($_REQUEST["idCommande"]);

        $histoEtatCommande = Modele_Commande::Historique_Etat_Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $Vue->addToCorps(new Vue_Panier_Client($listeArticleCommande, true, $infoCommande));
        $Vue->addToCorps(new Vue_Afficher_Button_Facture($_REQUEST["idCommande"]));

        if($histoEtatCommande != null && $histoEtatCommande != false) {
            $etatAct = $histoEtatCommande[0];

            $Vue->addToCorps(new Vue_Action_Sur_Commande_Client($infoCommande, $etatAct));
            $Vue->addToCorps(new Vue_Commande_Histo($histoEtatCommande));
        }
        break;


    case "Signalee_CommandeReceptionnee":

        if (isset($_REQUEST["info"]))
            $infoComplementaire = $_REQUEST["info"];
        else
            $infoComplementaire = "";
        Modele_Commande::HistoriqueEtatCommande_Inserer($_REQUEST["idCommande"], 7, $infoComplementaire, $_SESSION["idSalarie"]);
        $listeArticleCommande = Modele_Commande::Commande_Avoir_Article_Select_ParIdCommande($_REQUEST["idCommande"]);
        $infoCommande = Modele_Commande::Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $histoEtatCommande = Modele_Commande::Historique_Etat_Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $etatAct = $histoEtatCommande[0];
        $Vue->addToCorps(new Vue_Panier_Client($listeArticleCommande, true, $infoCommande));
        $Vue->addToCorps(new Vue_Action_Sur_Commande_Client($infoCommande, $etatAct));
        $Vue->addToCorps(new Vue_Afficher_Button_Facture($_REQUEST["idCommande"]));
        $Vue->addToCorps(new Vue_Commande_Histo($histoEtatCommande));
        break;


    case "Signalee_CommandeReceptionneeIncident":

        if (isset($_REQUEST["info"]))
            $infoComplementaire = $_REQUEST["info"];
        else
            $infoComplementaire = "";

        Modele_Commande::HistoriqueEtatCommande_Inserer($_REQUEST["idCommande"], 8, $infoComplementaire, $_SESSION["idSalarie"]);
        $listeArticleCommande = Modele_Commande::Commande_Avoir_Article_Select_ParIdCommande($_REQUEST["idCommande"]);
        $infoCommande = Modele_Commande::Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $histoEtatCommande = Modele_Commande::Historique_Etat_Commande_Select_ParIdCommande($_REQUEST["idCommande"]);
        $etatAct = $histoEtatCommande[0];
        $Vue->addToCorps(new Vue_Panier_Client($listeArticleCommande, true, $infoCommande));
        $Vue->addToCorps(new Vue_Action_Sur_Commande_Client($infoCommande, $etatAct));
        $Vue->addToCorps(new Vue_Afficher_Button_Facture($_REQUEST["idCommande"]));
        $Vue->addToCorps(new Vue_Commande_Histo($histoEtatCommande));
        break;

    default:
        $listeCommande = Modele_Commande::Commande_Select_ParIdEntreprise($_SESSION["idEntreprise"]);
        $Vue->addToCorps(new Vue_Commande_Info_Entreprise($listeCommande, false));
        break;
}

