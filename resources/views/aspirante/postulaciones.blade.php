@extends('layouts.admin')

@section('css')
<style type="text/css">
    
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
@endsection


@section('content')
<div class="container">
    
        
                @forelse ($postulaciones as $postulacion)
                <div class="row mb-4">
                    <div class="col">
	                    <div class="card border-primary">
	                        <div class="card-header">{{ $postulacion->oferta->titulo }}</div>
	                        <div class="card-body">
	                            <p class="line">{{ $postulacion->oferta->titulo }} - {{ $postulacion->oferta->user->name }}</p>
	                            <p class="line">{{ $postulacion->oferta->descripcion }}</p>
	                            <p class="line">Salario ${{$postulacion->oferta->salario ? number_format($postulacion->oferta->salario, 2, '.', ',') : '0.00'}}</p>
	                           <footer class="blockquote-footer text-right">Postulado {{\Carbon\Carbon::parse($postulacion->created_at)->format('j F, Y')}}</footer>
	                        </div>
	                    </div> 
                      </div>  
                </div>           
                @empty
                <div class="row">
                    <div class="col-md-12 mb-3" >
                        <div class="card border-primary">
                            <div class="card-body">
                               <p>No ha realizado ninguna postulación</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endforelse
      
            @if(!empty($postulaciones))
                <div class="row justify-content-center p-4">
                            {!! $postulaciones->render() !!}
                </div>
            @endif
</div>
@endsection
