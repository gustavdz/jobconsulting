
<table id="tbl_reporte" class="table table-bordered">
    <thead>
    <tr>
        <th>Usuario</th>
        <th>Cedula</th>
        <th>Email</th>
        <th>Teléfono</th>
        <th>Celular</th>
        <th>País</th>
        <th>Provincia</th>
        <th>Ciudad</th>
        <th>Ingreso</th>
        <th>Espectativa</th>
        <th>Fecha de Registro</th>
    </tr>
    </thead>
    <tbody>

    @foreach($results as $rst)
        <tr>
            <td>
                {{$rst->user->name}}
            </td>
            <td>
                {{$rst->cedula}}
            </td>
            <td>{{$rst->user->email}}</td>
            <td>{{$rst->telefono}}</td>
            <td>{{$rst->celular}}</td>
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
