<?php

namespace App\Http\Controllers;
use App\Repository\FilmRepository;
use Illuminate\Http\Request;

class FilmController extends Controller
{

    /**
     * Read films from storage
     */
    public static function readFilms(): array 
    {
        $repo = new FilmRepository();
        return $repo->getAll();
    }
    /**
     * List films older than input year 
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listOldFilms($year = null)
    {        
        $old_films = [];
        if ($year !== null) $year = 2000;
    
        $title = "Listado de Pelis Antiguas (Antes de $year)";    
        $films = self::readFilms();

        foreach ($films as $film) {
        //foreach ($this->datasource as $film) {
            if ($film->getYear() < $year)
                $old_films[] =  $film;
        }
        return view('films.list', ["films" => $old_films, "title" => $title]);
    }
    /**
     * List films younger than input year
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listNewFilms($year = null)
    {
        $new_films = [];
        if ($year !== null) $year = 2000;

        $title = "Listado de Pelis Nuevas (Después de $year)";
        $films = self::readFilms();

        foreach ($films as $film) {
            if ($film->getYear() >= $year)
                $new_films[] = $film;
        }
        return view('films.list', ["films" => $new_films, "title" => $title]);
    }
    /**
     * Lista TODAS las películas o filtra x año o categoría.
     */
    public function listFilmsByYear(Request $request) 
    {
        $year = $request->query('year');
        $films_filtered = [];
        
        $title = "Listado de películas por año";
        $films = self::readFilms();

        if (!$year) return view('films.list', ["films" => $films, "title" => $title]);

        foreach ($films as $film) {
            if ($film->getYear() == $year) {
                $title = "Listado de películas del año {$year}";
                $films_filtered[] = $film;
            }
        }

        return view('films.list', ["films" => $films_filtered, "title" => $title]);
    }

    public function listFilmsByGenre(Request $request) 
    {
        $genre = $request->query('genre');
        $genre = ucfirst($genre);
        $films_filtered = [];

        $title = "Listado de películas por género";
        $films = self::readFilms();

        if (!$genre) return view('films.list', ["films" => $films, "title" => $title]);

        foreach ($films as $film) {
            if ($film->getGenre() == $genre) {
                $title = "Listado de películas del género {$genre}";
                $films_filtered[] = $film;
            }
        }

        return view('films.list', ["films" => $films_filtered, "title" => $title]);
    }

    public function listFilms()
    {
        $title = "Listado de todas las pelis";
        $films = self::readFilms();

        return view("films.list", ["films" => $films, "title" => $title]);
    }

    public function sortFilms() 
    {
        $title = "Listado de todas las pelis, ordenadas por año";
        $films = self::readFilms();

        $year = array_map(fn($film) => $film->getYear(), $films);

        array_multisort($year, SORT_DESC, $films);
        return view("films.list", ["films" => $films, "title" => $title]);
    }
}
