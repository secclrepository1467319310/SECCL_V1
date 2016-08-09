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
            "documento": {
                required: true,
                pattern:"^[0-9]+$"
            },
            "nombres": {
                required: true,
                maxlength:100               
            },
            "pri_apellido": {
                required: true,
                maxlength:100              
            },
            "seg_apellido": {
                required: true,
                maxlength:100
            },
            "email": {
                required: true,
                email:true,
                maxlength:100                        
            },
            "email2": {
                required: true,
                email:true,
                maxlength:100             
            },
            "cel": {
                required: true,
                pattern:"^[0-9]+$"
            },
            "tel": {
                required: true,
                pattern:"^[0-9]+$"
            }
        },
        messages: {
            "documento": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            },
            "nombres": {
                required: 'Campo obligatorio'
            },
            "pri_apellido": {
                required: 'Campo obligatorio'
            },
            "seg_apellido": {
                required: 'Campo obligatorio'
            },
            "email": {
                required: 'Campo obligatorio',
                email:"Email no valido"
            },
            "email2": {
                required: 'Campo obligatorio',
                email:"Email no valido"
            },
            "cel": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            },
            "tel": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            }
        }
    });
});