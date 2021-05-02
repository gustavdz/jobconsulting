<div class="table-responsive">
    <table id="tbl_reporte" class="table table-bordered ">
        <thead>
        <tr>
            <th>Consultor</th>
            <th>Oferta</th>
            <th>Salario de Oferta</th>
            <th>Provincia de Oferta</th>
            <th>Ciudad de Oferta</th>
            <th>Validez de Oferta</th>
            <th>Estado de Oferta</th>
            <th>Aspirante</th>
            <th>Remuneración Actual de Aspirante</th>
            <th>Correo de Aspirante</th>
            <th>Celular de Aspirante</th>
            <th>Teléfono de Aspirante</th>
            <th>Fecha Aplicación</th>
        </tr>
        </thead>
        <tbody>

        @foreach($results as $rst)
            <tr>

                <td>
                    {{$rst->empresa}}
                </td>
                <td>
                    {{$rst->oferta}}
                </td>
                <td>
                    {{$rst->salario}}
                </td>
                <td>
                    {{$rst->provincia}}
                </td>
                <td>
                    {{$rst->ciudad}}
                </td>
                <td>
                    {{$rst->validez}}
                </td>
                <td>
                    {{$rst->estadodeoferta}}
                </td>
                <td>
                    {{$rst->aspirante}}
                </td>
                <td>
                    {{$rst->remuneracion_actual}}
                </td>
                <td>
                    {{$rst->correoaspirante}}
                </td>
                <td>
                    {{$rst->celular}}
                </td>
                <td>
                    {{$rst->telefono}}
                </td>
                <td>
                    {{$rst->created_at}}
                </td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>

