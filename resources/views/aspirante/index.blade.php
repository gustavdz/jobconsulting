@extends('layouts.admin')

@section('css')
<style type="text/css">
    p.line{
        line-height: 5px;
    }
    .app-page-title {
    padding: 30px;
    margin: -30px -29px 0px;
    position: relative;
}
</style>
@endsection

@section('js')
<script src="{{ asset('../js/aspirante.js') }}"></script>
@endsection

@section('title')
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-id icon-gradient bg-strong-bliss">
                    </i>
                </div>
                <div>{{ Auth::user()->name }}
                    <div class="page-title-subheading">Aspirante
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
<div class="container">
    <div class="row">
        <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
            <li class="nav-item">
                <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0" aria-selected="true">
                    <span>Datos Personales</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1" aria-selected="false">
                    <span>Perfil Profesional</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-2" aria-selected="false">
                    <span>Experiencias Profesionales</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-3" aria-selected="false">
                    <span>Formación Academica</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-4" aria-selected="false">
                    <span>Idiomas</span>
                </a>
            </li>
            <li class="nav-item">
                <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-5" aria-selected="false">
                    <span>Referencias</span>
                </a>
            </li>
        </ul>
        <div class="tab-content" style="width: 100%">
        	{{-- DATOS PERSONALES --}}
        	<div class="tab-pane tabs-animation fade active show" id="tab-content-0" role="tabpanel">
        		<div class="main-card mb-3 card">
                    <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>Datos Personales
                    </div>
                    <div class="card-body">
                        @include('aspirante.personales')
                    </div>
                </div>
        	</div>
        	{{-- FIN DATOS PERSONALES --}}

        	{{-- PERFIL PROFESIONAL --}}
        	<div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
        		<div class="main-card mb-3 card">
                    <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>PERFIL PROFESIONAL
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm nav btn-group">
                                <button class="mb-2 mr-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary"><i class="pe-7s-plus btn-icon-wrapper"> </i> Añadir</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('aspirante.personales')
                    </div>
                </div>
        	</div>
        	{{-- FIN PERFIL PROFESIONAL --}}

        	{{-- EXPERIENCIAS PROFESIONALES --}}
        	<div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
        		<div class="main-card mb-3 card">
                    <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i>EXPERIENCIAS PROFESIONALES
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm nav btn-group">
                                <button class="mb-2 mr-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary"><i class="pe-7s-plus btn-icon-wrapper"> </i> Añadir</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('aspirante.personales')
                    </div>
                </div>
        	</div>
        	{{-- FIN EXPERIENCIAS PROFESIONALES --}}

        	{{--  FORMACIÓN ACADEMICA --}}
        	<div class="tab-pane tabs-animation fade" id="tab-content-3" role="tabpanel">
        		<div class="main-card mb-3 card">
                    <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i> FORMACIÓN ACADEMICA
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm nav btn-group">
                                <button class="mb-2 mr-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary"><i class="pe-7s-plus btn-icon-wrapper"> </i> Añadir</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('aspirante.personales')
                    </div>
                </div>
        	</div>
        	{{-- FIN  FORMACIÓN ACADEMICA --}}

        	{{--  IDIOMAS --}}
        	<div class="tab-pane tabs-animation fade" id="tab-content-4" role="tabpanel">
        		<div class="main-card mb-3 card">
                    <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i> IDIOMAS
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm nav btn-group">
                                <button class="mb-2 mr-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary"><i class="pe-7s-plus btn-icon-wrapper"> </i> Añadir</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('aspirante.personales')
                    </div>
                </div>
        	</div>
        	{{-- FIN  IDIOMAS --}}


        	{{--  REFERENCIAS --}}
        	<div class="tab-pane tabs-animation fade" id="tab-content-5" role="tabpanel">
        		<div class="main-card mb-3 card">
                    <div class="card-header"><i class="header-icon lnr-license icon-gradient bg-plum-plate"> </i> REFERENCIAS
                        <div class="btn-actions-pane-right">
                            <div role="group" class="btn-group-sm nav btn-group">
                                <button class="mb-2 mr-2 btn-icon btn-shadow btn-dashed btn btn-outline-primary"><i class="pe-7s-plus btn-icon-wrapper"> </i> Añadir</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @include('aspirante.personales')
                    </div>
                </div>
        	</div>
        	{{-- FIN  REFERENCIAS --}}



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
