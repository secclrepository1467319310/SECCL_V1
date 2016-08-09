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
            "nombre": {
                required: true,
                maxlength:150               
            },
            "sigla":  {
                maxlength:50
            }
        },
        messages: {
            
        }
    });
});