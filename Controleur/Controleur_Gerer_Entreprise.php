<?php


use App\Modele\Modele_Entreprise;
use App\Modele\Modele_Salarie;
use App\Vue\Vue_Utilisateur_Changement_MDP;
use App\Vue\Vue_Connexion_Formulaire_client;
use App\Vue\Vue_Menu_Entreprise_Client;
use App\Vue\Vue_Entreprise_Gerer_Compte;
use App\Vue\Vue_Entreprise_Information;
use App\Vue\Vue_Salarie_Editer;
use App\Vue\Vue_Salarie_Liste;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;


switch ($action) {
    case "infoEntreprise" :
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->addToCorps(new Vue_Menu_Entreprise_Client());

        $entreprise = Modele_Entreprise::Entreprise_Select_ParId($_SESSION["idEntreprise"]);
        $Vue->addToCorps(new Vue_Entreprise_Information($entreprise["idEntreprise"], $entreprise["denomination"], $entreprise["rueAdresse"], $entreprise["complementAdresse"], $entreprise["codePostal"]
            , $entreprise["ville"], $entreprise["pays"], $entreprise["numCompte"], $entreprise["mailContact"], $entreprise["siret"]));


        $Vue->setBasDePage(new Vue_Structure_BasDePage());
        break;
    case "salariesHabitites":
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->setMenu(new Vue_Menu_Entreprise_Client());

        $listeSalarie = Modele_Salarie::Salarie_Select_Entreprise($_SESSION["idEntreprise"]);
        $Vue->addToCorps(new Vue_Salarie_Liste($listeSalarie));
        $Vue->setBasDePage(new Vue_Structure_BasDePage());
        break;
    case "ajouterSalarie":
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->setMenu(new Vue_Menu_Entreprise_Client());
        $Vue->addToCorps(new Vue_Salarie_Editer());
        $Vue->setBasDePage(new Vue_Structure_BasDePage());
        break;
    case "buttonCreerSalarie":
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->setMenu(new Vue_Menu_Entreprise_Client());
        Modele_Salarie::Salarie_Ajouter($_REQUEST["nom"], $_REQUEST["prenom"], $_REQUEST["role"], $_REQUEST["mailContact"], "secret", 1, $_SESSION["idEntreprise"]);
        $listeSalarie = Modele_Salarie::Salarie_Select_Entreprise($_SESSION["idEntreprise"]);
        $Vue->addToCorps(new Vue_Salarie_Liste($listeSalarie));
        $Vue->setBasDePage(new Vue_Structure_BasDePage());
        break;
    case "ModiferSalarie":
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->setMenu(new Vue_Menu_Entreprise_Client());
        $salarie = Modele_Salarie::Salarie_Select_byId($_REQUEST["idSalarie"]);
        $Vue->addToCorps(new Vue_Salarie_Editer(false, $salarie["idSalarie"], $salarie["nom"], $salarie["prenom"], $salarie["roleEntreprise"], $salarie["mail"]));
        $Vue->setBasDePage(new Vue_Structure_BasDePage());
        break;
    case "ModiferSalarieValider":
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->setMenu(new Vue_Menu_Entreprise_Client());

        Modele_Salarie::Salarie_MAJ($_REQUEST["nom"], $_REQUEST["prenom"], $_REQUEST["role"], $_REQUEST["mailContact"], $_REQUEST["idSalarie"]);
        $listeSalarie = Modele_Salarie::Salarie_Select_Entreprise($_SESSION["idEntreprise"]);
        $Vue->addToCorps(new Vue_Salarie_Liste($listeSalarie, "<br>Salarié modifié"));
        $Vue->setBasDePage(new Vue_Structure_BasDePage());
        break;
    case "DesactiverSalarie" :
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->setMenu(new Vue_Menu_Entreprise_Client());

        Modele_Salarie::Salarie_Activer($_REQUEST["idSalarie"]);
        $listeSalarie = Modele_Salarie::Salarie_Select_Entreprise($_SESSION["idEntreprise"]);
        $Vue->addToCorps(new Vue_Salarie_Liste($listeSalarie, "<br>Salarié modifié"));
        $Vue->setBasDePage(new Vue_Structure_BasDePage());
        break;
    case "ActiverSalarie":
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->setMenu(new Vue_Menu_Entreprise_Client());

        Modele_Salarie::Salarie_Desactiver($_REQUEST["idSalarie"]);
        $listeSalarie = Modele_Salarie::Salarie_Select_Entreprise($_SESSION["idEntreprise"]);
        $Vue->addToCorps(new Vue_Salarie_Liste($listeSalarie, "<br>Salarié modifié"));
        $Vue->setBasDePage(new Vue_Structure_BasDePage());
        break;
    case "submitModifMDP":
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->setMenu(new Vue_Menu_Entreprise_Client());
        //il faut récuperer le mdp en BDD et vérifier qu'ils sont identiques
        $entreprise_connectee = Modele_Entreprise::Entreprise_Select_ParId($_SESSION["idEntreprise"]);
        if (password_verify($_REQUEST["AncienPassword"], $entreprise_connectee["motDePasse"])) {
            //on vérifie si le mot de passe de la BDD est le même que celui rentré
            if ($_REQUEST["NouveauPassword"] == $_REQUEST["ConfirmPassword"]) {
                Modele_Entreprise::Entreprise_Modifier_motDePasse($_SESSION["idEntreprise"], $_REQUEST["NouveauPassword"]);
                $Vue->addToCorps(new Vue_Entreprise_Gerer_Compte("<label><b>Votre mot de passe a bien été modifié</b></label>"));
                // Dans ce cas les mots de passe sont bons, il est donc modifié

            } else {
                $Vue->addToCorps(new Vue_Utilisateur_Changement_MDP("<label><b>Les nouveaux mots de passe ne sont pas identiques</b></label>"));

            }
        } else {
            $Vue->addToCorps(new Vue_Utilisateur_Changement_MDP("<label><b>Vous n'avez pas saisi le bon mot de passe</b></label>"));

        }
        break;
    case "ChangerMDPEntreprise":
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->setMenu(new Vue_Menu_Entreprise_Client());
        $Vue->addToCorps(new Vue_Utilisateur_Changement_MDP());
        $Vue->setBasDePage(new Vue_Structure_BasDePage());
        break;
    case "deconnexionEntreprise":
        session_destroy();
        unset($_SESSION["idEntreprise"]);
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->addToCorps(new Vue_Connexion_Formulaire_client());
        $Vue->setBasDePage(new Vue_Structure_BasDePage());
        break;
    default:
        $Vue->setEntete(new Vue_Structure_Entete());
        $Vue->setMenu(new Vue_Menu_Entreprise_Client());
        $Vue->addToCorps(new Vue_Entreprise_Gerer_Compte());
        $Vue->setBasDePage(new Vue_Structure_BasDePage());
        break;
}


 


