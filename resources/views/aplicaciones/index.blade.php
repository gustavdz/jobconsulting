@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../../vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="../../vendor/select2/css/select2.min.css">
    <!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="./vendor/select2/select2-bootstrap.css">-->
    <style type="text/css">
		div.dataTables_wrapper div.dataTables_processing {
		    position: absolute;
		    top: 50%;
		    left: 50%;
		    width: 280px;
		    margin-left: -100px;
		    margin-top: -26px;
		    text-align: center;
		    padding: 1em 0;
		}

		.border-title{
			border-bottom: 1px solid;
		}

		.line{
			margin-bottom: 1px !important;
		}
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script rel="stylesheet" href="../../vendor/select2/js/select2.min.js"></script>
    <script src="{{ asset('../js/aplicaciones.js') }}"></script>
    
@stop

@section('title')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-strong-bliss">
                    </i>
                </div>
                <div>Aspirantes
                    <div class="page-title-subheading">{{ $oferta->titulo ?? '' }}
                    </div>
                    <input type="hidden" id="oferta_id" name="oferta_id" value="{{ $oferta->id }}">
                </div>
            </div>
            <div class="page-title-actions">
                <a href="{{ route('ofertas') }}"
                        class="btn-shadow mr-3 btn btn-success " >
                    <i class="fa fa-refesh"></i> Regresar
                </a>
            </div>
            
        </div>
        <div id="div_mensajes" class="d-none">
            <p id="mensajes"></p>
        </div>
    </div>
@endsection


@section('content')
   <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-12 card">
                <div class="card-body">
                    <div>
                        <form class="needs-validation" novalidate id="form_search">
                            {{ csrf_field() }}
                          <div class="form-row">
                            <div class="col-md-3 mb-3">
                              <label for="validationCustom02">Formación academica</label>
                                <select class="form-control" id="estado_search" name="estado_search">
                                    <option value="">Todos</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                              <label for="edad">Edad</label>
                                <input type="text" name="edad" id="edad" class="form-control">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="salario">Salario aspirado</label>
                                <input type="text" class="form-control" id="salario" name="salario">
                            </div>
                            <div class="col-md-2 mb-3">
                              <button style="margin-top: 30px;" type="button" class="btn btn-success" onclick="busqueda_search()">Buscar</button>
                            </div>
                          </div>
                          <div class="form-row">
                              @foreach ($oferta->preguntas as $pregunta)
                                <div class="col-md-3 mb-3">
                                    <label for="edad">{{ $pregunta->texto }}</label>
                                    @if ($pregunta->campo=='select')
                                    <select class="form-control" id="campo_{{ $pregunta->id }}" name="campo_{{ $pregunta->id }}">
                                        @php
                                            $datos = explode(",", $pregunta->respuestas)
                                        @endphp
                                        @foreach ($datos as $dato)
                                            <option value="{{ $dato }}">{{ $dato }}</option>
                                        @endforeach
                                    </select>
                                    @else
                                    <input type="text" name="campo_{{ $pregunta->id }}" id="campo_{{ $pregunta->id }}" class="form-control">
                                    @endif
                                </div>
                              @endforeach
                          </div>
                        </form>
                    </div>
                    <div id="div_table">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')

<!-- Modal -->
<div class="modal fade modal-aspirante" tabindex="-1" id="AspiranteModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Datos del Aspirante</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body" id="perfil_postulante">
            
            </div>
        </div>
    </div>
</div>
@endsection
