<table id="tbl_ofertas" class="table table-bordered">
    <thead>
    <tr>
        <th>Detalle de la Oferta</th>
        <th>Categorías</th>
        <th>Habilidades</th>
        <th>Opciónes</th>
    </tr>
    </thead>
    <tbody>
    @foreach($results as $rst)
        <tr>
            <td>
                <b>Consultor: </b>{{$rst->user->name}}<br>
                <b>Titulo: </b>{{$rst->titulo}}<br>
                <b>Detalle: </b>{!! $rst->descripcion !!}<br>
                <b>Salario: </b>${{$rst->salario ? number_format($rst->salario, 2, '.', ',') : '0.00'}}<br>
                <b>Validez: </b>{{\Carbon\Carbon::parse($rst->validez)->format('j F, Y')}}<br>
                @if($rst->validez >= date('Y-m-d'))
                    <span class="badge badge-primary">ACTIVA</span>
                @else
                    <span class="badge badge-danger">EXPIRADA</span>
                @endif

            </td>
            <td>
                <ul>
                    @foreach($rst->categoriasOfertas as $cat)
                        <li>{{$cat->categoria->nombre}}</li>
                    @endforeach
                </ul>
            </td>
            <td>
                <ul>
                    @foreach($rst->habilidadesOfertas as $habilidad)
                        <li>{{$habilidad->habilidad->nombre}}</li>
                    @endforeach
                </ul>
            </td>
            <td>
                <button onclick="editar({{ $rst->id }})" title="Editar" type="button" class="btn btn-success btn_show"><i class="fas fa-edit"></i> Editar</button>
                <button onclick="eliminar({{$rst->id}},'{{ $rst->titulo }}')" data-id="{{$rst->id}}" data-name="{{$rst->nombre}}" type="button" class="btn btn-danger btn_delete"><i class="fas fa-trash"></i> Eliminar</button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
