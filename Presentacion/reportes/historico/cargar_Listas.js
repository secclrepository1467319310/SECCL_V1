$(document).ready(function() {
    $('#regional').change(function() {
        $('#idtablaregional').remove();
        if ($('#regional').is(':checked')) {
            $.ajax({
                beforeSend: function() {
                    console.log("Enviando");
                },
                url: 'consultarRegionales.php',
                type: 'POST',
                dataType: 'json',
                success: function(resp) {
                    var tabla = $("<table id='idtablaregional'></table>");
                    $('.divRegional').append(tabla);
                    $('#idtablaregional').append($('<tr><td>Codigo</td><td>Nombre</td><td><input type="checkbox" id="selReg"/></td></tr>'));
                    for (var i = 0; i < resp[0].length; i++) {
                        var fila = $("<tr id='idfilaregional" + i + "'></tr>");
                        $('#idtablaregional').append(fila);
                        for (var j = 0; j < resp.length; j++) {
                            var columna = $("<td id='idcolumregional" + i + "-" + j + "'>" + resp[j][i] + "</td>");
                            $('#idfilaregional' + i).append(columna);
                        }
                        var chkRegiones = $("<td><input type='checkbox' value=" + resp[0][i] + " class='chkselReg' name='codigoRegion[]'/></td>");
                        $('#idfilaregional' + i).append(chkRegiones);
                    }
                    $('#selReg').change(function() {
                        if ($("#selReg").is(':checked')) {
                            $(".chkselReg").each(function() {
                                $(this).prop('checked', true);
                            });
                        } else {
                            $(".chkselReg").each(function() {
                                $(this).prop('checked', false);
                            });
                        }
                    });
                },
                error: function(jqXHR, estado, error) {
                    console.log(estado);
                    console.log(error);
                },
                complete: function(jqXHR, estado) {
                    console.log(estado);

                }
            });

        }
    });

    $('#centro').change(function() {
        $('#idtablacentro').remove();
        if ($('#centro').is(':checked')) {
            $.ajax({
                beforeSend: function() {
                    console.log("Enviando");
                },
                url: 'consultarCentros.php',
                type: 'POST',
                data: $('form').serialize(),
                dataType: 'json',
                success: function(resp) {
                    var tabla = $("<table id='idtablacentro'></table>");
                    $('.divCentro').append(tabla);
                    $('#idtablacentro').append($('<tr><td>Codigo</td><td>Nombre</td><td><input type="checkbox" id="selCen"/></td></tr>'));
                    for (var i = 0; i < resp[0].length; i++) {
                        var fila = $("<tr id='idfilacentro" + i + "'></tr>");
                        $('#idtablacentro').append(fila);
                        for (var j = 0; j < resp.length; j++) {
                            var columna = $("<td id='idcolumcentro" + i + "-" + j + "'>" + resp[j][i] + "</td>");
                            $('#idfilacentro' + i).append(columna);
                        }
                        var chkCentros = $("<td><input type='checkbox' value=" + resp[0][i] + " class='chkselCen' name='codigoCentro[]'/></td>");
                        $('#idfilacentro' + i).append(chkCentros);
                    }
                    $('#selCen').change(function() {
                        if ($("#selCen").is(':checked')) {
                            $(".chkselCen").each(function() {
                                $(this).prop('checked', true);
                            });
                        } else {
                            $(".chkselCen").each(function() {
                                $(this).prop('checked', false);
                            });
                        }
                    });
                },
                error: function(jqXHR, estado, error) {
                    console.log(estado);
                    console.log(error);
                },
                complete: function(jqXHR, estado) {
                    console.log(estado);

                }
            });
        }
    });

    $('#mesa').change(function() {
        $('#idtablamesa').remove();
        if ($('#mesa').is(':checked')) {
            $.ajax({
                beforeSend: function() {
                    console.log("Enviando");
                },
                url: 'consultarMesas.php',
                type: 'POST',
                data: $('form').serialize(),
                dataType: 'json',
                success: function(resp) {
                    var tabla = $("<table id='idtablamesa'></table>");
                    $('.divMesa').append(tabla);
                    $('#idtablamesa').append($('<tr><td>Codigo</td><td>Nombre</td><td><input type="checkbox" id="selMesa"/></td></tr>'));
                    for (var i = 0; i < resp[0].length; i++) {
                        var fila = $("<tr id='idfilamesa" + i + "'></tr>");
                        $('#idtablamesa').append(fila);
                        for (var j = 0; j < resp.length; j++) {
                            var columna = $("<td id='idcolummesa" + i + "-" + j + "'>" + resp[j][i] + "</td>");
                            $('#idfilamesa' + i).append(columna);
                        }
                        var chkMesa = $("<td><input type='checkbox' value=" + resp[0][i] + " class='chkselMesa' name='codigoMesa[]'/></td>");
                        $('#idfilamesa' + i).append(chkMesa);
                    }
                    $('#selMesa').change(function() {
                        if ($("#selMesa").is(':checked')) {
                            $(".chkselMesa").each(function() {
                                $(this).prop('checked', true);
                            });
                        } else {
                            $(".chkselMesa").each(function() {
                                $(this).prop('checked', false);
                            });
                        }
                    });
                },
                error: function(jqXHR, estado, error) {
                    console.log(estado);
                    console.log(error);
                },
                complete: function(jqXHR, estado) {
                    console.log(estado);

                }
            });
        }
    });

    $('#norma').change(function() {
        $('#idtablanorma').remove();
        if ($('#norma').is(':checked')) {
            $.ajax({
                beforeSend: function() {
                    console.log("Enviando");
                },
                url: 'consultarNormas.php',
                type: 'POST',
                data: $('form').serialize(),
                dataType: 'json',
                success: function(resp) {
                    var tabla = $("<table id='idtablanorma'></table>");
                    $('.divNorma').append(tabla);
                    $('#idtablanorma').append($('<tr><td>Codigo</td><td>Version</td><td>Titulo</td><td><input type="checkbox" id="selNor"/></td></tr>'));
                    for (var i = 0; i < resp[0].length; i++) {
                        var fila = $("<tr id='idfilanorma" + i + "'></tr>");
                        $('#idtablanorma').append(fila);
                        for (var j = 0; j < resp.length; j++) {
                            var columna = $("<td id='idcolumnorma" + i + "-" + j + "'>" + resp[j][i] + "</td>");
                            $('#idfilanorma' + i).append(columna);
                        }
                        var chkNorma = $("<td><input type='checkbox' value=" + resp[0][i] + " class='chkselNor' name='codigoNorma[]'/></td>");
                        $('#idfilanorma' + i).append(chkNorma);
                    }
                    $('#selNor').change(function() {
                        if ($("#selNor").is(':checked')) {
                            $(".chkselNor").each(function() {
                                $(this).prop('checked', true);
                            });
                        } else {
                            $(".chkselNor").each(function() {
                                $(this).prop('checked', false);
                            });
                        }
                    });
                },
                error: function(jqXHR, estado, error) {
                    console.log(estado);
                    console.log(error);
                },
                complete: function(jqXHR, estado) {
                    console.log(estado);

                }
            });
        }
    });
});
