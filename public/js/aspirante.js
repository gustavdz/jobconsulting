$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //
    //  view_table();



   


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

    

});

function limpiar(){
    $("#id").val('');
    $("#formulario")[0].reset();
}

function detalle(id){
	$('#detalleModal').modal('toggle');
    /*limpiar();
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
    });*/
}









