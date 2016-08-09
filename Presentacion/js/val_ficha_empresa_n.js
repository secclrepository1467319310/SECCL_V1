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
            "gremio": {
                required: true,
                number:true
            },
            "asoc": {
                required: true,
                maxlength:20
            },
            "nit": {
                required: true,
                number:true
            },
            "empleados": {
                required: true,
                number:true
            },
            "razonsoc": {
                required: true,
                maxlength:150
            },
            "sigla": {
                required: true,
                maxlength:50
            },
            "direccion_e": {
                required: true,
                maxlength:500
            },
            "departamento": {
                required: true,
                number:true
            },
            "representante": {
                required: true,
                maxlength:500
            },
            "email_rep": {
                required: true,
                email:true,
                maxlength:500
            },
            "tel_e": {
                required: true
            },
            "documento": {
                required: true,
                number:true
            },
            "nombres": {
                required: true,
                maxlength:100
            },
            "papellido": {
                required: true,
                maxlength:100
            },
            "sapellido": {
                required: true,
                maxlength:100
            },
            "direccion": {
                required: true,
                maxlength:100
            },
            "cargo": {
                required: true,
                maxlength:50
            },
            "tel": {
                required: true,
                number:true
            },
            "cel": {
                required: true,
                number:true
            },
            "email": {
                required: true,
                email:true,
                maxlength:150
            }
        },
        messages: {
        
        }
    });
});
