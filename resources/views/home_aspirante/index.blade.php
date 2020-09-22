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

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @foreach ($ofertas as $oferta)
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
        @endforeach
    </div>
    <div class="row justify-content-center p-4">
        {!! $ofertas->render() !!}
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
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
