@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="../vendor/datatables/css/dataTables.bootstrap4.css">
@stop

@section('js')
    <script src="{{ asset('../js/perfil.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="../../vendor/datatables/js/jquery.dataTables.js"></script>
    <script src="../../vendor/datatables/js/dataTables.bootstrap4.js"></script>
@stop

@section('title')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-id icon-gradient bg-strong-bliss">
            </i>
        </div>
        <div>Perfil de Usuario
            <div class="page-title-subheading">{{$user->role=='aspirante'?'Hoja de Vida':$user->role}}
            </div>

        </div>
    </div>
    <div class="page-title-actions">
{{--        <button title="Guardar" data-placement="bottom" data-toggle="modal" data-target=".modal-example" id="agregar"--}}
{{--                class="btn-shadow mr-3 btn btn-success " onclick="limpiar()">--}}
{{--            <i class="fa fa-plus"></i> Agregar Empresa--}}
{{--        </button>--}}
    </div>
@endsection


@section('content')
   <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-12 card">
                <div class="card-body">
                    <h5 class="card-title">Grid Rows</h5>
                    <form class="">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group"><label for="exampleEmail11" class="">Email</label><input name="email" id="exampleEmail11" placeholder="with a placeholder" type="email" class="form-control"></div>
                            </div>
                            <div class="col-md-6">
                                <div class="position-relative form-group"><label for="examplePassword11" class="">Password</label><input name="password" id="examplePassword11" placeholder="password placeholder" type="password"
                                                                                                                                         class="form-control"></div>
                            </div>
                        </div>
                        <div class="position-relative form-group"><label for="exampleAddress" class="">Address</label><input name="address" id="exampleAddress" placeholder="1234 Main St" type="text" class="form-control"></div>
                        <div class="position-relative form-group"><label for="exampleAddress2" class="">Address 2</label><input name="address2" id="exampleAddress2" placeholder="Apartment, studio, or floor" type="text" class="form-control">
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="position-relative form-group"><label for="exampleCity" class="">City</label><input name="city" id="exampleCity" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="position-relative form-group"><label for="exampleState" class="">State</label><input name="state" id="exampleState" type="text" class="form-control"></div>
                            </div>
                            <div class="col-md-2">
                                <div class="position-relative form-group"><label for="exampleZip" class="">Zip</label><input name="zip" id="exampleZip" type="text" class="form-control"></div>
                            </div>
                        </div>
                        <div class="position-relative form-check"><input name="check" id="exampleCheck" type="checkbox" class="form-check-input"><label for="exampleCheck" class="form-check-label">Check me out</label></div>
                        <button class="mt-2 btn btn-primary">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
