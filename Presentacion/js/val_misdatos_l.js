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
    $('#cons').validate({
        //ignore: [],
        rules: {
            "pass": {
                required: true,
                maxlength:200          
            }
        },
        messages: {
            "pass": {
                required: 'Campo obligatorio'                
            }
        }
    });
});