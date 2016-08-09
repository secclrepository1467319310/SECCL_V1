

$(document).ready(function() {
    minimo = $('#auto_grupo').val();
    if (minimo > 0) {
        minimo = 10
    } else {
        minimo = 20
    }
    if ($('#auto_grupo2').val() > 0) {
        minimo = 5;
    }
    $('#f2').validate({
        //ignore: [],

        rules: {
            "usuario[]": {
                required: true,
                minlength: minimo,
                maxlength: 40
            },
            "evaluador": {
                required: true,
            }
        },
        messages: {
            "usuario[]": {
                required: 'Debe Seleccionar Mínimo ' + minimo + ' candidatos',
                minlength: "Debe seleccionar Mínimo " + minimo + " candidatos",
                maxlength: "Debe seleccionar Máximo 40 candidatos"
            },
            "evaluador": {
                required: "Debe seleccionar un evaluador",
            }
        },
        errorElement: 'div',
        errorLabelContainer: '.errorVal'
    });
});