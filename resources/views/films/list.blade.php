<h1>{{$title}}</h1>

@if(empty($films))
    <FONT COLOR="red">No se ha encontrado ninguna película</FONT>
@else
    <div align="center">
        <table border="1">
            <tr>
                <th>Nombre</th>
                <th>Año</th>
                <th>País</th>
                <th>Género</th>
                <th>Duración</th>
                <th>Imagen</th>
            </tr>

            @foreach($films as $film)
                <tr>
                    <td>{{$film->getName() }}</td>
                    <td>{{$film->getYear() }}</td>
                    <td>{{$film->getCountry() }}</td>
                    <td>{{$film->getGenre() }}</td>
                    <td>{{$film->getDuration() }}</td>
                    <td><img src={{$film->getImgUrl() }} style="width: 100px; height: 120px;" /></td>
                </tr>
            @endforeach
        </table>
    </div>
@endif