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
    $('#formmapa').validate({
        //ignore: [],
        rules: {
            "documento": {
                required: true,
                pattern:"^[0-9]+$"
            },
            "priapellido": {
                required: true,
                maxlength:100               
            },
            "segapellido": {
//                required: true,
                maxlength:100                
            },
            "nombres": {
                required: true,
                maxlength:100                
            },
            "pass": {
                required: true,
                maxlength:100                
            },
            "email": {
                required: true,
                email:true,
                maxlength:100            
            },
            "fn": {
                required: true,
                pattern:"^[0-3][0-9][/][0-1][0-9][/]19[0-9][0-9]$"            
            },
            "lugarn": {
                required: true,
                maxlength:100                
            },
            "fe": {
                required: true,
                pattern:"^[0-3][0-9][/][0-1][0-9][/](1|2)(9|0|1)[0-9][0-9]$"            
            },
            "lugare": {
                required: true,
                maxlength:100               
            }

        },
        messages: {
            "documento": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            },
            "priapellido": {
                required: 'Campo obligatorio'
            },
            "segapellido": {
                required: 'Campo obligatorio'
            },
            "nombres": {
                required: 'Campo obligatorio'
            },
            "pass": {
                required: 'Campo obligatorio'
            },
            "email": {
                required: 'Campo obligatorio',
                email:"Email no valido"
            },
            "fn": {
                required: 'Campo obligatorio',
                pattern:"Fecha no valida"
            },
            "lugarn": {
                required: 'Campo obligatorio'                
            },
            "fe": {
                required: 'Campo obligatorio',
                pattern:"Fecha no valida"
            },
            "lugare": {
                required: 'Campo obligatorio'                
            }
        }
    });
    $('#frmConsulta').validate({
        //ignore: [],
        rules: {
            documento:{
                required:true,
                pattern:"^[0-9]+$"
            }
        },
        messages:{
            documento:{
                required:'Campo obligatorio',
                pattern:"Solo números"
            }
        }
    });
});