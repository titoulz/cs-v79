<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Produit_Creation extends Vue_Composant
{
    private bool $reponse;
    private bool $categorie=true;
    private bool $produit=true;
    public function __construct(bool $reponse, bool $categorie=true,bool $produit=true)
    {
        $this->reponse=$reponse;
        $this->categorie=$categorie ;
        $this->produit=$produit;
    }

    function donneTexte(): string
    {
        $str="";
        if ($this->reponse) {
            $str .= "
        <table> 
            <h3>";
            if ($this->categorie) {
                $str .= "La catégorie a été créée </h3>";
            }
            if ($this->produit) {
                $str .= "Le produit a été créé</h3>";
            }
            $str .= "<a href='?case=Gerer_catalogue'>Retourner sur le catalogue</a>
        </table>
        ";
        } else {
            $str .= "
        <table> ";
            if ($this->categorie) {
                $str .= "<h3>Nous avons rencontré un problème, la catégorie n'a pas pu être créée</h3>";
            }
            if ($this->produit) {
                $str .= "<h3>Nous avons rencontré un problème, le produit n'a pas pu être créé</h3>";
            }
            $str .= "</table>";
        }
        return $str;
    }

}