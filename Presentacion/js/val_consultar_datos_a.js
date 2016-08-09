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
            "documento": {
                required: true,
                pattern:"^[0-9]+$"
            }
        },
        messages: {
            "documento": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            }
        }
    });
});