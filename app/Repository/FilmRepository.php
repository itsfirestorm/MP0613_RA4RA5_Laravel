<?php
namespace App\Middleware;

use App\Models\Film;
use Illuminate\Support\Facades\Cache;

use function PHPUnit\Framework\isArray;

class FilmRepository
{
    private string $json_file = '/storage/app/public/films.json';

    public function getAll()
    {
        return Cache::rememberForever('films', function () {
            if (!file_exists(base_path($this->json_file))) {
                return [];
            }

            $jsonData = file_get_contents(base_path($this->json_file));
            $data = json_decode($jsonData, true);

            if (!isArray($data)) {
                return [];
            }

            return array_map(
                fn($film) =>
                new Film(
                    $film['name'],
                    $film['year'],
                    $film['genre'],
                    $film['duration'],
                    $film['country']
                ),
                $data
            );
        });
    }
}