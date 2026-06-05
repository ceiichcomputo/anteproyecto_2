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


    <p><strong>Apellido Paterno:</strong> {{ $anteproyectos->first()->anteproyecto->usuario->detalle->apellido_paterno ?? 'N/A' }}</p>
    <p><strong>Apellido Materno:</strong> {{ $anteproyectos->first()->anteproyecto->usuario->detalle->apellido_materno ?? 'N/A' }}</p>
    <p><strong>Nombres:</strong> {{ $anteproyectos->first()->anteproyecto->usuario->detalle->nombres ?? 'N/A' }}</p>
    <p><strong>Nombramiento:</strong> {{ $anteproyectos->first()->anteproyecto->usuario->detalle->nombramiento->nombramiento ?? 'N/A' }}</p>


    <hr></br>

        @foreach($anteproyectos as $anteproyecto)

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
                    <tr>
                        <td>{{ $anteproyecto->id }}</td>
                        <td>{{ $anteproyecto->anteproyecto->ejercicio->ejercicio  }}</td>
                        <td>{{ $anteproyecto->subcategoria->categoria->rubro->titulo }}</td>
                        <td>{{ $anteproyecto->subcategoria->categoria->categoria }}</td>
                        <td>{{ $anteproyecto->subcategoria->subcategoria }}</td>
                    </tr>
                </tbody>
            </table>

            @if($anteproyecto->subcategoria->categoria->rubro->id == '1') {{-- // Becarios --}}
                <p><strong>Actividades a desarrollar: </strong>{{ $anteproyecto->rubros_becario->actividades_a_desarrollar ?? 'N/A' }}</p>
                <p><strong>Nombre del Becario: </strong>{{ $anteproyecto->rubros_becario->nombre_becario ?? 'N/A' }}</p>
                <p><strong>Fecha de inicio: </strong>{{ $anteproyecto->rubros_becario->fecha_inicio_becario ?? 'N/A' }}</p>
                <p><strong>Fecha de finalización: </strong>{{ $anteproyecto->rubros_becario->fecha_fin_becario ?? 'N/A' }}</p>
            @endif

            @if($anteproyecto->subcategoria->categoria->rubro->id == '2') {{-- // Cómputo --}}
                <p><strong>Justificación de compra: </strong>{{ $anteproyecto->rubros_computo->justificacion_objeto_comprar ?? 'N/A' }}</p>
            @endif

            @if($anteproyecto->subcategoria->categoria->rubro->id == '3') {{-- // Eventos --}}
                <p><strong>Nombre evento: </strong>{{ $anteproyecto->rubros_eventos->nombre_evento ?? 'N/A' }}</p>
                <p><strong>Descripción: </strong>{{ $anteproyecto->rubros_eventos->descripcion_evento ?? 'N/A' }}</p>
                <p><strong>Fecha de inicio: </strong>{{ $anteproyecto->rubros_eventos->fecha_inicio_evento ?? 'N/A' }}</p>
                <p><strong>Fecha de finalización: </strong>{{ $anteproyecto->rubros_eventos->fecha_fin_evento ?? 'N/A' }}</p>
            @endif

            @if($anteproyecto->subcategoria->categoria->rubro->id == '4') {{-- // Financiamiento externo --}}
                <p><strong>Tipo de financiamiento: </strong>{{ $anteproyecto->rubros_fin_exts->tipo_financiamiento->tipo_financiamiento ?? 'N/A' }}</p>
                <p><strong>Título proyecto: </strong>{{ $anteproyecto->rubros_fin_exts->titulo_proyecto ?? 'N/A' }}</p>
                <p><strong>Nombre Dependencia: </strong>{{ $anteproyecto->rubros_fin_exts->nombre_dependencia ?? 'N/A' }}</p>
                <p><strong>Fecha de inicio: </strong>{{ $anteproyecto->rubros_fin_exts->fecha_inicio_evento ?? 'N/A' }}</p>
                <p><strong>Fecha de finalización: </strong>{{ $anteproyecto->rubros_fin_exts->fecha_fin_evento ?? 'N/A' }}</p>
            @endif

            @if($anteproyecto->subcategoria->categoria->rubro->id == '5') {{-- // Invitados --}}
                <p><strong>Actividades a desarrollar: </strong>{{ $anteproyecto->rubros_invitados->actividades_a_desarrollar ?? 'N/A' }}</p>
                <p><strong>Descripción: </strong>{{ $anteproyecto->rubros_invitados->descripcion_evento ?? 'N/A' }}</p>
                <p><strong>Nombre invitado: </strong>{{ $anteproyecto->rubros_invitados->nombre_invitado ?? 'N/A' }}</p>
                <p><strong>Procedencia invitado: </strong>{{ $anteproyecto->rubros_invitados->procedencia_invitado ?? 'N/A' }}</p>
                <p><strong>Fecha de inicio: </strong>{{ $anteproyecto->rubros_invitados->fecha_inicio_evento ?? 'N/A' }}</p>
                <p><strong>Fecha de finalización: </strong>{{ $anteproyecto->rubros_invitados->fecha_fin_evento ?? 'N/A' }}</p>
            @endif

            @if($anteproyecto->subcategoria->categoria->rubro->id == '6') {{-- // Otras Peticiones --}}
                <p><strong>Petición: </strong>{{ $anteproyecto->rubros_otr_pets->peticion ?? 'N/A' }}</p>
            @endif

            @if($anteproyecto->subcategoria->categoria->rubro->id == '7') {{-- // Promociones --}}
                <p><strong>Tipo de solicitud: </strong>{{ $anteproyecto->rubros_promos->tipo_solicitud->tipo_solicitud ?? 'N/A' }}</p>
                <p><strong>Categoría Académica: </strong>{{ $anteproyecto->rubros_promos->categoria_academica->categoria_academica ?? 'N/A' }}</p>
                <p><strong>Descripción: </strong>{{ $anteproyecto->rubros_promos->descripcion_promocion ?? 'N/A' }}</p>
                <p><strong>Fecha de inicio: </strong>{{ $anteproyecto->rubros_promos->fecha_inicio_promocion ?? 'N/A' }}</p>
                <p><strong>Fecha de finalización: </strong>{{ $anteproyecto->rubros_promos->fecha_fin_promocion ?? 'N/A' }}</p>
            @endif

            @if($anteproyecto->subcategoria->categoria->rubro->id == '8') {{-- // Viajes --}}
                <p><strong>País: </strong>{{ $anteproyecto->rubros_viajes->estado->pais->pais ?? 'N/A' }}</p>
                <p><strong>Estado: </strong>{{ $anteproyecto->rubros_viajes->estado->estado ?? 'N/A' }}</p>
                <p><strong>Lugar institución: </strong>{{ $anteproyecto->rubros_viajes->lugar_institucion ?? 'N/A' }}</p>
                <p><strong>Fecha de inicio: </strong>{{ $anteproyecto->rubros_viajes->fecha_inicio_viaje ?? 'N/A' }}</p>
                <p><strong>Fecha de finalización: </strong>{{ $anteproyecto->rubros_viajes->fecha_fin_viaje ?? 'N/A' }}</p>
            @endif


            <hr>
            </br>


        @endforeach
















</body>
</html>