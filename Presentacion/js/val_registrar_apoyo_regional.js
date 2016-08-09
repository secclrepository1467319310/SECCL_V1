jQuery.validator.addMethod("pattern", function(value, element, param) {
    if (this.optional(element)) {
        return 'Campo obligatorio';
    }
    if (typeof param === 'string') {
        param = new RegExp('^(?:' + param + ')$');
    }
    return param.test(value);
}, "Invalid format.");

jQuery.validator.addMethod("diferent", function(value, element, param) {
    if (this.optional(element)) {
        return 'Campo obligatorio';
    }
    return param!=value;
    //return param.test(value);
}, "Seleccione una opción.");




$(document).ready(function() {
    $('#f3').validate({
        //ignore: [],
        rules: {
            "centro": {
                required: true,
                diferent:-1
            },
            "documento": {
                required:true,
                number:true
            },
            "nombres": {
                required:true,
                maxlength:200
            },
            "papellido": {
                required:true,
                maxlength:200
            },
            "sapellido": {
                
                maxlength:200
            },
            "email": {
                required:true,
                maxlength:200,
                email:true
            }
        },
        messages: {
          
        }
    });
});