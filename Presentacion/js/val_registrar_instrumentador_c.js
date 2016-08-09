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
    $('#f3').validate({
        //ignore: [],
        rules: {
            "documento": {
                required: true,
                maxlength:200             
            },
            "nombres": {
                required: true,
                maxlength:200
            },
            "papellido": {
                required:true,
                maxlength:200
            },
            "sapellido": {
                required:true,
                maxlength:200
            },
            "email": {
                required:true,
                email:true,
                maxlength:200
            }
        },
        messages: {
        
        }
    });
});