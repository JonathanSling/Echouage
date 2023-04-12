<?php 

class Echouage
{
    private $id;
    private $date;
    private $espece;
    private $zone;
    private $nombre;

    public function getId()
    {
        return $this->id;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function getEspece()
    {
        return $this->espece;
    }

    public function getZone()
    {
        return $this->zone;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setEchouage($id,$date,$espece,$zone,$nombre)
    {
        $this->id=$id;
        $this->date=$date;
        $this->espece=$espece;
        $this->zone=$zone;
        $this->nombre=$nombre;
    }
}