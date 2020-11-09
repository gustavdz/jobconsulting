<div class="container">
	<div class="row">
		<div class="col-md-3">
			<img src="/storage/perfil/{{ $aspirante->user->id  }}.jpg?{{ time() }}" alt="" class="img-thumbnail" onerror="imgError(this);" class="img-thumbnail">
		</div>
		<div class="col-md-9">
			<h3 class="border-title">Datos Personales</h3>
			<div class="row">
				<div class="col-md-6">
					<p class="line"><b>Nombres y Apellidos:</b> {{ $aspirante->user->name }}</p>
					<p class="line"><b>Correo:</b> {{ $aspirante->user->email }}</p>
					<p class="line"><b>Teléfono:</b> {{ $aspirante->telefono }}</p>
					<p class="line"><b>País:</b> {{ $aspirante->pais }}</p>
					<p class="line"><b>Ciudad:</b> {{ $aspirante->ciudad }}</p>
					<p class="line"><b>Remuneración Actual:</b> ${{$aspirante->remuneracion_actual ? $aspirante->remuneracion_actual : '0.00'}}</p>
				</div>
				<div class="col-md-6">
					<p class="line"><b>Cédula: </b> {{ $aspirante->cedula }}</p>
					<p class="line"><b>Fecha de Nacimiento: </b> {{\Carbon\Carbon::parse($aspirante->fecha_nacimiento)->format('j F, Y')}}</p>
					<p class="line"><b>Celular:</b> {{ $aspirante->celular }}</p>
					<p class="line"><b>Provincia:</b> {{ $aspirante->provincia }}</p>
					<p class="line"><b>Expectativa Salarial:</b> ${{$aspirante->espectativa_salarial ? $aspirante->espectativa_salarial : '0.00'}}</p>
				</div>
			</div>
		</div>
	</div>

	<div class="row">

		<ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
            <li class="nav-item">
                <a role="tab" class="nav-link active" id="tab-1" data-toggle="tab" href="#tab-content-1" aria-selected="false" >
                    <span>Formación Academica</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-2" aria-selected="false" >
                    <span>Experiencias Profesionales</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-3" data-toggle="tab" href="#tab-content-3" aria-selected="false">
                    <span>Idiomas</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-4" data-toggle="tab" href="#tab-content-4" aria-selected="false">
                    <span>Referencias</span>
                </a>
            </li>
        </ul>

	    <div class="tab-content" style="width: 100%">

	    	{{-- FORMACION ACADEMICA --}}
        	<div class="tab-pane tabs-animation fade active show" id="tab-content-1" role="tabpanel">
        		<div class="main-card mb-3 card">
        		<div class="card-body">
	        		@forelse($aspirante->aspirante_formacion as $academica)
	        			<div class="main-card m-2 card border-info">
		                    <div class="card-body">
		                        <div class="row">
		                        	<div class="col-md-6">
		                        		<p class="line"><b>Institución Educativa:</b> {{ $academica->institucion_educativa }}</p>
		                        		<p class="line"><b>Inicio:</b> {{\Carbon\Carbon::parse($academica->inicio)->format('j F, Y')}}</p>
		                        	</div>
		                        	<div class="col-md-6">
		                        		<p class="line"><b>Titulo:</b> {{ $academica->titulo }}</p>
		                        		<p class="line"><b>Fin:</b> {{ !empty($academica->fin) ? \Carbon\Carbon::parse($academica->fin)->format('j F, Y') : 'Cursando.'}}</p>
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
        		</div>
        		</div>
        		
        	</div>
        	{{-- FIN FORMACION ACADEMICA --}}


        	{{-- EXPERIENCIAS PROFESIONALES --}}
        	<div class="tab-pane tabs-animation fade " id="tab-content-2" role="tabpanel">
        		<div class="main-card mb-3 card">
        		<div class="card-body">
	        		@forelse($aspirante->aspirante_experiencia as $Experiencia)
	        			<div class="main-card m-2 card border-info">
		                    <div class="card-body">
		                        <div class="row">
		                        	<div class="col-md-6">
		                        		<p class="line"><b>Empresa:</b> {{ $Experiencia->empresa }}</p>
		                        		<p class="line"><b>Sector:</b> {{ $Experiencia->sector }}</p>
		                        		<p class="line"><b>Personal a cargo:</b> {{ $Experiencia->personal_cargo }}</p>
		                        		<p class="line"><b>Fin:</b> {{ !empty($Experiencia->fin) ? \Carbon\Carbon::parse($Experiencia->fin)->format('j F, Y') : 'Actualmente.'}}</p>
		                        	</div>
		                        	<div class="col-md-6">
		                        		<p class="line"><b>Cargo:</b> {{ $Experiencia->cargo }}</p>
		                        		<p class="line"><b>Funciones:</b> {{ $Experiencia->funciones }}</p>
		                        		<p class="line"><b>Inicio:</b> {{\Carbon\Carbon::parse($Experiencia->inicio)->format('j F, Y')}}</p>
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
        		</div>
        		</div>
        		
        	</div>
        	{{-- FIN EXPERIENCIAS PROFESIONALES --}}


        	{{-- IDIOMAS --}}
        	<div class="tab-pane tabs-animation fade " id="tab-content-3" role="tabpanel">
        		<div class="main-card mb-3 card">
        		<div class="card-body">
	        		@forelse($aspirante->aspirante_idioma as $idioma)
	        			<div class="main-card m-2 card border-info">
		                    <div class="card-body">
		                        <div class="row">
		                        	<div class="col-md-6">
		                        		<p class="line"><b>Idioma:</b> {{ $idioma->idioma }}</p>
		                        	</div>
		                        	<div class="col-md-6">
		                        		<p class="line"><b>Nivel:</b> {{ $idioma->nivel }}</p>
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
        		</div>
        		</div>
        		
        	</div>
        	{{-- FIN IDIOMAS --}}


        	{{-- REFERENCIAS --}}
        	<div class="tab-pane tabs-animation fade " id="tab-content-4" role="tabpanel">
        		<div class="main-card mb-3 card">
        		<div class="card-body">
	        		@forelse($aspirante->aspirante_referencia as $referencia)
	        			<div class="main-card m-2 card border-info">
		                    <div class="card-body">
		                        <div class="row">
		                        	<div class="col-md-6">
		                        		<p class="line"><b>Nombre:</b> {{ $referencia->nombre }}</p>
		                        		<p class="line"><b>Teléfono:</b> {{ $referencia->telefono }}</p>
		                        	</div>
		                        	<div class="col-md-6">
		                        		<p class="line"><b>Correo:</b> {{ $referencia->email }}</p>
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
        		</div>
        		</div>
        		
        	</div>
        	{{-- FIN REFERENCIAS --}}
	      	
	    </div>
		
	</div>
</div>