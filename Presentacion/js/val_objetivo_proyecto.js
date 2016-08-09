jQuery.validator.addMethod("pattern", function(value, element, param) {
    if (this.optional(element)) {
        return 'Campo obligatorio';
    }
    if (typeof param === 'string') {
        param = new RegExp('^(?:' + param + ')$');
    }
    return param.test(value);
}, "Invalid format.");

$(document).ready(function() {
    $('#frmFormulario').validate({
        rules: {
            txtObjetivo: {
                required: true
            }
        },
        messages: {
            txtObjetivo: {
                required: 'Campo obligatorio'
            }
        }
    });
    $('#cantidadObjetivo').text($('#txtObjetivo').attr("maxlength"));
    $("#txtObjetivo").keyup(function() {
        var limit = $(this).attr("maxlength");
        var value = $(this).val();
        var current = value.length;
        $('#cantidadObjetivo').text(limit - current);
        if (limit < current) {
            $(this).val(value.substring(0, limit));
        }
    });
});