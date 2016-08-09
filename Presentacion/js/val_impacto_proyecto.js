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
            txtImpacto: {
                required: true
            }
        },
        messages: {
            txtImpacto: {
                required: 'Campo obligatorio'
            }
        }
    });
    $('#cantidadImpacto').text(300);
    $("#txtImpacto").keyup(function() {
        var limit = 300;
        var value = $(this).val();
        var current = value.length;
        $('#cantidadImpacto').text(limit - current);
        if (limit < current) {
            $(this).val(value.substring(0, limit));
        }
    });
});