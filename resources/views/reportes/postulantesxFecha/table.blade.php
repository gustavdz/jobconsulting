
<table id="tbl_reporte" class="table table-bordered">
    <thead>
    <tr>
        <th>Usuario</th>
        <th>Cedula</th>
        <th>País</th>
        <th>Provincia</th>
        <th>Ciudad</th>
        <th>Ingreso</th>
        <th>Espectativa</th>
        <th>Fecha Postulación</th>
    </tr>
    </thead>
    <tbody>
        
    @foreach($results as $rst)
        <tr>
            <td>
                {{$rst->user->name}}
            </td>
            <td>
                {{$rst->user->cedula}}
            </td>

            <td>
                {{$rst->pais}}
            </td>

            <td>
                {{$rst->provincia}}
            </td>

            <td>
                {{$rst->ciudad}}
            </td>

            <td>
                {{$rst->remuneracion_actual}}
            </td>

            <td>
                {{$rst->espectativa_salarial}}
            </td>

            <td>
                {{$rst->created_at}}
            </td>

        </tr>
    @endforeach
    </tbody>
</table>