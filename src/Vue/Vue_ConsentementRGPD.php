<?php

namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_ConsentementRGPD extends Vue_Composant
{
    private string $msgErreur;
    public function __construct(string $msgErreur = "")
    {
        $this->msgErreur = $msgErreur;
    }

    function donneTexte(): string
    {
        $str = "       
        <H1>Objet du traitement (finalité et base légale)</H1> La société ABCD, dont le siège est situé à CONFIANCE (96 000), 
        Rue la Transparence, dispose d’un site internet de vente en ligne. Ce site permet de recevoir les commandes de nos clients
         et les données collectées à cette occasion sont enregistrées et traitées dans un fichier clients. Ce fichier permet de : 
         Gérer les commandes, le paiement et la livraison. Mener des opérations de marketing (fidélisation, promotions) et adresser 
         des publicités par courriel auprès de nos clients qui ne s’y sont pas opposés ou qui l’ont accepté : Sur des produits 
         analogues à ceux qu’ils ont commandés. Sur d’autres produits proposés par la société. Par exemple, si un client achète 
         une robe, une crème pour le corps pourra lui être proposée. Transmettre les données de nos clients qui l’ont accepté à 
         nos partenaires commerciaux, pour leur permettre de leur adresser de la publicité (cf. ci-dessous). Bases légales des 
         traitements Gestion des commandes : la base légale du traitement est l’exécution d’un contrat (Cf. article 6.1.b) du 
         Règlement européen sur la protection des données). Envoi de sollicitations commerciales par courriel sur des produits 
         analogues à ceux commandés par les clients : la base légale du traitement est l’intérêt légitime de la société (Cf. 
         article 6.1.f) du Règlement européen sur la protection des données), à savoir promouvoir nos produits auprès de nos 
         clients. Envoi de sollicitations commerciales par courriel sur d’autres produits proposés par la société ABCD : la 
         base légale du traitement est le consentement (Cf. article 6.1.a) du Règlement européen sur la protection des données),
          comme l’exige l’article L. 34-5 du code des postes et des communications électroniques. Transmission de l’adresse 
          électronique aux partenaires commerciaux : la base légale du traitement est le consentement (Cf. article 6.1.a) du 
          Règlement européen sur la protection des données), comme l’exige l’article L. 34-5 du code des postes et des communications
           électroniques. Catégories de données Identité : civilité, nom, prénom, adresse, adresse de livraison, numéro de téléphone,
            adresse électronique, date de naissance, code interne de traitement permettant l'identification du client, données r
            elatives à l’enregistrement sur des listes d’opposition. Données relatives aux commandes : numéro de la transaction, 
            détail des achats, montant des achats, données relatives au règlement des factures (règlements, impayés, remises), 
            retour de produits. Données relatives aux moyens de paiement : numéro de carte bancaire, date de fin de validité de 
            la carte bancaire, cryptogramme visuel (lequel est immédiatement effacé). Données nécessaires à la réalisation des 
            actions de fidélisation et de prospection : historique des achats. Destinataires des données Les services clients e
            t facturation de la société ABCD sont destinataires de l’ensemble des catégories de données. Ses sous-traitants,
             chargés de la livraison de ses commandes, sont destinataires de l’identité, de l’adresse et du numéro de téléphone
              de nos clients. Les adresses électroniques des clients qui l’ont accepté sont mises à disposition de nos partenaires 
              commerciaux (liste des partenaires commerciaux, régulièrement mise à jour) : société X société Y société Z Durée de
               conservation des données Données nécessaires à la gestion des commandes et à la facturation : pendant toute la
                durée de la relation commerciale et dix (10) ans au titre des obligations comptables. Données nécessaires à 
                la réalisation des actions de fidélisation et à la prospection : pendant toute la durée de la relation 
                commerciale et trois (3) ans à compter du dernier achat. Données relatives aux moyens de paiement : 
                ces données ne sont pas conservées par la société ABCD ; elles sont collectées lors de la transaction 
                et sont immédiatement supprimées dès le règlement de l’achat. Données concernant les listes d'opposition
                 à recevoir de la prospection : trois (3) ans. Vos droits Si vous ne souhaitez plus recevoir de publicité 
                 de la part de la société ABCD (exercice du droit d’opposition ou retrait d’un consentement déjà donné), 
                 contactez-nous (prévoir ici un lien vers un formulaire d’exercice des droits informatique et libertés, faisant
                  apparaître les différents hypothèses détaillées ci-dessus). Si, après avoir consenti à ce que vos données soient
                   transmises à nos partenaires commerciaux, vous souhaitez revenir sur ce choix et ne plus recevoir publicité 
                   de leur part, contactez-nous (prévoir ici un lien vers le formulaire d’exercice des droits informatique et 
                   libertés). (NB : un lien permettant aux clients et prospects de demander la suppression de leur adresse 
                   électronique de la liste de prospection doit systématiquement figurer sur les sollicitations envoyées par
                    courriel) Vous pouvez accéder aux données vous concernant, les rectifier ou les faire effacer. Vous disposez
                     également d'un droit à la portabilité et d’un droit à la limitation du traitement de vos données (Consultez 
                     le site cnil.fr pour plus d’informations sur vos droits). Pour exercer ces droits ou pour toute question sur 
                     le traitement de vos données dans ce dispositif, vous pouvez contacter notre DPO. Contacter notre DPO par
                      voie électronique : dpo@abcd.fr Contacter notre DPO par courrier postal : Le délégué à la protection des 
                      données Société ABCD Rue la Transparence 96 000 CONFIANCE (NB : si vous n’avez pas de DPO, indiquez des 
                      coordonnées précises où exercer ces droits dans l’entreprise). Si vous estimez, après avoir contacté la 
                      société ABCD, que vos droits « Informatique et Libertés » ne sont pas respectés, vous pouvez adresser une 
                      réclamation en ligne à la CNIL.

";
        $str .="
        <form method='POST' action='?action=AccepterRGPD'>
            <input type='hidden' name='case' value='RGPD'> 
            <p>J'accepte : 
      <label for='RGPD'>
      <input type='checkbox' id='oui' name='oui' />
      Oui
      </label>
</p>
            <button type='submit' name='action' value='AccepterRGPD'>Accepter</button>            
            <button type='submit' name='action' value='RefuserRGPD'>Refuser</button>
        </form>
        ";
        return $str;
    }
}
