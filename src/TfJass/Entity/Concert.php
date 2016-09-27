<?php

namespace TfJass\Entity;

class Concert
{
    
    protected $id;
    protected $datec;
    protected $lieu;
    protected $prix;
    protected $heure;
    protected $gmaps;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getDatec()
    {
        return $this->datec;
    }

    public function setDatec($year)
    {
        if ($year instanceof \DateTime)
            $this->datec = $year;
        else
            $this->datec = new \Datetime($year);
    }

    public function getLieu()
    {
        return $this->lieu;
    }

    public function setLieu($lieu)
    {
        $this->lieu = $lieu;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;
    }

    public function getHeure()
    {
        return $this->heure;
    }

    public function setHeure($heure)
    {
        if ($heure instanceof \DateTime)
            $this->heure = $heure;
        else
            $this->heure = new \Datetime($heure);
    }

    public function getGmaps()
    {
        return $this->gmaps;
    }

    public function setGmaps($gmaps)
    {
        $this->gmaps = $gmaps;
    }
}