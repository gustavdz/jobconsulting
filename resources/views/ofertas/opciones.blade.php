<div class="btn-group">
<a data-toggle="tooltip" data-placement="top" title="Ver lista de aspirantes" type="button" target="_blank" href="{{ route('ofertas.aspirantes',$id) }}" class="btn btn-primary btn_delete"><i class="fas fa-users"></i></a>
<button data-toggle="tooltip" data-placement="top" title="Editar oferta" onclick="editar({{ $id }})" title="Editar" type="button" class="btn btn-success btn_show"><i class="fas fa-edit"></i></button>
<button data-toggle="tooltip" data-placement="top" title="Finalizar la oferta" onclick="eliminar({{$id}},'{{ $titulo }}','Finalizar')" type="button" class="btn btn-warning btn_delete"><i class="fa fa-reply"></i></button>
<button data-toggle="tooltip" data-placement="top" title="Eliminar la oferta" onclick="eliminar({{$id}},'{{ $titulo }}','Eliminar')" type="button" class="btn btn-danger btn_delete"><i class="fas fa-trash"></i></button>
 	
</div>