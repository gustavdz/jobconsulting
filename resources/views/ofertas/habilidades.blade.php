<ul>
    @foreach($habilidades_ofertas as $habilidad)
        <li>{{$habilidad['habilidad']['nombre']}}</li>
    @endforeach
</ul>