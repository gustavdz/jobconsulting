@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" href="./vendor/select2/css/select2.min.css">
    <style>
        .select2-selection--multiple{
            overflow-y: auto;
            
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
                                   <div class="card-header-tab card-header">
                                       <div class="card-header-title">
                                           Postulantes/Registros por Mes
                                       </div>
                                       <div class="btn-actions-pane-right">
                                           <select class="custom-select custom-select-sm  form-control-sm" id="filterYear">
                                               <option value="" selected disabled> Select Year </option>
                                               @php
                                                   $anio_actual = date("Y");
                                                   $anio_min = date("Y",strtotime($anio_actual."- 2 year"));
                                               @endphp
                                               @for ($i = $anio_actual; $i >= $anio_min; $i--)
                                                <option value="{{ $i }}" @if($anio_actual == $i) selected @endif>{{ $i }}</option>
                                               @endfor
                                           </select>
                                       </div>
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
                
                <br>
                <div class="mb-3 card">
                    <div class="card-header">
                        <div class="card-header-title">
                            Número de avisos publicados por mes/anual por usuario
                        </div>
                        {{-- <div class="btn-actions-pane-right">
                            
                            
                            
                            
                        </div> --}}
                        

                    </div>
                    <div class="">
                        <div class="" id="tab-eg-55">
                            <div class="card-body">


                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="filter_year" id="filter_year" class="custom-select custom-select-sm  form-control-sm">
                                            @for ($i = $anio_actual; $i >= $anio_min; $i--)
                                            <option value="{{ $i }}" @if($anio_actual == $i) selected @endif>{{ $i }}</option>
                                           @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-7">
                                        <select name="filter_empresa[]" id="filter_empresa" multiple="multiple" class="form-control" style="width: 100%">
                                            @foreach ($empresas as $key => $empresa)
                                                <option value="{{ $empresa->id }}" @if($key == 1) selected @endif>{{ $empresa->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btn-sm" id="visualizar">Visualizar</button>
                                    </div>
                                </div>
                                <hr>



                                <div class="widget-chart-wrapper widget-chart-wrapper-lg opacity-10 m-0">
                                    <div>
                                        <div id="oferta_view">
                                            
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>
                                            <canvas id="myChartOfertasEmpresas" width="667" height="250"></canvas>
                                        </div>
                                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <script rel="stylesheet" href="./vendor/select2/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#filter_empresa').select2({
            placeholder: "Seleccione",
            //allowClear: true
        });
        $("#visualizar").click(function(){
            ofertasEmpresas();
        })
        var MONTH = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        ofertasEmpresas();
        function ofertasEmpresas() {
            $.ajax({
                type: 'POST',
                url: '/home/ofertasPorEmpresas',
                data:{
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    'empresas':$("#filter_empresa").val(),
                    'anio':$("#filter_year").val(),
                }
                ,
                beforeSend: function () {
                    console.log('cargando')
                },
                success: function (d) {
                    console.log(d)
                    datas = []
                    for (var i = 0; i < d.length; i++) {
                        dato = {
                            label: d[i].nombre,
                            backgroundColor: getRandomColor(),
                            borderColor: getRandomColor(),
                            data: [d[i].ene, d[i].feb, d[i].mar, d[i].abr, d[i].may, d[i].jun, d[i].jul, d[i].ago, d[i].sep, d[i].oct, d[i].nov, d[i].dic],
                            fill: false,
                        }
                        datas.push(dato)
                    }
                    $('#myChartOfertasEmpresas').remove(); // this is my <canvas> element
                    $('#oferta_view').append('<canvas id="myChartOfertasEmpresas"  width="667" height="283"><canvas>');
                    var ctx = document.getElementById('myChartOfertasEmpresas').getContext('2d');
                    var chart = new Chart(ctx, {
                        // The type of chart we want to create
                        type: 'bar',

                        // The data for our dataset
                        data: {
                            labels: MONTH,
                            datasets: datas
                        },

                        // Configuration options go here
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

                },
                error: function (xhr) {
                    toastr.error('Error: ' + xhr.statusText + xhr.responseText);
                },
                complete: function () {
                    $('#div_mensajes').addClass('d-none');
                },
            });
        }

        postulanteMes();

        $("#filterYear").change(function(){
            postulanteMes();
        });
        function postulanteMes(){
            $.ajax({
                type: 'POST',
                url: '/home/postualanteMes',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "filterYear": $("#filterYear").val()
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
                    /****/
                    console.log(data)
                    var dataregistros = data.data_registrosxMes;
                    var ctx = document.getElementById('myChartPostulacionesMes');
                    var myChart = new Chart(ctx, {
                        type: 'line', //line - productos mas vendidos
                        data: {
                            labels: data.labels_postulaciones, // ['hola','mundo'], //para q lo imprima de esa manera
                            datasets: [{
                                fill: false,
                                label: '# Postulación al mes',
                                data: data.data_postulaciones,//
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
                                data: data.data_registrosxMes, 
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
                   
                    /****/
                },
                error: function (xhr) { // if error occured
                    toastr.error('Error: '+xhr.statusText + xhr.responseText);
                },
                complete: function () {
                   swal.close();
                },
            });

            //postulaciones/registros x mes
            
        }

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
        console.log({!! $labels !!})
        console.log({!! $data !!})
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
                    }],
                    xAxes: [{
                        ticks: {
                            callback: function(label) {
                                return label.substr(0,10);
                            }
                        }
                    }]
                }
            }
        });

        function getRandomColor() {
            var letters = '0123456789ABCDEF';
              var color = "#";

            for (var i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

    });
</script>
@stop
