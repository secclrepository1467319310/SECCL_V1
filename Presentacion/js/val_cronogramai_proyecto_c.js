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
	    "departamento": {
		required:true
	    },
            "fi": {
                required: true,
                pattern:"^[0-3][0-9][/][0-1][0-9][/]20[1-3][0-9]$"
            },
            "ff": {
                required: true,
                pattern:"^[0-3][0-9][/][0-1][0-9][/]20[1-3][0-9]$"
            },
            "constructor": {
                required: true                
            },
            "nitems": {
                required: true,
                pattern:"^[0-9]+$"                
            }
        },
        messages: {
            "fi": {
                required: 'Campo obligatorio',
                pattern:"Fecha no valida"
            },
            "ff": {
                required: 'Campo obligatorio',
                pattern:"Fecha no valida"
            },
            "constructor": {
                required: 'Campo obligatorio'
            },
            "nitems": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            }
        }
    });
});