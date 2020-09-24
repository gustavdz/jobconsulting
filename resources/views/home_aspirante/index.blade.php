@extends('layouts.admin')

@section('css')
<style type="text/css">
    p.line{
        line-height: 5px;
    }
</style>
@endsection

@section('js')
<script src="{{ asset('../js/aspirante.js') }}"></script>
@endsection

{{--@section('title')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading col-md-4">
                <select class="form-control" id="categories" name="categories">
                    <option>Seleccione</option>
                    @foreach($allCategories as $categories)
                    <option value="{{ $categories->id }}">{{ $categories->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="page-title-actions">
            </div>
            
        </div>
        <div id="div_mensajes" class="d-none">
            <p id="mensajes"></p>
        </div>
    </div>
@endsection --}}

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div class="row justify-content-center">
                @forelse ($ofertas as $oferta)
                    <div class="col-md-4 mb-3" >
                        <div class="card border-primary">
                            <div class="card-header"><a href="#" onclick="detalle({{ $oferta->id }})">{{ $oferta->titulo }}</a></div>

                            <div class="card-body">
                                <p class="line">{{ $oferta->descripcion }}</p>
                                <p class="line">Salario ${{$oferta->salario ? number_format($oferta->salario, 2, '.', ',') : '0.00'}}</p>
                               <footer class="blockquote-footer text-right">Publicado {{\Carbon\Carbon::parse($oferta->created_at)->format('j F, Y')}}</footer>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-md-12 mb-3" >
                        <div class="card border-primary">
                            <div class="card-body">
                               <p>No existe ofertas para mostrar</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="row justify-content-center p-4">
                {!! $ofertas->render() !!}
            </div>
        </div>
        <div class="col-md-3">
            <li class="app-sidebar__heading" style="list-style: none;"><a href="{{route('home')}}">CATEGORÍAS</a></li>
            <div class="list-group">
                @foreach($allCategories as $categories)
                    <a href="{{ route('oferta.categoria',$categories->id)}}" class="list-group-item list-group-item-action {{  (request()->is('categoria/'.$categories->id)) ? 'active' : '' }}">{{ $categories->nombre }}</a>

                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')

<!-- Modal -->
<div class="modal fade modal-example" tabindex="-1" id="detalleModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detalle de la Oferta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body">
                    
                    
                    
                   
                    
                    
                        
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="limpiar()">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_guardar">Aplicar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
