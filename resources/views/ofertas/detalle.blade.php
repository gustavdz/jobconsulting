 <b>Empresa: </b>{{$user['name']}}<br>
<b>Titulo: </b>{{$titulo}}<br>
<b>Ciudad: </b>{{$ciudad}}<br>
<b>Provincia: </b>{{$provincia}}<br>
<b>Detalle: </b>{!! $descripcion !!}<br>
<b>Salario: </b>${{$salario ? number_format($salario, 2, '.', ',') : '0.00'}}<br>
<b>Validez: </b>{{\Carbon\Carbon::parse($validez)->format('j F, Y')}}<br>
@if($validez >= date('Y-m-d'))
    <span class="badge badge-primary">ACTIVA</span>
@else
    <span class="badge badge-danger">EXPIRADA</span>
@endif

@if($estado=='F')
    <span class="badge badge-warning">FINALIZADA POR EL USUARIO</span>
@endif
