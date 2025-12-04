<?php

namespace App\Models;

class Film
{
    private $name, $year, $genre, $duration, $country, $img_url;

    public function __construct($name, $year, $genre, $duration, $country, $img_url)
    {
        $this->name = $name;
        $this->year = $year;
        $this->genre = $genre;
        $this->duration = $duration;
        $this->country = $country;
        $this->img_url = $img_url;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function getImgUrl() 
    {
        return $this->img_url;
    }
}