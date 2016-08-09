<?php
session_start();

if ($_SESSION['logged'] == 'yes') {
    $nom = $_SESSION["NOMBRE"];
    $ape = $_SESSION["PRIMER_APELLIDO"];
    $id = $_SESSION["USUARIO_ID"];
} else {
    echo '<script>window.location = "../index.php"</script>';
}
include("../Clase/conectar.php");
$connection = conectar($bd_host, $bd_usuario, $bd_pwd);
?>
<!DOCTYPE HTML>
<html>
    <!--        CREDITOS  CREDITS
Plantilla modificada por: Ing. Jhonatan Andrés Garnica Paredes
Requerimiento: Imagen Corporativa App SECCL.
Sistema Nacional de Formación para el Trabajo - SENA, Dirección General
última actualización Diciembre /2013
!-->
    <head>
        <meta charset="utf-8">
        <title>Sistema de Evaluación y Certificación de Competencias Laborales</title>
        <link rel="shortcut icon" href="../images/iconos/favicon.ico" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script src="../jquery/jquery-1.3.2.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />

        <script type="text/javascript">
            $(document).ready(function() {

                 $('textarea').keyup(function (){
                    $(this).css("height", 0 );
                    $(this).css("height" ,this.scrollHeight );

                });
                // Initialise Plugin
                var options1 = {
                    clearFiltersControls: [$('#cleanfilters')],
                    matchingRow: function(state, tr, textTokens) {
                        if (!state || !state.id) {
                            return true;
                        }
                        var val = tr.children('td:eq(2)').text();
                        switch (state.id) {
                            case 'onlyyes':
                                return state.value !== 'true' || val === 'yes';
                            case 'onlyno':
                                return state.value !== 'true' || val === 'no';
                            default:
                                return true;
                        }
                    }
                };

                $('#demotable1').tableFilter(options1);

                var grid2 = $('#demotable2');
                var options2 = {
                    filteringRows: function(filterStates) {
                        grid2.addClass('filtering');
                    },
                    filteredRows: function(filterStates) {
                        grid2.removeClass('filtering');
                        setRowCountOnGrid2();
                    }
                };
                function setRowCountOnGrid2() {
                    var rowcount = grid2.find('tbody tr:not(:hidden)').length;
                    $('#rowcount').text('(Rows ' + rowcount + ')');
                }

                grid2.tableFilter(options2); // No additional filters			
                setRowCountOnGrid2();
            });
        </script>
        <script>

            var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome/') > -1;



            function inicio() {

                if (is_chrome) {
                    /*var posicion = navigator.userAgent.toLowerCase().indexOf('chrome/');
                     var ver_chrome = navigator.userAgent.toLowerCase().substring(posicion+7, posicion+11);
                     //Comprobar version
                     ver_chrome = parseFloat(ver_chrome);
                     alert('Su navegador es Google Chrome, Version: ' + ver_chrome);*/
                    document.getElementById("flotante")
                            .style.display = 'none';
                }
                else {
                    document.getElementById("flotante")
                            .style.display = '';
                }

            }
            function cerrar() {
                document.getElementById("flotante")
                        .style.display = 'none';
            }
        </script>


    </head>
    <body onload="inicio()">

        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div id="contenedorcito">

                <center><?php echo "<font><strong>Responder Solicitud $_GET[solicitud]</strong></font>"; ?></center>

                <br>
                <a id="cleanfilters" href="#">Limpiar Filtros</a>

                <center>
                    <form action="guardar_respuesta_solicitud_banco.php" method="post">
                        <br><br>
                        <center>
                            <table id="demotable1" >
                                <tr>
                                    <th>Estado solicitud</th>
                                    <td>
                                        <select name="ddlEstado">
                                            <option value="-1">Seleccione</option>
                                            <?php
                                            $query1 = "SELECT * FROM T_TIPO_ESTADO_SOLICITUD";
                                            $statement1 = oci_parse($connection, $query1);
                                            $execute1 = oci_execute($statement1, OCI_DEFAULT);
                                            $numRows = oci_fetch_all($statement1, $rows);

                                            for ($i = 0; $i < $numRows; $i++) {
                                                ?>
                                                <option value="<?php echo $rows[ID_TIPO_ESTADO_SOLICITUD][$i]; ?>"><?php echo utf8_encode($rows[DETALLE][$i]); ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Detalles</th>
                                    <td><textarea name="txtDetalles" style='width: 500px; height: 100px'></textarea></td>
                                <input type="hidden" name="hidIdSolicitud" value="<?php echo $_GET[solicitud]; ?>"/>
                                </tr>
                                <tr>
                                    <th>Codigo Instrumento</th>
                                    <td><input type="text" name="codigo_instrumento" id="codigo_instrumento" style='width: 100%'/></td>
                                </tr>
                            </table>
                            <br>
                            <input type="submit" name="btnResponder" value="Responder"/>
                            <BR><BR>
                            Historial Respuestas

                            <table>
                                <tr>
                                    <th>
                                        FECHA ESTADO
                                    </th>
                                    <th>
                                        HORA ESTADO
                                    </th>
                                    <th>
                                        ESTADO
                                    </th>
                                    <th>
                                        OBSERVACION
                                    </th>
                                </tr>


                                <?php
                                $query = "SELECT ES.FECHA_REGISTRO, ES.HORA_REGISTRO, TES.DETALLE, ES.DETALLE AS OBSERVACION
                                                FROM T_ESTADO_SOLICITUD ES
                                                INNER JOIN T_TIPO_ESTADO_SOLICITUD TES ON ES.ID_TIPO_ESTADO_SOLICITUD = TES.ID_TIPO_ESTADO_SOLICITUD
                                                WHERE ID_SOLICITUD = '" . $_GET['solicitud'] . "' ORDER BY ES.ID_ESTADO_SOLICITUD DESC";
                                $statement = oci_parse($connection, $query);
                                oci_execute($statement, OCI_DEFAULT);
                                while ($row = oci_fetch_array($statement, OCI_BOTH)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['FECHA_REGISTRO'] ?></td>
                                        <td><?php echo $row['HORA_REGISTRO'] ?></td>
                                        <td><?php echo utf8_encode($row['DETALLE']) ?></td>
                                        <td><?php echo $row['OBSERVACION'] ?></td>

                                    </tr>
                                <?php } ?>
                            </table>
                        </center><br>
                    </form>                    
                </center>
                <?php
                oci_close($connection);
                ?>



            </div>
        </div>
        <?php include ('layout/pie.php') ?>


    </body>
</html>