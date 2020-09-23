@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="./vendor/select2/css/select2.min.css">
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
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script rel="stylesheet" href="./vendor/select2/js/select2.min.js"></script>
    <script src="{{ asset('../js/ofertas.js') }}"></script>
    
@stop

@section('title')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-strong-bliss">
                    </i>
                </div>
                <div>Ofertas
                    <div class="page-title-subheading">Listado
                    </div>

                </div>
            </div>
            <div class="page-title-actions">
                <button title="Guardar" data-placement="bottom" data-toggle="modal" data-target=".modal-example" id="agregar"
                        class="btn-shadow mr-3 btn btn-success " onclick="limpiar()">
                    <i class="fa fa-plus"></i> Agregar Oferta
                </button>
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
                    <div id="div_table">
                        <table id="table_ofertas" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Detalle de la Oferta</th>
                                    <th>Categorías</th>
                                    <th>Habilidades</th>
                                    <th>Opciónes</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
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
                <h5 class="modal-title" id="exampleModalLongTitle">Oferta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        @if(Auth::user()->role=='admin')
                        <div class="col">
                            <div class="form-group">
                              <label for="empresa" class="col-form-label">Empresa</label>
                                <select class="form-control"  id="empresa" name="empresa" >
                                  <option value="">Seleccione</option>
                                  @foreach($empresas as $empresa)
                                  <option value="{{$empresa->id}}">{{$empresa->name}}</option>
                                  @endforeach
                                </select>
                                <label tipo="error" id="empresa-error"></label>
                            </div>
                        </div>
                        @endif
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
                              <label for="categorias" class="col-form-label">Categorías</label>
                              <select class="form-control"  id="categorias" name="categorias[]" multiple="multiple"  style="width: 100%">
                                  <option value="">Seleccione</option>
                                  @foreach($categorias as $categoria)
                                  <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                                  @endforeach
                              </select>
                                <label tipo="error" id="categorias-error"></label>
                            </div>
                        </div>
                        <div class="col">
                          <div class="form-group">
                              <label for="habilidades" class="col-form-label">Habilidades</label>
                                <select class="form-control" id="habilidades" name="habilidades[]" multiple="multiple" style="width: 100%">
                                  <option value="">Seleccione</option>
                                  @foreach($habilidades as $habilidad)
                                  <option value="{{$habilidad->id}}">{{$habilidad->nombre}}</option>
                                  @endforeach
                              </select>
                                <label tipo="error" id="habilidades-error"></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                              <label for="salario" class="col-form-label">Salario</label>
                                <input type="text" id="salario" name="salario" class="form-control">
                                <label tipo="error" id="salario-error"></label>
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
                    <div class="form-group">
                      <label for="descripcion" class="col-form-label">Descripción</label>
                        <textarea id="descripcion" name="descripcion" class="form-control"  maxlength="250" rows="5"></textarea>
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
