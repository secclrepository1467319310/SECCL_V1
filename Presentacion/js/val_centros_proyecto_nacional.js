jQuery.validator.addMethod("pattern", function(value, element, param) {
  if (this.optional(element)) {
    return true;
  }
  if (typeof param === 'string') {
    param = new RegExp('^(?:' + param + ')$');
  }
  return param.test(value);
}, "Invalid format.");

$(document).ready(function() {
  $('#frmCentrosProyectoNacional').validate({
    rules: {
      'centro[]': {
        required: true,
        minlength: 1
      }
    },
    messages: {
      'centro[]': {
        required: 'Debe escoger minimo 1 centros',
        minlength: 'Debe escoger minimo 1 centros'
      }
    },
    errorPlacement: function(error){
        error.appendTo("#valError");
    },
    errorElement: "div"
  });
});