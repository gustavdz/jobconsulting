@extends('layouts.admin')

@section('css')
<style type="text/css">

    .app-page-title {
    	padding: 30px;
    	margin: -30px -29px 0px;
    	position: relative;
	}
	#formulario_aplicar label[tipo="error"]{
            display: none;
            font-size: 12px;
            color: #fe0000;
        }
</style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script src="{{ asset('../js/aspirante.js') }}"></script>
@endsection

@section('title')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <img id="img_aspirante" src="/storage/perfil/{{ Auth::user()->id  }}.jpg?{{ time() }}" alt="" class="img-thumbnail" onerror="imgError(this);" style="width: 60px;margin-right: 5px;">
                <div>{{ Auth::user()->name }}
                    <div class="page-title-subheading"><a href="/storage/cv/{{ Auth::user()->id  }}.{{ Auth::user()->aspirante->extension ?? 'pdf' }}" target="_blank">Descargar Currículum</a>
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

<div class="container pt-4">
   <div class="row">
   	<div class="col">
   		<div class="card border-primary">
            <div class="card-header">{{ $datos->titulo ?? '' }}
            	@if($datos->validez < date('Y-m-d') || $datos->estado != 'A')
            		<span class="ml-2 badge badge-danger"">Oferta Expirada</span>
            	@endif
            </div>
            <div class="card-body">

                <p class="line">{!! $datos->descripcion ?? '' !!}. </p>
                @if(!empty($datos->habilidadesOfertas))
                <ul>
	                @foreach($datos->habilidadesOfertas as $habilidades)
	                	<li>{{ $habilidades->habilidad->nombre }}</li>
	                @endforeach
                </ul>
               @endif
               <div class="row">
               	<div class="col">
                	&nbsp;
               	</div>
               	<div class="col">
               		<footer class="blockquote-footer text-right">Publicado {{\Carbon\Carbon::parse($datos->created_at)->format('j F, Y')}}</footer>
               	</div>
               </div>
            </div>
            <div class="d-block text-right card-footer">
                <a href="{{ route('home') }}" class="mr-2 btn btn-outline-primary btn-sm">Ofertas</a>
                <button class="btn btn-success btn-sm" data-toggle="modal" data-target=".modal-aplicar" >Aplicar</button>
            </div>
        </div>
    </div>
   </div>
</div>
@endsection

@section('modal')

<!-- Modal -->
<div class="modal fade modal-aplicar" tabindex="-1" id="aplicarModal" role="dialog" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Aplicar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="formulario_aplicar" class="form-horizontal">
                {{ csrf_field() }}
                <div class="modal-body" >
                    <div class="form-group row">
                    	<div class="col">

                        <label for="salario" class="col-form-label">Ingrese su salario pretendido</label>
                          <input type="hidden" class="form-control" id="oferta_id" name="oferta_id" value="{{ $datos->id }}">
                          <input type="text" class="form-control" id="salario" name="salario">
                          <label tipo="error" id="salario-error"></label>
                    	</div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary"  data-dismiss="modal" id="btn_aplicar_oferta">Aplicar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
