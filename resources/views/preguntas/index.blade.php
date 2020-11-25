@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="/vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="/vendor/select2/css/select2.min.css">
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
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="/vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="/vendor/datatables/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script rel="stylesheet" href="./vendor/select2/js/select2.min.js"></script>
    <script src="{{ asset('../vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('../js/preguntas.js') }}"></script>
@stop

@section('title')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-strong-bliss">
                    </i>
                </div>
                <div>Preguntas
                    <div class="page-title-subheading">Listado
                    </div>

                </div>
            </div>
            <div class="page-title-actions">
                <button title="Guardar" data-placement="bottom" data-toggle="modal" data-target=".modal-example" id="agregar"
                        class="btn-shadow mr-3 btn btn-success " onclick="limpiar()">
                    <i class="fa fa-plus"></i> Agregar Pregunta
                </button>
            </div>

        </div>
        <div id="div_mensajes" class="d-none">
            <p id="mensajes"></p>
        </div>
    </div>
@endsection


@section('content')
    <input type="hidden" name="oferta_id" id="oferta_id" value="{{ $oferta->id }}">
   <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-12 card">
                <div class="card-body" id="">
                    <div id="div_table"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')

<!-- Modal -->
<div class="modal fade modal-example" tabindex="-1" id="myModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Pregunta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                    
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                              <label for="titulo" class="col-form-label">Titulo</label>
                                <input type="hidden" name="id" id="id">
                                <input type="text" id="titulo" name="titulo" class="form-control">
                                <label tipo="error" id="titulo-error"></label>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="tipo" class="col-form-label">Tipo de Pregunta</label>
                                <select class="form-control" id="tipo" name="tipo">
                                    <option value="text">Texto</option>
                                    <option value="select">Combo</option>
                                </select>
                                <label tipo="error" id="tipo-error"></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="validez" class="col-form-label">Validez hasta</label>
                                <input type="text" id="validez" name="validez" class="form-control">
                                <label tipo="error" id="validez-error"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="ciudad" class="col-form-label">Ciudad</label>
                                <input type="text" id="ciudad" name="ciudad" class="form-control">
                                <label tipo="error" id="ciudad-error"></label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="provincia" class="col-form-label">Provincia</label>
                                <input type="text" id="provincia" name="provincia" class="form-control">
                                <label tipo="error" id="provincia-error"></label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <label for="descripcion" class="col-form-label">Descripción</label>
                        <textarea id="descripcion" name="descripcion" class="form-control"  maxlength="999999" rows="5"></textarea>
                        <label tipo="error" id="descripcion-error"></label>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
