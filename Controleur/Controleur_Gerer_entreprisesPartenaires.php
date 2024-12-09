<?php

use App\Modele\Modele_Entreprise;
use App\Modele\Modele_Utilisateur;
use App\Vue\Vue_Menu_Administration;
use App\Vue\Vue_Entreprise_Formulaire;
use App\Vue\Vue_Entreprise_Liste;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;
use PHPMailer\PHPMailer\PHPMailer ;
use function App\Fonctions\GenereMDP;

//Obligatoire pour avoir l’objet phpmailer qui marche

/**
 * Ce contrôleur est dédié à la gestion des entreprises partenaires.
 * Toutes les pages de cette user story renvoie sur ce contrôleur.
 * Le tri entre les actions est fait sur l'existence des boutons submit. Deux boutons ne doivent pas avoir le même nom ! ;)
 */
$Vue->setEntete(new Vue_Structure_Entete());
$Vue->setMenu(new Vue_Menu_Administration($typeConnexion));

switch ($action) {
    case "Modifer":
        //Modifier dans le formulaire de mise à jour
        $entreprise = Modele_Entreprise::Entreprise_Select_ParId($_REQUEST["idEntreprise"]);
        $Vue->addToCorps(new Vue_Entreprise_Formulaire(false, $entreprise["idEntreprise"], $entreprise["denomination"], $entreprise["rueAdresse"], $entreprise["complementAdresse"], $entreprise["codePostal"]
            , $entreprise["ville"], $entreprise["pays"], $entreprise["numCompte"], $entreprise["mailContact"], $entreprise["siret"]));
        break;
    case  "mettreAJour":
        //Mettre à jour dans la liste des entreprises
        Modele_Entreprise::Entreprise_Modifier($_REQUEST["idEntreprise"], $_REQUEST["denomination"], $_REQUEST["rueAdresse"], $_REQUEST["complementAdresse"], $_REQUEST["codePostal"]
            , $_REQUEST["ville"], $_REQUEST["pays"], $_REQUEST["mailContact"], $_REQUEST["siret"]);
        $listeEntreprise = Modele_Entreprise::Entreprise_Select();
        $Utilisateur = Modele_Utilisateur::Utilisateur_Select_ParId($_SESSION["idUtilisateur"]);
        $Vue->addToCorps(new Vue_Entreprise_Liste($listeEntreprise));
        break;
    case  "réinitialiserMDP":
        //Réinitialiser MDP sur la fiche de l'entreprise
        $entreprise = Modele_Entreprise::Entreprise_Select_ParId($_REQUEST["idEntreprise"]);

        $motDePasse = App\Fonctions\GenereMDP(10);
        Modele_Entreprise::Entreprise_Modifier_motDePasse($_REQUEST["idEntreprise"], $motDePasse); //$entreprise["numCompte"]

        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = '127.0.0.1';
        $mail->CharSet = "UTF-8";
        $mail->Port = 1025; //Port non crypté
        $mail->SMTPAuth = false; //Pas d’authentification
        $mail->SMTPAutoTLS = false; //Pas de certificat TLS
        $mail->setFrom('contact@labruleriecomtoise.fr', 'contact');
        $mail->addAddress($entreprise["mailContact"], $entreprise["denomination"]);
        if ($mail->addReplyTo('test@labruleriecomtoise.fr', 'admin')) {
            $mail->Subject = 'Objet : MDP !';
            $mail->isHTML(false);
            $mail->Body = "MDP $motDePasse";

            if (!$mail->send()) {
                $msg = 'Désolé, quelque chose a mal tourné. Veuillez réessayer plus tard.';
            } else {
                $msg = 'Message envoyé ! Merci de nous avoir contactés.';
            }
        } else {
            $msg = 'Il doit manquer qqc !';
        }
        //    echo $msg;
        $listeEntreprise = Modele_Entreprise::Entreprise_Select();
        $Utilisateur = Modele_Utilisateur::Utilisateur_Select_ParId($_SESSION["idUtilisateur"]);
        $Vue->addToCorps(new Vue_Entreprise_Liste($listeEntreprise));

        break;
    case "nouveau":
        //Nouveau sur la liste des entreprises
        $Vue->addToCorps(new Vue_Entreprise_Formulaire(true));
        break;
    case  "buttonCreer":
        //Créer sur la fiche de création d'une entreprise
        Modele_Entreprise::Entreprise_Creer($_REQUEST["denomination"], $_REQUEST["rueAdresse"], $_REQUEST["complementAdresse"], $_REQUEST["codePostal"]
            , $_REQUEST["ville"], $_REQUEST["pays"], $_REQUEST["mailContact"], $_REQUEST["siret"]);
        $listeEntreprise = Modele_Entreprise::Entreprise_Select();

        $Vue->addToCorps(new Vue_Entreprise_Liste($listeEntreprise));
        break;
    case "DesactiverEntreprise":
    case  "ActiverEntreprise":
        //Désactiver utilisateur ou réactiver utilisateur
        $Entreprise = Modele_Entreprise::Entreprise_Select_ParId($_REQUEST["idEntreprise"]);
        // champ desactiver valeur 0 : personne activée sur le site
        if ($Entreprise["desactiver"] == 0) {
            $Entreprise["desactiver"] = 1;
            Modele_Entreprise::Entreprise_Modifier_Desactivation($_REQUEST["idEntreprise"], $Entreprise["desactiver"]);

        } // champ desactiver valeur 1 : personne désactivée sur le site
        elseif ($Entreprise["desactiver"] == 1) {
            $Entreprise["desactiver"] = 0;
            Modele_Entreprise::Entreprise_Modifier_Desactivation($_REQUEST["idEntreprise"], $Entreprise["desactiver"]);
        }
        $listeEntreprise = Modele_Entreprise::Entreprise_Select();
       // $Utilisateur = Modele_Utilisateur::Utilisateur_Select_ParId($_SESSION["idUtilisateur"]);
        $Vue->addToCorps(new Vue_Entreprise_Liste($listeEntreprise));
        break;
    default:
        //situation par défaut :
        $listeEntreprise = Modele_Entreprise::Entreprise_Select();
        //$Utilisateur = Modele_Utilisateur::Utilisateur_Select_ParId($_SESSION["idUtilisateur"]);
        $Vue->addToCorps(new Vue_Entreprise_Liste($listeEntreprise));
        break;
}

$Vue->setBasDePage(new Vue_Structure_BasDePage());
