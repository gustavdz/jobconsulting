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

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
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
    });
</script>
@stop