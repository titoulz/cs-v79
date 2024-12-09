<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Menu_Entreprise_Salarie  extends Vue_Composant
{
    private int $quantiteMenu=0;

    public function __construct(int $quantiteMenu)
    {
        $this->quantiteMenu=$quantiteMenu;
    }

    function donneTexte(): string
    {

        $str="
<nav id='menu'>
  <ul id='menu-closed'>  
    <li><a href='?case=Gerer_catalogue'>Catalogue</a></li> 
    <li><a href='?case=Gerer_MonCompte_Salarie'>Mon compte</a></li> 
    <li><a href='?case=Gerer_Panier'>Panier";
        if ($this->quantiteMenu > 0) {
            $str .= " ($this->quantiteMenu) ";
        }
        $str .= "</a></li>
    <li><a href='?case=Gerer_CommandeClient'>Mes commandes</a></li> 
  </ul>
</nav> ";

        return $str;
    }

}