@extends('layouts.admin')

@section('css')
<style type="text/css">
    p.line{
        line-height: 5px;
    }
    .app-page-title {
    	padding: 30px;
    	margin: -30px -29px 0px;
    	position: relative;
	}

#formulario_personal label[tipo="error"]{
    display: none;
    font-size: 12px;
    color: #fe0000;
}

#formulario_academia label[tipo="error"]{
    display: none;
    font-size: 12px;
    color: #fe0000;
}

#formulario_experiencia label[tipo="error"]{
    display: none;
    font-size: 12px;
    color: #fe0000;
}

#formulario_idioma label[tipo="error"]{
    display: none;
    font-size: 12px;
    color: #fe0000;
}

#formulario_referencia label[tipo="error"]{
    display: none;
    font-size: 12px;
    color: #fe0000;
}
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{ asset('../js/aspirante.js') }}"></script>
@endsection

@section('title')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <img id="img_aspirante" src="/storage/perfil/{{ Auth::user()->id  }}.jpg?{{ time() }}" alt="{{ Auth::user()->name }}" class="img-thumbnail" onerror="imgError(this);" style="width: 60px;margin-right: 5px;">
                <div>{{ Auth::user()->name }}
                    <div class="page-title-subheading"><a href="/storage/cv/{{ Auth::user()->id  }}.pdf" target="_blank">Descargar Currículum</a>
                    </div>

                </div>
            </div>
        </div>
        <div id="div_mensajes" class="d-none">
            <p id="mensajes"></p>
        </div>
    </div>
@endsection 

@section('content')
<input type="hidden" name="aspirante_id" id="aspirante_id" value="{{ $aspirante->id }}">
<input type="hidden" name="aspirante_user_id" id="aspirante_user_id" value="{{ Auth::user()->id }}">
<div class="container">
    <div class="row">
        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
            <li class="nav-item">
                <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0" aria-selected="true">
                    <span>Datos Personales</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-3" aria-selected="false" onclick="aspirante_formacion()">
                    <span>Formación Academica</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-2" aria-selected="false" onclick="aspirante_experiencia()">
                    <span>Experiencias Profesionales</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-4" aria-selected="false" onclick="aspirante_idioma()">
                    <span>Idiomas</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-5" aria-selected="false" onclick="aspirante_referencia()">
                    <span>Referencias</span>
                </a>
            </li>
        </ul>
        <div class="tab-content" style="width: 100%">
        	{{-- DATOS PERSONALES --}}
        	<div class="tab-pane tabs-animation fade active show" id="tab-content-0" role="tabpanel">
        		<div class="main-card mb-3 card">
                    <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Datos Personales
                    </div>
                    <div class="card-body">
                        @include('aspirante.personales')
                    </div>
                </div>
        	</div>
        	{{-- FIN DATOS PERSONALES --}}


        	{{-- EXPERIENCIAS PROFESIONALES --}}
        	<div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
        		<div class="main-card mb-3 card">
                    <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>EXPERIENCIAS PROFESIONALES
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm nav btn-group">
                                <button class="mb-2 mr-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" onclick="limpiar_experiencia()" data-toggle="modal" data-target=".modal-experienciaModal"><i class="pe-7s-plus btn-icon-wrapper"> </i> Añadir</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="aspirante_experiencia">
                        {{-- @include('aspirante.experiencia') --}}
                    </div>
                </div>
        	</div>
        	{{-- FIN EXPERIENCIAS PROFESIONALES --}}

        	{{--  FORMACIÓN ACADEMICA --}}
        	<div class="tab-pane tabs-animation fade" id="tab-content-3" role="tabpanel">
        		<div class="main-card mb-3 card">
                    <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i> FORMACIÓN ACADEMICA
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm nav btn-group">
                                <button class="mb-2 mr-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" onclick="limpiar_formacion()" data-toggle="modal" data-target=".modal-formacionModal"><i class="pe-7s-plus btn-icon-wrapper"> </i> Añadir</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="aspirante_formacion">
                        {{--include('aspirante.academica') --}}
                    </div>
                </div>
        	</div>
        	{{-- FIN  FORMACIÓN ACADEMICA --}}

        	{{--  IDIOMAS --}}
        	<div class="tab-pane tabs-animation fade" id="tab-content-4" role="tabpanel">
        		<div class="main-card mb-3 card">
                    <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i> IDIOMAS
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm nav btn-group">
                                <button class="mb-2 mr-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" onclick="limpiar_idioma()" data-toggle="modal" data-target=".modal-idiomaModal"><i class="pe-7s-plus btn-icon-wrapper"> </i> Añadir</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="aspirante_idioma">
                        {{--include('aspirante.idioma') --}}
                    </div>
                </div>
        	</div>
        	{{-- FIN  IDIOMAS --}}


        	{{--  REFERENCIAS --}}
        	<div class="tab-pane tabs-animation fade" id="tab-content-5" role="tabpanel">
        		<div class="main-card mb-3 card">
                    <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i> REFERENCIAS
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm nav btn-group">
                                <button class="mb-2 mr-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary" onclick="limpiar_referencia()" data-toggle="modal" data-target=".modal-referenciaModal"><i class="pe-7s-plus btn-icon-wrapper"> </i> Añadir</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="aspirante_referencia">
                      {{-- @include('aspirante.referencia') --}}
                    </div>
                </div>
        	</div>
        	{{-- FIN  REFERENCIAS --}}



        </div>
    </div>
</div>
@endsection

@section('modal')

<!-- Modal -->
<div class="modal fade modal-formacionModal" tabindex="-1" id="formacionModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Formación Academica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario_academia" class="form-horizontal">
			     {{ csrf_field() }}
			     <div class="modal-body">
				     <div class="row">
				     	<div class="col">
				     		<div class="form-group">
							    <label for="institucion">Institución Educativa</label>
							    <input type="hidden" class="form-control" id="formacion_id" name="formacion_id">
							    <input type="text" class="form-control" id="institucion" name="institucion">
                                <label tipo="error" id="institucion-error"></label>
							</div>
				     	</div>
				     	<div class="col">
				     		<div class="form-group">
							    <label for="titulo">Titulo</label>
							    <input type="text" class="form-control" id="titulo" name="titulo">
                                <label tipo="error" id="titulo-error"></label>
							</div>
				     	</div>
				     </div>

				     <div class="row">
				     	<div class="col">
				     		<div class="form-group">
							    <label for="inicio_formacion">Inicio</label>
							    <input type="date" class="form-control" id="inicio_formacion" name="inicio_formacion" max="{{ date('Y-m-d') }}">
                                <label tipo="error" id="inicio_formacion-error"></label>
							</div>
				     	</div>
				     	<div class="col">
				     		<div class="form-group">
							    <label for="fin_formacion">Fin</label>
							    <input type="date" class="form-control" id="fin_formacion" name="fin_formacion" max="{{ date('Y-m-d') }}">
							</div>
				     	</div>
				     </div>
			     </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar_formacion()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="guardar_formacion">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade modal-idiomaModal" tabindex="-1" id="idiomaModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Idiomas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario_idioma" class="form-horizontal">
			     {{ csrf_field() }}
			     <div class="modal-body">
				     <div class="row">
				     	<div class="col">
				     		<div class="form-group">
							    <label for="idioma">Idioma</label>
							    <input type="hidden" class="form-control" id="idioma_id" name="idioma_id">
							    <input type="text" class="form-control" id="idioma" name="idioma" placeholder="" value="">
                                <label tipo="error" id="idioma-error"></label>
							</div>
				     	</div>
				     	<div class="col">
				     		<div class="form-group">
							    <label for="nivel">Nivel</label>
							    <input type="text" class="form-control" id="nivel" name="nivel" placeholder="" value="">
                                <label tipo="error" id="nivel-error"></label>
							</div>
				     	</div>
				     </div>			
			     </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar_idioma()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="guardar_idioma">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade modal-referenciaModal" tabindex="-1" id="referenciaModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Referencias</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario_referencia" class="form-horizontal">
			     {{ csrf_field() }}
			     <div class="modal-body">
				     <div class="row">
				     	<div class="col">
				     		<div class="form-group">
							    <label for="nombres_referencia">Nombre y Apellidos</label>
							    <input type="hidden" class="form-control" id="referencia_id" name="referencia_id">
							    <input type="text" class="form-control" id="nombres_referencia" name="nombres_referencia">
                                <label tipo="error" id="nombres_referencia-error"></label>
							</div>
				     	</div>
				     	<div class="col">
				     		<div class="form-group">
							    <label for="correo_referencia">correo</label>
							    <input type="email" class="form-control" id="correo_referencia" name="correo_referencia">
                                <label tipo="error" id="correo_referencia-error"></label>
							</div>
				     	</div>
				     </div>

				     <div class="row">
				     	<div class="col">
				     		<div class="form-group">
							    <label for="telefono_referencia">Teléfono</label>
							    <input type="text" class="form-control" id="telefono_referencia" name="telefono_referencia">
                                <label tipo="error" id="telefono_referencia-error"></label>
							</div>
				     	</div>
				     	<div class="col">
				     		
				     	</div>
				     </div>		
			     </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar_referencia()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="guardar_referencia">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-experienciaModal" tabindex="-1" id="experienciaModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Experiencias Profesionales</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario_experiencia" class="form-horizontal">
			     {{ csrf_field() }}
			     <div class="modal-body">
				     <div class="row">
				     	<div class="col">
				     		<div class="form-group">
							    <label for="empresa">Empresa</label>
							    <input type="hidden" class="form-control" id="experiencia_id" name="experiencia_id" placeholder="" value="">
							    <input type="text" class="form-control" id="empresa" name="empresa" placeholder="" value="">
                                <label tipo="error" id="empresa-error"></label>
							</div>
				     	</div>
				     	<div class="col">
				     		<div class="form-group">
							    <label for="inicio_experiencia">Fecha de inicio</label>
							    <input type="date" class="form-control" id="inicio_experiencia" name="inicio_experiencia" placeholder="" value="">
                                <label tipo="error" id="inicio_experiencia-error"></label>
							</div>
				     	</div>
				     </div>

				     <div class="row">
				     	<div class="col">
				     		<div class="form-group">
							    <label for="fin_experiencia">Fecha de Terminación</label>
							    <input type="date" class="form-control" id="fin_experiencia" name="fin_experiencia" placeholder="">
							</div>
				     	</div>
				     	<div class="col">
				     		<div class="form-group">
							    <label for="sector">Sector</label>
							    <input type="text" class="form-control" id="sector" name="sector" placeholder="">
                                <label tipo="error" id="sector-error"></label>
							</div>
				     	</div>
				     </div>
				 	
				 	<div class="row">
				     	<div class="col">
				     		<div class="form-group">
							    <label for="cargo">Cargo</label>
							    <input type="text" class="form-control" id="cargo" name="cargo" placeholder="">
                                <label tipo="error" id="cargo-error"></label>
							</div>
				     	</div>
				     	<div class="col">
				     		<div class="form-group">
							    <label for="personal">Personal a Cargo</label>
							    <input type="text" class="form-control" id="personal" name="personal">
                                <label tipo="error" id="personal-error"></label>
							</div>
				     	</div>
				     </div>

				     <div class="row">
				          <div class="col">
				               <div class="form-group">
				                   <label for="funciones">Funciones</label>
				                   <textarea rows="5" id="funciones" name="funciones" class="form-control" ></textarea>
                                   <label tipo="error" id="funciones-error"></label>
				               </div>
				          </div>
				     	
				 	</div>	
			     </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar_experiencia()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="guardar_experiencia">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
