$(document).ready(function() {
    $('#btnGuardar').click(function(ev) {
        ev.preventDefault();
        if ($('[name*=chkMesa]:checked').length <= 0) {
            $('.valError').empty();
            $('.valError').text('Debe seleccionar al menos una mesa');
        } else if ($('[name*=codigo]:checked').length <= 0) {
            $('.valError').empty();
            $('.valError').text('Debe modificar al menos un instrumento');
        } else {
            $('.valError').empty();
            $('#frmProyectoNacional').submit();
        }
    });
});