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
    $('#f1').validate({
        //ignore: [],
        rules: {
            "num_certif_meta": {
                required: true,
                pattern:"^[0-9]+$"
            },
            "num_personas_certificadas": {
                required: true,
                pattern:"^[0-9]+$"
            }
        },
        messages: {
            "num_certif_meta": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            },
            "num_personas_certificadas": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            }
        }
    });
});