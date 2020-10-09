$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //
    view_table();



     $("#formulario").validate({
        ignore: [],
        rules: {
          'nombre'          : {required: true}

        },
        messages:{
          'cedula':{
            minlength: "Por favor, ingresa {0} caracteres",
            maxlength: "Por favor, ingresa {0} caracteres",
          }
        },
          errorPlacement: function (error, element) {
            var er=error[0].innerHTML;
            var nombre = element[0].id;
            if(element[0].type=="select-one"){
                $("#" + nombre).parent().find(".select2-container").addClass("error");
            }else{
                $("#" + nombre).addClass("is-invalid");
            }
            $("#" + nombre + "-error").html(er);
            $("#" + nombre + "-error").show();
          }, unhighlight: function (element) {
            var nombre = element.id;
            if(element.type=="select-one"){
                $("#" + nombre).parent().find(".select2-container").removeClass("error");
            }else{
                $("#" + nombre).removeClass("is-invalid");
            }
            $("#" + nombre + "-error").hide();
            $("#"+nombre).removeClass("error");
          }
      });


 

    $("#btn_guardar").click(function () {
        if (!$("#formulario").valid()) {
            return false;
        }
        
        var data = new $('#formulario').serialize();
        $('#categoriaModal').modal('toggle');
        $.ajax({
            type: 'POST',
            url: '/categorias',
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
                    view_table();
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

function limpiar(){
	$("#id").val('');
    $("#nombre").val('');
}
function editar(id,nombre){
    $("#id").val(id);
    $("#nombre").val(nombre);
}

function view_table() {

    $.ajax({
        type: 'POST',
        url: '/categorias/data',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content')
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
            $('#tbl_categgorias').DataTable({
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


function eliminar(data,name){
    $.confirm({
                title: '¡Eliminar!',
                content: '¿Desea eliminar la categoría '+name+'?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            type: 'POST',
                            url: '/categorias/delete',
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                                "id": data
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
                                    limpiar();
                                }
                            },
                            error: function (xhr) {
                                toastr.error('Error: '+xhr.statusText + xhr.responseText);
                            },
                            complete: function () {
                                swal.close();
                            },
                        });
                    },
                    cancel: function () {
                        $.alert('Se ha cancelado la acción!');
                    }
                }
            });
}