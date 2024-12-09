<?php


use App\Modele\Modele_Catalogue;
use App\Vue\Vue_Menu_Administration;
use App\Vue\Vue__CategoriesListe;
use App\Vue\Vue_Produit_Creation;
use App\Vue\Vue_Categories_Liste;
use App\Vue\Vue_Produit_Tous;
use App\Vue\Vue_AfficherMessage;
use App\Vue\Vue_Demande_Approbation_Desactivation;
use App\Vue\Vue_Categorie_Creation_Modification_;
use App\Vue\Vue_Catalogue_Formulaire;
use App\Vue\Vue_Liste_Categorie;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;





$Vue->setEntete(new Vue_Structure_Entete());
$Vue->setMenu(new Vue_Menu_Administration($typeConnexion));
$listeCategorie = Modele_Catalogue::Categorie_Select_Tous();
$Vue->addToCorps(new Vue_Categories_Liste($listeCategorie, true));

switch ($action) {
    case "boutonCategorie" :
        $idCategorie = $_REQUEST["idCategorie"];
        $listeProduit = Modele_Catalogue::Select_Produit_Select_ParIdCateg($idCategorie);
        $Vue->addToCorps(new Vue_Produit_Tous($listeProduit, $idCategorie));
        //Vue_Affiche_Liste_Produit_UneCategorie($listeProduit);
        break;
    case "CreationCategorieAvecProduit":
        $listeCategorie = Modele_Catalogue::Categorie_Select_Tous();
        $listeTVA = Modele_Catalogue::TVA_Select_Tous();
        $fichier_image = "";
        $listeCategorie = Modele_Catalogue::Categorie_Select_Tous();
        $listeTVA = Modele_Catalogue::TVA_Select_Tous();
        if (isset($_FILES['image_utilisateur']) and $_FILES['image_utilisateur']['error'] == 0) {
            $Vue->addToCorps(new Vue_AfficherMessage("<label><b>Pour des raisons de sécurité, veuillez resélectionner votre image</b></label>"));
        }
        $Vue->addToCorps(new Vue_Catalogue_Formulaire($listeCategorie, $listeTVA, true,
            true, "", $_REQUEST["nom"], $_REQUEST["description"], $_REQUEST["resume"],
            $fichier_image, $_REQUEST["prixVenteHT"], $_REQUEST["idCategorie"], $_REQUEST["idTVA"],
            0));
        break;
    case "CreationProduit":
        $listeCategorie = Modele_Catalogue::Categorie_Select_Tous();
        $listeTVA = Modele_Catalogue::TVA_Select_Tous();
        $fichier_image = "";
        if (isset($_FILES['image_utilisateur']) and $_FILES['image_utilisateur']['error'] == 0) {
            $fichier_image = basename($_FILES['image_utilisateur']['name']);
            move_uploaded_file($_FILES['image_utilisateur']['tmp_name'], 'public/image/' . $fichier_image);
        }
        if (isset($_REQUEST["CategorieAvecProduit"])) {
            $idCategorie = Modele_Catalogue::Categorie_Creer($_REQUEST["CategorieAvecProduit"],
                $_REQUEST["DescriptionCategorieAvecProduit"], 0);
        } else {
            $idCategorie = $_REQUEST["idCategorie"];
        }
        $idProduit = Modele_Catalogue::Produit_Creer($_REQUEST["nom"], $_REQUEST["description"],
            $_REQUEST["resume"], $fichier_image, $_REQUEST["prixVenteHT"], $idCategorie, $_REQUEST["idTVA"],
            $_REQUEST["DesactiverProduit"]);
        $produit = Modele_Catalogue::Produit_Select_ParId($idProduit);
        Modele_Catalogue::Produit_Update_Ref($produit["libelle"], $produit["nom"], $idProduit);
        // Une fois le produit crée, on lui affiche une page pour savoir si le produit a bien été créé ou non, ainsi qu'un lien pour revenir sur le catalogue
        $Vue->addToCorps(new Vue_Produit_Creation($idProduit, false, true));
        break;
    case "CreationProduit":
        $listeCategorie = Modele_Catalogue::Categorie_Select_Tous();
        $listeTVA = Modele_Catalogue::TVA_Select_Tous();
        $fichier_image = "";
        // Si l'utilisateur veut créer une nouvelle catégorie, tout en créant un nouveau produit

        if (isset($_FILES['image_utilisateur']) and $_FILES['image_utilisateur']['error'] == 0) {
            $fichier_image = basename($_FILES['image_utilisateur']['name']);
            move_uploaded_file($_FILES['image_utilisateur']['tmp_name'], 'public/image/' . $fichier_image);
        }

        $idCategorie = $_REQUEST["idCategorie"];

        $idProduit = Modele_Catalogue::Produit_Creer($_REQUEST["nom"], $_REQUEST["description"],
            $_REQUEST["resume"], $fichier_image, $_REQUEST["prixVenteHT"], $idCategorie, $_REQUEST["idTVA"],
            $_REQUEST["DesactiverProduit"]);
        $produit = Modele_Catalogue::Produit_Select_ParId($idProduit);
        Modele_Catalogue::Produit_Update_Ref($produit["libelle"], $produit["nom"], $idProduit);
        // Une fois le produit crée, on lui affiche une page pour savoir si le produit a bien été crée ou non, ainsi qu'un lien pour revenir sur le catalogue
        $Vue->addToCorps(new Vue_Produit_Creation($idProduit, false, true));
        break;
    case "CategorieAvecProduit":
        $listeCategorie = Modele_Catalogue::Categorie_Select_Tous();
        $listeTVA = Modele_Catalogue::TVA_Select_Tous();
        $fichier_image = "";
        // Si l'utilisateur veut créer une nouvelle catégorie, tout en créant un nouveau produit

        if (isset($_FILES['image_utilisateur']) and $_FILES['image_utilisateur']['error'] == 0) {
            $fichier_image = basename($_FILES['image_utilisateur']['name']);
            move_uploaded_file($_FILES['image_utilisateur']['tmp_name'], 'public/image/' . $fichier_image);
        }

        $idCategorie = Modele_Catalogue::Categorie_Creer($_REQUEST["CategorieAvecProduit"],
            $_REQUEST["DescriptionCategorieAvecProduit"], 0);

        $idProduit = Modele_Catalogue::Produit_Creer($_REQUEST["nom"], $_REQUEST["description"],
            $_REQUEST["resume"], $fichier_image, $_REQUEST["prixVenteHT"], $idCategorie, $_REQUEST["idTVA"],
            $_REQUEST["DesactiverProduit"]);
        $produit = Modele_Catalogue::Produit_Select_ParId($idProduit);
        Modele_Catalogue::Produit_Update_Ref($produit["libelle"], $produit["nom"], $idProduit);
        // Une fois le produit crée, on lui affiche une page pour savoir si le produit a bien été crée ou non, ainsi qu'un lien pour revenir sur le catalogue
        $Vue->addToCorps(new Vue_Produit_Creation($idProduit, false, true));
        break;
    case "nouveauProduit":
        $listeCategorie = Modele_Catalogue::Categorie_Select_Tous();
        $listeTVA = Modele_Catalogue::TVA_Select_Tous();
        $fichier_image = "";
        // Si l'utilisateur veut créer une nouvelle catégorie, tout en créant un nouveau produit

        if (isset($_REQUEST["idCategorie"])) {
            $Vue->addToCorps(new Vue_Catalogue_Formulaire($listeCategorie, $listeTVA, true, false, "", "", "", "", "", "",
                $_REQUEST["idCategorie"]));
        } else
            $Vue->addToCorps(new Vue_Catalogue_Formulaire($listeCategorie, $listeTVA, true,));

        break;
    case "mettreAJourProduit":

        $produit = Modele_Catalogue::Produit_Select_ParId($_REQUEST["idProduit"]);
        $listeCategorie = Modele_Catalogue::Categorie_Select_Tous();
        $listeTVA = Modele_Catalogue::TVA_Select_Tous();

        if (isset($_FILES['image_utilisateur']) and $_FILES['image_utilisateur']['error'] == 0) {
            $fichier_image = basename($_FILES['image_utilisateur']['name']);
            move_uploaded_file($_FILES['image_utilisateur']['tmp_name'], 'public/image/' . $fichier_image);
        } else {
            $fichier_image = $_REQUEST["fichierImage"];
        }
        Modele_Catalogue::Produit_Modifier($_REQUEST["idProduit"], $_REQUEST["nom"], $_REQUEST["description"],
            $_REQUEST["resume"], $fichier_image, $_REQUEST["prixVenteHT"], $_REQUEST["idCategorie"],
            $_REQUEST["idTVA"], $_REQUEST["DesactiverProduit"]);
        // Une fois le produit modifié, on réaffiche tout le catalogue
        $listeProduit = Modele_Catalogue::Produit_Select();
        $Vue->addToCorps(new Vue_Produit_Tous($listeProduit));


        break;
    case "ModifierProduit":

        $produit = Modele_Catalogue::Produit_Select_ParId($_REQUEST["idProduit"]);
        $listeCategorie = Modele_Catalogue::Categorie_Select_Tous();
        $listeTVA = Modele_Catalogue::TVA_Select_Tous();

        $Vue->addToCorps(new Vue_Catalogue_Formulaire($listeCategorie, $listeTVA, false,
            false, $produit["idProduit"], $produit["nom"], $produit["description"],
            $produit["resume"], $produit["fichierImage"], $produit["prixVenteHT"], $produit["idCategorie"],
            $produit["idTVA"], $produit["desactiverProduit"]));

        break;
    case "AjouterCategorie":
        $listeCategorie = Modele_Catalogue::Categorie_Select_Tous();
        $Vue->addToCorps(new Vue_Liste_Categorie($listeCategorie));

        break;
    case "DesactiverCategorie":
    case "ActiverCategorie":
        // si l'utilisateur clique sur Désactiver/activer
        // On modifie la valeur dans la BDD
        // On affiche soit le bouton Activer soit le bouton Désactiver en fonction
        $idCategorie = $_REQUEST["idCategorie"];
        $categorie = Modele_Catalogue::Categorie_Select_ParID($idCategorie);
        switch ($categorie["desactiverCategorie"]) {
            case 0:
                $Vue->addToCorps(new Vue_Demande_Approbation_Desactivation($idCategorie));
                break;
            case 1:
                $categorie["desactiverCategorie"] = 0;
                Modele_Catalogue::Categorie_Modifier_Desactivation($idCategorie, $categorie["desactiverCategorie"]);
                break;
        }
        $listeCategorie = Modele_Catalogue::Categorie_Select_Tous();
        $Vue->addToCorps(new Vue_Liste_Categorie($listeCategorie));
        break;
    case "OuiDesactivation":
        $idCategorie = $_REQUEST["idCategorie"];
        $categorie = Modele_Catalogue::Categorie_Select_ParID($idCategorie);
        $categorie["desactiverCategorie"] = 1;
        Modele_Catalogue::Categorie_Modifier_Desactivation($idCategorie, $categorie["desactiverCategorie"]);
        $listeCategorie = Modele_Catalogue::Categorie_Select_Tous();
        $Vue->addToCorps(new Vue_Liste_Categorie($listeCategorie));
        break;
    case "ModifierCategorie":
        // l'utilisateur clique sur "Modifier", on lui affiche le formulaire de modification
        $idCategorie = $_REQUEST["idCategorie"];
        $categorie = Modele_Catalogue::Categorie_Select_ParID($idCategorie);
        $Vue->addToCorps(new Vue_Categorie_Creation_Modification_(false,
            $categorie["idCategorie"], $categorie["libelle"], $categorie["description"]));
        break;
    case "mettreAJourCategorie":
        // l'utilsateur clique sur mettre à jour, pour valider sa modification
        $idCategorie = $_REQUEST["idCategorie"];
        Modele_Catalogue::Categorie_Modifier($idCategorie, $_REQUEST["libelle"], $_REQUEST["description"]);
        $listeCategorie = Modele_Catalogue::Categorie_Select_Tous();
        $Vue->addToCorps(new Vue_Liste_Categorie($listeCategorie));
        break;
    case "nouvelleCategorie":
        // l'utilisateur veut ajouter une nouvelle catégorie, on lui affiche le formulaire de création
        $Vue->addToCorps(new Vue_Categorie_Creation_Modification_(true, false));
        break;
    case "CreerCategorie":
        // L'utlisateur a cliquer sur Créer, afin d'ajouter sa nouvelle catégorie
        $categorie = Modele_Catalogue::Categorie_Select_Par_Libelle($_REQUEST["libelle"]);
        if (is_array($categorie)) {
            $Vue->addToCorps(new Vue_AfficherMessage("<h3>Cette catégorie existe déjà, veuillez recommencer</h3>"));

            $Vue->addToCorps(new Vue_Categorie_Creation_Modification_(true, false));
        } else {
            $desactiver = 0;
            $reponse = Modele_Catalogue::Categorie_Creer($_REQUEST["libelle"], $_REQUEST["description"], $desactiver);
            // Une fois la catégorie crée, on lui affiche une page pour savoir si la catégorie a bien été crée ou non, ainsi qu'un lien pour revenir sur le catalogue
            $Vue->addToCorps(new Vue_Produit_Creation($reponse, true, false));
            $listeCategorie = Modele_Catalogue::Categorie_Select_Tous();
            $listeTVA = Modele_Catalogue::TVA_Select_Tous();
            $Vue->addToCorps(new Vue_Catalogue_Formulaire($listeCategorie, $listeTVA, true, "", "", "", "",
                "", "", "", $reponse));
        }
        break;
    case "okRechercher":
        $produits_recherche = Modele_Catalogue::Produit_Rechercher($_REQUEST["recherche"]);
        $Vue->addToCorps(new Vue_Produit_Tous($produits_recherche));
        break;
    default:
        $listeProduit = Modele_Catalogue::Produits_Select_Libelle_Categ();
        $Vue->addToCorps(new Vue_Produit_Tous($listeProduit));
        break;
}
$Vue->setBasDePage(new Vue_Structure_BasDePage());
