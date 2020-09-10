$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    view_table();

     $('#habilidades').select2({
        placeholder: "Seleccione",
        allowClear: true
     });

     $('#categorias').select2({
        placeholder: "Seleccione",
        allowClear: true
     });

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


    $("#btn_actualizar").click(function () {
        var data = new $('#form').serialize();
        $('#EditModal').modal('toggle');
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

    //Función para guardar o editar
    $.validator.addMethod('monto_minimo', function(value, element, param) {
        var max=parseFloat(param);
        var val=parseFloat(value);
        if(val>=max){
            return true;
        }else{
            return false;
        }
    }, "El valor debe ser igual o mayor a $"+1);

    $.validator.addMethod('monto_maximo', function(value, element, param) {
        var max=parseFloat(param);
        var val=parseFloat(value);
        if(val<=max){
            return true;
        }else{
            return false;
        }
    }, "El valor debe ser menor o igual a $2000");

     $.validator.addMethod('required_monto', function(value, element, param) {
        if( $("#terminos").is(':checked') ){
                // Hacer algo si el checkbox ha sido seleccionado
                return true;
            } else {
                // Hacer algo si el checkbox ha sido deseleccionado
                return false;
            }
        }, "Debe aceptar los términos y condicones");

     $.validator.addMethod('dollarsscents', function(value, element) {
        return this.optional(element) || /^\d{0,4}(\.\d{0,2})?$/i.test(value);
    }, "El valor debe incluir dos decimales");

    $("#formulario").validate({ 
        ignore: [],
        rules: {
          'titulo'          : {required: true},
          'descripcion'            : {required: true},
          'categorias'          : {required: true,},
          'validez'          : {required: true,},
          'habilidades'          : {required: true},
          'empresa'          : {required: true},
          'salario'       : {required: true,number:true,monto_minimo:0,monto_maximo:50000,dollarsscents:true},

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

    $('#validez').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxYear: parseInt(moment().format('YYYY'),10)
        });

});

function limpiar(){
    $("#formulario")[0].reset();
}

function editar(id,name,email){
    $('#EditModal').modal('toggle');
    $("#id").val(id);
    $("#name_edit").val(name);
    $("#email_edit").val(email);
}

function eliminar(data,name){
    $.confirm({
                title: 'Eliminar usuario!',
                content: '¿Desea eliminar el usuario usuario '+name+'?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            type: 'POST',
                            url: '/delete/usuarios',
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                                "id": data
                            },
                            beforeSend: function () {
                                $('#div_mensajes').removeClass('d-none');
                                $('#div_mensajes').addClass('text-center');
                                $('#mensajes').html('<img src="../images/load.gif" width="5%" height="5%" />');
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
                                $('#div_mensajes').addClass('d-none');
                            },
                        });
                    },
                    cancel: function () {
                        $.alert('Se ha cancelado la eliminación!');
                    }
                }
            });
}

function view_table() {

    $.ajax({
        type: 'POST',
        url: '/ofertas/data',
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
            $('#tbl_ofertas').DataTable({
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







