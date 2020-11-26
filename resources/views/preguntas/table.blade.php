<table id="table_pregunta" class="table table-bordered">
    <thead>
        <tr>
            <th>titulo</th>
            <th>Tipo de Pregunta</th>
            <th>Respuestas</th>
            <th>Opciónes</th>
        </tr>
    </thead>
    <tbody>
    	@foreach($results as $result)
    	<tr>
    		<td>{{ $result->texto }}</td>
    		<td>{{ $result->campo }}</td>
    		<td>{{ $result->respuestas }}</td>
    		<td>
    			<div class="btn-group">
					<button data-toggle="tooltip" data-placement="top" title="Editar" onclick="editar({{ $result->id }},'{{ $result->texto }}','{{ $result->campo }}','{{ $result->respuestas }}')" title="Editar" type="button" class="btn btn-success btn_show"><i class="fas fa-edit"></i></button>
					<button data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="eliminar({{ $result->id }},'{{ $result->texto }}')" type="button" class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></button> 	
				</div>
    		</td>
    	</tr>
    	@endforeach
    </tbody>
</table>
