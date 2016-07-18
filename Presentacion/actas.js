$(document).ready(function() {
    agregarCampos();
    eliminarCampos();
    formularioActa();
    modal();
});


//Función para agregar campos al acta
function agregarCampos() {
    var campos;

    $('#agregar_compromiso').click(function() {
        campos = "<tr class='contenedorCompromisos'>" + $('.contenedorCompromisos').html() + "</tr>";
        $(campos).insertAfter(".contenedorCompromisos:last");
        $(".contenedorCompromisos:last input[type=text]").val('');
        $(".contenedorCompromisos:last select option:first-child").attr("selected", true);
    });

    $('#agregar_asistente').click(function() {
        campos = "<tr class='contenedorAsistentes'>" + $('.contenedorAsistentes').html() + "</tr>";
        $(campos).insertAfter(".contenedorAsistentes:last");
        $(".contenedorAsistentes:last input[type=text]").val('');
    });

    $('#agregar_invitado').click(function() {
        campos = "<tr class='contenedorInvitados'>" + $('.contenedorInvitados').html() + "</tr>";
        $(campos).insertAfter(".contenedorInvitados:last");
        $(".contenedorInvitados:last input[type=text]").val('');
    });
}

function eliminarCampos() {
    var elemento, contador;
    $(document).on('click', '.eliminar', function() {
        elemento = $(this).closest('tr').attr('class');
        contador = $('tr.' + elemento).length;
        if (contador > 1) {
            $(this).closest('tr').remove();
        }
    });
}

function formularioActa() {
    $('#formActa').validate({
        rules: {
            nombre_comite: {
                required: true
            },
            ciudad: {
                required: true
            },
            hora_inicio: {
                required: true
            },
            hora_fin: {
                required: true
            },
            lugar: {
                required: true
            },
            temas: {
                required: true
            },
            objetivos: {
                required: true
            },
            desarrollo: {
                required: true
            },
            concluciones: {
                required: true
            }

        },
        messages: {
            nombre_comite: {
                required: 'Campo necesario'
            },
            ciudad: {
                required: 'Campo necesario'
            },
            hora_inicio: {
                required: 'Campo necesario'
            },
            hora_fin: {
                required: 'Campo necesario'
            },
            lugar: {
                required: 'Campo necesario'
            },
            temas: {
                required: 'Campo necesario'
            },
            objetivos: {
                required: 'Campo necesario'
            },
            desarrollo: {
                required: 'Campo necesario'
            },
            concluciones: {
                required: 'Campo necesario'
            }
        }
    });
}

