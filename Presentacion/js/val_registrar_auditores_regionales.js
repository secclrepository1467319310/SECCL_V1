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
    $('#f2').validate({
        //ignore: [],
        rules: {
            "documento": {
                required: true,
                number:true
            },
            "nombres": {
                required:true,
                maxlength:300
            },
            "ip": {
                required:true,
                maxlength:20
            },
            "celular": {
                required:true,
                maxlength:22
            },
            "email": {
                required:true,
                maxlength:100,
                email:true
            },
            "email2": {
                required:true,
                maxlength:100,
                email:true
            },
            "num_certi": {
                required:true,
                maxlength:100
            },
            "fecha_certificado_1": {
                required:true,
                maxlength:200,
                pattern:"^[0-3][0-9][/][0-1][0-9][/]20[0-9][0-9]$"
            },
            "fecha_certificado": {
                required:function(){
                    if($("[name='iso']:checked").val()=="1")
                    {                        
                        return true;
                    }                        
                        return false;
                },
                maxlength:200,
                pattern:"^[0-3][0-9][/][0-1][0-9][/]20[0-9][0-9]$"  
            },
            "entidad": {
                required:true,
                maxlength:200
            },
            "auditoria_1": {
                required:true,
                maxlength:200,
                pattern:"^[0-3][0-9][/][0-1][0-9][/]20[0-9][0-9]$"  
            },
            "auditoria_2": {
                required:true,
                maxlength:200,
                pattern:"^[0-3][0-9][/][0-1][0-9][/]20[0-9][0-9]$"  
            }
        },
        messages: {
            "fecha_certificado_1": {
                pattern:"Fecha no valida"
            },
            "fecha_certificado": {
                pattern:"Fecha no valida"
            },
            "auditoria_1": {
                pattern:"Fecha no valida"
            },
            "auditoria_2": {
                pattern:"Fecha no valida"
            }
        }
    });
});