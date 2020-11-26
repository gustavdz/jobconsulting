$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("body").tooltip({ selector: '[data-toggle=tooltip]' });
    //
    //  view_table();
loadHabilidades();

    $("#table_ofertas").DataTable({
        "processing": true,
        "serverSide": true,
        "ajax":"/ofertas/data",
        "columns":[
            {data:'titulo'},
            {data:'descripcion'},
            {data:'salario'},
            {data:'ciudad'},
            {data:'provincia'},
            {data:'user.name'},
            {data:'detalle'},
            {data:'categorias'},
            {data:'habilidades'},
            {data:'opciones'}
        ],
        "columnDefs": [
            {
                "targets": [ 0 ],
                "visible": false,
                "searchable": true
            },
            {
                "targets": [ 1 ],
                "visible": false,
                "searchable": true
            },
            {
                "targets": [ 2 ],
                "visible": false,
                "searchable": true
            },
            {
                "targets": [ 3 ],
                "visible": false,
                "searchable": true
            },
            {
                "targets": [ 4 ],
                "visible": false,
                "searchable": true
            },
            {
                "targets": [ 5 ],
                "visible": false,
                "searchable": true
            }
        ],
        "language": {
            "sProcessing": "<img src='../images/loading.gif' width='100%' height='100%' />",
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
    });

     /*$('#habilidades').select2({
        placeholder: "Seleccione",
        allowClear: true,
        tags: true
     });*/

     $('#categorias').select2({
        placeholder: "Seleccione",
        allowClear: true
     });

    $("#btn_guardar").click(function () {
        if (!$("#formulario").valid()) {
            return false;
        }
        if ($("#habilidades").val().length==0) {
            $("#habilidades-error").html('Seleccione al menos un item');
            $("#habilidades-error").show();
            $("#habilidades").parent().find(".select2-container").addClass("error");
            return false;
        }else{
            $("#habilidades-error").html('');
            $("#habilidades-error").hide();
            $("#habilidades").parent().find(".select2-container").removeClass("error");
        }
        if ($("#categorias").val().length==0) {
            $("#categorias-error").html('Seleccione al menos un item');
            $("#categorias-error").show();
            $("#categorias").parent().find(".select2-container").addClass("error");
            return false;
        }else{
            $("#categorias-error").html('');
            $("#categorias-error").hide();
            $("#categorias").parent().find(".select2-container").removeClass("error");
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
                     loadHabilidades();
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
                    toastr.success(d['data'])
                    loadHabilidades();
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
          'descripcion': {
              required: function(textarea) {
                      CKEDITOR.instances[textarea.id].updateElement(); // update textarea
                      var editorcontent = textarea.value.replace(/<[^>]*>/gi, ''); // strip tags
                      return editorcontent.length === 0;
              }
          },
          'categorias'          : {required: true,},
          'validez'          : {required: true,},
          'habilidades'          : {required: true},
          'empresa'          : {required: true},
          'ciudad'          : {required: true},
          'provincia'          : {required: true},
          'salario'       : {required: true,number:true,monto_minimo:0,monto_maximo:99999,dollarsscents:true},

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
            maxYear: parseInt(moment().format('YYYY'),10),
            locale: {
                format: 'YYYY-MM-DD'
            }
        });

    CKEDITOR.config.width = 'auto';
    CKEDITOR.config.language = 'es';
    CKEDITOR.replace('descripcion');

});

function limpiar(){
    $("#id").val('');
    $('#categorias').val([]).trigger('change');
    $('#habilidades').val([]).trigger('change');
    $("#formulario")[0].reset();
    CKEDITOR.instances.descripcion.setData( '<p>&nbsp;</p>');
}

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
            //console.log(data);
            if (data != "") {
                $('#myModal').modal('toggle');
                $("#id").val(data.id);
                $("#empresa").val(data.empresa_id);
                $("#titulo").val(data.titulo);
                // $("#descripcion").val(data.descripcion);
                CKEDITOR.instances.descripcion.setData( data.descripcion );
                $("#salario").val(data.salario);
                $("#ciudad").val(data.ciudad);
                $("#provincia").val(data.provincia);
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

function eliminar(data,name,op){
    $.confirm({
                title: '¡'+op+'!',
                content: '¿Desea '+op+' la oferta '+name+'?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            type: 'POST',
                            url: '/ofertas/delete',
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                                "id": data,
                                "estado": op == 'Eliminar' ?'E':'F',
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
                                    $("#table_ofertas").DataTable().ajax.reload();
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


function loadHabilidades() {
    $.ajax({
        type: 'POST',
        url: '/ofertas/habilidad',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
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
            var option = "";
            //debugger;
            for (var i = 0 ;  i < d.length; i++) {
                option += "<option value='"+d[i].id+"'>"+d[i].nombre+"</option>"
            }
            //console.log(option)
            $("#habilidades").html('');
            $("#habilidades").html(option);
            $('#habilidades').select2({
                placeholder: "Seleccione",
                allowClear: true,
                tags: true
             });
        },
        error: function (xhr) {
            toastr.error('Error: '+xhr.statusText + xhr.responseText);
        },
        complete: function () {
            swal.close();
        },
    });
}




