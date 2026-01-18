<?php

namespace App\Http\Controllers;
use App\Repository\FilmRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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
        $year = session('filmout.year', 2000);

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

        $year = session('filmout.year', 2000);

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
    public function listFilmsByYear() 
    {
        $year = session('filmout.year', 2000);
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

    public function listFilmsByGenre() 
    {
        $genre = session('filmout.genre', "Drama");
        if ($genre == "ciencia ficción") {
            $genre = "Ciencia Ficción";
        } else {
            $genre = ucfirst($genre);
        }
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
        $title = "Listado de todas las pelis, ordenadas por año (asc.)";
        $films = self::readFilms();

        return view("films.list", ["films" => $films, "title" => $title]);
    }

    public function sortFilms() 
    {
        $title = "Listado de todas las pelis, ordenadas por año (desc.)";
        $films = self::readFilms();

        $year = array_map(fn($film) => $film->getYear(), $films);

        array_multisort($year, SORT_DESC, $films);
        return view("films.list", ["films" => $films, "title" => $title]);
    }

    public function setFilters(Request $request) 
    {
        $request->validate([
            'year' => 'nullable|integer',
            'genre' => 'nullable|string',
            'action' => 'required|string',
        ]);

        session([
            'filmout.year' => $request->year,
            'filmout.genre' => $request->genre,
        ]);

        return match ($request->action) {
            'old' => redirect()->route('oldFilms'),
            'new' => redirect()->route('newFilms'),
            'byYear' => redirect()->route('filmsByYear'),
            'byGenre' => redirect()->route('filmsByGenre'),
            'sorted' => redirect()->route('sortFilms'),
            'all' => redirect()->route('listFilms'),
        };
    }

    public function createNewFilm(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'year' => 'required|integer',
            'country' => 'required|string',
            'duration' => 'required|integer',
            'genre' => 'required|string',
            'image-url' => 'required|string',
        ]);

        $filePath = "public/films.json";

        Log::info('Full storage path: ' . Storage::path($filePath));

        $films = [];
        if (Storage::exists($filePath)) {
            $json = Storage::get($filePath);
            $films = json_decode($json, true) ?? [];
            Log::info('Existing films count: ' . count($films));
        } else {
            Log::info('File does not exist yet');
        }

        $films[] = [
            'name' => $validated['title'],
            'year' => $validated['year'],
            'genre' => $validated['genre'],
            'duration' => $validated['duration'],
            'country' => $validated['country'],
            'img_url' => $validated['image-url']
        ];

        $result = Storage::put($filePath, json_encode($films, JSON_PRETTY_PRINT));
        Log::info('Write result: ' . ($result ? 'success' : 'failed'));
        Log::info('New films count: ' . count($films));

        Cache::forget('films');

        return redirect()->back()->with('success', 'Film added successfully.');
    }

    public function setAdminFilters(Request $request) {
        return match ($request->action) {
            'create' => redirect()->route('createFilm'),
            'delete' => redirect()->route('deleteFilm'),
        };
    }
}
