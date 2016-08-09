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
    $('#cons').validate({
        //ignore: [],
        rules: {
            "nit": {
                required: true,
                pattern:"^[0-9]+$"
            }
        },
        messages: {
            "nit": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            }
        }
    });
});