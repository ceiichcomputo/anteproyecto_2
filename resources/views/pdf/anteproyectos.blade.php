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