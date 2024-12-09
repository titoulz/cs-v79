<?php


use App\Modele\Modele_Catalogue;
use App\Modele\Modele_Commande;
use App\Vue\Vue__CategoriesListe;
use App\Vue\Vue_Categories_Liste;
use App\Vue\Vue_Menu_Entreprise_Salarie;
use App\Vue\Vue_Produits_Info_Clients;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;


$Vue->setEntete(new Vue_Structure_Entete());


    if ($action == "AjoutPanierClient") {
        //on met dans le panier avant de calculer le menu
        Modele_Commande::Panier_Ajouter_Produit_ParIdProduit($_SESSION["idEntreprise"], $_REQUEST["idProduit"]);
    }

    $quantiteMenu = Modele_Commande::Panier_Quantite($_SESSION["idEntreprise"]);

    $Vue->setMenu(new Vue_Menu_Entreprise_Salarie($quantiteMenu));

    //Vue_Entreprise_Client_ Menu();
    $listeCategorie = Modele_Catalogue::Categorie_Select_Tous();
    $Vue->addToCorps(new Vue_Categories_Liste($listeCategorie, false));
    switch ($action) {
        case "boutonCategorie" :
            $idCategorie = $_REQUEST["idCategorie"];
            $listeProduit = Modele_Catalogue::Select_Produit_Select_ParIdCateg($idCategorie, "client");
            $Vue->addToCorps(new Vue_Produits_Info_Clients($listeProduit, $idCategorie));
            break;
        case "okRechercher" :
            $produits_recherche = Modele_Catalogue::Produit_Rechercher($_REQUEST["recherche"], "client");
            $Vue->addToCorps(new Vue_Produits_Info_Clients($produits_recherche, null, $_REQUEST["recherche"]));
            break;
        case "AjoutPanierClient":
            //    Ajouter_Produit_Panier(  $_SESSION["idEntreprise"],$_REQUEST["idProduit"] );
            //
            if ($_REQUEST["idCategorie"] != "") {
                $listeProduit = Modele_Catalogue::Select_Produit_Select_ParIdCateg($_REQUEST["idCategorie"], "client");
                $idCategorie = $_REQUEST["idCategorie"];
                $recherche = null;
            } elseif ($_REQUEST["recherche"] != "") {
                $listeProduit = Modele_Catalogue::Produit_Rechercher($_REQUEST["recherche"], "client");
                $idCategorie = null;
                $recherche = $_REQUEST["recherche"];
            }
            $Vue->addToCorps(new Vue_Produits_Info_Clients($listeProduit, $idCategorie, $recherche));

            //$_SESSION["idEntreprise"]
            break;
        default :

            $listeProduit = Modele_Catalogue::Produits_Select_Libelle_Categ("client");
            $Vue->addToCorps(new Vue_Produits_Info_Clients($listeProduit));
    }

$Vue->setBasDePage(new  Vue_Structure_BasDePage());
