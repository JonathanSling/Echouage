<?php 

class Statistiques
{
    private $total;
    private $valeur;

    public function getTotal()
    {
        return $this->total;
    }

    public function getValeur()
    {
        return $this->valeur;
    }

    public function setStatistiques($total,$valeur)
    {
        $this->total=$total;
        $this->valeur=$valeur;
    }
}