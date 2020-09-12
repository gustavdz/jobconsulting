<ul>
    @foreach($categorias_ofertas as $cat)
        <li>{{$cat['categoria']['nombre']}}</li>
    @endforeach
</ul>