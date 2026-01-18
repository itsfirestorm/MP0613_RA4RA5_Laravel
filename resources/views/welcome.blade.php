<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies List</title>

    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <!-- Include any additional stylesheets or scripts here -->
</head>

<body class="container">

    <h1 class="mt-4">Lista de Peliculas</h1>
    <!-- Method oldFilms -->
    <form method="get" action="{{ route('filmout.filters') }}">
        <label for="name">Introduce el año: </label>
        <input type="number" name="year" required placeholder="2000" class="ml-2">
        <div></div>
        <label for="genre" class="ml-8">Introduce el género: </label>
        <select name="genre" required class="ml-2">
            <option value="drama">Drama</option>
            <option value="comedia">Comedia</option>
            <option value="ciencia-ficcion">Ciencia Ficción</option>
        </select>

        <div></div>
        <button name="action" class="btn btn-link ml-6 align-baseline" value="old">
            Pelis antiguas
        </button>
        <div></div>
        <button name="action" class="btn btn-link ml-6 align-baseline" value="new">
            Pelis nuevas
        </button>
        <div></div>
        <button name="action" class="btn btn-link ml-6 align-baseline" value="byYear">
            Listar películas por año
        </button>
        <div></div>
        <button name="action" class="btn btn-link ml-6 align-baseline" value="byGenre">
            Listar películas por género
        </button>
        <div></div>
        <button name="action" class="btn btn-link ml-6 align-baseline" value="sorted">
            Todas las películas (órden desc.)
        </button>
        <div></div>
        <button name="action" class="btn btn-link ml-6 align-baseline" value="all">
            Todas las películas (órden asc.)
        </button>
    </form>

    <div style="height: 200px;"></div>

    <h1>Crear/Eliminar película</h1>
    <form method="post" action="{{ route('createFilm') }}" class="mt-4">
        <label for="title">Título: </label>
        <input type="text" name="title" required class="ml-2">
        <div></div>
        <label for="year">Año: </label>
        <input type="number" name="year" required class="ml-2">
        <div></div>
        <label for="country">País: </label>
        <select name="country" required class="ml-2">
            @foreach(config('countries') as $code => $name)
            <option value="{{ $code }}">{{ $name }}</option>
            @endforeach
        </select>
        <div></div>
        <label for="genre">Género: </label>
        <select name="genre" required class="ml-2">
            <option value="drama">Drama</option>
            <option value="ciencia-ficción">Ciencia Ficción</option>
            <option value="Comedia">Comedia</option>
            <option value="Suspense">Suspense</option>
        </select>
        <div></div>
        <label for="duration">Duración: </label>
        <input type="number" name="duration" required class="ml-2">
        <div></div>
        <label for="image-url">URL Imágen: </label>
        <input type="text" name="image-url" required class="ml-2">
        @csrf

        <div style="height: 10px;"></div>
        <button name="action" class="btn btn-link ml-6 align-baseline">Crear peli</button>
        
    </form>

    <!-- Add Bootstrap JS and Popper.js (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <!-- Include any additional HTML or Blade directives here -->

</body>

</html>
