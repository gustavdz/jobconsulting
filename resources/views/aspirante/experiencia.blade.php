@forelse($experiencias as $experiencia)
<div class="main-card mb-3 card border-info">
    <div class="card-header">
        {{ $experiencia->empresa }}
        <div class="btn-actions-pane-right">
            <div  role="group" class="btn-group-sm btn-group">
                <button class="mb-2 mr-2 btn-icon btn-shadow btn-dashed btn btn-outline-success" onclick="editar_experiencia({{ $experiencia->id }},'{{ $experiencia->empresa }}','{{ $experiencia->inicio }}','{{ $experiencia->fin }}','{{ $experiencia->sector }}','{{ $experiencia->cargo }}','{{ $experiencia->funciones }}','{{ $experiencia->personal_cargo }}','{{ $experiencia->area_cargo }}','{{ $experiencia->nivel_cargo }}')"><i class="pe-7s-pen btn-icon-wrapper" > </i> Editar</button>
                <button class="mb-2 mr-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger" onclick="eliminar_experiencia({{ $experiencia->id }},'{{ $experiencia->empresa }}')"><i class="pe-7s-trash btn-icon-wrapper"> </i> Eliminar</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <p>{{ $experiencia->cargo }}.</p>
        <div class="row">
            <div class="col">
                <p>Fecha de Inicio: {{\Carbon\Carbon::parse($experiencia->inicio)->format('j F, Y')}}</p>
            </div>
            <div class="col">
                <p>Fecha de Terminación: {{ !empty($experiencia->fin) ? \Carbon\Carbon::parse($experiencia->fin)->format('j F, Y') : 'Actualmente.'}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>Sector de la empresa: {{ $experiencia->sector }}</p>
            </div>
            <div class="col">
                <p>Personal a Cargo: {{ $experiencia->personal_cargo }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>Area del cargo: {{ $experiencia->area_cargo }}</p>
            </div>
            <div class="col">
                <p>Nivel del Cargo: {{ $experiencia->nivel_cargo }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>Funciones: {{ $experiencia->funciones }}</p>
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
