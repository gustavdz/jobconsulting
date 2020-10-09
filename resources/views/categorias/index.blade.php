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
    <script src="{{ asset('../js/categorias.js') }}"></script>
    
@stop

@section('title')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-strong-bliss">
                    </i>
                </div>
                <div>Categorías
                    <div class="page-title-subheading">Listado
                    </div>
                </div>
            </div>
            <div class="page-title-actions">
                <button data-placement="bottom" data-toggle="modal" data-target=".modal-categoria"
                        class="btn-shadow mr-3 btn btn-primary " onclick="limpiar()">
                    <i class="fa fa-plus"></i> Agregar
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
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')

<!-- Modal -->
<div class="modal fade modal-categoria" tabindex="-1" id="categoriaModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Categorías</h5>
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
                              <label for="nombre" class="col-form-label">Nombre</label>
                                <input type="hidden" name="id" id="id">
                                <input type="text" id="nombre" name="nombre" class="form-control">
                                <label tipo="error" id="nombre-error"></label>
                            </div>
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
