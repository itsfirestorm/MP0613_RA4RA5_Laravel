<?php

namespace App\Models;

class Film
{
    private $name, $year, $genre, $duration, $country;

    public function __construct($name, $year, $genre, $duration, $country)
    {
        $this->name = $name;
        $this->year = $year;
        $this->genre = $genre;
        $this->duration = $duration;
        $this->country = $country;
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
}