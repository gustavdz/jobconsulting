@forelse($referencias as $referencia)
<div class="main-card mb-3 card border-info">
    <div class="card-header">
        {{ $referencia->nombre }}
        <div class="btn-actions-pane-right">
            <div  role="group" class="btn-group-sm btn-group">
                <button class="mb-2 mr-2 btn-icon btn-shadow btn-dashed btn btn-outline-success" onclick="editar_referencia({{ $referencia->id }},'{{ $referencia->nombre }}','{{ $referencia->email }}','{{ $referencia->telefono }}','{{ $referencia->empresa }}','{{ $referencia->cargo }}','{{ $referencia->nivel_cargo }}')"><i class="pe-7s-pen btn-icon-wrapper" > </i> Editar</button>
                <button class="mb-2 mr-2 btn-icon btn-shadow btn-dashed btn btn-outline-danger" onclick="eliminar_referencia({{ $referencia->id }},'{{ $referencia->nombre }}')"><i class="pe-7s-trash btn-icon-wrapper"> </i> Eliminar</button>
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col">
                <p>Nombre: {{ $referencia->nombre }}.</p>
            </div>
            <div class="col">
                <p>Correo electrónico: {{ $referencia->email }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>Teléfono: {{ $referencia->telefono }}</p>
            </div>
            <div class="col">
                <p>Empresa: {{ $referencia->empresa }}</p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p>Cargo: {{ $referencia->cargo }}</p>
            </div>
            <div class="col">
                <p>Nivel del cargo: {{ $referencia->nivel_cargo }}</p>
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
