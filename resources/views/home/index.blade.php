@extends('layouts.admin')

@section('title')
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
@endsection


@section('content')
   <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-12 card">
                <div class="card-body">
                    <div id="div_table">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
