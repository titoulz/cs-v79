<?php


use App\Modele\Modele_Utilisateur;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;
use App\Vue\Vue_Menu_Administration;

$Vue->setEntete(new Vue_Structure_Entete());



switch ($action) {

    case "AccepterRGPD" :
        $date = new DateTime();
        Modele_Utilisateur::Utilisateur_Modifier_RGPD($_SESSION["idUtilisateur"],1,$date,$_SERVER['REMOTE_ADDR']);

        switch ($_SESSION["idCategorie_utilisateur"]) {
            case 1:
                $_SESSION["typeConnexionBack"] = "administrateurLogiciel"; //Champ inutile, mais bien pour voir ce qu'il se passe avec des étudiants !
                $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                break;
            case 2:
                $_SESSION["typeConnexionBack"] = "gestionnaireCatalogue";
                $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                $Vue->addToCorps(new \App\Vue\Vue_AfficherMessage("Bienvenue " . $_REQUEST["compte"]));
                break;
            case 3:
                $_SESSION["typeConnexionBack"] = "entrepriseCliente";
                //error_log("idUtilisateur : " . $_SESSION["idUtilisateur"]);
                $_SESSION["idEntreprise"] = Modele_Entreprise::Entreprise_Select_Par_IdUtilisateur($_SESSION["idUtilisateur"])["idEntreprise"];
                include "./Controleur/Controleur_Gerer_Entreprise.php";
                break;
            case 4:
                $_SESSION["typeConnexionBack"] = "salarieEntrepriseCliente";
                $_SESSION["idSalarie"] = $_SESSION["idUtilisateur"];
                $_SESSION["idEntreprise"] = Modele_Salarie::Salarie_Select_byId($_SESSION["idUtilisateur"])["idEntreprise"];
                include "./Controleur/Controleur_Catalogue_client.php";
                break;
            case 5:
                $_SESSION["typeConnexionBack"] = "commercialCafe";
                $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                break;
        }
        break;
    case "RefuserRGPD":
        session_destroy();
        unset($_SESSION);
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->addToCorps(new Vue_Connexion_Formulaire_client());
        break;
    case "AfficherRGPD" :
        default:
        $Vue->addToCorps(new \App\Vue\Vue_ConsentementRGPD());
        break;
}
$Vue->setBasDePage(new  Vue_Structure_BasDePage());

