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
            "instrumentos": {
                required: true,
                maxlength:250
            },
            "fi": {                
                pattern:"^[0-3][0-9][/][0-1][0-9][/]20[0-9][0-9]$"
            }
        },
        messages: {
            "instrumentos": {
                required: 'Campo obligatorio'
            },
            "fi": {                
                pattern:"Fecha no valida"
            }
        }
    });    
});