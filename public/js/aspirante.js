$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    $("#guardar_perfil").click(function () {

        if (!$("#formulario_personal").valid()) {
            return false;
        }

        var formData = new FormData();
        formData.append('_token',$('meta[name="csrf-token"]').attr('content'));
        formData.append('foto',$('#foto')[0].files[0]);
        formData.append('cv',$('#cv')[0].files[0]);
        formData.append('nombres',$('#nombres').val());
        formData.append('cedula',$('#cedula').val());
        formData.append('correo',$('#correo').val());
        formData.append('fecha_nacimiento',$('#fecha').val());
        formData.append('telefono',$('#telefono').val());
        formData.append('celular',$('#celular').val());
        formData.append('pais',$('#pais').val());
        formData.append('provincia',$('#provincia').val());
        formData.append('ciudad',$('#ciudad').val());
        formData.append('remuneracion_actual',$('#remuneracion_actual').val());
        formData.append('espectativa_salarial',$('#espectativa_salarial').val());

        $.ajax({
            type: 'POST',
            url: '/aspirante',
            data: formData,
            processData:false,
            contentType:false,
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
                var d = JSON.parse(data);
                //$('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    var src = '/storage/perfil/'+$("#aspirante_user_id").val()+ '.jpg?'+new Date().getTime();
                    var ext = $('#cv')[0].files[0].name.split('.')[1] ? $('#cv')[0].files[0].name.split('.')[1] : 'pdf';
                    var src_cv = '/storage/cv/'+$("#aspirante_user_id").val()+ '.' + ext +'?'+ new Date().getTime();
                    $("#img_aspirante").prop('src',src);
                    $("#cv_aspirante").prop('href',src_cv);
                    toastr.success(d['data'])
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

    $("#btn_aplicar_oferta").click(function () {
        if (!$("#formulario_aplicar").valid()) {
            return false;
        }
        var data = $('#formulario_aplicar').serialize();
        $('#aplicarModal').modal('toggle');
        $.ajax({
            type: 'POST',
            url: '/postulacion',
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
                 Swal.close();
              //  $('#formregisterdiv').html(data);
             // console.log(data)
                var d = JSON.parse(data);
                //$('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    //aspirante_formacion();
                    toastr.success(d['data'])
                    //limpiar_postulacion();
                }
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: '+xhr.statusText + xhr.responseText);
            },
            complete: function () {
               Swal.close();
            },
            dataType: 'html'
        });
    });

    $("#btn_aplicar").click(function () {
        if (!$("#formulario_postulacion").valid()) {
            return false;
        }
        var data = $('#formulario_postulacion').serialize();
        
        $.ajax({
            type: 'POST',
            url: '/postulacion',
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
              console.log(data)
                var d = JSON.parse(data);
                //$('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    $('#detalleModal').modal('toggle');
                    //aspirante_formacion();
                    toastr.success(d['data'])
                    limpiar_postulacion();
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

    $("#guardar_formacion").click(function () {
        if (!$("#formulario_academia").valid()) {
            return false;
        }
        var data = $('#formulario_academia').serialize() + "&aspirante_id="+$("#aspirante_id").val();
        $('#formacionModal').modal('toggle');
        $.ajax({
            type: 'POST',
            url: '/aspirante/formacion',
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
              console.log(data)
                var d = JSON.parse(data);
                //$('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    aspirante_formacion();
                    toastr.success(d['data'])
                    limpiar_formacion();
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

    $("#guardar_idioma").click(function () {
         if (!$("#formulario_idioma").valid()) {
            return false;
        }
        var data = $('#formulario_idioma').serialize() + "&aspirante_id="+$("#aspirante_id").val();
        $('#idiomaModal').modal('toggle');
        $.ajax({
            type: 'POST',
            url: '/aspirante/idioma',
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
              console.log(data)
                var d = JSON.parse(data);
                //$('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    aspirante_idioma();
                    toastr.success(d['data'])
                    limpiar_idioma();
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
    $("#chb_trabajo_actual").click(function () {
        if($("#chb_trabajo_actual").prop('checked')){$("#fin_experiencia").hide();}else{$("#fin_experiencia").show();}
    });
    $("#guardar_referencia").click(function () {
        if (!$("#formulario_referencia").valid()) {
            return false;
        }
        var data = $('#formulario_referencia').serialize() + "&aspirante_id="+$("#aspirante_id").val();
        $('#referenciaModal').modal('toggle');
        $.ajax({
            type: 'POST',
            url: '/aspirante/referencia',
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
              console.log(data)
                var d = JSON.parse(data);
                //$('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    aspirante_referencia();
                    toastr.success(d['data'])
                    limpiar_referencia();
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

    $("#guardar_experiencia").click(function () {
        if (!$("#formulario_experiencia").valid()) {
            return false;
        }
        var data = $('#formulario_experiencia').serialize() + "&aspirante_id="+$("#aspirante_id").val();
        $('#experienciaModal').modal('toggle');
        $.ajax({
            type: 'POST',
            url: '/aspirante/experiencia',
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
              console.log(data)
                var d = JSON.parse(data);
                //$('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    aspirante_experiencia();
                    toastr.success(d['data'])
                    limpiar_experiencia();
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
    }, "El valor debe ser menor o igual a $1000000");

    $.validator.addMethod('dollarsscents', function(value, element) {
        return this.optional(element) || /^\d{0,4}(\.\d{0,2})?$/i.test(value);
    }, "El valor debe incluir dos decimales");

    $("#formulario_personal").validate({
        ignore: [],
        rules: {
          'nombres'          : {required: true},
          'cedula'          : {required: true},
          'correo'            : {required: true,email:true},
          'fecha'          : {required: true,},
          'telefono'          : {required: true,},
          'celular'          : {required: true},
          'pais'          : {required: true},
          'provincia'          : {required: true},
          'ciudad'          : {required: true},
          'remuneracion_actual'          : {required: true,number:true,monto_minimo:0,monto_maximo:1000000,dollarsscents:true},
          'espectativa_salarial'          : {required: true,number:true,monto_minimo:0,monto_maximo:1000000,dollarsscents:true},
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

    /*FORMACION ACADEMICA*/
    $("#formulario_academia").validate({
        ignore: [],
        rules: {
          'institucion'          : {required: true},
          'titulo'            : {required: true,},
          'inicio_formacion'          : {required: true,},
          'grado'          : {required: true,}
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
    /*FORMACION ACADEMICA*/

     /*FORMACION EXPERIENCIA*/
    $("#formulario_experiencia").validate({
        ignore: [],
        rules: {
          'empresa'          : {required: true},
          'inicio_experiencia'            : {required: true,},
          'sector'          : {required: true,},
          'cargo'          : {required: true,},
          'sector'          : {required: true,},
          'personal'          : {required: true,number:true},
          'funciones'          : {required: true,maxlength:250}
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
    /*FORMACION EXPERIENCIA*/

     /*FORMACION IDIOMA*/
    $("#formulario_idioma").validate({
        ignore: [],
        rules: {
          'idioma'          : {required: true},
          'nivel'            : {required: true,},
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
    /*FORMACION IDIOMA*/

     /*FORMACION REFERENCIA*/
    $("#formulario_referencia").validate({
        ignore: [],
        rules: {
          'nombres_referencia'          : {required: true},
          'correo_referencia'            : {required: true,},
          'telefono_referencia'          : {required: true,maxlength:10}
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
    /*FORMACION REFERENCIA*/

     /*FORMACION POSTULACION*/
    $("#formulario_postulacion").validate({
        ignore: [],
        rules: {
          'salario'          : {required: true,number:true,monto_minimo:0,monto_maximo:1000000,dollarsscents:true},
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
    /*FORMACION POSTULACION*/

    /*FORMACION POSTULACION*/
    $("#formulario_aplicar").validate({
        ignore: [],
        rules: {
          'salario'          : {required: true,number:true,monto_minimo:0,monto_maximo:1000000,dollarsscents:true},
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
    /*FORMACION POSTULACION*/



});

function limpiar_formacion(){
    $("#formacion_id").val('');
    $("#formulario_academia")[0].reset();
}

function limpiar_idioma(){
    $("#idioma_id").val('');
    $("#formulario_idioma")[0].reset();
}

function limpiar_referencia(){
    $("#referencia_id").val('');
    $("#formulario_referencia")[0].reset();
}

function limpiar_experiencia(){
    $("#experiencia_id").val('');
    $("#formulario_experiencia")[0].reset();
}

function limpiar_postulacion(){
    $("#oferta_id").val('');
    $("#formulario_postulacion")[0].reset();
}

function editar_formacion(id,institucion,titulo,inicio,fin,grado){
    $("#formacion_id").val(id);
    $("#institucion").val(institucion);
    $("#titulo").val(titulo);
    $("#inicio_formacion").val(inicio);
    $("#fin_formacion").val(fin);
    $("#grado").val(grado);
    $('#formacionModal').modal('toggle');
}

function editar_idioma(id,idioma,nivel){
    $("#idioma_id").val(id);
    $("#idioma").val(idioma);
    $("#nivel").val(nivel);
    $('#idiomaModal').modal('toggle');
}

function editar_referencia(id,nombres,correo,telefono,empresa,cargo,nivel_cargo){
    $("#referencia_id").val(id);
    $("#nombres_referencia").val(nombres);
    $("#correo_referencia").val(correo);
    $("#telefono_referencia").val(telefono);
    $("#empresa_referencia").val(empresa);
    $("#cargo_referencia").val(cargo);
    $("#nivel_cargo_referencia").val(nivel_cargo);
    $('#referenciaModal').modal('toggle');
}

function editar_experiencia(id,empresa,inicio,fin,sector,cargo,funciones,personal_cargo,area_cargo,nivel_cargo){
    $("#experiencia_id").val(id);
    $("#empresa").val(empresa);
    $("#inicio_experiencia").val(inicio);
    $("#fin_experiencia").val(fin);
    $("#sector").val(sector);
    $("#cargo").val(cargo);
    $("#area_cargo").val(area_cargo);
    $("#nivel_cargo").val(nivel_cargo);
    $("#personal").val(personal_cargo);
    $("#funciones").val(funciones);
    $('#experienciaModal').modal('toggle');
}

function aspirante_formacion(){
    $.ajax({
        type: 'POST',
        url: '/aspirante/view',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "aspirante_id": $("#aspirante_id").val()
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
            //console.log(data)
            $('#aspirante_formacion').html(data);

        },
        error: function (xhr) {
            toastr.error('Error: '+xhr.statusText + xhr.responseText);
        },
        complete: function () {
            swal.close();
        },
    });
}

function aspirante_idioma(){
    $.ajax({
        type: 'POST',
        url: '/aspirante/idioma/view',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "aspirante_id": $("#aspirante_id").val()
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
            //console.log(data)
            $('#aspirante_idioma').html(data);

        },
        error: function (xhr) {
            toastr.error('Error: '+xhr.statusText + xhr.responseText);
        },
        complete: function () {
            swal.close();
        },
    });
}

function aspirante_referencia(){
    $.ajax({
        type: 'POST',
        url: '/aspirante/referencia/view',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "aspirante_id": $("#aspirante_id").val()
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
            //console.log(data)
            $('#aspirante_referencia').html(data);

        },
        error: function (xhr) {
            toastr.error('Error: '+xhr.statusText + xhr.responseText);
        },
        complete: function () {
            swal.close();
        },
    });
}

function aspirante_experiencia(){
    $.ajax({
        type: 'POST',
        url: '/aspirante/experiencia/view',
        data: {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "aspirante_id": $("#aspirante_id").val()
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
            //console.log(data)
            $('#aspirante_experiencia').html(data);

        },
        error: function (xhr) {
            toastr.error('Error: '+xhr.statusText + xhr.responseText);
        },
        complete: function () {
            swal.close();
        },
    });
}

/*bsuqueda de ofertas*/
function detalle(id){
    limpiar_postulacion();
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
            $('#detalleModal').modal('toggle');
            console.log(data)
            var html_text="";
            var html_rspta="";
            if (data != "") {
                console.log(data)
                html_text+=  "<h5>"+data.titulo+"</h5>";
                html_text+= "<p>"+data.descripcion+"</p><ul>";

                for (var i = 0; i < data.habilidades_ofertas.length; i++) {
                   html_text+= "<li>"+data.habilidades_ofertas[i].habilidad.nombre+"</li>";
                }
                html_text+="</ul>";
                html_text+="<p>Salario $"+data.salario+"</p>";
                $("#detalle_oferta").html(html_text);
                $("#oferta_id").val(data.id);

                $("#preguntas").html('');
                for (var i = 0; i < data.preguntas.length; i++) {
                    html_rspta += '<div class="form-group row">'+
                            '<label for="campo_'+data.preguntas[i].id+'" class="col-sm-4 col-form-label">'+data.preguntas[i].texto+'</label>'+
                            '<div class="col-sm-8">';
                            if (data.preguntas[i].campo == 'select') {
                                html_rspta += '<select class="form-control" id="campo_'+data.preguntas[i].id+'" name="campo_'+data.preguntas[i].id+'">';
                                var opt = data.preguntas[i].respuestas.split(',');
                                for (var j = 0; j < opt.length; j++) {
                                    html_rspta += '<option value="'+opt[j]+'">'+opt[j]+'</option>';
                                }
                                html_rspta += '</select>';
                            }else{
                                html_rspta +=  '<input type="text" class="form-control" id="campo_'+data.preguntas[i].id+'" name="campo_'+data.preguntas[i].id+'">';
                            }
                    
                        html_rspta +=  '</div>'+
                        '</div>';
                }

                $("#preguntas").html(html_rspta);

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

function eliminar_formacion(data,name){
    $.confirm({
                title: '¡Eliminar!',
                content: '¿Desea eliminar la Formación Academica '+name+'?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            type: 'POST',
                            url: '/aspirante/formacion/delete',
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
                                    aspirante_formacion();
                                    limpiar_formacion();
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
                        $.alert('Se ha cancelado la eliminación!');
                    }
                }
            });
}

function eliminar_experiencia(data,name){
    $.confirm({
                title: '¡Eliminar!',
                content: '¿Desea eliminar la Experiencia profesional '+name+'?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            type: 'POST',
                            url: '/aspirante/experiencia/delete',
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
                                    aspirante_experiencia();
                                    limpiar_experiencia();
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
                        $.alert('Se ha cancelado la eliminación!');
                    }
                }
            });
}

function eliminar_idioma(data,name){
    $.confirm({
                title: '¡Eliminar!',
                content: '¿Desea eliminar El Idioma '+name+'?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            type: 'POST',
                            url: '/aspirante/idioma/delete',
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
                                    aspirante_idioma();
                                    limpiar_idioma();
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
                        $.alert('Se ha cancelado la eliminación!');
                    }
                }
            });
}


function eliminar_referencia(data,name){
    $.confirm({
                title: '¡Eliminar!',
                content: '¿Desea eliminar la referencia de '+name+'?',
                buttons: {
                    confirm: function () {
                        $.ajax({
                            type: 'POST',
                            url: '/aspirante/referencia/delete',
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
                                    aspirante_referencia();
                                    limpiar_referencia();
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
                        $.alert('Se ha cancelado la eliminación!');
                    }
                }
            });
}

function imgError(image) {
    image.onerror = "";
    image.src = "/images/avatar.jpg";
    return true;
}





