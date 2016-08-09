$(document).ready(function(){
    $('.trDemandaSocial').hide();
    $('#radAlianza').attr('checked',true);
    $('#radDemandaSocial').attr('checked',false);
    $('#ddlLienaAtencion').change(function(){
        if ($('#ddlLienaAtencion').val() == '2'){
            $('.trAlianza').show();
            $('.trDemandaSocial').hide();
            $('#radAlianza').attr('checked',true);
            $('#radDemandaSocial').attr('checked',false);
        }else{
            $('.trAlianza').hide();
            $('.trDemandaSocial').show();
            $('#radDemandaSocial').attr('checked',true);
            $('#radAlianza').attr('checked',false);
        }
    });
});


