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
        .middle{
            vertical-align: middle !important;
        }
    </style>
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
                    <div class="page-title-subheading">Listado
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
            <div class="main-card mb-12 card">
                <div class="card-body">
                    <div id="div_table">
                        <table class="table table-bordered dataTable no-footer">
                            <thead>
                                <tr role="row">
                                    <th class="" tabindex="0" aria-controls="tbl_reportes" rowspan="1" colspan="1" aria-label="Categorías: Activar para ordenar la columna de manera ascendente" aria-sort="descending">Reportes</th>
                                    <th class="" tabindex="0" aria-controls="tbl_reportes" rowspan="1" colspan="1" aria-label="Categorías: Activar para ordenar la columna de manera ascendente">Opción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="middle">
                                        Postulantes por Mes
                                    </td>

                                    <td class="middle">
                                        <a  href="/reportes/postulantes-registros-mes" class="btn btn-secondary btn_show"><i class="fas fa-info-circle"></i> Consultar</a>
                                    </td>

                                </tr>

                                <tr>
                                    <td class="middle">
                                        Registros/Aplicaciones por Mes
                                    </td>

                                    <td class="middle">
                                        <a  href="/reportes/aplicaciones-mes" class="btn btn-secondary btn_show"><i class="fas fa-info-circle"></i> Consultar</a>
                                    </td>

                                </tr>

                                <tr>
                                    <td class="middle">
                                        Postulantes por Oferta
                                    </td>

                                    <td class="middle">
                                        <a  href="/reportes/postulantes-ofertas" class="btn btn-secondary btn_show"><i class="fas fa-info-circle"></i> Consultar</a>
                                    </td>

                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection