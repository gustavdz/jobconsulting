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
    <script src="{{ asset('../js/reporte-postulantes-ofertas.js') }}"></script>





@stop

@section('title')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-strong-bliss">
                    </i>
                </div>
                <div>Reportes
                    <div class="page-title-subheading">Postulaciones Oferta por Mes
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

<div class="row">
    <div class="col-md-12">
        <div class="">
            <div class="">


                    <div class="form-row">
                        <div class="form-group col-md-5">
                          <label for="desdeFiltro">Desde: &nbsp; </label>
                          <input type="date" class="form-control" id="desdeFiltro" name="desdeFiltro" />
                        </div>
                        <div class="form-group col-md-5">
                            <label for="hastaFiltro">Hasta: &nbsp; </label>
                            <input type="date" class="form-control" id="hastaFiltro" name="hastaFiltro" />
                        </div>
                        <div class="form-group col-md-2" style="align-self: flex-end;">
                            <button type="button" class="btn btn-primary" onclick="filtrarData()">Filtrar</button>

                        </div>


                      </div>




            </div>
        </div>
    </div>
</div>

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

<script rel="javascript" type="text/javascript">


    function filtrarData(){

        //get filtros values
        var desdeFiltro = document.getElementById("desdeFiltro").value;
        var hastaFiltro = document.getElementById("hastaFiltro").value;
        console.log(hastaFiltro);
        if(desdeFiltro !== '' && hastaFiltro === ''){
            Swal.fire({
                title: 'Error!',
                text: 'Por favor usar ambos filtros',
                icon: 'error',
                confirmButtonText: 'ok'
            });
            return;
        }

        if(desdeFiltro === '' && hastaFiltro !== ''){
            Swal.fire({
                title: 'Error!',
                text: 'Por favor usar ambos filtros',
                icon: 'error',
                confirmButtonText: 'ok'
            });
            return;
        }

        if(desdeFiltro > hastaFiltro ){
            Swal.fire({
                title: 'Error!',
                text: 'Por favor ingresar fechas validas',
                icon: 'error',
                confirmButtonText: 'ok'
            });
            return;
        }


        $.ajax({
        type: 'POST',
        url: '/reportes/dataPostulantesOfertasRegistro?desdeFiltro='+desdeFiltro+' 00:00:00'+'&hastaFiltro='+hastaFiltro+' 23:59:59',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function () {
             Swal.fire({
	                title: '¡Espere, Por favor!',
	                html: 'Cargando informacion...',
	                allowOutsideClick: false,
	                onBeforeOpen: () => {
	                    Swal.showLoading()
	                }
	            });
        },
        success: function (data) {
            $('#div_table').html(data);
            $('#tbl_reporte').DataTable({
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                },
                "paging": true,
                "lengthChange": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "order": [[0, "desc"]]
            });
            // acciones();
        },
        error: function (xhr) { // if error occured
            toastr.error('Error: ' + xhr.statusText + xhr.responseText);
        },
        complete: function () {
             	swal.close()
        },
        dataType: 'html'
    });
    }
</script>
