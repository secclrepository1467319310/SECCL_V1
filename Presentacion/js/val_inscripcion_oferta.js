$(document).ready(function() {

    centros();

    jQuery.validator.addMethod("pattern", function(value, element, param) {
        if (typeof param === 'string') {
            param = new RegExp('^(?:' + param + ')$');
        }
        return param.test(value);
    }, "Invalid format.");

    jQuery.validator.addMethod("valueNotEquals", function(value, element, arg) {
        return arg != value;
    }, "Value must not equal arg.");


    $('#form_inscripcion').validate({
        rules: {
            nombre: {
                required: true
            },
            primer_apellido: {
                required: true
            },
            cargo: {
                required: true
            },
            correo: {
                required: true,
                email: true
            },
            celular: {
                required: true,
                pattern: /^[0-9]*$/
            },
            centros: {valueNotEquals: "0"},
            regionales: {valueNotEquals: "0"}
        },
        messages: {
            nombre: {
                required: 'Campo obligatorio'
            },
            primer_apellido: {
                required: 'Campo obligatorio'
            },
            cargo: {
                required: 'Campo obligatorio'
            },
            correo: {
                required: 'Campo obligatorio',
                email: 'Email Incorrecto'
            },
            celular: {
                required: 'Campo obligatorio',
                pattern: 'Campo Numerico'
            },
            centros: {valueNotEquals: "Campo Obligatorio"},
            regionales: {valueNotEquals: "Campo Obligatorio"}
        }
//        errorPlacement: function(error, element) {
//            if (element.attr('name') === 'codigo[]') {
//                error.insertAfter("#cantidad");
//            } else {
//                error.insertAfter(element);
//            }
//        }
    });
});

function centros() {
    $("#regionales").change(function() {
        $("#regionales option:selected").each(function() {
            elegido = $(this).val();
            $.post("ajax_centros_regional.php", {codigo_regional: elegido}, function(data) {
                $("#centros").html(data);
            });
        });
    });
}