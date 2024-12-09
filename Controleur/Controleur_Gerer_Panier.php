<?php

use App\Modele\Modele_Commande;
use App\Modele\Modele_Entreprise;
use App\Vue\Facture_BasPageBrulerie;
use App\Vue\Facture_EnteteBrulerie;
use App\Vue\Vue__CategoriesListe;
use App\Vue\Vue_Menu_Entreprise_Salarie;
use App\Vue\Vue_Panier_Client;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;
use Spipu\Html2Pdf\Html2Pdf;

$Vue->setEntete(new Vue_Structure_Entete());



/* Premier  */
switch ($action) {
    case "diminuerQTT" :
        Modele_Commande::Panier_DiminuerQTT_Article($_SESSION["idEntreprise"], $_REQUEST["idProduit"]);
        $listeArticlePanier = Modele_Commande::Panier_ListeArticle($_SESSION["idEntreprise"]);
        $Vue->addToCorps(new Vue_Panier_Client($listeArticlePanier));
        break;
    case  "augmenterQTT":
        Modele_Commande::Panier_AugmenterQTT_Article($_SESSION["idEntreprise"], $_REQUEST["idProduit"]);
        $listeArticlePanier = Modele_Commande::Panier_ListeArticle($_SESSION["idEntreprise"]);
        $Vue->addToCorps(new Vue_Panier_Client($listeArticlePanier));
        break;
    case "validerPanier":
        ob_start();
        $listeArticlePanier = Modele_Commande::Panier_ListeArticle($_SESSION["idEntreprise"]);
        $infoCommande = Modele_Commande::Caddie_Select_ParIdEntreprise($_SESSION["idEntreprise"]);
        $infoEntreprise = Modele_Entreprise::Entreprise_Select_ParId($_SESSION["idEntreprise"]);
        $Vue->setEntete(new Facture_EnteteBrulerie($infoCommande, $infoEntreprise));
        $Vue->addToCorps(new Vue_Panier_Client($listeArticlePanier, true));
        $Vue->setBasDePage(new Facture_BasPageBrulerie($infoCommande, $infoEntreprise));
        $Vue->afficher();
        Modele_Commande::Commande_Valider_Caddie($infoCommande["id"], $_SESSION["idSalarie"]);
        $content = ob_get_clean();
        $html2pdf = new Html2Pdf('L', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content);
        $html2pdf->output('facture.pdf');
        exit();
    //  echo $content;
    /*$html2pdf = new Html2Pdf();
    $html2pdf->writeHTML('<h1>HelloWorld</h1>This is my first test');
    $html2pdf->output();*/
    default:
        $listeArticlePanier = Modele_Commande::Panier_ListeArticle($_SESSION["idEntreprise"]);
        $Vue->addToCorps(new Vue_Panier_Client($listeArticlePanier));
        break;
}
$quantiteMenu = Modele_Commande::Panier_Quantite($_SESSION["idEntreprise"]);

$Vue->setMenu(new Vue_Menu_Entreprise_Salarie($quantiteMenu));

$Vue->setBasDePage(new Vue_Structure_BasDePage());
