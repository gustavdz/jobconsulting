$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    view_table();

    $("body").tooltip({ selector: '[data-toggle=tooltip]' });

    $("#tipo").change(function(){
    	if ($(this).val()=="select") {
    		$("#nopciones").show()
    	}
    });

	$("#opciones").keyup(function(){
    	var cantidad  = $(this).val();
    	var opcion  = "";

    	$("#cantidad").html('')
    	$("#cantidad").show();
    	j = 0;
    	for (var i = 0; i < cantidad; i++) {
    		j = j + 1;
    		console.log(j)
    	 	opcion += '<div class="row">'+
                            '<div class="col">'+
                                '<div class="form-group">'+
                                    '<label for="opcion" class="col-form-label">Opciones N° '+j+'</label>'+
                                    '<input type="text" id="opcion'+j+'" name="opcion[]" class="form-control">'+
                                    '<label tipo="error" id="opcion-error"></label>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
    	} 
    	$("#cantidad").append(opcion);
    });

    $("#btn_guardar").click(function () {
        /*if (!$("#formulario").valid()) {
            return false;
        }*/
        
        var data = new $('#formulario').serialize();
        $('#myModal').modal('toggle');
        $.ajax({
            type: 'POST',
            url: '/preguntas',
            data: data+'&oferta_id='+$("#oferta_id").val(),
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
                swal.close();
              //  $('#formregisterdiv').html(data);
                var d = JSON.parse(data);
                //$('#div_mensajes').removeClass('d-none text-center')
                if (d['msg'] == 'error') {
                    toastr.error(d['data']);
                } else {
                    toastr.success(d['data']);
                    view_table();
                   // limpiar();
                }
            },
            error: function (xhr) { // if error occured
                toastr.error('Error: '+xhr.statusText + xhr.responseText);
                swal.close();
            },
            complete: function () {
               swal.close();
            },
            dataType: 'html'
        });
    });

});

function editar(id,texto,campo,respuestas){
    $('#myModal').modal('toggle');
    $("#id").val(id);
    $("#titulo").val(texto);
    $("#tipo").val(campo);
}
function view_table() {

    $.ajax({
        type: 'POST',
        url: '/ofertas/preguntas',
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
            $('#table_pregunta').DataTable({
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