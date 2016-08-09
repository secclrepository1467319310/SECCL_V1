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
            "cert_alianza[]": {
                required: true,
                pattern:"^[0-9]+$"
            },
            "num_ev_req[]": {
	            required: true,
                pattern:"^[0-9]+$"	
            },
            "hor_ev_total[]": {
	            required: true,
                pattern:"^[0-9]+$"	
            },
            "pres_rec_hum[]": {
	            required: true,
                pattern:"^[0-9]+$"	
            },
            "pres_mat[]": {
	            required: true,
                pattern:"^[0-9]+$"	
            },
            "pres_viat[]": {
	            required: true,
                pattern:"^[0-9]+$"	
            }
        },
        messages: {
            "cert_alianza[]": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            },
            "num_ev_req[]": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            },
            "hor_ev_total[]": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            },
            "pres_rec_hum[]": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            }            ,
            "pres_mat[]": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            },
            "pres_viat[]": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            }
        }
    });
});