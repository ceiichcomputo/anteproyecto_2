<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <style>
        table{
            width:100%;
            border-collapse: collapse;
        }

        th,td{
            border:1px solid #000;
            padding:5px;
        }

        th{
            background:#eee;
        }
    </style>

</head>
<body>

<h2>Reporte de Anteproyectos</h2>

<span style="color: red;">Vista previa del anteproyecto</span>


        @foreach($anteproyectos as $anteproyecto)
        
            <p><strong>ID:</strong> {{ $anteproyecto->id }}</p>

            <p><strong>Ejercicio:</strong> {{ $anteproyecto->anteproyectos->ejercicio->ejercicio  }}</p>

            <p><strong>Rubro:</strong>
                {{ $anteproyecto->subcategoria->categoria->rubro->titulo }}
            </p>

            <p><strong>Categoría:</strong>
                {{ $anteproyecto->subcategoria->categoria->categoria }}
            </p>

            <p><strong>Subcategoría:</strong>
                {{ $anteproyecto->subcategoria->nombre }}
            </p>

            <hr>


        @endforeach


<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Ejercicio</th>
            <th>Rubro</th>
            <th>Categoría</th>
            <th>Subcategoría</th>
        </tr>
    </thead>

    <tbody>

        @foreach($anteproyectos as $anteproyecto)

            <tr>

                <td>{{ $anteproyecto->id }}</td>

                <td>{{ $anteproyecto->anteproyectos->ejercicio->ejercicio  }}</td>

                <td>
                    {{ $anteproyecto->subcategoria->categoria->rubro->titulo }}
                </td>

                <td>
                    {{ $anteproyecto->subcategoria->categoria->categoria }}
                </td>

                <td>
                    {{ $anteproyecto->subcategoria->nombre }}
                </td>

            </tr>

        @endforeach

    </tbody>

</table>

</body>
</html>