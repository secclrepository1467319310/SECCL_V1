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
  var el=$(".f1");
  for (var i = 0; i < el.length; i++) {
  	
	  $(el[i]).validate({
	        //ignore: [],
	        rules: {
	            "meta": {
	                required: true,
	                pattern:"^[0-9]+$"
	            }
	        },
	        messages: {
	            "meta": {
	                required: 'Campo obligatorio',
	                pattern:"Solo números"
	            }
	        }
    	});
	};
});