@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Empresa Dashboard') }}</div>

                <div class="card-body">
                    <div class="row">
                            <div class="col">
                                <div class="card border-info">
                                    <div class="card-header">
                                        Total de estados por ofertas
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
            type: 'line', //pieCHART - productos mas vendidos  
            data: {
                labels: {!! $labels !!},// ['hola','mundo'], //para q lo imprima de esa manera     
                datasets: [{
                    label: '# ofertas',
                    data: {!! $data !!}, 
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
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
            type: 'polarArea', //pieCHART - productos mas vendidos  
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
