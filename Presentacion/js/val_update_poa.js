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
        rules: {
            "al_num_certif": {
                required: true,
                pattern:"^[0-9]+$"
            },
            "ds_num_certif": {
                required: true,
                pattern:"^[0-9]+$"
            },
            "fun_num_certif": {
                required: true,
                pattern:"^[0-9]+$"
            },
            "ev_num_requerido": {
                required: true,
                pattern:"^[0-9]+$"
            },
            "ev_horas_totales": {
                required: true,
                pattern:"^[0-9]+$"
            },
            "pres_rec_humanos": {
                required: true,
                pattern:"^[0-9]+$"
            },
            "pres_materiales": {
                required: true,
                pattern:"^[0-9]+$"
            },
            "pres_viaticos": {
                required: true,
                pattern:"^[0-9]+$"
            },
            "det_pro_productivos" : {
                maxlength:1000
            }


        },
        messages: {
            "al_num_certif": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            },
            "ds_num_certif": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            },
            "fun_num_certif": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            },
            "ev_num_requerido": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            },
            "ev_horas_totales": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            },
            "pres_rec_humanos": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            },
            "pres_materiales": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            },
            "pres_viaticos": {
                required: 'Campo obligatorio',
                pattern:"Solo números"
            }
        }
    });
});
