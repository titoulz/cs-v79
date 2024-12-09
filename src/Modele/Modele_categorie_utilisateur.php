<?php

namespace App\Modele;
use App\Utilitaire\Singleton_ConnexionPDO;
use PDO;
class Modele_categorie_utilisateur
{
    static function categorie_utilisateur_Select()
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
        select * 
        from `categorie_utilisateur` 
        ');
        $reponse = $requetePreparee->execute(); //$reponse boolean sur l'état de la requête

        $tableauReponse = $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
        return $tableauReponse;
    }
}