@forelse($formaciones as $formacion)
<div class="main-card mb-3 card border-info">
    <div class="card-header">
        {{ $formacion->institucion_educativa }} 
        <div class="btn-actions-pane-right">
            <div  role="group" class="btn-group-sm btn-group">
                <button class="mb-2 mr-2 btn-icon btn-shadow btn-dashed btn btn-outline-success" onclick="editar_formacion({{ $formacion->id }},'{{ $formacion->institucion_educativa }}','{{ $formacion->titulo }}','{{ $formacion->inicio }}','{{ $formacion->fin }}')"><i class="pe-7s-pen btn-icon-wrapper" > </i> Editar</button>
                <button class="mb-2 mr-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger" onclick="eliminar_formacion({{ $formacion->id }},'{{ $formacion->institucion_educativa }} ')"><i class="pe-7s-trash btn-icon-wrapper"> </i> Eliminar</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <p>{{ $formacion->titulo }}.</p>
        <div class="row">
            <div class="col">
                <p>Fecha de Inicio: {{\Carbon\Carbon::parse($formacion->inicio)->format('j F, Y')}}</p>
            </div>
            <div class="col">
                <p>Fecha de Fin: {{ !empty($formacion->fin) ? \Carbon\Carbon::parse($formacion->fin)->format('j F, Y') : 'Cursando.'}}</p>
            </div>
        </div>
    </div>
</div>
 @empty
    <div class="col-md-12 mb-3" >
        <div class="card border-info">
            <div class="card-body">
               <p>No se encontro información para mostrar</p>
            </div>
        </div>
    </div>
@endforelse