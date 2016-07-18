//por Abrahan Apaza
$(document).ready(function(){
        $("#pais").change(function(){
			$("#provincia").empty().attr("disabled","disabled");
            
            if($(this).val()!=""){
                var dato=$(this).val();
                $("#imgprovincia").show();
                $.ajax({
                    type:"POST",
                    dataType:"html",
                    url:"action2.php",
                    data:"codigo_regional="+dato+"&tarea=listcentro",
                    success:function(msg){
                        $("#provincia").empty().removeAttr("disabled").append(msg);
                        $("#imgprovincia").hide();
                    }
                });
            }else{
                $("#provincia").empty().attr("disabled","disabled");
                
            }
        });
        $("#provincia").change(function(){			
            if($(this).val()!=""){
                var dato=$(this).val();
                $("#imgciudad").show();
                $.ajax({
                    type:"POST",
                    dataType:"html",
                    url:"action2.php",
                    data:"codigo_centro="+dato+"&tarea=listCiudad",
                    success:function(msg){                        
                        $("#ciudad").empty().removeAttr("disabled").append(msg);
                        $("#imgciudad").hide();
                    }
                });
            }else{
                $("#ciudad").empty().attr("disabled","disabled");
            }
        });
    });