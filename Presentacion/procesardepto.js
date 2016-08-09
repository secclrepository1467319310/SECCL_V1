//por Abrahan Apaza
$(document).ready(function(){
        $("#departamento").change(function(){
			$("#municipio").empty().attr("disabled","disabled");
            
            if($(this).val()!=""){
                var dato=$(this).val();
                $("#imgprovincia").show();
                $.ajax({
                    type:"POST",
                    dataType:"html",
                    url:"actiondepto.php",
                    data:"departamento="+dato+"&tarea=listmunicipio",
                    success:function(msg){
                        $("#municipio").empty().removeAttr("disabled").append(msg);
                        $("#imgprovincia").hide();
                    }
                });
            }else{
                $("#municipio").empty().attr("disabled","disabled");
                
            }
        });

    });