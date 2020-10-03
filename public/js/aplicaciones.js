$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //
    view_table();


 

    $("#btn_guardar").click(function () {
        if (!$("#formulario").valid()) {
            return false;
        }
        
        var data = new $('#formulario').serialize();
        $('#myModal').modal('toggle');
        $.ajax({
            type: 'POST',
            url: '/ofertas',
            data: data,
            beforeSend: function () {
                Swal.fire({
                    title: '¡Espere, Por favor!',
                    html: 'Cargando informacion...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                });
            },
            success: function (data) {
              //  $('#formregisterdiv').html(data);
                var d = JSON.parse(data);
                //$('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                    $("#table_ofertas").DataTable().ajax.reload();
                    limpiar();
                }
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: '+xhr.statusText + xhr.responseText);
            },
            complete: function () {
               swal.close();
            },
            dataType: 'html'
        });
    });

});


function editar(id){
    limpiar();
    $.ajax({
        type: 'POST',
        url: '/ofertas/show',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id": id
        },
        beforeSend: function () {
            Swal.fire({
                title: '¡Espere, Por favor!',
                html: 'Cargando informacion...',
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading()
                }
            });
        },
        success: function (data) {
            console.log(data)
            if (data != "") {
                $('#myModal').modal('toggle');
                $("#id").val(data.id);
                $("#empresa").val(data.empresa_id);
                $("#titulo").val(data.titulo);
                $("#descripcion").val(data.descripcion);
                $("#salario").val(data.salario);
                $("#validez").val(data.validez);
                var categorias = [];
                for (var i = 0; i < data.categorias_ofertas.length ; i++) {
                    categorias.push(data.categorias_ofertas[i].categoria_id);
                }
                var habilidades = [];
                for (var i = 0; i < data.habilidades_ofertas.length ; i++) {
                    habilidades.push(data.habilidades_ofertas[i].habilidad_id);
                }
                $("#categorias").val(categorias).trigger('change');
                $("#habilidades").val(habilidades).trigger('change');
            }else{
                toastr.warning("No se encontraron resultados");
            }
        },
        error: function (xhr) {
            toastr.error('Error: '+xhr.statusText + xhr.responseText);
        },
        complete: function () {
            swal.close();
        },
    });
}

function view_table() {

    $.ajax({
        type: 'POST',
        url: '/ofertas/aplicaciones',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "oferta_id": $('#oferta_id').val()
        },
        beforeSend: function () {
             Swal.fire({
	                title: '¡Espere, Por favor!',
	                html: 'Cargando informacion...',
	                allowOutsideClick: false,
	                onBeforeOpen: () => {
	                    Swal.showLoading()
	                }
	            });  
        },
        success: function (data) {
            $('#div_table').html(data);
            $('#tbl_aplicaciones').DataTable({
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla =(",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    },
                    "buttons": {
                        "copy": "Copiar",
                        "colvis": "Visibilidad"
                    }
                },
                "paging": true,
                "lengthChange": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "order": [[0, "desc"]]
            });
            // acciones();
        },
        error: function (xhr) { // if error occured
            toastr.error('Error: ' + xhr.statusText + xhr.responseText);
        },
        complete: function () {
             	swal.close()
        },
        dataType: 'html'
    });
}

function imgError(image) {
    image.onerror = "";
    image.src = "/images/avatar.jpg";
    return true;
}

function viewProfile(aspirante_id) {
    console.log(aspirante_id)
	$.ajax({
        type: 'POST',
        url: '/ofertas/aplicaciones/profile',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "aspirante_id": aspirante_id
        },
        beforeSend: function () {
            $('#perfil_postulante').html('<img src="/images/load.gif" width="10%" height="10%" />'); 
        },
        success: function (data) {
            
            $('#perfil_postulante').html(data)
        },
        error: function (xhr) { // if error occured
            toastr.error('Error: ' + xhr.statusText + xhr.responseText);
        }
    });
}

function changeStatus(id_postulacion,id_estado) {
    $.ajax({
        type: 'POST',
        url: '/ofertas/aplicaciones/estado',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id_postulacion": id_postulacion,
            "id_estado": id_estado,
        },
        beforeSend: function () {
            Swal.fire({
                    title: '¡Espere, Por favor!',
                    html: 'Cargando informacion...',
                    allowOutsideClick: false,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                    }
                }); 
        },
        success: function (d) {
            
            if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                    view_table();
                }
        },
        error: function (xhr) { // if error occured
            toastr.error('Error: ' + xhr.statusText + xhr.responseText);
        },
            complete: function () {
               swal.close();
            },
    });
}