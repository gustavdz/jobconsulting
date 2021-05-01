@extends('layouts.admin')


@section('title')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-strong-bliss">
                    </i>
                </div>
                <div>Administración
                    <div class="page-title-subheading">Dashboard
                    </div>

                </div>
            </div>
            <div class="page-title-actions">
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="checkbox" id="activar" value="A" @if($activar->social_media == 'A') checked @endif>
                  <label class="form-check-label" for="activar">Activar Publicación en Redes Sociales</label>
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

                        <div class="row">
                            <div class="col">
                                <div class="card border-info">
                                    <div class="card-header">
                                        Top 5 de Consultores con más ofertas
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myChartOfertas" width="300" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card border-info">
                                    <div class="card-header">
                                        Top 5 de ofertas con mas postulaciones
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myChartPostulaciones" width="300" height="300"></canvas>

                                    </div>
                                </div>
                            </div>

                        </div>
                            <br>
                        <div class="row">
                            <div class="col">
                               <div class="card border-info">
                                  <div class="card-header">
                                      Postulantes/Registros por Mes
                                  </div>
                                  <hr>
                                  <div class="form-inline">
                                    
                                        <select class="custom-select custom-select-sm  form-control-sm" id="filterYear">
                                            <option value="" selected disabled> Select Year </option>
                                            <option value="2021"> 2021 </option>
                                            <option value="2020"> 2020 </option>
                                        </select>
                                        <button type="button"  class="btn btn-sm btn-primary" onClick=""> Buscar </button>
                                    
                                  </div>
                                  
                                  <div class="card-body">
                                     <canvas id="myChartPostulacionesMes" width="300" height="300"></canvas>
                                  </div>
                               </div>
                            </div>

                            <div class="col">
                                <div class="card border-info">
                                    <div class="card-header">
                                            Postulantes por Oferta
                                    </div>
                                    <div class="card-body">
                                        <canvas id="myChartPostulacionesXOfertas" width="300" height="300"></canvas>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $("#activar").change(function(){
            $.ajax({
                type: 'POST',
                url: '/activar',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "activar": $("#activar").is(':checked') ? 'A':'D'
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
                  //  $('#formregisterdiv').html(data);
                    var d = JSON.parse(data);
                    //$('#div_mensajes').removeClass('d-none text-center')
                    if (d['msg'] == 'error') {
                        toastr.error(d['data']);
                    } else {
                        toastr.success(d['data']);
                    }
                },
                error: function (xhr) { // if error occured
                    toastr.error('Error: '+xhr.statusText + xhr.responseText);
                },
                complete: function () {
                   swal.close();
                },
                dataType: 'html'
            });
        });
        var ctx = document.getElementById('myChartOfertas');
        var myChart = new Chart(ctx, {
            type: 'bar', //pieCHART - productos mas vendidos
            data: {
                labels: {!! $labels !!},// ['hola','mundo'], //para q lo imprima de esa manera
                datasets: [{
                    label: '# ofertas',
                    data: {!! $data !!},
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


        var ctx = document.getElementById('myChartPostulaciones');
        var myChart = new Chart(ctx, {
            type: 'doughnut', //pieCHART - productos mas vendidos
            data: {
                labels: {!! $labels_aplicaciones !!},// ['hola','mundo'], //para q lo imprima de esa manera
                datasets: [{
                    label: '# Postulación',
                    data: {!! $data_aplicaciones !!},
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 99, 132, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


        //postulaciones/registros x mes
        var dataregistros = {!! $data_registrosxMes !!};
        console.log(dataregistros);
        var ctx = document.getElementById('myChartPostulacionesMes');
        var myChart = new Chart(ctx, {
            type: 'line', //line - productos mas vendidos
            data: {
                labels: {!! $labels_postulaciones !!},// ['hola','mundo'], //para q lo imprima de esa manera
                datasets: [{
                    fill: false,
                    label: '# Postulación al mes',
                    data: {!! $data_postulaciones !!},
                    /*backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                    ],*/
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(54, 162, 235, 1)'

                    ],
                    borderWidth: 3
                },
                {
                    fill: false,
                    label: '# Registros al mes',
                    data: {!! $data_registrosxMes !!},
                    /*backgroundColor: [
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                    ],*/
                    borderColor: [
                        'rgba(150, 40, 27, 1)',
                        'rgba(150, 40, 27, 1)',
                        'rgba(150, 40, 27, 1)',
                        'rgba(150, 40, 27, 1)',
                        'rgba(150, 40, 27, 1)'

                    ],
                    borderWidth: 3
                }
              ]
            },
            options: {
                responsive: true,
                plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                }
                }
            },
        });


        //Postulantes x Oferta
        var ctx = document.getElementById('myChartPostulacionesXOfertas');
        var myChart = new Chart(ctx, {
            type: 'bar', //pieCHART - productos mas vendidos
            data: {
                labels: {!! $labels_pOfertas !!},// ['hola','mundo'], //para q lo imprima de esa manera
                datasets: [{
                    label: '# Postulantes ',
                    data: {!! $data_pOfertas !!},
                    backgroundColor: [
                        'rgba(150, 40, 27, 0.2)',
                        'rgba(226, 106, 106, 0.2)',
                        'rgba(226, 106, 106, 0.2)',
                        'rgba(224, 130, 131, 0.2)',
                        'rgba(241, 169, 160, 0.2)'
                    ],
                    borderColor: [
                        'rgba(150, 40, 27, 1)',
                        'rgba(240, 52, 52, 1)',
                        'rgba(226, 106, 106, 1)',
                        'rgba(224, 130, 131, 1)',
                        'rgba(241, 169, 160, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


    });
</script>
@stop
