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
            "fp": {                
                pattern:"^[0-3][0-9][/][0-1][0-9][/]20[0-9][0-9]$"             
            },
            "horap": {                
                maxlength:20               
            },
            "lugarp": {               
                maxlength:150               
            },
            "fc": {
                required: true,
                pattern:"^[0-3][0-9][/][0-1][0-9][/]20[0-9][0-9]$"             
            },
            "horac": {
                required: true,
                maxlength:20              
            },
            "lugarc": {
                required: true,
                maxlength:150               
            },
            "fo": {                
                pattern:"^[0-3][0-9][/][0-1][0-9][/]20[0-9][0-9]$"             
            },
            "horao": {                
                maxlength:20               
            },
            "lugaro": {                
                maxlength:150              
            }
        },
        messages: {
            "fp": {
                required: 'Campo obligatorio',
                pattern: "Fecha no valida"       
            },
            "horap": {
                required: 'Campo obligatorio'    
            },
            "lugarp": {
                required: 'Campo obligatorio'    
            },
            "fc": {
                required: 'Campo obligatorio',
                pattern: "Fecha no valida"       
            },
            "horac": {
                required: 'Campo obligatorio'    
            },
            "lugarc": {
                required: 'Campo obligatorio'    
            },
            "fo": {
                required: 'Campo obligatorio',
                pattern: "Fecha no valida"       
            },
            "horao": {
                required: 'Campo obligatorio'    
            },
            "lugaro": {
                required: 'Campo obligatorio'    
            }
        }
    });
});