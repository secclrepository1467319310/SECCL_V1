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
        <script src="../jquery/jquery-1.9.1.js" type="text/javascript"></script>
<script type="text/javascript" src="../jquery/jquery.validate.mod.js"></script>
        <script type="text/javascript"  src="js/val_meta_centro.js"></script>
        <script type="text/javascript" src="../jquery/picnet.table.filter.min.js"></script>
        <script src="../jquery/jquery.magnificpopup.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="../css/style.css" />
        <link rel="stylesheet" type="text/css" href="../css/magnificpopup.css" />
        <link rel="stylesheet" type="text/css" href="../css/menu.css" />
        <link rel="stylesheet" type="text/css" href="../css/tabla.css" />

        <script type="text/javascript">
            $(document).ready(function() {

                modal();
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

                $('#demotable').tableFilter(options1);

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
        <script type="text/javascript" language="JavaScript">
            function validar() {
                var form = document.f2;
                var total = 0;
                for (var i = 0; i < form.codigo.length; i++) {
                    //cuento la cantidad de input activos
                    if (form.codigo[i].checked) {
                        total = total + 1;
                    }
                }  //cierre for
                if (total == 12) {
                    for (i = 0; i < form.codigo.length; i++) {
                        //deshabilito el resto de checkbox
                        if (!form.codigo[i].checked) {
                            form.codigo[i].disabled = true;
                        }
                    }
                } else {
                    for (i = 0; i < form.codigo.length; i++) {
                        // habilito los checkbox cuando el total es menor que 3
                        form.codigo[i].disabled = false;
                    }
                }
                return false;
            } //cierre función

            function modal() {
                $('.areasClaves').magnificPopup({
                    type: 'inline',
                    preloader: false,
                    modal: true
                });
                $(document).on('click', '.popup-modal-dismiss', function(e) {
                    e.preventDefault();
                    $.magnificPopup.close();
                });
            }

        </script>

    </head>
    <body onload="inicio()">
        <?php include ('layout/cabecera.php') ?>
        <div id="cuerpo">
            <div style="width:900px; margin: 0 auto;">
                <center>
                    <strong>REGISTRO DE METAS</strong><br></br>
                    <?php
                    $queryMetaRegional = ("SELECT T_METAS_REGIONALES.META_REGIONAL, REGIONAL.NOMBRE_REGIONAL, REGIONAL.CODIGO_REGIONAL FROM "
                            . "T_REGIONALES_USUARIOS INNER JOIN T_METAS_REGIONALES ON "
                            . "T_REGIONALES_USUARIOS.CODIGO_REGIONAL = T_METAS_REGIONALES.CODIGO_REGIONAL "
                            . "INNER JOIN REGIONAL ON T_REGIONALES_USUARIOS.CODIGO_REGIONAL = REGIONAL.CODIGO_REGIONAL"
                            . " WHERE T_REGIONALES_USUARIOS.ID_USUARIO = $id");
                    $statementMetaRegional = oci_parse($connection, $queryMetaRegional);
                    oci_execute($statementMetaRegional);
                    $metaRegional = oci_fetch_array($statementMetaRegional, OCI_BOTH);

                    $queryMetaCentros = ("SELECT SUM(META) FROM CENTRO INNER JOIN T_METAS_CENTROS ON CENTRO.CODIGO_CENTRO = T_METAS_CENTROS.CODIGO_CENTRO  WHERE CODIGO_REGIONAL = $metaRegional[CODIGO_REGIONAL]");
                    $statementMetaCentros = oci_parse($connection, $queryMetaCentros);
                    oci_execute($statementMetaCentros);
                    $metaCentros = oci_fetch_array($statementMetaCentros, OCI_BOTH);

                    if ($metaRegional['META_REGIONAL'] >= $metaCentros['SUM(META)']) {
                        $metaActual = $metaRegional['META_REGIONAL'] - $metaCentros['SUM(META)'];
                    } else {
                        $metaActual = $metaCentros['SUM(META)'] - $metaRegional['META_REGIONAL'];
                        $metaActual = "+" . $metaActual;
                    }

                    echo "REGIONAL: " . utf8_encode($metaRegional['NOMBRE_REGIONAL']) . "<br><br>";
                    echo "Meta de la regional: " . $metaRegional['META_REGIONAL'] . "<br><br>";
                    echo "Meta por asignar: " . $metaActual;
                    ?>
                </center>

                <input type="hidden" name="numActa" value="<?php echo $acta['T_ID_ACTA'] ?>" />
                <table id="demotable">
                    <tr>
                        <th>Regional</th>
                        <th>Código de Centro</th>
                        <th>Nombre Centro</th>
                        <th>Meta registrada</th>
                        <th>Registrar Meta</th>
                    </tr>
                    <?php
                    $nCentro = count($centro);
                    $query = ("SELECT CENTRO.NOMBRE_CENTRO, CENTRO.CODIGO_CENTRO, "
                            . "REGIONAL.NOMBRE_REGIONAL FROM T_REGIONALES_USUARIOS "
                            . "INNER JOIN REGIONAL ON T_REGIONALES_USUARIOS.CODIGO_REGIONAL = REGIONAL.CODIGO_REGIONAL "
                            . "INNER JOIN CENTRO ON CENTRO.CODIGO_REGIONAL = REGIONAL.CODIGO_REGIONAL "
                            . "WHERE T_REGIONALES_USUARIOS.ID_USUARIO = $id ORDER BY REGIONAL.NOMBRE_REGIONAL ASC");
                    $statement = oci_parse($connection, $query);
                    $resp = oci_execute($statement);
                    $i = 0;
                    while ($centros = oci_fetch_array($statement, OCI_BOTH)) {
                        $i++;
                        $queryMeta = ("SELECT META FROM T_METAS_CENTROS WHERE CODIGO_CENTRO = $centros[CODIGO_CENTRO]");
                        $statementMeta = oci_parse($connection, $queryMeta);
                        $resp = oci_execute($statementMeta);
                        $metaRow = oci_fetch_array($statementMeta, OCI_BOTH);
                        ?>
                        <tr>
                            <td><?php echo utf8_encode($centros['NOMBRE_REGIONAL']) ?></td>
                            <td><?php echo $centros['CODIGO_CENTRO'] ?></td>
                            <td><?php echo utf8_encode($centros['NOMBRE_CENTRO']) ?></td>
                            <td><?php echo $metaRow['META'] ?></td>
                            <td>
                                <a href="#ventanaEmergenteMeta<?php echo $i ?>" class="areasClaves">Meta Centro</a>
                                <div id="ventanaEmergenteMeta<?php echo $i ?>" class="ventanaEmergenteBlanca mfp-hide">
                                    <form class="f1" action="guardar_meta.php" method="POST">
                                        <?php
                                        ?>
                                        <a class="popup-modal-dismiss" href="#">Cancelar</a><br><br>
                                        <input type="hidden" name="centro" value="<?php echo $centros['CODIGO_CENTRO'] ?>" />
                                        <strong><?php echo utf8_encode($centros['NOMBRE_CENTRO']) ?></strong><br><br>
                                        <strong> Meta: </strong> <input type="text" name="meta" value="<?php echo $metaRow['META'] ?>" /><br><br>
                                        <input type="submit" value="Registrar">
                                    </form>
                                </div>
                            </td>
                        </tr>


                        <?php
                    }
                    oci_close($connection);
                    ?>
                    <tr>
                        <td colspan="3">
                            Total Meta registrada de centros
                        </td>
                        <td colspan="2">
                            <?php echo $metaCentros['SUM(META)']; ?>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
        <?php include ('layout/pie.php') ?>
    </body>
</html>