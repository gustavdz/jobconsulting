@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
@stop

@section('js')
    <script src="{{ asset('../js/ofertas.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
@stop

@section('title')
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
@endsection


@section('content')
   <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-12 card">
                <div class="card-body">
                    <div id="div_table">

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
                <h5 class="modal-title" id="exampleModalLongTitle">Usuarios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                      <div class="form-group row">
                        <label for="name" class="col-sm-3 col-form-label">Nombres</label>
                        <div class="col-sm-9">
                            <input type="text" id="name" name="name" class="form-control">
                            <label tipo="error" id="name-error"></label>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Correo</label>
                        <div class="col-sm-9">
                            <input type="email" id="email" name="email" class="form-control">
                            <label tipo="error" id="email-error"></label>
                        </div>
                      </div>
                      <div class="form-group row" id="">
                        <label for="password" class="col-sm-3 col-form-label">Contraseña  </label>
                        <div class="col-sm-9">
                            <input type="password" id="password" name="password" class="form-control">
                            <label tipo="error" id="password-error"></label>
                        </div>
                      </div>

                      <div class="form-group row" id="">
                        <label for="confirm" class="col-sm-3 col-form-label">Confirmar Contraseña</label>
                        <div class="col-sm-9">
                            <input type="password" id="confirm" name="confirm" class="form-control">
                            <label tipo="error" id="confirm-error"></label>
                        </div>
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
