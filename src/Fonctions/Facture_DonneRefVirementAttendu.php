<?php
namespace App\Fonctions;

    function Facture_DonneRefVirementAttendu($infoCommande, $infoentreprise): string
    {
        return "Brulerie_".$infoentreprise["numCompte"]."_".$infoCommande["id"];
    }

