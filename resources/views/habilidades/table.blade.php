<table id="tbl_categgorias" class="table table-bordered">
    <thead>
    <tr>
        <th>Categorías</th>
        <th>Opción</th>
    </tr>
    </thead>
    <tbody>
    @foreach($results as $rst)
        <tr>
            <td>
                {{ $rst->nombre }}
            </td>
            <td>
                <div class="btn-group">
                    <button data-toggle="modal" data-target=".modal-categoria" title="Editar " onclick="editar({{ $rst->id }},'{{ $rst->nombre }}')" title="Editar" type="button" class="btn btn-success btn_show"><i class="fas fa-edit"></i> Editar</button>
                    <button  title="Eliminar " onclick="eliminar({{ $rst->id }},'{{ $rst->nombre }}')" type="button" class="btn btn-danger btn_delete"><i class="fas fa-trash"></i> Eliminar</button>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>