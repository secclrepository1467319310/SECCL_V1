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
    $('#form_cron_grupo').validate({
        //ignore: [],
        rules: {
            "fi": {
                required: true,
                pattern:"^[0-3][0-9][/][0-1][0-9][/]20[1-3][0-9]$"
            },
            "fef": {
                required: true,
                pattern:"^[0-3][0-9][/][0-1][0-9][/]20[1-3][0-9]$"
            },
            "responsable": {
                required: true,
                maxlength:255             
            },
            "obs": {
                maxlength:255
            }
        },
        messages: {
            "fi": {
                required: 'Campo obligatorio',
                pattern:"Fecha no valida"
            },
            "fef": {
                required: 'Campo obligatorio',
                pattern:"Fecha no valida"
            },
            "responsable": {
                required: 'Campo obligatorio'
            }
        }
    });
});