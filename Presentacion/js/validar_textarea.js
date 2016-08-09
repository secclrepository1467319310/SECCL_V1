$(document).ready(function() {
    $('#cantidadImpacto').text($('#txt').attr("maxlength"));
    $("#txt").keyup(function() {
        var limit = $(this).attr("maxlength");
        var value = $(this).val();
        var current = value.length;
        $('#cantidadImpacto').text(limit - current);
        if (limit < current) {
            $(this).val(value.substring(0, limit));
        }
    });
});